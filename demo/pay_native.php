<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/demo.php";
var_dump($config);
$client = new WeChatClient($config);

//调用接口
$out_trade_no = time();
$result = $client->payment->payNative([
    "body"          => "test",
    "out_trade_no"  => $out_trade_no,
    "total_fee"     => 1,
],Url::to("notify.php"));

//DEBUG
var_dump($result);
?>
<h3>订单号：<?=$out_trade_no?></h3>
<img src="http://qr.liantu.com/api.php?text=<?=$result["code_url"]?>"/>
