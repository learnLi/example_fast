<?php

error_reporting(E_ALL);
set_time_limit(0);
ini_set("allow_call_time_pass_reference",true);


$port = 8880;
$host = "0.0.0.0";
$protocol = 'tcp://';


$sock = stream_socket_server($protocol . $host . ":" . $port, $errno, $err_message);

if (!$sock) {
    exit("$err_message \n");
}

// 不阻塞
stream_set_blocking($sock, 0);

//
$reads = array();

$writes = array();

$Max_Users = 1024;

$_e = null;

// 连接池
$connections = [];

$input = array();

$close = array();
fwrite(STDOUT, "socket server listen on port: {$port}" . PHP_EOL);
while (true) {
    $reads = array_merge([$sock], $connections);
    // 轮询查看连接池中的连接活跃数   reads 可读列表   writes 可写列表   错误列表
    if (@\stream_select($reads, $writes, $_e, $t = 60)) {
        // select轮询后会在内部修改可读列表和可写列表
        foreach ($reads as $rfd) {
            // 如果是当前服务端的监听连接
            if ($rfd === $sock) {
                \set_error_handler(function () {});
                $newConn = stream_socket_accept($sock, 0);
                \restore_error_handler();
                $i = (int)$newConn;
                $reject = "";
                if (count($connections) >= $Max_Users) {
                    $reject = "Server Full. Try again later.\n";
                }
                // 将当前客户端连接放入连接池
                $connections[$i] = $newConn;

                // 输入的连接资源缓存容器
                $writes[$i] = $newConn;
                \call_user_func_array('onConnect', [$i]);

                if ($reject) {
                    $close[$i] = true;
                } else {
                    echo "Welcome to the PHP Chat Server!\n";

                    echo "Client >>  User Id $i" . "\n";

                    echo "Connection Users counts >> ". count($connections) .PHP_EOL;

                    echo "---------------------------------------------------------------------" . PHP_EOL;
                }
                $input[$i] = "";
                continue;
            }
            // 客户端连接
            $i = (int)$rfd;
            // 读取内容
            $tmp = @\stream_get_contents($rfd, 1024);
            if (!$tmp) {
                \call_user_func_array('onCloseMessage',array($i));
                continue;
            }
            // 将读取的内容写入到缓存输入数据中
            $input[$i] .= $tmp;
            // 判断结尾是否有 \r\n 判断数据是否传输完整
            $tmp = substr($input[$i], -1);
            # 定界符
            if ($tmp != "\r" && $tmp != "\n") {
                continue;
            }
            $line = trim($input[$i]);
            $result = \call_user_func_array('onMessage', [$i, $input[$i]]);
            // 清空缓存输入
            $input[$i] = "";
            echo "---------------------------------------------------------------------" . PHP_EOL;
            echo 'Client >> ' . $line . "\r\n";
            echo "---------------------------------------------------------------------" . PHP_EOL;

//            $socketName = stream_socket_get_name($connections[$i], false);
//            echo "SocketName: ".$socketName . PHP_EOL;
        }
    }
}


function onConnect($i)
{
    global $connections;
    send($i,"hello~!");
}

function onMessage($i, $buffer)
{
    global $connections;
    send($i, $buffer);
    #close($i);
}


function send($i, $buffer)
{
    global $connections;
    fwrite($connections[$i], $buffer);
}


function close($i)
{
    global $input, $connections, $writes;
    // 关闭接收数据和读数据
    stream_socket_shutdown($connections[$i], STREAM_SHUT_WR);
    fclose($connections[$i]);
    unset($input[$i]);
    unset($writes[$i]);
    unset($connections[$i]);
    echo "connection closed on socket $i \n";
}


function onCloseMessage($i)
{
    global $connections;
    @\fwrite($connections[$i], "关闭连接" . "\n");
    close($i);
}


// 创建stream_socket对象

