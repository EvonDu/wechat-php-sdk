<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->payment->refund([
    "out_trade_no"  => "TEXT000001",
    "out_refund_no" => time(),
    "total_fee"     => 1,
    "refund_fee"    => 1,
]);

//DEBUG
var_dump($result);
?>
