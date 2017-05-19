<?php
defined('_MYINC') or die();

class AuthHelper
{
    public static function loginSystem($email,$password){
        $return=[];
        if(!empty(trim($email)) && !empty(trim($password))){
            $email=Functions::clearString($email);
            $password=Functions::clearString($password);
            $db = Db::getInstance();
            $req = $db->prepare('SELECT * FROM users WHERE email = :email AND password = MD5(:password)');
            $req->execute(array('email' => $email,'password' => $password));
            $res=$req->fetchObject();
            if($res){
                $_SESSION['user_id']=$res->pk_user_id;
                $_SESSION['logged_in']=time();

                $return['status']=true;
                $return['message']="";
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__("You entered wrong email or password. May be you can't authorized for this action. Please fill the form with correct informations.",true);
                return $return;
            }
        }
        $return['status']=false;
        $return['message']=T::__("Please fill the blanks!",true);
        return $return;
    }

    public static function updateSession(){
        try{
            $db = Db::getInstance();
            $req = $db->prepare('UPDATE users SET last_visit=NOW() WHERE pk_user_id = :id');
            $req->execute(array('id' => $_SESSION['user_id']));
            $_SESSION['logged_in']=time();
        }
        catch(PDOException $e){
            var_dump($e);
            die('Die...');
        }
    }

    public static function logoutSystem(){
        $_SESSION = array();
        unset($_SESSION['user_id']);
        unset($_SESSION['logged_in']);
        session_destroy();
    }
    
    public static function checkSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function isLogged(){
        self::checkSession();
        $time=time();
        if(isset($_SESSION['logged_in'])){
            if($time-$_SESSION['logged_in']>SESSION_TIMEOUT){
                AuthHelper::logoutSystem();
                return false;
            }
            AuthHelper::updateSession();
            return true;
        }
        return false;
    }

    public static function recoverPassword($params){
        $return=[];
        if(!empty($params['email'])){
            $params['email']=Functions::clearString($params['email']);
            $db = Db::getInstance();
            $req = $db->prepare('SELECT * FROM users WHERE email = :email');
            $req->execute(array('email' => $params['email']));
            $res=$req->fetchObject();
            if($res){
                //todo send email to account $res->email
                $return['status']=true;
                $return['message']=T::__("We have sent password reset instructions to your e-mail address. Please check your inbox, junk or spam",true);
                return $return;
            }
            else{
                //normally, we should show error text but we don't want to tell anybody is any email exists on our system. so send success text even if not exists
                $return['status']=true;
                $return['message']=T::__("We have sent password reset instructions to your e-mail address. Please check your inbox, junk or spam",true);
                return $return;
            }
        }
        $return['status']=false;
        $return['message']=T::__("Please fill the blanks!",true);
        return $return;
    }

    public static function userHasAccess($currentUser,$controller,$action,$do){
        if($controller!="module"){ //todo şimdilik sadece module düzeyinde view level sorguluyoruz...
            return true;
        }
        $params=[
            "search_term"=>"",
            "order_by"=>"name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0"
        ];
        $viewLevels=ViewLevels::getObjList($params);
        if(array_key_exists($action,$currentUser->modules)){//kullanıcı o modüle erişebilir demek
            if(empty($do)){//eğer do yoksa OK
                return true;
            }
            if(in_array($do,$currentUser->modules[$action])){//eğer do varsa ve kullanıcı da o do ya erişebiliyorsa ok.
                return true;
            }
        }
        // return false;
        return true;
    }
}
?>