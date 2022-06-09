<?php


namespace Administrator\ExampleFast\Lib;


class Utils
{
    static function xml_encode($data = [], $encoding = 'utf-8', $root = 'root')
    {
        $xml = '<?xml version="1.0" encoding="'.$encoding.'"?>';
        $xml .= "<$root>";
        $xml .= self::data_to_xml($data);
        $xml .= "</$root>";
        return $xml;
    }

    private static function data_to_xml($data)
    {
        $xml = '';

        foreach ($data as $key => $val) {
            is_numeric($key) && $key = "item id=\"$key\"";

            $xml .= "<$key>";

            $xml .= (is_array($val) || is_object($val)) ? self::data_to_xml($val) : $val;

            list($key,) = explode(' ', $key);

            $xml .= "</$key>";
        }

        return $xml;
    }
}