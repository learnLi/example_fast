<?php


namespace Administrator\ExampleFast\YieldStreamSocket;


use Administrator\ExampleFast\YieldSocket\SelectItemInter;
use Administrator\ExampleFast\YieldSocket\Utils;


class SelectItem implements SelectItemInter
{
    public $connections = array();
    public $connectInstan = array();
    public $reads = array();
    public $inputs = array();
    public $writes = null;
    public $_e = null;

    public function __construct(array $connections = array(), array $reads = array(), $writes = null, $_e = null)
    {
        $this->connections = $connections;
        $this->reads = $reads;
        $this->writes = $writes;
        $this->_e = $_e;
    }

    public function add(TcpConnection $connect)
    {
        $reject = "";
        if (count($this->connections) >= static::Max_User) {
            $reject = "Server Full. Try again later.\n";
        }
        $connect->_errorMsg = $reject;

        $this->handleAddFunc($connect);
        $this->echoConnectClient($connect);

    }

    public function delete(TcpConnection $connect)
    {
        unset($this->connections[$connect->id]);
        unset($this->connectInstan[$connect->id]);
        unset($this->writes[$connect->id]);
        unset($this->inputs[$connect->id]);
    }

    public function getInput(TcpConnection $connection)
    {
        return $this->inputs[$connection->id];
    }

    public function setInput($connection, $buffer)
    {
        $this->inputs[$connection->id] .= $buffer;
    }

    public function clearInput(TcpConnection $connection)
    {
        $this->inputs[$connection->id] = "";
    }

    public function checkInputEmpty()
    {
        $input = Utils::Yield_Range(0, count($this->inputs));
        $result = true;
        while ($input->valid()) {
            if ($this->inputs[$input->current()] != "") {
                $result = false;
            }
            $input->next();
        }
        return $result;
    }

    private function handleAddFunc(TcpConnection $connect)
    {
        $this->connections[$connect->id] = $connect->_client;
        $this->writes[$connect->id] = $connect->_client;
        $this->connectInstan[$connect->id] = $connect;
        $this->inputs[$connect->id] = "";
    }

    public function echoConnectClient($connect)
    {
        echo "Welcome to the PHP Chat Server!\n";

        echo "Client >>  User Id $connect->id" . "\n";

        echo "Connection Users counts >> " . count($this->connections) . PHP_EOL;

        echo "---------------------------------------------------------------------" . PHP_EOL;
    }
}