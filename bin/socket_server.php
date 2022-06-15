<?php


$port = 8880;
$socket = stream_socket_server("tcp://0.0.0.0:$port", $err_code, $err_message);

if (!$socket) {
    echo "$err_message ($err_code)<br />\n";
} else {
    fwrite(STDOUT, "socket server listen on port: {$port}" . PHP_EOL);
    stream_set_blocking($socket, false);
    while ($conn = stream_socket_accept($socket)) {
        $data = stream_get_contents($conn, 1024);
        echo "{ 当前有请求进入... } \n";
        echo "{ 读取的数据 $data } \n";
        fwrite($conn, 'The local time is ' . date('Y-m-d H:i:s') . "\n");
        fclose($conn);
    }
    fclose($socket);
}

