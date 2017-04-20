<?php
class TranslateHelper {
    public static function __($text,$return=false){ //todo use this function for parsing raw text
        if($return){
            return $text;
        }
        echo $text;
    }
    public static function ___($text,$return=false){ //todo use this function for parsing html text
        if($return){
            return $text;
        }
        echo $text;
    }
}
class T extends TranslateHelper {

}