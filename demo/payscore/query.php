<?php
require '../../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "../config/demo.php";
$client = new WeChatClient($config);

//设置时区
date_default_timezone_set('PRC');

//调用接口
$result = $client->payscore->query("5cc3c08c60715",[
    "service_id"  => "00004000000000523335451575645446",
]);

//DEBUG
var_dump($result);
?>