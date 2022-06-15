<?php

$port = 8880;
$host = "0.0.0.0";
$protocol = 'tcp://';
$sock = stream_socket_server($protocol . $host . ":" . $port, $errno, $err_message);


$reads = $clients = [];
$writes = $exceptions = [];

// 不阻塞当前进程
stream_set_blocking($sock, false);
if (!$sock) {
    exit("$err_message ($errno)<br />\n");
}
fwrite(STDOUT, "socket server listen on port: {$port}" . PHP_EOL);


function socket_server2($sock, array $clients, $writes, $exceptions): void
{
    while (true) {
        $reads = array_merge([$sock], $clients);

        $active_counts = @\stream_select($reads, $writes, $exceptions,0);

        while ($active_counts > 0) {

            \set_error_handler(function(){});
            $conn = stream_socket_accept($sock,0);
            \restore_error_handler();

            if ($conn) {
                $clients[] = $conn;
            }



            while ($client = array_pop($clients)) {
                if (($request_buffer = @\stream_get_contents($client, 1024, 0))) {
                    echo "{ 当前有请求进入... } \n";
                    echo "{ 读取的数据 $request_buffer";
                    fwrite($client, $request_buffer);
                    fclose($client);
                    break;
                }
            }
        }

    }
}


if (!function_exists('socket_server2')) {
    socket_server2($sock,$clients,$writes,$exceptions);
}





/**
 *
 * @param array $clients
 * @param $writes
 * @param $exceptions
 * @return void
 */
function socket_server1($sock, array $clients, $writes, $exceptions)
{
    for (; ;) {
        # 可写socket连接
        $reads = array_merge([$sock], $clients);

        # 活性连接数量
        $active_counts = @stream_select($reads, $writes, $exceptions, 0);


        if ($active_counts > 0) {
            # 判断当前连接是否正常
            if (($conn = stream_socket_accept($sock)) != false) {
                $clients[] = $conn;
            }
            for ($i = 0; $i < count($clients); $i++) {
                $client = $clients[$i];
                try {
                    if (($request_buffer = @\stream_get_contents($client, 1024, 0))) {
                        echo "{ 当前有请求进入... } \n";
                        echo "{ 读取的数据 $request_buffer";
                        fwrite($client, $request_buffer);
                        fclose($client);
                        break;
                    }
                } catch (\Exception $exception) {
                    continue;
                }
            }
        }

    }

}

socket_server1($sock,$clients, $writes, $exceptions);
