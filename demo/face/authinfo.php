<?php
require '../../vendor/autoload.php';

use evondu\wechat\WeChatClient;

date_default_timezone_set('PRC');

$config = include("../config/qiyi.php");
$client = new WeChatClient($config);
$authinfo = $client->face->getAuthinfo([
    "store_id"      => "S000001",
    "store_name"    => "测试店铺1",
    "device_id"     => "D000001",
    "rawdata"       => "H0kvnUgGHKuqflNwtNqCdOVpbO4Fd4u2NRS2uJz5/n080cOlYF5nNnuyVc+UsX0+q3nVrEYAhJFyxeG8MBx/cmZSicjI8UipaehhfFiIHnBZndrCSeGizNs6PSowudTG",
]);

var_dump($authinfo);