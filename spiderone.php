<?php


require_once __DIR__.'/vendor/autoload.php';


use GuzzleHttp\RequestOptions;
use QL\QueryList;
use GuzzleHttp\Client;
use Administrator\ExampleFast\Lib\Utils;

define("DS", DIRECTORY_SEPARATOR);
define("publicDir", __DIR__.DS.'public');
define("htmlDir", publicDir.DS.'html');
define("imageDir", publicDir.DS.'image');
define("dataDir", publicDir.DS. 'data');

$baseUrl = "http://www.1fang.wang";

$baseHtml = htmlDir.DS.'index.html';




if ( ! file_exists($baseHtml)) {
    $client = new Client(['base_uri' => $baseUrl]);

    $result = $client->get(
        '/', [
            RequestOptions::SINK => $baseHtml
        ]
    );
} else {
    $html = file_get_contents($baseHtml);
}


$html = $html ? QueryList::html($html) : QueryList::get($baseUrl);

//$urls = $html->find('a')->attrs('href')->filter(
//    function ($item) use ($baseUrl) {
//        if ($item == "javascript:void(0);"
//            || $item == "javacript:void(0);"
//            || $item == "javascript:void(0)"
//            || $item == ""
//            || $item == "/"
//            || $item == $baseUrl
//        ) {
//            return false;
//        }
//
//        return true;
//    }
//);


//$title = $html->find('title')->text();
//$nav = $html->rules(
//    [
//        'name' => ['a', 'text'],
//        'url' => ['a', 'href', '', function ($item) use ($baseUrl) { return $baseUrl.$item;}]
//    ]
//)->range('div.list > li')->query()->getData()->toArray();
//$json_str = json_encode($nav, JSON_UNESCAPED_UNICODE);
//$result = file_put_contents(jsonDir.DS."nav.json", $json_str);
//if ($result) {
//    echo "写入json成功" . PHP_EOL;
//}


// 资讯
$newsData = $html->rules([
    'title' => ['a' , 'text'],
    'url' => ['a', 'href','',function($item) use($baseUrl) { return $baseUrl . $item; }]
])->range('.body > .right > li')->query()->getData()->toArray();


// 动态
$async = $html->rules([
    'title' => ['a', 'text'],
    'url' => ['a', 'href']
])->range(".layui-carousel > div > .newslist > li")->query()->getData()->toArray();


// 置业顾问
$zygw = $html->rules([
    'name' => ['div.name', 'text'],
    'avthod' => ['img', 'src','', function($item) use($baseUrl) {return $baseUrl . $item; }]
])->range(".zygj > li")->query()->getData()->toArray();

# 热门楼盘
$hotHouse = $html->rules([
    'title' => ['span.loupan','text'],
    'url' => ['span.loupan > a', 'href','',function($item) use($baseUrl) {return $baseUrl.$item;}],
    'price' => ['span:eq(2)','text']
])->range('.body > .left > .hotlist > li')->query()->getData()->toArray();


# 排行榜
$hot = $html->rules([
    'title' => [' a > .title', 'text','',function($item) { $item = explode(
        '-', $item); return $item[1];}],
    'url' => ['a', 'href','',function($item) use($baseUrl) {return $baseUrl.$item;}],
    'image' => ['a > img', 'src','',function($item) use($baseUrl) {return $baseUrl.$item;}],
    'price' => ['div.price > span', 'text']
])->range('.paiming > .width > .item')->query()->getData()->toArray();





$xmls = Utils::xml_encode($async);

$result = file_put_contents(dataDir.DS."nav.xml", $xmls);
if ($result) {
    echo "写入xml成功" . PHP_EOL;
}











