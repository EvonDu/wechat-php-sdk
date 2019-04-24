<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Xml;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;

/**
 * Class Pappay
 * @package evondu\wechat\module
 * 文档地址：https://pay.weixin.qq.com/wiki/doc/api/pap.php?chapter=18_1&index=1
 */
class Pappay extends BaseModule {
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
     * 申请扣款(免密支付)
     * @param array $params
     * @param $notify_url
     * @return mixed
     */
    public function apply(Array $params=[], $notify_url){
        //参数判断
        Parameter::checkRequire($params ,[
            'body',
            'out_trade_no',
            'total_fee',
            'contract_id',
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/pay/pappayapply";
        $data = array_merge($this->app->config->getPaymentConfig(),$params);
        $data["trade_type"] = "PAP";
        $data["notify_url"] = $notify_url;
        $data["spbill_create_ip"] = $this->getClientIp();
        $data["sign"] = Sign::MD5($data, $this->app->config->getKey());
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 查询签约关系
     * @param array $params
     * @return mixed
     */
    public function queryContract(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'contract_id',
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/papay/querycontract";
        $data = array_merge($this->app->config->getPaymentConfig(),$params);
        $data["sign"] = Sign::MD5($data, $this->app->config->getKey());
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 申请签约解约
     * @param array $params
     * @return mixed
     */
    public function deleteContract(Array $params=[]){
        //参数判断
        Parameter::checkRequire($params ,[
            'contract_id',
        ]);

        //准备参数
        $api = "https://api.mch.weixin.qq.com/papay/deletecontract";
        $data = array_merge($this->app->config->getPaymentConfig(),$params);
        $data["sign"] = Sign::MD5($data, $this->app->config->getKey());
        $xml = Xml::arrayToXml($data);

        //调用接口
        $http = new Http();
        $result = $http->post($api,$xml);
        $result = Xml::xmlToArray($result);

        //返回
        return $result;
    }

    /**
     * 获取签约地址
     * @param $plan_id
     * @param $contract_code
     * @param $request_serial
     * @param $contract_display_account
     * @param $notify_url
     * @return string
     */
    public function getEntrustUrl($plan_id, $contract_code, $request_serial, $contract_display_account, $notify_url){
        //拼接地址
        $api = "https://api.mch.weixin.qq.com/papay/entrustweb";
        $params = [
            "appid" => $this->app->config->getAppId(),
            "mch_id" => $this->app->config->getMerchantId(),
            "plan_id" => $plan_id,                                      //模板ID
            "contract_code" => $contract_code,                          //签约协议号
            "request_serial" => $request_serial,                        //商户请求签约时的序列号，要求唯一性。
            "contract_display_account" => $contract_display_account,    //签约用户的名称，用于页面展示
            "notify_url" => $notify_url,                                //签约成功回调地址
            "version" => "1.0",
            "timestamp" => time(),
            'return_web' => 1,
        ];
        $params["sign"] = Sign::MD5($params, $this->app->config->getKey());

        //返回
        $url = "$api?".http_build_query($params);
        return $url;
    }
}