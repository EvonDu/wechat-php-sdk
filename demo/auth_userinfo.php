<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "config/test.php";
$client = new WeChatClient($config);

//认证获取
$client->auth->oauth();
$info = $client->auth->getUserInfo();

//DEBUG
var_dump($info);
?>
