<?php
require '../vendor/autoload.php';

//引入
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;

//创建客户端
$config = include "config/demo.php";
$client = new WeChatClient($config);

//认证获取OPENID
$client->auth->oauth();
$openid = $client->auth->getOpenid();

//获取JSSDK签署
$current_url = Url::current();
$signature = $client->jssdk->getSignature($current_url);
var_dump($signature);

//微信统一下单
$config = $client->payment->payJsapi([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "openid"        => $openid
],Url::to("notify.php"));
var_dump($config);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JSAPI支付</title>
    <!-- 加载微信JSSDK -->
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <!-- 配置微信JSSDK -->
    <script>
        wx.config({
            debug: true,                                // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?=$signature["appId"]?>',          // 必填，企业号的唯一标识，此处填写企业号corpid
            timestamp: '<?=$signature["timestamp"]?>',  // 必填，生成签名的时间戳
            nonceStr: '<?=$signature["nonceStr"]?>',    // 必填，生成签名的随机串
            signature: '<?=$signature["signature"]?>',  // 必填，签名，见附录1
            jsApiList: ['chooseWXPay']
        });
        wx.ready(function(){
            wx.chooseWXPay({
                "timestamp": <?=$config["timeStamp"]?>,   // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                "nonceStr": '<?=$config["nonceStr"]?>',   // 支付签名随机串，不长于 32 位
                "package": '<?=$config["package"]?>',     // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                "signType": '<?=$config["signType"]?>',   // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                "paySign": '<?=$config["paySign"]?>',     // 支付签名
                "success": function (res) {
                    alert("支付完成");
                }
            });
        });
    </script>
</head>
<body>
</body>
</html>