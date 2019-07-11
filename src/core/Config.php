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
     * @var string|null $serial_no          APIv3 - 证书序列号
     */
    protected $appid;
    protected $secret;
    protected $mch_id;
    protected $key;
    protected $sslCertPath;
    protected $sslKeyPath;
    protected $sign_type = "MD5";
    protected $serial_no;
    protected $key_api_v3;

    /**
     * Config constructor.
     * @param $config
     */
    public function __construct(array $config){
        $this->appid       = isset($config["appid"]) ? $config["appid"] : null;
        $this->secret       = isset($config["secret"]) ? $config["secret"] : null;
        $this->mch_id       = isset($config["mch_id"]) ? $config["mch_id"] : null;
        $this->key          = isset($config["key"]) ? $config["key"] : null;
        //$this->sign_type  = isset($config["sign_type"]) ? $config["sign_type"] : "MD5";
        $this->sslCertPath  = isset($config["sslCertPath"]) ? $config["sslCertPath"] : null;
        $this->sslKeyPath   = isset($config["sslKeyPath"]) ? $config["sslKeyPath"] : null;
        $this->serial_no    = isset($config["serial_no"]) ? $config["serial_no"] : null;
        $this->key_api_v3   = isset($config["key_api_v3"]) ? $config["key_api_v3"] : null;
    }

    /**
     * @return mixed|null
     */
    public function getAppid(){
        return $this->appid;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setAppid($value){
        return $this->appid = $value;
    }

    /**
     * @return mixed|null
     */
    public function getSecret(){
        return $this->secret;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setSecret($value){
        return $this->secret = $value;
    }

    /**
     * @return mixed|null
     */
    public function getMchId(){
        return $this->mch_id;
    }

    /**
     * @param $value
     */
    public function setMchId($value){
        $this->mch_id = $value;
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
     * @return mixed|null
     */
    public function getSerialNo(){
        return $this->serial_no;
    }

    /**
     * @param $value
     */
    public function setSerialNo($value){
        $this->serial_no = $value;
    }

    /**
     * @return mixed|null
     */
    public function getKeyApiV3(){
        return $this->key_api_v3;
    }

    /**
     * @param $value
     */
    public function setKeyApiV3($value){
        $this->key_api_v3 = $value;
    }

    /**
     * 获取支付基本配置
     * @return array
     */
    public function getPaymentConfig(){
        return [
            "appid" => $this->appid,
            "mch_id" => $this->mch_id,
            "nonce_str" => time(),
            "sign_type" => $this->sign_type,
        ];
    }
}