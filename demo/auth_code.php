<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//获取授权地址
if(isset($_GET['code'])){
    $client->auth->oauthByCode($_GET['code']);
    var_dump($client->auth->getOpenid());
} else {
    //获取授权地址
    $url = $client->auth->getAuthUrl(Url::to("auth_code.php"));
    header("Location: $url");
}
?>