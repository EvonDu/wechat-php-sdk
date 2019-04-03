<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\lib\Xml;
use evondu\wechat\WeChatNotify;

//获取数据
$xml = file_get_contents("php://input");
$data = Xml::xmlToArray($xml);

//保存到日志
file_put_contents(__DIR__."/logs/notify.log",json_encode($data)."\n",FILE_APPEND);

//应答notify
WeChatNotify::reply(true);