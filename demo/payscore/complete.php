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
$result = $client->payscore->completeOrder("5cde1d713a61f",[
    "service_id"  => "00004000000000523335451575645446",
    "finish_type" => 2,
    "total_amount" => 1,
    "real_service_end_time" => date("YmdHis",strtotime("+60 seconds")),
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