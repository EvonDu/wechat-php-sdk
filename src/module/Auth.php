<?php
namespace evondu\wechat\module;

use evondu\wechat\core\BaseModule;
use evondu\wechat\lib\Http;
use evondu\wechat\lib\Url;

class Auth extends BaseModule {
    /**
     * @const string SNSAPI_BASE
     * @const string SNSAPI_USERINFO
     */
    const SNSAPI_BASE = 'snsapi_base';          //静默授权，但只能获取OPENID
    const SNSAPI_USERINFO = 'snsapi_userinfo';  //授权获取用户信息

    /**
     * @var string|null $openid
     * @var string|null $access_token
     */
    public $openid;
    public $access_token;
    public $user_info;

    /**
     * 进行认证
     * @param string $scope
     * @return string
     */
    public function oauth($scope = self::SNSAPI_BASE, $state = ""){
        if(!isset($_GET["code"]))
            return $this->toAuth(Url::current(), $scope, $state);
        else{
            $response = $this->requestAccessToken($_GET["code"]);
            $this->openid = $response->openid;
            $this->access_token = $response->access_token;
        }
    }

    /**
     * 获取AccessToken
     * @param $code
     * @return mixed
     * @throws \Exception
     */
    public function requestAccessToken($code){
        //设置参数
        $params = [
            "appid"         => $this->app->config->getAppId(),
            "secret"        => $this->app->config->getAppSecret(),
            "code"          => $code,
            "grant_type"    => "authorization_code"
        ];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?".http_build_query($params);

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
     * 获取Openid
     * @return mixed
     */
    public function getOpenid(){
        return $this->openid;
    }

    /**
     * 获取用户信息
     * @param $access_token
     * @param $openid
     * @return mixed
     * @throws \Exception
     */
    public function getUserInfo(){
        //判断认证
        if(empty($this->openid) || empty($this->access_token))
            throw new \Exception("请先进行认证");

        //拼凑地址
        $api = "https://api.weixin.qq.com/sns/userinfo?access_token=$this->access_token&openid=$this->openid";

        //调用接口
        $http = new Http();
        $json = $http->get($api);
        $result = json_decode($json);

        //返回
        return $result;
    }

    /**
     * 获取认证地址
     * @param $redirectUrl
     * @param string $scope
     * @return string
     */
    public function getAuthUrl($redirectUrl, $scope = self::SNSAPI_BASE, $state = ""){
        $params["appid"] = $this->app->config->getAppId();
        $params["redirect_uri"] = $redirectUrl;
        $params["response_type"] = "code";
        $params["scope"] = $scope;
        $params["state"] = $state;
        $params = http_build_query($params);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$params;
    }

    /**
     * 前往授权获取code
     * @param $redirect_uri
     * @return string
     */
    protected function toAuth($redirect_uri, $scope = self::SNSAPI_BASE, $state = ""){
        $url = $this->getAuthUrl($redirect_uri, $scope, $state);
        header("Location: $url");
        die;
    }
}