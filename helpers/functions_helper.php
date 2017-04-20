<?php
defined('_MYINC') or die();

class Variables
{
    public static $aylar = array( 
        'January'    =>    'Ocak', 
        'February'    =>    'Şubat', 
        'March'        =>    'Mart', 
        'April'        =>    'Nisan', 
        'May'        =>    'Mayıs', 
        'June'        =>    'Haziran', 
        'July'        =>    'Temmuz', 
        'August'    =>    'Ağustos', 
        'September'    =>    'Eylül', 
        'October'    =>    'Ekim', 
        'November'    =>    'Kasım', 
        'December'    =>    'Aralık', 
        'Monday'    =>    'Pazartesi', 
        'Tuesday'    =>    'Salı', 
        'Wednesday'    =>    'Çarşamba', 
        'Thursday'    =>    'Perşembe', 
        'Friday'    =>    'Cuma', 
        'Saturday'    =>    'Cumartesi', 
        'Sunday'    =>    'Pazar', 
    ); 
}
class Functions
{
    private function __construct() {}
    public static function clearString($string,$replaceDash=true){
        $string=preg_replace("/[;]|[\\\*]/","",$string);
        $string=str_replace("'","''",$string);
        $string=($replaceDash) ? str_replace("-","\-",$string) : $string;
        return $string;
    }
    public static function convertMonthNames($month){
        return strtr($month,Variables::$aylar);
    }
    public static function stringURLSafe($string){
        //remove any '-' from the string they will be used as concatonater
        $str = str_replace('-', ' ', $string);
        $str = str_replace('_', ' ', $string);

        //$lang =& JFactory::getLanguage();
        //$str = $lang->transliterate($str);
        //convert unwanted characters
        $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç");
        $english = array("i", "g", "u", "s", "o", "c", "I", "G", "U", "S", "O", "C");
        $str = str_replace($turkish, $english, $str);
        
        // remove any duplicate whitespace, and ensure all characters are alphanumeric
        $str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);

        // lowercase and trim
        $str = trim(strtolower($str));
        return $str;
    }
    public static function checkURLSafe($string){
        $literalChars = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç", " ");
        foreach($literalChars as $char){
            if(strpos($string,$char)===true){
                return false;
            }
        }
        if(preg_match('/\s+/', $string) || preg_match('/[^A-Za-z0-9\-\_]/', $string)){
            return false;
        }
        return true;
    }
    public static function printPre($array){
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }
    public static function replaceLineBreaks($string){
        $string=preg_replace('~\\[nrtfb]~', '', $string);
        // $json = preg_replace("!\r?\n!", "", $json);
        return $string;
    }
    public static function getCurrentMilliseconds(){
        return round(microtime(true) * 1000);
    }
    public static function isActive($route){
        if(empty($_SERVER['QUERY_STRING']) && $route=='dashboard'){
            return "active";
        }
        $vars=explode('&',$_SERVER['QUERY_STRING']);
        if($vars){
            foreach($vars as $per){
                $pm=explode("=",$per);
                if($pm[0]=="controller" && $pm[1]==$route){
                    return "active";
                }
            }
        }
    }
    public static function getUrlVariableValue($variable){
        $vars=explode('&',$_SERVER['QUERY_STRING']);
        if($vars){
            foreach($vars as $per){
                $pm=explode("=",$per);
                if($pm[0]==$variable){
                    return isset($pm[1]) ? $pm[1] : "";
                }
            }
        }
        return "";
    }
    public static function getAlertBox($type,$title,$text){
        switch($type){
            case "danger":
            $icon="ban";
            break;
            case "success":
            $icon="check";
            break;
            default:
            $icon=$type;
        }
        echo sprintf('<div class="alert alert-%s alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-%s"></i> %s</h4>
                %s
              </div>',$type,$icon,$title,$text);
    }
    public static function getFolderContent($path){
        return glob($path.'/*.*');
    }
    public static function requireFile($folder,$file){
        $files=self::getFolderContent($folder);
        if(in_array($folder."/".$file,$files)){
            require_once($folder."/".$file);
        }
    }
}