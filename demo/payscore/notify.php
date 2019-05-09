<?php
require '../../vendor/autoload.php';

//引入
use evondu\wechat\lib\Url;
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "../config/qiyi.php";
$client = new WeChatClient($config);
$data = $client->payscore->getNotify();