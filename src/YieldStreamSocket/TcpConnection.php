<?php


namespace Administrator\ExampleFast\YieldStreamSocket;


use Administrator\ExampleFast\YieldSocket\TcpConnectInter;

class TcpConnection implements TcpConnectInter
{

    public int $id;

    public int $connectKey;

    public $_errorMsg = null;

    public $onMessage = null;

    public $onClose = null;

    public $onConnect = null;


    public $_client = null;


    public function __construct($client)
    {
        $this->id = (int)$client;
        $this->_client = $client;
        // 获取取余后的连接池

        $this->connectKey = ($this->id % StreamWorker::$_globalConnections->getLength());
        StreamWorker::$_globalConnections->addItemData($this);
    }

    public function send($buffer)
    {
        // TODO: Implement send() method.
        @\fwrite($this->_client, $buffer);
    }

    public function sendAll($buffer)
    {
        // TODO: Implement sendAll() method.
    }

    public function getUid()
    {
        // TODO: Implement getUid() method.
    }

    public function close($buffer = null)
    {
        // TODO: Implement close() method.
        if ($buffer) {
            $this->send($buffer);
        }
        $ref = fclose($this->_client);
        if ($ref) {
            if ($this->_client->onClose) {
                try {
                    \call_user_func($this->_client->onClose, $this->_client);
                } catch (\Exception $exception) {}
            }
        }
        StreamWorker::$_globalConnections->delItemData($this);
    }

    public static function CheckUid($uid)
    {
        // TODO: Implement CheckUid() method.
    }
}