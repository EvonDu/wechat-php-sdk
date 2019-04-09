<?php
namespace evondu\wechat\module;

use evondu\wechat\core\Sign;
use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Xml;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Parameter;

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
     * 微信免密支付(代扣)
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