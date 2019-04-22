<?php
namespace evondu\wechat\core;

class Sign{
    /**
     * 获取签名串
     * @param $key
     * @param array $params
     * @return null|string
     */
    public static function getSignTemplate($key, array $params = []){
        //参数拼凑
        $template = null;
        ksort($params);
        foreach ($params as $name=>$value){
            if($value === null || $value === "")
                continue;
            $template .= $template ? "&$name=$value" : "$name=$value";
        }
        //添加KEY
        $template .= "&key=$key";
        //返回签名串
        return $template;
    }

    /**
     * MD5方式签名
     * @param $key
     * @param array $params
     * @return string
     */
    public static function MD5($key, array $params = []){
        //获取签名串
        $template = self::getSignTemplate($key, $params);
        //进行签名加密
        $sign = MD5($template);
        $sign = strtoupper($sign);
        //返回
        return $sign;
    }
}