<?php

namespace Administrator\ExampleFast;


class Animal
{
    /**
     * 是否检查
     *
     * @var bool $_isCheck
     */
    protected $_isCheck = false;


    const BITS = 1;

    const CUSTOM = 4;
    


    /**
     * 事件集合
     *
     * @var array $_events
     */
    protected $_events = array();

    /**
     * 状态码
     *
     * @var null $_statusCode
     */
    protected $_statusCode = null;

    public function __construct()
    {
        $this->_init();
    }

    // 初始化
    protected function _init()
    {
    }


    public function rule(): Animal
    {
        // dh
        return $this;
    }

    /**
     * @param  null  $statusCode
     *
     * @return Animal
     */
    public function setStatusCode($statusCode): Animal
    {
        $this->_statusCode = $statusCode;

        return $this;
    }

    public function run(): Animal
    {
        return $this;
    }


}