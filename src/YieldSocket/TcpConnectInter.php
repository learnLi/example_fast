<?php
namespace Administrator\ExampleFast\YieldSocket;

interface TcpConnectInter extends SocketBuffer
{
    
    public function __construct($client);

    public function send($buffer);

    // 需要拿到所有连接池并轮询发送消息
    public function sendAll($buffer);

    public function getUid();

    public function close($buffer);

    // 检查uid是否在线
    public static function CheckUid($uid);


}