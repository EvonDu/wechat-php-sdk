<?php
namespace evondu\wechat\lib;

class UrlHelp{
    /**
     * 获取访问路径
     * @param $path
     * @return string
     */
    public static function to($path){
        return $_SERVER["SERVER_PORT"] == "80" ?
            dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."/$path" :
            dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"])."/$path";
    }
}