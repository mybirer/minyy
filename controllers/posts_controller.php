<?php
defined('_MYINC') or die();

class PostsController implements ModuleInterface
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
            "post_type"=>"post",
            "search_term"=>$search_term,
            "order_by"=>$order_by,
            "order_dir"=>$order_dir,
            "limit"=>$limit,
            "offset"=>$offset
        ];
        
        $objList = Posts::getObjList($params);

        $pagination = (new Pagination());
        $pagination->setCurrent($page);
        $pagination->setRPP($limit);
        $pagination->setTotal(Posts::getTotal($search_term));
        $pagination->setClasses(array("pagination","pagination-sm","no-margin","pull-right"));
        $paginationHTML = $pagination->parse();
        
        $gparams=[
            "search_term"=>"",
            "order_by"=>"name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0"
        ];
        ViewHelper::setTitle('Minyy | Posts');
        ViewHelper::getView('posts','posts');
    }
    public static function add() {
        if(isset($_POST['addPostForm'])){
            $_DATA=array('post_title'=>$_POST['title'],
                        'post_alias'=>$_POST['title'],
                        'created_by'=>$_SESSION['user_id'],
                        'post_content'=>$_POST['content'],
                        'post_status'=>$_POST['status']=='publish'?'publish':'draft',
                        'comment_status'=>isset($_POST['comment_status'])?'on':'off',
                        'guid'=>com_create_guid(),
                        'post_type'=>'post',
                        'featured_image'=>'fetured image',
                        'post_params'=>'');
            $req=Posts::insert($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
            
        }
        
        ViewHelper::setTitle('Minyy | Posts');
        ViewHelper::getView('posts','add_post');
        
    }
    public static function edit($id) {
        global $obj;
        if(isset($_POST['editPostForm'])){
                $id=$_POST['editPostFormId'];
                $_DATA=array('post_title'=>$_POST['title'],
                            'post_alias'=>$_POST['title'],
                            'modified_by'=>$_SESSION['user_id'],
                            'post_content'=>$_POST['content'],
                            'post_status'=>$_POST['status']=='publish'?'publish':'draft',
                            'comment_status'=>isset($_POST['comment_status'])?'on':'off',
                            'post_type'=>'post',
                            'featured_image'=>'fetured image',
                            'post_params'=>'');
            $req=Posts::update($id,$_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
            PostsController::getList();
        }
        else{
            $obj = Posts::getObj($id);
            if($obj->post_type != 'post'){
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",'Post not found!!');
                PostsController::getList();
            }else{
                ViewHelper::setTitle('Minyy | Posts');
                ViewHelper::getView('posts','edit_post');
            }
        }

    }
    public static function remove($id) {
        $id=isset($id) && !empty($id) ? (int) Functions::clearString($id) : -1;
        $req=Posts::delete($id);
        if (!$req['status']) {
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
        }
        else{
            MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
        }
        PostsController::getList();
    }
}
?>