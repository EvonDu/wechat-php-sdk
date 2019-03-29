<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "config/qiyi.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->payment->query([
    "out_trade_no"  => "TEXT000001",
]);

//DEBUG
var_dump($result);
?>
