<?php

namespace Administrator\ExampleFast\YieldSocket;


interface SelectInter
{
    // 最大select轮询数组
    const Max_select = 10;

    public function addItem(SelectItemInter $item);

    public function toArray();


}