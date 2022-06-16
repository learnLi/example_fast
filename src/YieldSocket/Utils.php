<?php


namespace Administrator\ExampleFast\YieldSocket;


class Utils implements UtilsInter
{

    public static function Yield_Range($start, $end)
    {
        // TODO: Implement Yield_Range() method.
        while ($start < $end) {
            yield $start++;
        }
    }
}