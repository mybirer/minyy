<?php
defined('_MYINC') or die();

class ModuleHelper
{
    public static function getNameByValue($groupList,$val){
        foreach($groupList as $gkey=>$gval){
            $groupObj=$groupList[$gkey];
            if($groupObj['value']==$val){
                return $groupObj['name'];
            }
        }
        return $val;
    }
}
?>