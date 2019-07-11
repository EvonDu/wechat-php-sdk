<?php
require '../../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "../config/demo.php";
$client = new WeChatClient($config);

//调用接口
$result = $client->payscore->ckeck([
    "service_id"    => "00004000000000523335451575645446",
    "openid"        => "o7mZD0eBguk285G-DphCcmywubwo",
]);

//DEBUG
var_dump($result);
?>
