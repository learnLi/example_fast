<?php


namespace Administrator\ExampleFast;


use QL\QueryList;

/**
 * Class SpiderIndex
 *
 * @package Administrator\ExampleFast
 *
 *  1. 首先保存一个基础页面html的引用
 *  2. 每一次的查询操作后的对象都保存到私有变量$_data中以当前操作的索引或键值
 *  3. 将数据以html保存时，需要在一开始就设置好保存的地址
 *  4.
 */
class SpiderIndex
{
    // 基础url
    public $base_url;

    private $_saveHtmlPath = "";

    private $_saveJsonPath = "";

    // fetch url data arrays
    private $_data = array();



    // 请求并发数
    const multi = 5;

    public function __construct($base_url, $saveHtmlPath = "", $saveJsonPath = "")
    {
        $this->base_url = $base_url;
        $this->_saveHtmlPath = $saveHtmlPath;
        $this->_saveJsonPath = $saveJsonPath;
    }

    public function setQueryData()
    {
        return $this;
    }

    public function saveHtml($key)
    {

    }

    public function send()
    {

    }




    public function saveJson()
    {

    }

    private function handleUrl()
    {
    }


}