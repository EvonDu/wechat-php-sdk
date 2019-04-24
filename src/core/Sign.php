<?php
namespace evondu\wechat\core;

class Sign{
    /**
     * 获取签名串
     * @param $key
     * @param array $params
     * @return null|string
     */
    public static function getSignTemplate(array $params, $key){
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
     * MD5 签名
     * @param $key
     * @param array $params
     * @return string
     */
    public static function MD5(array $params, $key){
        //获取签名串
        $template = self::getSignTemplate($params, $key);
        //进行签名加密
        $sign = MD5($template);
        $sign = strtoupper($sign);
        //返回
        return $sign;
    }

    /**
     * APIv3 - 获取签名内容串
     * @param array $params
     * @param $method
     * @param $url
     * @param $timestamp
     * @return string
     */
    public static function getSignContent(array $params, $method, $url, $nonce_str ,$timestamp){
        $content = "$method\n$url\n$timestamp\n$nonce_str\n".json_encode($params)."\n";
        return $content;
    }

    /**
     * APIv3 - 获取认证签名串
     * @param array $params
     * @param $mchid
     * @param $serial_no
     * @param $method
     * @param $url
     * @return string
     */
    public static function getAuthorization($method, $url ,array $params, $mchid, $serial_no, $sslKeyPath){
        $timestamp = time();
        $nonce_str = uniqid();
        $signcontent = self::getSignContent($params, $method, $url, $nonce_str, $timestamp);
        $signature = self::SHA256_WITH_RSA($signcontent, $sslKeyPath);
        $sources = [
            "mchid"         => $mchid,
            "nonce_str"     => $nonce_str,
            "signature"     => $signature,
            "timestamp"     => $timestamp,
            "serial_no"     => $serial_no,
        ];
        $result = "";
        foreach ($sources as $key => $value){
            $result .= $result ? ",$key=\"$value\"" : "$key=\"$value\"";
        }
        $result = "WECHATPAY2-SHA256-RSA2048 ".$result;
        return $result;
    }

    /**
     * APIv3 - SHA256_WITH_RSA 签名
     * @param $signContent
     * @param $sslKeyPath
     * @return string
     */
    public static function SHA256_WITH_RSA($signContent, $sslKeyPath){
        //进行签名(用key进行签名)
        $cert = file_get_contents($sslKeyPath);
        $privateKey = openssl_get_privatekey($cert);
        openssl_sign($signContent, $sign, $privateKey, "SHA256");
        openssl_free_key($privateKey);
        $sign = base64_encode($sign);
        return $sign;
    }
}