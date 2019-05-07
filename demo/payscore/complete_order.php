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
$result = $client->payscore->completeOrder("CZG201905065ccfab58e26ad",[
    "service_id"  => "00004000000000523335451575645446",
    "finish_type" => 2,
    "total_amount" => 1,
    "real_service_end_time" => date("YmdHis"),
    'fees' => [
        [
            'fee_name' => '测试商品',
            'fee_count' => 1,
            'fee_amount' => 1,
            'fee_desc' => '测试商品',
        ]
    ],
]);

//DEBUG
var_dump($result);
?>