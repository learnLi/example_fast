<?php


$fp = stream_socket_client("tcp://127.0.0.1:8880", $errno, $errstr, 0);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    send($fp);
}

function send($fp)
{
    fwrite($fp, "this is client request");
    while (!feof($fp)) {
        echo fgets($fp, 1024);
    }
    fclose($fp);
}

