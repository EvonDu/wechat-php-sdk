<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Xml;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;

/**
 * Class Payscore
 * @package evondu\wechat\module
 */
class Payscore extends BaseModule {
    /**
     * 创建智慧零售订单
     * @param array $params
     * @return mixed
     */
    public function create(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'out_order_no',
            'service_id',
            'service_start_time',
            'service_start_location',
            'service_introduction',
            'risk_amount',
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/payscore/smartretail-orders";
        $params["appid"] = $this->app->config->getAppId();

        //获取签名认证信息
        $authorization = Sign::getAuthorization(
            "POST",
            "/payscore/smartretail-orders",
            $params,
            $this->app->config->getMerchantId(),
            $this->app->config->getSerialNo(),
            $this->app->config->getSslKeyPath()
        );

        //调用接口
        $http = new Http();
        $http->setHeader([
            "User-Agent: curl/7.54.0",
            "Authorization: $authorization",
            "Content-Type: application/json"
        ]);
        $result = $http->post($api,json_encode($params));
        $result = json_decode($result);

        //返回
        return $result;
    }
}