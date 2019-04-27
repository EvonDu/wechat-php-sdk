<?php
require '../../vendor/autoload.php';

//引入
use evondu\wechat\lib\Url;
use evondu\wechat\WeChatClient;

//创建客户端
$config = include "../config/qiyi.php";
$client = new WeChatClient($config);

//设置时区
date_default_timezone_set('PRC');

//调用接口
$result = $client->payscore->cancel("5cc2cf97a072c",[
    "service_id"  => "00004000000000523335451575645446",
    "reason"  => "测试测试",
]);
var_dump($result);
?>