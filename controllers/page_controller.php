<?php
defined('_MYINC') or die();

class PageController
{
    public function home() {
        ViewHelper::setTitle('Minyy | Anasayfa');
        ViewHelper::getView('page/home');
    }

    public function error() {
        ViewHelper::setTitle('Minyy | Hata');
        ViewHelper::getView('page/error');
    }

    public function dashboard() {
        ViewHelper::setTitle('Minyy | Dashboard');
        ViewHelper::getView('page/dashboard');
    }

    public function login(){
        AuthHelper::checkSession();
        if(isset($_POST['email']) && isset($_POST['password'])){
            $req=AuthHelper::loginSystem($_POST['email'],$_POST['password']);
            if($req){
                header('Location: index.php');
            }
            else{
                $error_text="Email veya parola yanlış olabilir. Yada panele erişim yetkiniz bulunmamaktadır. Lütfen bilgileri kontrol ederek tekrardan giriniz. ";
                ViewHelper::setTitle('Minyy | Login');
                ViewHelper::setBodyClasses('login-page');
                ViewHelper::getView('auth/login');
            }

        }
        else{
            ViewHelper::setTitle('Minyy | Login');
            ViewHelper::setBodyClasses('login-page');
            ViewHelper::getView('auth/login');
        }
    }
    public function logout(){
        AuthHelper::checkSession();
        AuthHelper::logoutSystem();
        header('Location: index.php');
    }
}