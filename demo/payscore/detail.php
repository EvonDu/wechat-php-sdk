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
$queryString = $client->payscore->getQueryString_Detail("00004000000000523335451575645446","5cc2cf97a072c");

//获取JSSDK
$current_url = Url::current();
$signature = $client->jssdk->getSignature($current_url);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>订单详情</title>
    <!-- 加载JSSDK -->
    <script src="http://res.wx.qq.com/open/js/jweixin-1.5.0.js"></script>
    <!-- 配置微信JSSDK -->
    <script>
        wx.config({
            debug: true,                                // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '<?=$signature["appId"]?>',          // 必填，企业号的唯一标识，此处填写企业号corpid
            timestamp: '<?=$signature["timestamp"]?>',  // 必填，生成签名的时间戳
            nonceStr: '<?=$signature["nonceStr"]?>',    // 必填，生成签名的随机串
            signature: '<?=$signature["signature"]?>',  // 必填，签名，见附录1
            jsApiList: ['openBusinessView']
        });
        wx.ready(function(){
            wx.invoke('openBusinessView', { businessType: 'wxpayScoreDetail', queryString:'<?=$queryString?>'}, function (res) {
                // 从微信侧小程序返回时会执行这个回调函数
                parseInt(res.err_code) === 0 ? alert("成功") : alert("失败啦");
            })
        });
    </script>
</head>
<body>
<h1>订单详情（请在微信浏览器打开）</h1>
</body>
</html>
