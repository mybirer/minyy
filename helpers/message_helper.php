<?php
defined('_MYINC') or die();

class MessageHelper
{
    private static $__title='';
    private static $__class='info';
    private static $__icon='info';
    private static $__message="";
    public static function setMessage($title,$class,$icon,$message){
        self::$__title=$title;
        self::$__class=$class;
        self::$__icon=$icon;
        self::$__message=$message;
    }

    public static function getMessageHTML(){
        if(!empty(self::$__message)){
            return '
            <div class="alert alert-'.self::$__class.'">
                    <h4><i class="icon fa fa-'.self::$__icon.'"></i> '.self::$__title.'</h4>
                    '.self::$__message.'
            </div>';
        }
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