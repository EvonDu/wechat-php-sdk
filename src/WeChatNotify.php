<?php
namespace evondu\wechat;

use evondu\wechat\lib\Xml;

class WeChatNotify{
    /**
     * 应答
     * @param string $return_code
     * @param string $return_msg
     */
    public static function reply($return_code="SUCCESS", $return_msg="OK"){
        $result = [
            "return_code"   => $return_code,
            "return_msg"    => $return_msg
        ];
        $xml = Xml::arrayToXml($result);
        exit($xml);
    }
}