<?php
defined('_MYINC') or die();

class MessageHelper
{
    private static $__title='';
    private static $__class='info';
    private static $__icon='info';
    private static $__message="";

    private static $__title2='';
    private static $__class2='info';
    private static $__icon2='info';
    private static $__message2="";
    
    public static function setMessage($title,$class,$icon,$message){
        self::$__title=$title;
        self::$__class=$class;
        self::$__icon=$icon;
        self::$__message=$message;
    }

    public static function setMessage2($title,$class,$icon,$message){
        self::$__title2=$title;
        self::$__class2=$class;
        self::$__icon2=$icon;
        self::$__message2=$message;
    }

    public static function getMessageHTML(){
        $message="";
        if(!empty(self::$__message)){
            $message.= '
            <div class="alert alert-'.self::$__class.'">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="icon fa fa-'.self::$__icon.'"></i> '.self::$__title.'</h4>
                '.self::$__message.'
            </div>';
        }
        if(!empty(self::$__message2)){
            $message.= '
            <div class="alert alert-'.self::$__class2.'">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="icon fa fa-'.self::$__icon2.'"></i> '.self::$__title2.'</h4>
                '.self::$__message2.'
            </div>';
        }
        return $message;
    }

    public static function getTitle(){
        return self::$__title;
    }
    public static function getClass(){
        return self::$__class;
    }
    public static function getIcon(){
        return self::$__icon;
    }
    public static function getMessage(){
        return self::$__message;
    }
}
?>