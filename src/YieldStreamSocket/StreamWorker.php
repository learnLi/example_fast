<?php


namespace Administrator\ExampleFast\YieldStreamSocket;


use Administrator\ExampleFast\YieldSocket\Utils;

class StreamWorker
{
    /**
     * 连接回调
     * @var null | Closure
     */
    public $onConnect = null;

    /**
     * 开启worker回调
     * @var null
     */
    public $onStartWorker = null;

    /**
     * 接收消息回调
     * @var null
     */
    public $onMessage = null;

    public $onClose = null;

    /**
     * 连接池数量
     * @var int
     */
    public $count = 1;

    public $worker_name = 'none';

    private $address = 'tcp://127.0.0.1:8880';

    private $remote_address = "";

    /**
     * @var Select
     */
    static $_globalConnections;


    static $_workers = array();

    private $_mainSocket;

    public string $workerId;


    public function __construct($socketName = null, $count = 1)
    {
        $this->address = $socketName ? $socketName : $this->address;
        $this->workerId = \spl_object_hash($this);
        $this->count = $count;

    }

    private function init()
    {
        $this->_mainSocket = stream_socket_server($this->address, $errno, $err_msg);
        if (!$this->_mainSocket) {
            exit("$err_msg \n");
        }
        stream_set_blocking($this->_mainSocket, 0);
        $co = new Select($this->count);
        while ($co->valid()) {
            $co->addItem(new SelectItem());
            $co->next();
        }
        // 重置
        $co->rewind();
        if ($this->onStartWorker) {
            try {
                \call_user_func($this->onStartWorker, $this);
            } catch (\Exception $exception) {}
        }
        StreamWorker::$_globalConnections = $co;
        echo "--------------------------------------- \n";

        echo "socketName: $this->worker_name \n";

        echo "--------------------------------------- \n";
    }


    public function acceptConnection($socket)
    {
        \set_error_handler(function () {});
        $new_socket = stream_socket_accept($socket, 0);
        \restore_error_handler();
        if (!$new_socket) {
            return;
        }

        $connection = new TcpConnection($new_socket);
        $connection->onMessage = $this->onMessage;
        $connection->onConnect = $this->onConnect;
        $connection->onClose = $this->onClose;

        if ($connection->_errorMsg) {
            $connection->close($connection->_errorMsg);
            return;
        }

        if ($this->onConnect) {
            try {
                \call_user_func($this->onConnect, $connection);
            } catch (\Exception $exception) {
            }
        }
    }

    public function loop()
    {
        $this->init();

        while (StreamWorker::$_globalConnections->valid()) {
            // select
            $selectItem = StreamWorker::$_globalConnections->current();
            $selectItem->reads = array_merge([$this->_mainSocket], $selectItem->connections);
            if (@\stream_select($selectItem->reads, $selectItem->writes, $selectItem->_e, 0,60)) {
                foreach ($selectItem->reads as $ref) {
                    if ($ref === $this->_mainSocket) {
                        $this->acceptConnection($this->_mainSocket);
                        continue;
                    }
                    $this->getContents($selectItem->connectInstan[(int)$ref]);
                }
            }
            if ($selectItem->checkInputEmpty()) {
                StreamWorker::$_globalConnections->loop();
            }
        }
    }

    public function getContents($rfd)
    {
        // 读取数据包
        $tmp = @\stream_get_contents($rfd->_client, TcpConnection::PackageBuffet);
        if (!$tmp) {
            $rfd->close();
            return;
        }
        // 将读取的内容写入到缓存输入数据中
        $connections = StreamWorker::$_globalConnections;
        $connections->setItemInputData($rfd, $tmp);
        # $input[$i] .= $tmp;
        // 判断结尾是否有 \r\n 判断数据是否传输完整
        $tmp = substr($connections->getItemInputData($rfd), -1);
        # 定界符
        if ($tmp != "\r" && $tmp != "\n") {
            return;
        }
        $line = trim($connections->getItemInputData($rfd));
        if ($rfd->onMessage) {
            try {
                \call_user_func_array($rfd->onMessage, [$rfd, $connections->getItemInputData($rfd)]);
            } catch (\Exception $exception) {
            }
        }
        // 清空缓存输入
        $connections->ClearItemInputData($rfd);
        echo "---------------------------------------------------------------------" . PHP_EOL;
        echo 'Client >> ' . $line . "\r\n";
        echo "---------------------------------------------------------------------" . PHP_EOL;
    }

}