<?php
namespace evondu\wechat\lib;

class Url{
    /**
     * 获取目标URL
     * @param $path
     * @return string
     */
    public static function to($path){
        return $_SERVER["SERVER_PORT"] == "80" ?
            dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."/$path" :
            dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"])."/$path";
    }

    /**
     * 获取当前URL
     * @param bool $query_string 是否保留GET参数
     * @return string
     */
    public static function current($query_string = false){
        //判断是否保留GET参数
        if($query_string){
            return $_SERVER["SERVER_PORT"] == "80" ?
                $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] :
                $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            return $_SERVER["SERVER_PORT"] == "80" ?
                $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL'] :
                $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REDIRECT_URL"];
        }
    }
}