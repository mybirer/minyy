<?php
defined('_MYINC') or die();

class ViewLevelsController implements ModuleInterface
{
    public static function getList($params=array()) {
        //required libraries
        require_once('helpers/pagination_helper.php');
        global $objList;
        global $paginationHTML;
        global $params;
        global $groupList;
        global $modules;
        global $controllers;
        $modules=$controllers["module"];

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
        $objList = ViewLevels::getObjList($params);

        $pagination = (new Pagination());
        $pagination->setCurrent($page);
        $pagination->setRPP($limit);
        $pagination->setTotal(ViewLevels::getTotal($search_term));
        $pagination->setClasses(array("pagination","pagination-sm","no-margin","pull-right"));
        $paginationHTML = $pagination->parse();
        
        $gparams=[
            "search_term"=>"",
            "order_by"=>"name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0"
        ];
        $groupList= UserGroups::getObjList($gparams);
        ViewHelper::setTitle('Minyy | View Levels');
        ViewHelper::getView('view_levels','view_levels');
    }
    public static function add() {
        if(isset($_POST['addViewLevelForm'])){
            $_DATA=array('title'=>$_POST['addViewLevelFormTitle'],
                            'groups'=>isset($_POST['addViewLevelFormGroups']) ? $_POST['addViewLevelFormGroups'] : [],
                            'modules'=>isset($_POST['addViewLevelFormModules']) ? $_POST['addViewLevelFormModules'] : []);
            $req=ViewLevels::insert($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        ViewLevelsController::getList();
    }
    public static function edit($id) {
        if(isset($_POST['editViewLevelForm'])){
            $id=$_POST['editViewLevelFormId'];
            $_DATA=array('title'=>$_POST['editViewLevelFormTitle'],
                            'groups'=>isset($_POST['editViewLevelFormGroups']) ? $_POST['editViewLevelFormGroups'] : [],
                            'modules'=>isset($_POST['editViewLevelFormModules']) ? $_POST['editViewLevelFormModules'] : []);
            $req=ViewLevels::update($id,$_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        else{
            global $obj;
            $obj=ViewLevels::getObj($id);
            if(empty($obj)){
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("View level not found! Please select from the list!",true));
            }
        }
        ViewLevelsController::getList();
    }
    public static function remove($id) {
        $id=isset($id) && !empty($id) ? (int) Functions::clearString($id) : -1;
        $req=ViewLevels::delete($id);
        if (!$req['status']) {
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
        }
        else{
            MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
        }
        ViewLevelsController::getList();
    }
}
?>