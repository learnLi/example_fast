<?php


require_once __DIR__ . '/../vendor/autoload.php';


use Workerman\Connection\TcpConnection;
use Workerman\Worker;



// Create a Websocket server
$ws_worker = new Worker('tcp://127.0.0.1:8880');

// Emitted when new connection come
$ws_worker->onConnect = function ($connection) {
    echo "New connection\n";
};

// Emitted when data received
$ws_worker->onMessage = function (TcpConnection $connection, $data) {
    // Send hello $data
    $connection->send($data);
    #$connection->close('关闭');
};

// Emitted when connection closed
$ws_worker->onClose = function ($connection) {
    $connection->send("关闭222");
};

// Run worker
Worker::runAll();