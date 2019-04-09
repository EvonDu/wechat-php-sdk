<?php
namespace evondu\wechat;

use evondu\wechat\core\Config;
use evondu\wechat\module\Auth;
use evondu\wechat\module\Jssdk;
use evondu\wechat\module\Payment;
use evondu\wechat\module\Pappay;

/**
 * @property \evondu\wechat\core\Config $config
 * @property \evondu\wechat\module\Auth $auth
 * @property \evondu\wechat\module\Jssdk $jssdk
 * @property \evondu\wechat\module\Payment $payment
 * @property \evondu\wechat\module\Pappay $pappay
 */
class WeChatClient{
    /**
     * @var Config $config
     * @var Auth $auth
     * @var Payment $payment
     * @var Pappay $pappay
     */
    public $config;
    public $auth;
    public $jssdk;
    public $payment;
    public $pappay;

    /**
     * 构造函数
     * AlipayClient constructor.
     * @param $params
     */
    public function __construct($params){
        // 初始化核心类
        $this->config = new Config($params);

        //加载模块
        $this->auth = new Auth($this);
        $this->jssdk = new Jssdk($this);
        $this->payment = new Payment($this);
        $this->pappay = new Pappay($this);
    }
}