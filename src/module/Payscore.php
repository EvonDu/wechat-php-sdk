<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Xml;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;

/**
 * Class Payscore
 * 微信支付分接口模块
 * @package evondu\wechat\module
 */
class Payscore extends BaseModule {
    /**
     * 查询用户是否可使用服务
     * @param array $params
     * @return mixed
     */
    public function ckeck(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'service_id',
            'openid',
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/payscore/user-service-state";
        $params = [
            "appid"         => $this->app->config->getAppId(),
            "service_id"    => $params["service_id"],
            "openid"        => $params["openid"],
        ];

        //获取签名认证信息
        $authorization = Sign::getAuthorization(
            "GET",
            "/payscore/user-service-state?".http_build_query($params),
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
        $result = $http->get($api."?".http_build_query($params));
        $result = json_decode($result);

        //返回
        return $result;
    }

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
            $this->app->config->getMerchantId(),
            $this->app->config->getSerialNo(),
            $this->app->config->getSslKeyPath(),
            $params
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

    /**
     * 查询智慧零售订单
     * @param $out_order_no
     * @param array $params
     * @return mixed
     */
    public function query($out_order_no, Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            //['out_order_no','query_id'],
            'service_id',
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/payscore/smartretail-orders";
        $params["appid"] = $this->app->config->getAppId();
        $params["out_order_no"] = $out_order_no;

        //获取签名认证信息
        $authorization = Sign::getAuthorization(
            "GET",
            "/payscore/smartretail-orders?".http_build_query($params),
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
        $result = $http->get($api."?".http_build_query($params));
        $result = json_decode($result);

        //返回
        return $result;
    }

    /**
     * 撤销智慧零售订单
     * @param $out_order_no
     * @param array $params
     * @return mixed
     */
    public function cancel($out_order_no, Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'service_id',
            'reason',                          //取消理由
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/payscore/smartretail-orders/$out_order_no/cancel";
        $params["appid"] = $this->app->config->getAppId();

        //获取签名认证信息
        $authorization = Sign::getAuthorization(
            "POST",
            "/payscore/smartretail-orders/$out_order_no/cancel",
            $this->app->config->getMerchantId(),
            $this->app->config->getSerialNo(),
            $this->app->config->getSslKeyPath(),
            $params
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

    /**
     * 完结智慧零售订单
     * @param $out_order_no
     * @param array $params
     * @return mixed
     */
    public function complete($out_order_no, Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'service_id',
            'finish_type',                          //1.取消订单；2.结束订单
            'total_amount',                         //扣费金额，单位为分
            'finish_ticket',                        //订单结束凭着(query获取)
            ['cancel_reason','fees']                //服务取消原因 和 扣费项
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/payscore/smartretail-orders/$out_order_no/complete";
        $params["appid"] = $this->app->config->getAppId();

        //获取签名认证信息
        $authorization = Sign::getAuthorization(
            "POST",
            "/payscore/smartretail-orders/$out_order_no/complete",
            $this->app->config->getMerchantId(),
            $this->app->config->getSerialNo(),
            $this->app->config->getSslKeyPath(),
            $params
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

    /**
     * 结算智慧零售订单(query和complete的复合)
     * @param $out_order_no
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function fulfillment($out_order_no, Array $params=[]){
        //调用订单查询获取finish_ticket
        $query = $this->query($out_order_no, $params);
        if(empty($query->state))
            throw new \Exception("订单查询失败");

        //判断订单是否已经结束
        if($query->state == "USER_PAID"){
            return (object)[
                "appid"            => $query->appid,
                "mchid"             => $query->mchid,
                "order_id"          => null,
                "out_order_no"      => $out_order_no,
                "service_id"        => $query->service_id,
            ];
        }

        //判断状态合法
        if($query->state != "USER_ACCEPTED"){
            throw new \Exception("订单状态错误");
        }

        //调用订单结束完成接口
        $params['finish_ticket'] = isset($query->finish_ticket) ? $query->finish_ticket : null;
        $complete = $this->complete($out_order_no, $params);

        //返回结果
        return $complete;
    }

    /**
     * 获取QueryString - 开启服务
     * @param $service_id
     * @return string
     */
    public function getQueryString_Enable($service_id){
        //参数准备
        $timestamp = time();
        $nonce_str = uniqid();
        $params = [
            "mch_id"        => $this->app->config->getMerchantId(),
            "service_id"    => $service_id,
            "timestamp"     => $timestamp,
            "nonce_str"     => $nonce_str,
            "sign_type"     => "HMAC-SHA256",
        ];

        //获取签名
        $sign = Sign::HMAC_SHA256($params,$this->app->config->getKey());

        //拼凑串
        $queryString = "appid=".urlencode($this->app->config->getAppId());
        foreach ($params as $key => $value){
            $queryString .= "&$key=".urlencode($value);
        }
        $queryString .= "&sign=".urlencode($sign);

        //返回
        return $queryString;
    }

    /**
     * 获取QueryString - 确认订单
     * @param $package
     * @return string
     */
    public function getQueryString_Order($package){
        //参数准备
        $timestamp = time();
        $nonce_str = uniqid();
        $params = [
            "mch_id"        => $this->app->config->getMerchantId(),
            "package"       => $package,
            "timestamp"     => $timestamp,
            "nonce_str"     => $nonce_str,
            "sign_type"     => "HMAC-SHA256",
        ];

        //获取签名
        $sign = Sign::HMAC_SHA256($params,$this->app->config->getKey());

        //拼凑串
        $queryString = "appid=".urlencode($this->app->config->getAppId());
        foreach ($params as $key => $value){
            $queryString .= "&$key=".urlencode($value);
        }
        $queryString .= "&sign=".urlencode($sign);

        //返回
        return $queryString;
    }

    /**
     * 获取QueryString - 确认订单
     * @param $service_id
     * @param $out_order_no
     * @return string
     */
    public function getQueryString_Detail($service_id, $out_order_no){
        //参数准备
        $timestamp = time();
        $nonce_str = uniqid();
        $params = [
            "mch_id"        => $this->app->config->getMerchantId(),
            "service_id"    => $service_id,
            "out_order_no"     => $out_order_no,
            "timestamp"     => $timestamp,
            "nonce_str"     => $nonce_str,
            "sign_type"     => "HMAC-SHA256",
        ];

        //获取签名
        $sign = Sign::HMAC_SHA256($params,$this->app->config->getKey());

        //拼凑串
        $queryString = "appid=".urlencode($this->app->config->getAppId());
        foreach ($params as $key => $value){
            $queryString .= "&$key=".urlencode($value);
        }
        $queryString .= "&sign=".urlencode($sign);

        //返回
        return $queryString;
    }
}