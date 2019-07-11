<?php
namespace evondu\wechat\module;

use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Url;

class Jssdk extends BaseModule {
    /**
     * 获取AccessToken(ClientCredential)
     * @return mixed
     * @throws \Exception
     */
    public function requestAccessTokenClient(){
        //拼凑地址
        $app_id = $this->app->config->getAppid();
        $app_secret = $this->app->config->getSecret();
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$app_id&secret=$app_secret";

        //调用接口
        $http = new Http();
        $json = $http->get($url);
        $result = json_decode($json);

        //判断返回
        if(empty($result->access_token))
            throw new \Exception("认证失败:".$json);

        //返回
        return $result;
    }

    /**
     * 获取JsapiTicket
     * @return mixed
     */
    public function requestJsapiTicket(){
        //获取AccessToken
        $response = $this->requestAccessTokenClient();
        $access_token = $response->access_token;

        //拼凑地址
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$access_token&type=jsapi";

        //调用接口
        $http = new Http();
        $json = $http->get($url);
        $result = json_decode($json);

        //返回
        return $result;
    }

    /**
     * 获取JsapiTicket(含缓存)
     */
    public function getJsapiTicket(){
        //读取缓存
        $app_id = $this->app->config->getAppid();
        $filepath = __DIR__."/../cache/jsapi_ticket_$app_id.cache";
        $cache = file_exists($filepath)?file_get_contents($filepath):"{}";
        $cache = json_decode($cache);

        //判断缓存是否有效
        if(isset($cache->time) && $cache->time > time()){
            //返回
            return $cache;
        }
        else {
            //从新请求并保存
            $response = $this->requestJsapiTicket();
            $response->time = time() + $response->expires_in - 200;
            @file_put_contents($filepath,json_encode($response));
            return $response;
        }
    }

    /**
     * 获取JSSDK签署
     * @param $url
     * @return array
     */
    public function getSignature($url){
        //设置参数
        $noncestr = uniqid();
        $timestamp = time();
        $ticket = $this->getJsapiTicket();

        //生成签名
        $params = "jsapi_ticket=$ticket->ticket&noncestr=$noncestr&timestamp=$timestamp&url=$url";
        $signature = sha1($params);

        //返回
        return [
            "appId"     => $this->app->config->getAppid(),
            "nonceStr"  => $noncestr,
            "timestamp" => $timestamp,
            "signature" => $signature,
        ];
    }
}