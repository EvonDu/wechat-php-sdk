<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//认证获取
$client->auth->oauth();
$openid = $client->auth->getOpenid();

//DEBUG
var_dump($openid);
?>
