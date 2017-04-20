<?php
defined('_MYINC') or die();

class AuthHelper
{
    public static function loginSystem($email,$password){
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
                return true;
            }
            else{
                return false;
            }
        }
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
}
?>