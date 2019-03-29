<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\UrlHelp;

//创建客户端
$config = include "config/qiyi.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->payment->payMweb([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "scene_info"    => json_encode([])
],UrlHelp::to("notify.php"));

//DEBUG
var_dump($result);
?>

<a href="<?=$result['mweb_url']?>">微信H5支付</a>
