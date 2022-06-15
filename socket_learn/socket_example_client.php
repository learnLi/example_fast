<?php

$port = 8880;
$host = "127.0.0.1";
$protocol = 'tcp://';
$socket = stream_socket_client($protocol . $host . ":" . $port, $errno, $err_message);

if (!$socket) {
    echo "$err_message ($errno)<br />\n";
} else {
    $res_counts = fwrite($socket, "this is client request11". "\n");
    echo $res_counts.PHP_EOL;
    while (!feof($socket)) {
        echo fgets($socket, 1024);
    }
    fclose($socket);
}

