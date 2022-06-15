<?php
namespace Administrator\ExampleFast\YieldSocket;


interface HooksInter
{
    public static function add(string $eventName, \Closure $callback, $level = 1);

}