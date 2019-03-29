<?php
namespace evondu\wechat\lib;

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
                    throw new \Exception("missing parameter : [ ".implode(" | ", $item)." ]");
            }
            else{
                if(!in_array($item, $keys) === null)
                    throw new \Exception("missing parameter : $item");
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
        if(!in_array($trade_type, ["JSAPI","NATIVE","APP"]))
            throw new \Exception("trade_type error");
        //返回
        return true;
    }
}