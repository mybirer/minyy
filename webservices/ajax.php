<?php
define('_MYINC','minyy');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

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
require_once('../models/teams_model.php');
require_once('../models/team_members_model.php');

AuthHelper::checkSession();
// set_time_limit(0);

$_OBJ=array();
$form_data = array('success'=>false,'message'=>'Bad Query'); //Pass back the data to `form.php`
if(isset($_REQUEST) && !empty($_REQUEST)){
	$_OBJ=$_REQUEST;
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
				$form_data['message']="Success!";
				$form_data['returnedUsers']=$returnedUsers;
			}
			else{
				$form_data['message'] = 'Bad Query';
			}
		break;
		case 'ltm'://ltm stands for list team members
			if(isset($ui) && isset($token) && isset($ti) && Functions::checkToken($ui,$token)){
	
				$_columns = array( 
				// datatable column index  => database column name
					0 =>'user_id', 
					1 => 'fullname',
					2=> 'since',
					3=> 'type'
				);
				
				$search_term=isset($search['value']) ? $search['value'] : '';
				$order_by=isset($order['column']) ? $order['column'] : '';
				$order_dir=isset($order['dir']) ? $order['dir'] : '';
				$limit=isset($length) ? $length : "10";
				$offset=isset($start) ? $start : "0";

				$gparams=[
					"search_term"=>$search_term,
					"order_by"=>$order_by,
					"order_dir"=>$order_dir,
					"limit"=>$limit,
					"offset"=>$offset
				];
				$memberCount=TeamMembers::getTotal($ti,$search_term);
				$memberList=TeamMembers::getTeamMembers($ti,$gparams);
				$memberData=array();
				if(!empty($memberList)){
					foreach($memberList as $memberObj){
						$memberData[]=[$memberObj->user_id,$memberObj->fullname,$memberObj->since,$memberObj->type];
					}
				}
				$json_data = array(
				"draw"            => intval( isset($draw) ? $draw : 1 ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => intval( $memberCount ),  // total number of records
				"recordsFiltered" => intval( $limit ), // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $memberData   // total data array
				);
				$form_data['success']=true;
				$form_data['message']="Success!";
			}
			else{
				$form_data['message'] = 'Bad Query';
			}
		break;
	}
}
echo json_encode($json_data);
?>