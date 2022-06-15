<?php
set_time_limit(0);


function createClient($start)
{
    $port = 8880;
    $host = "127.0.0.1";
    $protocol = 'tcp://';
    $socket = stream_socket_client($protocol . $host . ":" . $port, $errno, $err_message);
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
    $sockets[$i] = (int)createClient($i);
    $client->next();

}







