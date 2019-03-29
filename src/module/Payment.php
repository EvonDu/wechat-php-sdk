<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Xml;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;

class Payment extends BaseModule {
    /**
     * @param array $params
     * @param string $notify_url
     * @return mixed
     */
    public function unifiedOrder(Array $params=[], $notify_url){
        //参数判断
        Parameter::checkRequire($params ,[
            'body',
            'out_trade_no',
            'total_fee',
            'trade_type',
        ]);
        Parameter::checkTradeType($params["trade_type"]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        $data = array_merge($this->app->config->getPaymentConfig(),$params);
        $data["notify_url"] = $notify_url;
        $data["sign"] = Sign::MD5($this->app->config->getKey(), $data);
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }
}