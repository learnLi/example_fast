<?php

require_once __DIR__.'/vendor/autoload.php';


use GuzzleHttp\Psr7\Response;
use QL\QueryList;
use GuzzleHttp\Client;

define("DS", DIRECTORY_SEPARATOR);
define("publicDir", __DIR__.DS.'public');
define("htmlDir", publicDir.DS.'html');
define("imageDir", publicDir.DS.'image');


$baseUrl = "http://www.1fang.wang";

//$client = new Client(['base_uri' => $baseUrl]);
//
//
//$result = $client->get(
//    '/xinfang/', [
//        RequestOptions::SINK => htmlDir.'/xinfang.html'
//    ]
//);
//
//
//if (file_exists(htmlDir.'/xinfang.html')) {
//    echo "下载成功";
//}


$html = file_get_contents(htmlDir.'/xinfang.html');

$urls = QueryList::html($html)->find('img')->attrs('src')->map(
    function ($item) use ($baseUrl) { return $baseUrl.$item; }
)->toArray();


QueryList::multiGet($urls)->success(
    function (QueryList $ql, Response $response, $index) use ($urls, $baseUrl) {
        $filename = imageDir.DS.handleImageName($baseUrl, $urls[$index]);
        if ( ! file_exists($filename)) {
            $result = handleBody($response, $filename);
            if ($result) {
                echo "下载成功".'___'.$index.PHP_EOL;
            }
        }
    }
)->send();


function handleImageName($baseUrl, $image)
{
    $img = explode('/', \str_replace($baseUrl, '', $image));

    return $img[count($img) - 1];
}

function handleBody(Response $response, $filename)
{
    $fileHandle = fopen($filename, 'wb+');
    $body       = $response->getBody();
    fwrite($fileHandle, $body);
    $body->close();
    fclose($fileHandle);

    return true;
}



//var_dump($result);











