<?php


namespace Administrator\ExampleFast\YieldSocket;


class Utils implements UtilsInter
{

    public static function Yield_Range($start, $end)
    {
        // TODO: Implement Yield_Range() method.
        while ($start <= $end) {
//            if (!is_null($closure)) {
//                \call_user_func_array($closure,[$start]);
//            }
            yield $start++;
        }
    }
}