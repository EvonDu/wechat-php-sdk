<?php
namespace evondu\wechat\core;

class Sign{
    /**
     * MD5方式签名
     * @param $key
     * @param array $params
     * @return string
     */
    public static function MD5($key, array $params = []){
        //参数拼凑
        $template = null;
        ksort($params);
        foreach ($params as $name=>$value){
            if($value === null || $value === "")
                continue;
            $template .= $template ? "&$name=$value" : "$name=$value";
        }
        //进行签名
        $template .= "&key=$key";
        $sign = MD5($template);
        $sign = strtoupper($sign);
        return $sign;
    }
}