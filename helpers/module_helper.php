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
    public static function getYoutubeSnippet($video_id){
        $apiKey="AIzaSyACE4Mdr43S_p8zqRtFyjuc1g-N69OcIGo";
        $html = "https://www.googleapis.com/youtube/v3/videos?id={$video_id}&key={$apiKey}&part=snippet";
        $response = file_get_contents($html);
        if(!empty($response)){
            $decoded = json_decode($response, true);
            if($decoded['pageInfo']['totalResults']==0){
                return [];
            }
            foreach ($decoded['items'] as $item) {
                return $item['snippet'];
            }
        }
        return [];
    }
    public static function getYoutubeIdFromUrl($url){
        $result = array();
        //string must contain at least one = and cannot be in first position
        if(strpos($url,'youtu.be')!==false) {
            if(preg_match("/^.*\/(.*)$/",$url,$matched)){
                if(strpos($matched[1],'?')!==false) {
                    $q = parse_url($matched[1]);
                    return $q['path'];
                }
                return $matched[1];
            }
            return false;
        }
        elseif(strpos($url,'=')) {
            if(strpos($url,'?')!==false) {
                $q = parse_url($url);
                $url = $q['query'];
            }
            foreach (explode('&', $url) as $couple) {
                if(!empty($couple)){
                    list ($key, $val) = explode('=', $couple);
                    if($key=="v"){
                        return $val;
                    }
                }
            }
        }
        return false;
    }
}
?>