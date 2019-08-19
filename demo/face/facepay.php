<?php
require '../../vendor/autoload.php';

use evondu\wechat\WeChatClient;

date_default_timezone_set('PRC');

$config = include("../config/demo.php");
$client = new WeChatClient($config);
$authinfo = $client->face->facepay([
    "body"          => "测试商品",
    "out_trade_no"  => "TEST72501201407033233367018",
    "total_fee"     => 1,
    "openid"        => "o7mZD0VYSdbfK69L78NS0qO0kOgw",
    "face_code"     => "0ff4b5cb-b531-443e-8a45-f07320de4e9d",
]);

var_dump($authinfo);