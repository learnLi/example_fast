<?php

namespace Administrator\ExampleFast\YieldSocket;

/**
 * Interface ConnectionInter
 * 连接池
 */
interface ConnectionInter extends \Iterator
{
    public function __construct(SelectItemInter $selectItem);

    public function add(TcpConnectInter $connect);

    public function delete(int $uid);

    public function getUid();

    public function getItem($index);

}