<?php


function createClient($start)
{
    $port = 8880;
    $host = "127.0.0.1";
    $protocol = 'tcp://';

    $socket = stream_socket_client($protocol . $host . ":" . $port, $errno, $err_message, 0);

    if (!$socket) {
        exit("$err_message ($errno)");
    }

    fwrite($socket, "这是一个client3的请求第 $start 个 请求" . "\n");
    $data = "";
    while (!feof($socket)) {
        $data .= fgets($socket, 100000);
    }
    fclose($socket);

}
createClient(1);

