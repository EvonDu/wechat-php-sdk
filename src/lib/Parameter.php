<?php
namespace evondu\wechat\lib;

use evondu\wechat\core\Config;

class Parameter{
    /**
     * 检测必需参数
     * @param $params
     * @param array $names
     * @throws \Exception
     */
    static function checkRequire($params, Array $names = []){
        $keys = array_keys($params);
        foreach ($names as $item){
            if(is_array($item)){
                if(empty(array_intersect($item, $keys)))
                    throw new \Exception("缺少参数 : [ ".implode(" | ", $item)." ]");
            }
            else{
                if(!in_array($item, $keys))
                    throw new \Exception("缺少参数 : $item");
            }
        }
    }

    /**
     * 检测交易类型
     * @param $trade_type
     * @return bool
     * @throws \Exception
     */
    static function checkTradeType($trade_type){
        //参数判断
        if(!in_array($trade_type, ["JSAPI","NATIVE","APP","MWEB"]))
            throw new \Exception("交易类型(trade_type)错误");
        //返回
        return true;
    }

    /**
     * 判断证书配置
     * @param Config $config
     * @throws \Exception
     */
    static function checkCert(Config $config){
        if(empty($config->getSslKeyPath()) || empty($config->getSslCertPath()))
            throw new \Exception("未配置证书");
    }
}