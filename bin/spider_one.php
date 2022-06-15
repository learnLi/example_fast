<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Workerman\Timer;
use Workerman\Worker;


$worker = new Worker();


$worker->onWorkerStart = function ($worker) {
    $worker->timer_name = Timer::add(3, function ($worker) {
        echo "hello";
        Timer::del($worker->timer_name);
        echo PHP_EOL;
        echo "定时结束";
    },[$worker]);
};


Worker::runAll();


