<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Xml;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;

class Payment extends BaseModule {
    /**
     * 获取客户端IP
     * @return string
     */
    protected function getClientIp() {
        $ip = null;
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    }

    /**
     * 统一下单
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
        $data["spbill_create_ip"] = $this->getClientIp();
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

    /**
     * 二维码支付
     * @param array $params
     * @param string $notify_url
     * @return mixed
     */
    public function payNative(Array $params=[], $notify_url){
        $params["trade_type"] = "NATIVE";
        return $this->unifiedOrder($params, $notify_url);
    }

    /**
     * 手机网页支付
     * @param array $params
     * @param string $notify_url
     * @return mixed
     */
    public function payMweb(Array $params=[], $notify_url){
        //参数判断
        Parameter::checkRequire($params ,[
            'scene_info',
        ]);

        //调用统一下单
        $params["trade_type"] = "MWEB";
        return $this->unifiedOrder($params, $notify_url);
    }

    /**
     * 查询订单
     * @param array $params
     * @return mixed
     */
    public function query(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            ['transaction_id ', 'out_trade_no'],
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/pay/orderquery";
        $data = array_merge($this->app->config->getPaymentConfig(), $params);
        $data["sign"] = Sign::MD5($this->app->config->getKey(), $data);
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 关闭订单
     * @param array $params
     * @return mixed
     */
    public function close(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'out_trade_no' ,
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/pay/closeorder";
        $data = array_merge($this->app->config->getPaymentConfig(), $params);
        $data["sign"] = Sign::MD5($this->app->config->getKey(), $data);
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 申请退款
     * @param array $params
     * @return mixed
     */
    public function refund(Array $params=[], $notify_url=null){
        //参数判断
        Parameter::checkRequire($params ,[
            ['transaction_id ', 'out_trade_no'],
            'out_refund_no',
            'total_fee',
            'refund_fee'
        ]);
        Parameter::checkCert($this->app->config);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/secapi/pay/refund";
        $data = array_merge($this->app->config->getPaymentConfig(),$params);
        $data["sign"] = Sign::MD5($this->app->config->getKey(), $data);
        $data["notify_url"] = $notify_url;
        $data = array_filter($data);
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $http->setSslCert($this->app->config->getSslCertPath());
        $http->setSslKey($this->app->config->getSslKeyPath());
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 查询退款
     * @param array $params
     * @return mixed
     */
    public function refundQuery(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            ['transaction_id', 'out_trade_no', 'out_refund_no', 'refund_id'],
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/pay/refundquery";
        $data = array_merge($this->app->config->getPaymentConfig(), $params);
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