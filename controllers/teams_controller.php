<?php
defined('_MYINC') or die();

class TeamsController implements ModuleInterface
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

        $objList = Teams::getObjList($params);

        $pagination = (new Pagination());
        $pagination->setCurrent($page);
        $pagination->setRPP($limit);
        $pagination->setTotal(Teams::getTotal($search_term));
        $pagination->setClasses(array("pagination","pagination-sm","no-margin","pull-right"));
        $paginationHTML = $pagination->parse();
        
        $gparams=[
            "search_term"=>"",
            "order_by"=>"name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0"
        ];

        $groupList = array(['value'=>'team_manager','name'=>'Team Manager'] , 
                           ['value'=>'moderator', 'name'=>'Moderator'] , 
                           ['value'=>'member','name'=>'Member']);

        ViewHelper::setTitle('Minyy | Teams');
        ViewHelper::getView('teams','teams');
    }
    public static function add() {
        if(isset($_POST['addTeamForm'])){
            $_DATA=array('name'=>$_POST['addTeamFormName'],
                        'description'=>$_POST['addTeamFormDescription'],
                        'created_by'=>$_SESSION['user_id']);
            $req=Teams::insert($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        TeamsController::getList();
    }

    public static function edit($id) {
        if(isset($_POST['editTeamForm'])){
            $id=$_POST['editTeamFormId'];
            $_DATA=array('name'=>$_POST['editTeamFormName'],
                        'description'=>$_POST['editTeamFormDescription'],
                        'members'=>isset($_POST['editTeamFormMemberNameList']) ? $_POST['editTeamFormMemberNameList'] : [],
                        'types'=>isset($_POST['editTeamFormMemberTypeList']) ? $_POST['editTeamFormMemberTypeList'] : []);
            $req=Teams::update($id,$_DATA);
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
            $obj=Teams::getObj($id);
            if(empty($obj)){
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",T::__("Team not found! Please select from the list!",true));
            }
            else{
                $params2=[
                    "search_term"=>"",
                    "order_by"=>"name",
                    "order_dir"=>"asc",
                    "limit"=>"1000",
                    "offset"=>"0"
                ];
                $members=TeamMembers::getTeamMembers($obj->pk_team_id,$params2);
                $obj->members=$members;
            }
        }
        TeamsController::getList();
        
    }
    public static function remove($id) {
        $id=isset($id) && !empty($id) ? (int) Functions::clearString($id) : -1;
        $req=Teams::delete($id);
        if (!$req['status']) {
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
        }
        else{
            MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
        }
        TeamsController::getList();
    }

    public static function show($id){
        require_once('helpers/pagination_helper.php');
        global $team;
        global $paginationHTML;

        $team=Teams::getObj($id);
        $team->media_count=Medias::getTotal($id,'team',null);
        $team->topic_count=Topics::getTotal($id,'team',null);
        $team->subtitle_count=Subtitles::getTotal($id,'team',null);

        ViewHelper::setTitle('Minyy | Team');
        ViewHelper::getView('teams','team_dashboard');
    }
}
?>