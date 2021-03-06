<?php
/**
 * 微信MWEB支付：在手机上用微信外的浏览器打开并支付
 */
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->payment->payMweb([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "scene_info"    => json_encode([])
],Url::to("notify.php"));

//DEBUG
var_dump($result);
?>

<a href="<?=$result['mweb_url']?>">微信H5支付</a>
