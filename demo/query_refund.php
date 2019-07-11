<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->payment->refundQuery([
    "out_trade_no"  => "TEXT000001",
]);

//DEBUG
var_dump($result);
?>
