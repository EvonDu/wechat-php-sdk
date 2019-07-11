<?php
require '../../vendor/autoload.php';

//引入
use evondu\wechat\lib\Url;
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "../config/demo.php";
$client = new WeChatClient($config);

//设置时区
date_default_timezone_set('PRC');

//调用接口
$result = $client->payscore->create([
    "out_order_no"              => uniqid(),
    "service_id"                => "00004000000000523335451575645446",
    "service_start_time"        => date("YmdHis",strtotime("+60 seconds")),
    "service_end_time"          => date("YmdHis",strtotime("+1 day")),
    "service_start_location"    => "利保机器人重力柜",
    "service_end_location"      => "利保机器人重力柜",
    "service_introduction"      => "自助购物",
    "risk_amount"               => 1,
    "need_user_confirm"         => false,                           //设置为免确认订单
    "openid"                    => "o7mZD0eBguk285G-DphCcmywubwo",   //设置opneid
]);
var_dump($result);