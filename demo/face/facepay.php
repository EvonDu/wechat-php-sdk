<?php
require '../../vendor/autoload.php';

use evondu\wechat\WeChatClient;

date_default_timezone_set('PRC');

$config = include("../config/qiyi.php");
$client = new WeChatClient($config);
$authinfo = $client->face->facepay([
    "body"          => "可口可乐",
    "sub_mch_id"    => "1900000100",
    "out_trade_no"  => uniqid(),
    "total_fee"     => 1,
    "openid"        => "o7mZD0ThJr3mLB15Y_tEDRe3Qfvo",
    "face_code"     => "b713b5d2-666c-48",
]);

var_dump($authinfo);