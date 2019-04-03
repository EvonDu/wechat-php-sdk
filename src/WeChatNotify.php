<?php
namespace evondu\wechat;

use evondu\wechat\lib\Xml;

class WeChatNotify{
    /**
     * 获取数据
     * @return array
     */
    public static function data()
    {
        $xml = file_get_contents("php://input");
        $data = Xml::xmlToArray($xml);
        return $data;
    }

    /**
     * 应答通知
     * @param bool $success
     * @return mixed
     */
    public static function reply($success = true){
        $result = $success ? ["return_code" => "SUCCESS", "return_msg" => "OK"] : ["return_code" => "FAIL"];
        $xml = Xml::arrayToXml($result);
        return exit($xml);
    }
}