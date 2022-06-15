<?php


function createClient($start)
{
    $port = 8880;
    $host = "127.0.0.1";
    $protocol = 'tcp://';

    $socket = stream_socket_client($protocol . $host . ":" . $port, $errno, $err_message);

    if (!$socket) {
        exit("$err_message ($errno)");
    }
    fwrite($socket, "这是一个client3的请求第 $start 个 请求" . "\n");
    $data = "";
    while (!feof($socket)) {
        $data .= fgets($socket, 1024);
    }
    $tmp = @\stream_get_contents($socket,1024);
    if (!$tmp) {
        return $socket;
    }
    fwrite(STDOUT, "$data" . PHP_EOL);
    return $socket;

}

$sockets = array();
function yieldRange($start, $end) {
    while ($start < $end) {
        $start++;
        yield $start;
    }
}


$client = yieldRange(0,100);


while ($client->valid()) {
    $sockets[] = createClient($client->current());
    $client->next();
}

