<?php
namespace evondu\wechat\module;

use evondu\wechat\core\BaseModule;
use evondu\wechat\core\Sign;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;
use evondu\wechat\lib\Tools;
use evondu\wechat\lib\Xml;

class Face extends BaseModule {
    /**
     * 获取接口公共参数
     * @return array
     */
    private function getCommonParameters(){
        return [
            "appid"         => $this->app->config->getAppId(),
            "mch_id"        => $this->app->config->getMerchantId(),
            "now"           => time(),
            "version"       => 1,
            "sign_type"     => "MD5",
            "nonce_str"     => uniqid(),
        ];
    }

    /**
     * 获取SDK调用凭证
     * @param array $params
     * @return string
     */
    public function getAuthinfo(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            ['store_id', 'store_name', 'device_id', 'rawdata']
        ]);

        //准备参数
        $api = "https://payapp.weixin.qq.com/face/get_wxpayface_authinfo";
        $data = array_merge($params, $this->getCommonParameters());
        $data["sign"] = Sign::MD5($data, $this->app->config->getKey());

        //调用接口
        $http = new Http();
        $result = $http->post($api,Xml::arrayToXml($data));
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 支付押金（人脸支付）
     * @param array $params
     * @return mixed
     */
    public function facepay(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'body',
            'out_trade_no',
            'total_fee',
            'face_code',
        ]);

        //设置公共参数/默认参数
        $timestamp = time();
        $nonce_str = uniqid();
        $common = [
            "appid"             => $this->app->config->getAppId(),
            "mch_id"            => $this->app->config->getMerchantId(),
            "nonce_str"         => $nonce_str,
            "timestamp"         => $timestamp,
            "sign_type"         => "HMAC-SHA256",
            "deposit"           => "N",
            "fee_type"          => "CNY",
            "spbill_create_ip"  => Tools::getClientIp()
        ];

        //合并参数并进行签名
        $data = array_merge($params, $common);
        $data["sign"] = Sign::HMAC_SHA256($data, $this->app->config->getKey());

        //调用接口
        $api = "https://api.mch.weixin.qq.com/deposit/facepay";
        $http = new Http();
        $result = $http->post($api,Xml::arrayToXml($data));
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }
}