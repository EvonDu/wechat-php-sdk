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
$result = $client->payscore->complete("5cc2cf97a072c",[
    "service_id"  => "00004000000000523335451575645446",
    "finish_type" => 2,
    "total_amount" => 1,
    'finish_ticket' => "S4zntHDLYpang3lLrCG9JnWwh3xNdXtStbPYx7L85F%2BQ3FioIO%2BmcS6%2FX0AC9p04rffXr%2BnkkWYsK7BHqR8F%2FymXZp5AJ%2BTMJ7eSdXEHcLFWdH6CjfgWgYEObT0qSA8daH0%2F0U11GEwfQB4QPSUp%2Bg33bBPjZQ%3D%3D",
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