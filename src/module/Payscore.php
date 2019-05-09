<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
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
            'finish_ticket',                        //订单结束凭着(query获取)
            ['cancel_reason','fees']                //服务取消原因 和 扣费项
            //'total_amount',                       //扣费金额，单位为分
            //'real_service_end_time',              //服务结束时间
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
    public function completeOrder($out_order_no, Array $params=[]){
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

        //判断结果
        if(isset($complete->code) && isset($complete->message)){
            throw new \Exception($complete->message);
        }

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

    /**
     * 获取Notify报文结果(AEAD_AES_256_GCM解密)
     * @throws \Exception
     */
    public function getNotify(){
        //获取POST BODY数据
        $body = file_get_contents("php://input");
        $data = json_decode($body);

        //检测环境
        $check_sodium_mod = extension_loaded('sodium');
        if($check_sodium_mod === false){
            throw new \Exception('没有安装sodium模块');
        }
        $check_aes256gcm = sodium_crypto_aead_aes256gcm_is_available();
        if($check_aes256gcm === false){
            throw new \Exception('当前环境不支持aes256gcm');
        }

        //获取参数
        if(empty($data->resource->ciphertext) || empty($data->resource->ciphertext) || empty($data->resource->ciphertext))
            throw new \Exception("Notify回调数据有误");
        $ciphertext         = $data->resource->ciphertext;
        $nonce              = $data->resource->nonce;
        $associated_data    = $data->resource->associated_data;
        $key                = $this->app->config->getKeyApiV3();

        //报文解密
        $decode = sodium_crypto_aead_aes256gcm_decrypt(base64_decode($ciphertext),$associated_data,$nonce,$key);
        $result = json_decode($decode);

        //返回结果
        return $result;
    }
}