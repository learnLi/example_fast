<?php

namespace Administrator\ExampleFast\YieldSocket;

/**
 * Interface SelectItemInter
 * select连接池 子项
 * @package Administrator\ExampleFast\YieldSocket
 */
interface SelectItemInter
{
    const Max_User = 1024;

    const Se_READ = 1;

    const Se_WRITE = 2;

    const Se_Except = 3;

    const Se_Sec_False = 0;

    const Se_Sec_True = 1;

    public function __construct(array $connections = array(), array $reads = array(), $writes = null, $_e = null);
}
