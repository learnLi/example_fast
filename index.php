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


//$html = file_get_contents(htmlDir.'/xinfang.html');
//
//$urls = QueryList::html($html)->find('img')->attrs('src')->map(
//    function ($item) use ($baseUrl) { return $baseUrl.$item; }
//)->toArray();
//
//
//QueryList::multiGet($urls)->success(
//    function (QueryList $ql, Response $response, $index) use ($urls, $baseUrl) {
//        $filename = imageDir.DS.handleImageName($baseUrl, $urls[$index]);
//        if ( ! file_exists($filename)) {
//            $result = handleBody($response, $filename);
//            if ($result) {
//                echo "下载成功".'___'.$index.PHP_EOL;
//            }
//        }
//    }
//)->send();


//function handleImageName($baseUrl, $image)
//{
//    $img = explode('/', \str_replace($baseUrl, '', $image));
//
//    return $img[count($img) - 1];
//}

//function handleBody(Response $response, $filename)
//{
//    $fileHandle = fopen($filename, 'wb+');
//    $body       = $response->getBody();
//    fwrite($fileHandle, $body);
//    $body->close();
//    fclose($fileHandle);
//
//    return true;
//}



//var_dump($result);


function gen1() {
    for( $i = 1; $i <= 10; $i++ ) {
        echo "GEN1 : {$i}".PHP_EOL;
        // sleep没啥意思，主要就是运行时候给你一种切实的调度感，你懂么
        // 就是那种“你看！你看！尼玛,我调度了！卧槽”
        sleep( 1 );
        // 这句很关键，表示自己主动让出CPU，我不下地狱谁下地狱
        yield;
    }
}
function gen2() {
    for( $i = 1; $i <= 10; $i++ ) {
        echo "GEN2 : {$i}".PHP_EOL;
        // sleep没啥意思，主要就是运行时候给你一种切实的调度感，你懂么
        // 就是那种“你看！你看！尼玛,我调度了！卧槽”
        sleep( 1 );
        // 这句很关键，表示自己主动让出CPU，我不下地狱谁下地狱
        yield;
    }
}
$task1 = gen1();
$task2 = gen2();
while( true ) {
    // 首先我运行task1，然后task1主动下了地狱
    echo $task1->current();
    // 这会儿我可以让task2介入进来了
    echo $task2->current();
    // task1恢复中断
    $task1->next();
    // task2恢复中断
    $task2->next();
    if (!$task2->valid()) {
        die();
    }
}















