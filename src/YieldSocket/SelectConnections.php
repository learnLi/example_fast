<?php

namespace Administrator\ExampleFast\YieldSocket;

use Iterator;

class SelectConnections implements Iterator
{
    // 连接池组
    private static array $_pools;

    // socket连接
    private $_socket;

    public function __construct(array $pools, AsyncTcpConnectInter $_socket)
    {
        self::$_pools  = $pools;
        $this->_socket = $_socket;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     *
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * @return mixed
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * @return bool
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     *
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}