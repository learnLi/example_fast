<?php


require_once __DIR__ . '/../vendor/autoload.php';


use Administrator\ExampleFast\YieldStreamSocket\StreamWorker;
use Administrator\ExampleFast\YieldStreamSocket\TcpConnection;


$socket = new StreamWorker();

$socket->onStartWorker = function (StreamWorker $worker) {
    echo "脚本开启\n";
};

$socket->onConnect = function (TcpConnection $connection) {
    $connection->send("连接成功");
};

$socket->onMessage = function (TcpConnection $connection, $buffer) {
    $connection->send("连接成功");
};

$socket->count = 2;

$socket->loop();

