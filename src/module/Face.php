<?php
namespace evondu\wechat\module;

use evondu\wechat\core\BaseModule;
use evondu\wechat\core\Sign;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;
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
}