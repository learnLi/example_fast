<?php
error_reporting(E_ALL);
set_time_limit(0);
ini_set("allow_call_time_pass_reference",true);


function createClient($start)
{
    $port = 8880;
    $host = "127.0.0.1";
    $protocol = 'tcp://';
    $socket = stream_socket_client($protocol . $host . ":" . $port, $errno, $err_message,STREAM_CLIENT_ASYNC_CONNECT);
    if (!$socket) {
        exit("$err_message ($errno)");
    }
    return $socket;
}

// socket连接池
$sockets = array();
function yieldRange($start, $end) {
    while ($start < $end) {
        $start++;
        yield $start;
    }
}



$client = yieldRange(0,100);


while ($client->valid()) {
    $i = $client->current();
    $socket = createClient($i);
    sleep(1);
    $client->next();
}







