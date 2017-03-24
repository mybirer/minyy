<?php
defined('_MYINC') or die();

class ViewHelper
{
    private static $__title='Minyy | Online Translation System';
    private static $__layout='public';
    private static $__beforeHeader='';
    private static $__afterHeader='';
    private static $__beforeBody='';
    private static $__afterBody='';
    private static $__bodyClasses='';

    public static function setTitle($title){
        self::$__title=$title;
    }

    public static function getTitle(){
        return self::$__title;
    }

    public static function getView($view){
        require_once('views/'.$view.'.php');
    }

    public static function setLayout($layout){
        self::$__layout=$layout;
    }

    public static function getLayout(){
        return self::$layout;
    }

    public static function setBeforeHeader($bfHead){
        self::$__beforeHeader.=$bfHead;
    }

    public static function getBeforeHeader(){
        return self::$__beforeHeader;
    }

    public static function setBeforeBody($bfBody){
        self::$__beforeBody.=$bfBody;
    }

    public static function getBeforeBody(){
        return self::$__beforeBody;
    }
    
    public static function setAfterHeader($bfHead){
        self::$__afterHeader.=$bfHead;
    }

    public static function getAfterHeader(){
        return self::$__afterHeader;
    }

    public static function setAfterBody($bfBody){
        self::$__afterBody.=$bfBody;
    }

    public static function getAfterBody(){
        return self::$__afterBody;
    }

    public static function setBodyClasses($classes){
        self::$__bodyClasses.=$classes;
    }

    public static function getBodyClasses(){
        return self::$__bodyClasses;
    }

    public static function getHeader(){
        require_once('views/'.self::$__layout.'_header.php');
    }

    public static function getFooter(){
        require_once('views/'.self::$__layout.'_footer.php');
    }
}
?>