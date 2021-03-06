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
            "appid"         => $this->app->config->getAppid(),
            "mch_id"        => $this->app->config->getMchId(),
            "now"           => time(),
            "version"       => 1,
            "sign_type"     => "MD5",
            "nonce_str"     => uniqid(),
        ];
    }

    /**
     * 获取SDK调用凭证
     * @param array $params
     * @return mixed
     * @throws \Exception
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

        //判断返回
        if(!isset($result["return_code"]) || $result["return_code"] !== "SUCCESS")
            throw new \Exception((isset($result["return_msg"]) ? $result["return_msg"] : "获取人脸识别调用凭证失败" ) . ":" . json_encode($result));

        //返回
        return $result;
    }

    /**
     * 支付押金（人脸支付）
     * @param array $params
     * @return mixed
     * @throws \Exception
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
        $nonce_str = uniqid();
        $common = [
            "appid"             => $this->app->config->getAppid(),
            "mch_id"            => $this->app->config->getMchId(),
            "nonce_str"         => $nonce_str,
            "sign_type"         => "HMAC-SHA256",
            "fee_type"          => "CNY",
            "spbill_create_ip"  => Tools::getClientIp()
        ];

        //合并参数并进行签名
        $data = array_merge($params, $common);
        $data["sign"] = Sign::HMAC_SHA256($data, $this->app->config->getKey());

        //调用接口
        $api = "https://api.mch.weixin.qq.com/pay/facepay";
        $http = new Http();
        $result = $http->post($api,Xml::arrayToXml($data));
        $result = Xml::xmlToArray($result);

        //判断返回
        if(!isset($result["return_code"]) || isset($result["err_code"]))
            throw new \Exception((isset($result["err_code_des"]) ? $result["err_code_des"] : "扫脸支付失败" ) . ":" . json_encode($result));

        //返回
        return $result;
    }
}