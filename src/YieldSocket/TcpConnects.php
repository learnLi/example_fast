<?php

namespace Administrator\ExampleFast\YieldSocket;


class TcpConnects implements TcpConnectInter
{

    public $rfd;

    public int $uid;

    // 全局的连接池副本
    private static $__globalPool;


    /**
     * TcpConnects constructor.
     *
     * @param $client
     */
    public function __construct($client)
    {
        $this->rfd = $client;
        $this->uid = (int)$client;
    }

    /**
     * @param $buffer
     *
     * @return void
     */
    public function send($buffer): void
    {
        // TODO: Implement send() method.
        fwrite($this->rfd, $buffer);
    }

    private function handleBuffer($buffer)
    {
        return $this->endCode($buffer);
    }

    private function endCode($buffer)
    {
        return $buffer."\n";
    }


    private function deCode($buffer)
    {
        return rtrim($buffer, "\r\n");
    }


    /**
     * @param $buffer
     *
     * @return mixed
     */
    public function sendAll($buffer)
    {
        self::$__globalPool->sendAll($buffer);
    }

    /**
     * @return mixed
     */
    public function getUid()
    {
        // TODO: Implement getUid() method.
        return $this->uid;
    }

    /**
     * @param $uid
     *
     * @return mixed
     */
    public static function CheckUid($uid): bool
    {
        // TODO: Implement CheckUid() method.
        return self::$__globalPool->CheckUid($uid);
    }

    /**
     * @return mixed
     */
    public function close()
    {
        // TODO: Implement close() method.
    }
}