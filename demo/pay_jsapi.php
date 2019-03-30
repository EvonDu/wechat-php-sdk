<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/qiyi.php";
$client = new WeChatClient($config);

//认证获取
$current_url = Url::current();
$signature = $client->jssdk->getSignature($current_url);
var_dump($signature);