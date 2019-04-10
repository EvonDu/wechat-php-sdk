# 微信SDK简化版
该项目根据微信支付的[开发文档](https://pay.weixin.qq.com/wiki/doc/api/index.html)重构微信的PHP-SDK，可以在项目中利用Composer简单的引入和使用，并适用于现在的各大PHP框架。

# 安装方法
`$ composer require evondu/wechat-php-sdk`

# 简单示例
这里以二维码支付为例，只用必填参数做调用（选填参数请参考[官方文档](https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_1)）
```
//引入Composer自动加载(例如YII等PHP框架则不需要，因为框架本身已经引入)
require '../vendor/autoload.php';
//引入类名空间
use evondu\wechat\WeChatClient;
use evondu\wechat\lib\Url;
//创建客户端
$config = include "config/qiyi.php";
$client = new WeChatClient([
    "app_id"        => "***************",
    "app_secret"    => "***************",
    "merchant_id"   => "***************",
    "key"           => "***************",
]);
//调用接口
$result = $client->payment->payNative([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
],Url::to("notify.php"));
```

# API
### 统一下单（NATIVE）
```
$result = $client->payment->payNative([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
], "notify_url");
```

### 统一下单（JSAPI）
```
$config = $client->payment->payJsapi([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "openid"        => $openid
], "notify_url");
```

### 统一下单（H5支付）
```
$result = $client->payment->payMweb([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "scene_info"    => json_encode([])
], "notify_url");
```

### 申请微信免密支付扣费
```
$result = $client->pappay->apply([
    "body"          => "test",
    "out_trade_no"  => time(),
    "total_fee"     => 1,
    "contract_id"   => "***********"
], "notify_url");
```

### 查询微信免密支付签约关系
```
$result = $client->pappay->queryContract([
    "contract_id"   => "***********"
]);
```

### 查询订单
```
$result = $client->payment->query([
    "out_trade_no"  => "TEXT000001",
]);
```

### 申请退款
```
$result = $client->payment->refund([
    "out_trade_no"  => "TEXT000001",
    "out_refund_no" => time(),
    "total_fee"     => 1,
    "refund_fee"    => 1,
]);
```

### 退款查询
```
$result = $client->payment->refundQuery([
    "out_trade_no"  => "TEXT000001",
]);
```

# 通知（Notify）
* 获取通知数据：`$data = WeChatNotify::data();`
* 应答通知结果：`WeChatNotify::reply(true);`