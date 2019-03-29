<?php
namespace evondu\wechat;

use evondu\wechat\core\Config;
use evondu\wechat\module\Payment;

/**
 * @property \evondu\wechat\core\Config $config
 * @property \evondu\wechat\module\Payment $payment
 */
class WeChatClient{
    /**
     * 属性
     */
    public $config;
    public $payment;

    /**
     * 构造函数
     * AlipayClient constructor.
     * @param $params
     */
    public function __construct($params){
        // 初始化核心类
        $this->config = new Config($params);

        //加载模块
        $this->payment = new Payment($this);
    }
}