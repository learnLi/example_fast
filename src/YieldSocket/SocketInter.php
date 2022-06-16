<?php

namespace Administrator\ExampleFast\YieldSocket;

interface SocketInter extends SocketBuffer
{


    public function __construct($address, $port, $protocol = "tcp");

    public function send($buffer);

    public function close();



}
