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
            if($req){
                header('Location: index.php');
            }
            else{
                $_SESSION['error_text']="Email veya parola yanlış olabilir. Yada panele erişim yetkiniz bulunmamaktadır. Lütfen bilgileri kontrol ederek tekrardan giriniz. ";
                ViewHelper::setTitle('Minyy | Login');
                ViewHelper::setBodyClasses('login-page');
                ViewHelper::getView('auth','login');
            }

        }
        else{
            ViewHelper::setTitle('Minyy | Login');
            ViewHelper::setBodyClasses('login-page');
            ViewHelper::getView('auth','login');
        }
    }

    public function logout(){
        AuthHelper::checkSession();
        AuthHelper::logoutSystem();
        header('Location: index.php');
    }

    public function register(){
        AuthHelper::checkSession();
        if(isset($_POST['register_form'])){
            $_DATA = filter_input_array(INPUT_POST, array(
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
            var_dump($_DATA);
            if ($_DATA === null || in_array(null, $_DATA, true)) {
                $_SESSION['error_text']=T::__("Please fill the blanks!",true);
                ViewHelper::setTitle('Minyy | Register');
                ViewHelper::setBodyClasses('register-page');
                ViewHelper::getView('auth','register');
            }
            else{
                $req=AuthHelper::loginSystem($_POST['email'],$_POST['password']);
                if($req){
                    header('Location: index.php');
                }
                else{
                    $_SESSION['error_text']="Email veya parola yanlış olabilir. Yada panele erişim yetkiniz bulunmamaktadır. Lütfen bilgileri kontrol ederek tekrardan giriniz. ";
                    ViewHelper::setTitle('Minyy | Register');
                    ViewHelper::setBodyClasses('register-page');
                    ViewHelper::getView('auth','register');
                }
            }
        }
        else{
            ViewHelper::setTitle('Minyy | Register');
            ViewHelper::setBodyClasses('register-page');
            ViewHelper::getView('auth','register');
        }
    }
}