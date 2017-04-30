<?php
defined('_MYINC') or die();

class PageController
{
    public function home() {
        ViewHelper::setTitle('Minyy | Anasayfa');
        ViewHelper::getView('page','home');
    }

    public function error() {
        ViewHelper::setTitle('Minyy | Hata');
        ViewHelper::getView('page','error');
    }

    public function dashboard() {
        ViewHelper::setTitle('Minyy | Dashboard');
        ViewHelper::getView('page','dashboard');
    }

    public function login(){
        AuthHelper::checkSession();
        if(isset($_POST['email']) && isset($_POST['password'])){
            $req=AuthHelper::loginSystem($_POST['email'],$_POST['password']);
            if($req['status']){
                header('Location: index.php');
                return;
            }
            MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
        }
        ViewHelper::setTitle('Minyy | Login');
        ViewHelper::setBodyClasses('login-page');
        ViewHelper::getView('auth','login');
    }

    public function logout(){
        AuthHelper::checkSession();
        AuthHelper::logoutSystem();
        header('Location: index.php');
    }

    public function register(){
        if(AuthHelper::isLogged()){
            header('Location: index.php');
        }
        if(isset($_POST['register_form'])){
            $_DATA = filter_input_array(INPUT_POST, array(
                'username' => array(
                    'filter' => FILTER_UNSAFE_RAW,
                    'flags' => FILTER_NULL_ON_FAILURE,
                ),
                'fullname' => array(
                    'filter' => FILTER_UNSAFE_RAW,
                    'flags' => FILTER_NULL_ON_FAILURE,
                ),
                'email' => array(
                    'filter' => FILTER_VALIDATE_EMAIL
                ),
                'password' => array(
                    'filter' => FILTER_UNSAFE_RAW,
                    'flags' => FILTER_NULL_ON_FAILURE,
                ),
                'repassword' => array(
                    'filter' => FILTER_UNSAFE_RAW,
                    'flags' => FILTER_NULL_ON_FAILURE,
                ),
                'terms' => array(
                    'filter' => FILTER_UNSAFE_RAW,
                    'flags' => FILTER_NULL_ON_FAILURE,
                )
            ));
            $req=Users::insert($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        ViewHelper::setTitle('Minyy | Register');
        ViewHelper::setBodyClasses('register-page');
        ViewHelper::getView('auth','register');
    }

    public function forgotpassword(){
        if(AuthHelper::isLogged()){
            header('Location: index.php');
        }
        if(isset($_POST['rcpassword_form'])){
            $_DATA = filter_input_array(INPUT_POST, array(
                'email' => array(
                    'filter' => FILTER_VALIDATE_EMAIL
                )
            ));
            $req=AuthHelper::recoverPassword($_DATA);
            if (!$req['status']) {
                MessageHelper::setMessage(T::__("Error",true),"danger","ban",$req['message']);
            }
            else{
                MessageHelper::setMessage(T::__("Success",true),"success","check",$req['message']);
            }
        }
        ViewHelper::setTitle('Minyy | '.T::__("Recover Password",true));
        ViewHelper::setBodyClasses('login-page');
        ViewHelper::getView('auth','forgotpassword');
    }
}