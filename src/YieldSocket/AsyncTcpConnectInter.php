<?php

namespace Administrator\ExampleFast\YieldSocket;

/**
 * Interface AsyncTcpConnectInter
 * 异步tcp连接
 *
 * @package Administrator\ExampleFast\YieldSocket
 */
interface AsyncTcpConnectInter extends SocketInter
{
    public function __init();

    public function onMessage($connect, $buffer);

    public function onClose($connect);

    public function onConnect($connect);




}