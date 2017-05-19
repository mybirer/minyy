<?php
defined('_MYINC') or die();

class ModuleHelper
{
    public static function getModules(){
        try{
            $db = Db::getInstance();
            $req = $db->prepare('SELECT * FROM modules');
            $req->execute();
            $res=$req->fetchAll(PDO::FETCH_ASSOC);
            $returnArray=[];
            foreach($res as $obj){
                $returnArray[$obj['module_key']]=$obj;
            }
            return $returnArray;
            
        }
        catch(PDOException $e){
            return [];
            var_dump($e);
            die('Die...');
        }
    }
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