<?php
namespace evondu\wechat\core;

/**
 * Class Config
 * @package evondu\wechat\core
 */
class Config{
    /**
     * @var string|null $app_id
     * @var string|null $app_secret
     * @var string|null $merchant_id
     * @var string|null $key
     * @var string|null $sslCertPath
     * @var string|null $sslKeyPath
     * @var string|null $sign_type
     */
    protected $app_id;
    protected $app_secret;
    protected $merchant_id;
    protected $key;
    protected $sslCertPath;
    protected $sslKeyPath;
    protected $sign_type= "MD5";

    /**
     * Config constructor.
     * @param $config
     */
    public function __construct(array $config){
        $this->app_id       = isset($config["app_id"]) ? $config["app_id"] : null;
        $this->app_secret   = isset($config["app_secret"]) ? $config["app_secret"] : null;
        $this->merchant_id  = isset($config["merchant_id"]) ? $config["merchant_id"] : null;
        $this->key          = isset($config["key"]) ? $config["key"] : null;
        //$this->sign_type    = isset($config["sign_type"]) ? $config["sign_type"] : "MD5";
        $this->sslCertPath   = isset($config["sslCertPath"]) ? $config["sslCertPath"] : null;
        $this->sslKeyPath   = isset($config["sslKeyPath"]) ? $config["sslKeyPath"] : null;
    }

    /**
     * @return mixed|null
     */
    public function getAppId(){
        return $this->app_id;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setAppId($value){
        return $this->app_id = $value;
    }

    /**
     * @return mixed|null
     */
    public function getAppSecret(){
        return $this->app_secret;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setAppSecret($value){
        return $this->app_secret = $value;
    }

    /**
     * @return mixed|null
     */
    public function getMerchantId(){
        return $this->merchant_id;
    }

    /**
     * @param $value
     */
    public function setMerchantId($value){
        $this->merchant_id = $value;
    }

    /**
     * @return mixed|null
     */
    public function getKey(){
        return $this->key;
    }

    /**
     * @param $value
     */
    public function setKey($value){
        $this->key = $value;
    }

    /**
     * @return mixed|null
     */
    public function getSslCertPath(){
        return $this->sslCertPath;
    }

    /**
     * @param $value
     */
    public function setSslCertPath($value){
        $this->sslCertPath = $value;
    }

    /**
     * @return mixed|null
     */
    public function getSslKeyPath(){
        return $this->sslKeyPath;
    }

    /**
     * @param $value
     */
    public function setSslKeyPath($value){
        $this->sslKeyPath = $value;
    }

    /**
     * @return mixed|null
     */
    public function getSignType(){
        return $this->sign_type;
    }

    /**
     * @param $value
     */
    public function setSignType($value){
        $this->sign_type = $value;
    }

    /**
     * 获取支付基本配置
     * @return array
     */
    public function getPaymentConfig(){
        return [
            "appid" => $this->app_id,
            "mch_id" => $this->merchant_id,
            "nonce_str" => time(),
            "sign_type" => $this->sign_type,
        ];
    }
}