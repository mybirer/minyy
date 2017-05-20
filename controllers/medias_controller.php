<?php
defined('_MYINC') or die();

class MediasController implements ModuleInterface
{
    public static function getList($params=array()) {
        //required libraries
        
        require_once('helpers/pagination_helper.php');
        global $objList;
        global $paginationHTML;
        global $params;
        $search_term=isset($_GET['search_term']) ? Functions::clearString($_GET['search_term']) : "";
        $order_by=isset($_GET['order_by']) && !empty($_GET['order_by']) ? strtolower(Functions::clearString($_GET['order_by'])) : "id";
        $order_dir=isset($_GET['order_dir']) && !empty($_GET['order_dir']) ? strtolower(Functions::clearString($_GET['order_dir'])) : "desc";
        $limit=isset($_GET['limit']) && !empty($_GET['limit']) ? (int) Functions::clearString($_GET['limit']) : 20;
        $page=isset($_GET['page']) && !empty($_GET['page']) ? (int) Functions::clearString($_GET['page']) : 1;
        
        $offset=($page-1)*$limit;
        $params=[
            "search_term"=>$search_term,
            "order_by"=>$order_by,
            "order_dir"=>$order_dir,
            "limit"=>$limit,
            "offset"=>$offset
        ];
        $objList = Medias::getObjList($params);

        $pagination = (new Pagination());
        $pagination->setCurrent($page);
        $pagination->setRPP($limit);
        $pagination->setTotal(Medias::getTotal(null,'all',$search_term));
        $pagination->setClasses(array("pagination","pagination-sm","no-margin","pull-right"));
        $paginationHTML = $pagination->parse();
        
        global $teamList;
        $gparams=[
            "search_term"=>"",
            "order_by"=>"name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0"
        ];
        $teamList= Teams::getObjList($gparams);

        ViewHelper::setTitle('Minyy | Medias');
        ViewHelper::getView('medias','medias');
    }
    public static function add() {
        if(isset($_POST['addMediaForm']) && isset($_POST['addMediaFormUrl'])){
            $youtube_id=ModuleHelper::getYoutubeIdFromUrl($_POST['addMediaFormUrl']);
            if(!$youtube_id){
                MessageHelper::setMessage(T::__("Error",true),"danger","ban","The URL can't parsed! Please type correct Youtube video url.");
            }
            else{
                $url="https://youtube.com/watch?v=".$youtube_id;
                $snippet=ModuleHelper::getYoutubeSnippet($youtube_id);
                if(empty($snippet)){
                    MessageHelper::setMessage(T::__("Error",true),"danger","ban","Video not found on Youtube! Please try another video. Video:".$url);
                }
                else{
                    $_DATA=array('name'=>!empty($_POST['addMediaFormName']) ? $_POST['addMediaFormName'] : $snippet['title'],
                                    'description'=>!empty($_POST['addMediaFormDescription']) ? $_POST['addMediaFormDescription'] : $snippet['description'],
                                    'url'=>$url,
                                    'type'=>"video",
                                    'thumbnail'=>$snippet['thumbnails']['default']['url'],
                                    'language'=>$_POST['addMediaFormLanguage'],
                                    'team'=>$_POST['addMediaFormTeam']);
                    $req=Medias::insert($_DATA);
                    if (!$req['status']) {
                        MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
                    }
                    else{
                        MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
                    }
                }
            }
        }
        MediasController::getList();
    }
    public static function edit($id) {
        if(isset($_POST['editMediaForm'])){
            $id=$_POST['editMediaFormId'];
            $_DATA=array('name'=>$_POST['editMediaFormName']);
            $req=Medias::update($id,$_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        else{
            global $obj;
            $obj=Medias::getObj($id);
            if(empty($obj)){
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("Group not found! Please select from the list!",true));
            }
        }
        MediasController::getList();
    }
    public static function remove($id) {
        $id=isset($id) && !empty($id) ? (int) Functions::clearString($id) : -1;
        $req=Medias::delete($id);
        if (!$req['status']) {
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
        }
        else{
            MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
        }
        MediasController::getList();
    }
    public static function show($id){
        global $media;
        $media=Medias::getObj($id);
        if(empty($media)){
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("Media not found! Please select from the list!",true));
            MediasController::getList();
        }
        else{
            ViewHelper::setTitle('Minyy | Medias');
            ViewHelper::getView('medias','show_media');
        }
    }
    public static function addSubtitle($id) {
        if(isset($_POST['addSubtitleForm'])){
            $_DATA=array('language'=>$_POST['addSubtitleFormLanguage']);
            $req=Medias::insertSubtitle($id,$_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        MediasController::show($id);
    }
    public static function editor($mediaId,$langCode) {
        global $media;
        $media=Medias::getObj($mediaId);
        if(empty($media)){
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("Media not found! Please select from the list!",true));
            MediasController::getList();
        }
        if(!($langCode==$media->lang_code || array_key_exists($langCode,$media->subtitles))){
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("Subtitle not found! Please click from the list!",true));
            ViewHelper::setTitle('Minyy | Medias');
            ViewHelper::getView('medias','show_media');
        }
        else{
            ViewHelper::setTitle('Minyy | Editor');
            ViewHelper::getView('medias','editor');
        }
    }
    
}
?>