<?php
namespace Administrator\ExampleFast\YieldSocket;

interface TcpConnectInter
{
    
    public function __construct($client);

    public function send($buffer);

    // 需要拿到所有连接池并轮询发送消息
    public function sendAll($buffer);

    public function getUid();

    public function close();

    // 检查uid是否在线
    public static function CheckUid($uid);


}