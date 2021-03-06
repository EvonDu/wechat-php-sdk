<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->pappay->apply([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "contract_id"   => "201902255993378072"
],Url::to("notify.php"));

//DEBUG
var_dump($result);
?>
