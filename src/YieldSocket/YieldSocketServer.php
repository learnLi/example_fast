<?php
namespace Administrator\ExampleFast\YieldSocket;

use Iterator;

class YieldSocketServer implements Iterator
{


    private $_socket;

    private $_globalEvent;

    private $Max_user = 5000;


    public function __construct($socket)
    {
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