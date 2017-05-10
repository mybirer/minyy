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
        $pagination->setTotal(Medias::getTotal($search_term));
        $pagination->setClasses(array("pagination","pagination-sm","no-margin","pull-right"));
        $paginationHTML = $pagination->parse();
        
        ViewHelper::setTitle('Minyy | Medias');
        ViewHelper::getView('medias','medias');
    }
    public static function add() {
        if(isset($_POST['addMediaForm'])){
            $_DATA=array('name'=>$_POST['addMediaFormName']);
            $req=Medias::insert($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
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
}
?>