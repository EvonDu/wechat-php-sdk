<?php
namespace evondu\wechat\core;

/**
 * @property \evondu\wechat\WeChatClient $app
 */
class BaseModule{
    /**
     * @var \evondu\wechat\WeChatClient $app
     */
    protected $app;

    /**
     * 构造函数
     * Trade constructor.
     * @param $app
     */
    public function __construct(&$app){
        $this->app = $app;
    }
}