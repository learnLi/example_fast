<?php

namespace Administrator\ExampleFast\YieldSocket;


use Administrator\ExampleFast\YieldStreamSocket\SelectItem;

interface SelectInter extends \Iterator
{
    // 最大select轮询数组
    const Max_select = 10;

    public function __construct($count);

    public function addItem(SelectItem $item);

    public function toArray();


}