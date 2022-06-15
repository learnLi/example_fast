<?php

namespace Administrator\ExampleFast\YieldSocket;

class SelectParams
{
    public array $connections;
    public array $reads;
    public $writes;
    public $_e;

    public function __construct(array $connections = array(), array $reads = array(), array $writes = null, $_e = null) {
        $this->connections = $connections;
        $this->reads       = $reads;
        $this->writes      = $writes;
        $this->_e          = $_e;
    }
}