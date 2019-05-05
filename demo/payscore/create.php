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
$result = $client->payscore->create([
    "out_order_no" => uniqid(),
    "service_id"  => "00004000000000523335451575645446",
    "service_start_time" => date("YmdHis",strtotime("+30 seconds")),
    "service_end_time" => date("YmdHis",strtotime("+1 day")),
    "service_start_location" => "利保机器人重力柜",
    "service_end_location" => "利保机器人重力柜",
    "service_introduction"=> "自助购物",
    "risk_amount" => 1,
]);
var_dump($result);

//获取小程序串
$queryString = $client->payscore->getQueryString_Order($result->package);
var_dump($queryString);

//获取JSSDK
$current_url = Url::current();
$signature = $client->jssdk->getSignature($current_url);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>创建订单</title>
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
            wx.invoke('openBusinessView', { businessType: 'wxpayScoreUse', queryString:'<?=$queryString?>'}, function (res) {
                // 从微信侧小程序返回时会执行这个回调函数
                if(parseInt(res.err_code) === 0)
                    alert("确认订单");
                else
                    alert("取消订单");
            })
        });
    </script>
</head>
<body>
</body>
</html>