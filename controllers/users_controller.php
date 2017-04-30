<?php
defined('_MYINC') or die();

class UsersController implements ModuleInterface
{
    public static function getList($params=array()) {
        //required libraries
        require_once('helpers/pagination_helper.php');
        global $objList;
        global $paginationHTML;
        global $params;
        global $groupList;
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
        $objList = Users::getObjList($params);

        $pagination = (new Pagination());
        $pagination->setCurrent($page);
        $pagination->setRPP($limit);
        $pagination->setTotal(Users::getTotal($search_term));
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
        ViewHelper::setTitle('Minyy | Users');
        ViewHelper::getView('users','users');
    }
    public static function add() {
        if(isset($_POST['addUserForm'])){
            $_DATA=array('fullname'=>$_POST['addUserFormName'],
                        'username'=>$_POST['addUserFormUsername'],
                        'email'=>$_POST['addUserFormEmail'],
                        'password'=>$_POST['addUserFormPassword'],
                        'repassword'=>$_POST['addUserFormPassword2'],
                        'country'=>$_POST['addUserFormCountry'],
                        'phone'=>$_POST['addUserFormPhone'],
                        'picture'=>$_POST['addUserFormPicture'],
                        'about'=>$_POST['addUserFormAbout'],
                        'terms'=>'on',
                        'groups'=>isset($_POST['addUserFormGroups']) ? $_POST['addUserFormGroups'] : []);
            $req=Users::insert($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        UsersController::getList();
    }
    public static function edit($id) {
        if(isset($_POST['editUserForm'])){
            $id=$_POST['editUserFormId'];
            $_DATA=array('fullname'=>$_POST['editUserFormName'],
                        'username'=>$_POST['editUserFormUsername'],
                        'email'=>$_POST['editUserFormEmail'],
                        'password'=>$_POST['editUserFormPassword'],
                        'repassword'=>$_POST['editUserFormRepassword'],
                        'country'=>$_POST['editUserFormCountry'],
                        'phone'=>$_POST['editUserFormPhone'],
                        'picture'=>$_POST['editUserFormPicture'],
                        'about'=>$_POST['editUserFormAbout'],
                        'terms'=>'on',
                        'groups'=>isset($_POST['editUserFormGroups']) ? $_POST['editUserFormGroups'] : []);
            $req=Users::update($id,$_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
            if(isset($req['status2'])){
                if (!$req['status2']) {
                    MessageHelper::setMessage2(T::__("Error",true),"danger","ban",$req['message2']);
                }
                else{
                    MessageHelper::setMessage2(T::__("Success",true),"success","check",$req['message2']);
                }
            }
        }
        else{
            global $obj;
            $obj=Users::getObj($id);
            if(empty($obj)){
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("User not found! Please select from the list!",true));
            }
        }
        UsersController::getList();
    }
    public static function remove($id) {
        $id=isset($id) && !empty($id) ? (int) Functions::clearString($id) : -1;
        $req=Users::delete($id);
        if (!$req['status']) {
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
        }
        else{
            MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
        }
        UsersController::getList();
    }
}
?>