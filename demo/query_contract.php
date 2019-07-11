<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->pappay->queryContract([
    "contract_id"  => "201902255993378072",
]);

//DEBUG
var_dump($result);
?>
