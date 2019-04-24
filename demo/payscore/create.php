<?php
require '../../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "../config/qiyi.php";
$client = new WeChatClient($config);

//设置时区
date_default_timezone_set('PRC');

//调用接口
$result = $client->payscore->create([
    "out_order_no" => uniqid(),
    "service_id"  => "00004000000000523335451575645446",
    "service_start_time" => date("YmdHis"),
    "service_end_time" => date("YmdHis",strtotime("+1 day")),
    "service_start_location" => "利保机器人重力柜",
    "service_end_location" => "利保机器人重力柜",
    "service_introduction"=> "自助购物",
    "risk_amount" => 1,
]);

//DEBUG
var_dump($result);
?>
