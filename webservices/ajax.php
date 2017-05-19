<?php
define('_MYINC','minyy');
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');


require_once('../config.php');
require_once('../connection.php');

require_once('../helpers/auth_helper.php');
require_once('../helpers/view_helper.php');
require_once('../helpers/functions_helper.php');
require_once('../helpers/translate_helper.php');
require_once('../helpers/message_helper.php');

require_once('../models/model_template.php');
require_once('../models/users_model.php');
require_once('../models/view_levels_model.php');

AuthHelper::checkSession();
// set_time_limit(0);

$_OBJ=array();
$form_data = array('success'=>false,'message'=>'Bad Query'); //Pass back the data to `form.php`
if(isset($_GET) && !empty($_GET)){
	$_OBJ=$_GET;
}
else if(isset($_POST) && !empty($_POST)){
	$_OBJ=$_POST;
}
else if(isset($GLOBALS['HTTP_RAW_POST_DATA'])){
	$_OBJ=json_decode($GLOBALS['HTTP_RAW_POST_DATA'],TRUE);
}
else if(isset($HTTP_RAW_POST_DATA)){
	$_OBJ=json_decode($HTTP_RAW_POST_DATA);
}
foreach($_OBJ as $key=>$item){
	$$key=Functions::clearString($item);
}

if(isset($ot)){
	switch($ot){
		case 'fmbnoe'://fmbnoe stands for find member by name or email
			if(isset($ui) && isset($token) && isset($term) && Functions::checkToken($ui,$token)){
				$returnedUsers=[];
				$gparams=[
					"search_term"=>$term,
					"order_by"=>"name",
					"order_dir"=>"asc",
					"limit"=>"10",
					"offset"=>"0"
				];
				$userList=Users::getObjList($gparams);
				if(!empty($userList)){
					foreach($userList as $userObj){
						$returnedUsers[$userObj->pk_user_id]=$userObj->fullname;
					}
				}
				$form_data['success']=true;
				$form_data['message']="Success! Data fetched from twitter";
				$form_data['returnedUsers']=$returnedUsers;
			}
			else{
				$form_data['message'] = 'Bad Query';
			}
		break;
	}
}
header('Content-Type: application/json');
echo json_encode($form_data);
?>