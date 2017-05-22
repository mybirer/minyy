<?php
defined('_MYINC') or die();

class ModuleController
{
    public function dashboard() {
        ViewHelper::setTitle('Minyy | Dashboard');
        ViewHelper::getView('page','dashboard');
    }
    public function users() {
        require_once('controllers/users_controller.php');
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
                UsersController::add();
                break;
            case "edit":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                UsersController::edit($id);
                break;
            case "remove":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                UsersController::remove($id);
                break;
            case "list":
                default:
                UsersController::getList();
            break;
        }
    }
    public function user_groups() {
        require_once('controllers/user_groups_controller.php');
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
            UserGroupsController::add();
            break;
            case "edit":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            UserGroupsController::edit($id);
            break;
            case "remove":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            UserGroupsController::remove($id);
            break;
            case "list":
            default:
            UserGroupsController::getList();
            break;
        }
    }
    public function view_levels() {
        require_once('controllers/view_levels_controller.php');
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
            ViewLevelsController::add();
            break;
            case "edit":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            ViewLevelsController::edit($id);
            break;
            case "remove":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            ViewLevelsController::remove($id);
            break;
            case "list":
            default:
            ViewLevelsController::getList();
            break;
        }
    }
    public function posts() {
        require_once('controllers/posts_controller.php');
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
            PostsController::add();
            break;
            case "edit":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            PostsController::edit($id);
            break;
            case "remove":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            PostsController::remove($id);
            break;
            case "list":
            default:
            PostsController::getList();
            break;
        }
    }
    public function pages() {
        require_once('controllers/pages_controller.php');
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
            PagesController::add();
            break;
            case "edit":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            PagesController::edit($id);
            break;
            case "remove":
            $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
            PagesController::remove($id);
            break;
            case "list":
            default:
            PagesController::getList();
            break;
        }
    }
    public function medias() {
        global $languages;
        $gparams=[
            "search_term"=>"",
            "order_by"=>"lang_name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0",
            "return_as_array"=>"true"
        ];
        $languages=Languages::getObjList($gparams);
        require_once('controllers/medias_controller.php');
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
                MediasController::add();
                break;
            case "add_subtitle":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                MediasController::addSubtitle($id);
                break;
            case "editor":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                $ml=isset($_GET['ml']) && !empty($_GET['ml']) ? Functions::clearString($_GET['ml']) : "";
                MediasController::editor($id,$ml);
                break;
            case "edit":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                MediasController::edit($id);
                break;
            case "remove":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                MediasController::remove($id);
                break;
            case "show":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                MediasController::show($id);
                break;
            case "list":
            default:
                MediasController::getList();
                break;
        }
    }

    public function teams() {
        require_once('controllers/teams_controller.php');
        global $currentUser;
        $do=isset($_GET['do']) ? $_GET['do'] : "list";
        switch($do){
            case "add":
                TeamsController::add();
                break;
            case "edit":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                TeamsController::edit($id);
                break;
            case "remove":
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                TeamsController::remove($id);
                break;
            case 'show':
                $id=isset($_GET['id']) && !empty($_GET['id']) ? (int) Functions::clearString($_GET['id']) : -1;
                TeamsController::show($id);
                break;
            case "list":
            default:
                TeamsController::getList();
                break;
        }
    }
}