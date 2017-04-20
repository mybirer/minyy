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
                $_SESSION['user_id']=$res->pkUserID;
                $_SESSION['fullname']=$res->fullName;
                $_SESSION['email']=$res->email;
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
            $req = $db->prepare('UPDATE users SET lastVisit=NOW() WHERE pkUserID = :id');
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
        unset($_SESSION['fullname']);
        unset($_SESSION['email']);
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

    public static function registerUser($params){
        $return=[];
        if ($params === null || empty($params['username']) || empty($params['fullname']) || empty($params['password']) || empty($params['repassword']) || empty($params['email'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill the blanks",true);
            return $return;
        }
        elseif(empty($params['terms'])){
            $return['status']=false;
            $return['message']=T::__("Please agree the terms",true);
            return $return;
        }
        elseif($params['password'] != $params['repassword']){
            $return['status']=false;
            $return['message']=T::__("Passwords don't match!",true);
            return $return;
        }
        else{
            $params['username']=Functions::clearString($params['username']);
            $params['fullname']=Functions::clearString($params['fullname']);
            $params['email']=Functions::clearString($params['email']);
            $params['password']=md5($params['password']);
            $db = Db::getInstance();
            //check if credentials are exists on db 
            $req = $db->prepare('SELECT COUNT(pkUserId) FROM users WHERE username=:username OR email=:email');
            $req->execute(array(
                'username' => $params['username'],
                'email' => $params['email']));
            $req->execute(); 
            if($req->fetchColumn()>0){
                $return['status']=false;
                $return['message']=T::__("This username or email already exists! You can login with your credentials!",true);
                return $return;
            }
            //if not, save it
            $req = $db->prepare('INSERT INTO users (username,password,email,fullname,registrationDate) VALUES (:username,:password,:email,:fullname,NOW())');
            $res=$req->execute(array(
                'username' => $params['username'],
                'fullname' => $params['fullname'],
                'email' => $params['email'],
                'password' => $params['password']));
            if($res){
                $return['status']=true;
                $return['message']=T::__("The account created succesfully. You can login with your account",true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__("An error occured. Please contact with administrators!",true);
                return $return;
            }
        }
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
}
?>