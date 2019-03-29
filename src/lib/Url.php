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
     * @return string
     */
    public static function current(){
        return $_SERVER["SERVER_PORT"] == "80" ?
            $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] :
            $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    }
}