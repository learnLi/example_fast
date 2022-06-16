<?php
set_time_limit(0);

require_once __DIR__ . '/../vendor/autoload.php';


use Administrator\ExampleFast\YieldStreamSocket\TcpConnection;

$port = 8880;
$host = "127.0.0.1";
$protocol = 'tcp://';
$socket = stream_socket_client($protocol . $host . ":" . $port, $errno, $err_message);

if (!$socket) {
    echo "$err_message ($errno)<br />\n";
} else {
    fwrite($socket, "this is client request11" . "\n");

    while (!feof($socket)) {
        echo \fread($socket, TcpConnection::PackageBuffet) ."\n";
    }

    fclose($socket);
}

