<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//认证获取
$current_url = Url::current();
$signature = $client->jssdk->getSignature($current_url);
var_dump($signature);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSSDK</title>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script>
        wx.config({
            debug: true,                                // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?=$signature["appId"]?>',          // 必填，企业号的唯一标识，此处填写企业号corpid
            timestamp: '<?=$signature["timestamp"]?>',  // 必填，生成签名的时间戳
            nonceStr: '<?=$signature["nonceStr"]?>',    // 必填，生成签名的随机串
            signature: '<?=$signature["signature"]?>',  // 必填，签名，见附录1
            jsApiList: ['chooseWXPay']
        });
        wx.ready(function(){});
    </script>
</head>
<body>
<h1>JSSDK</h1>
</body>
</html>