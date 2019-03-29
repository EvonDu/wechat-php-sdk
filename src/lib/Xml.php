<?php
namespace evondu\wechat\lib;

class Xml{
    /**
     * Array转化为XML
     * @param array $arr
     * @return string
     */
    public static function arrayToXml($arr = []){
        $xml = "<xml".">";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * XML转化为Array
     * @param $xml
     * @return mixed
     */
    public static function xmlToArray($xml){
        $objectxml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $xmljson= json_encode($objectxml );
        $xmlarray=json_decode($xmljson,true);
        return $xmlarray;
    }
}