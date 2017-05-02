<?php
defined('_MYINC') or die();
/*
 * Burada controller ve action değişkenlerinin default değerleri tanımlanıyor.$_COOKIE
 * Eğer kullanıcı giriş yapmamışsa page controlleri ile home actionu çağrılır
 * Eğer kullanıcı giriş yapmışsa module controlleri ile dashboard actionu çağrılır
 */
$controller = AuthHelper::isLogged() ? 'module' : 'page';
$action     = AuthHelper::isLogged() ? 'dashboard' : 'home';
/*
 * Eğer kullanıcı get ile controller ve action belirtmişse belirtilen değerler default değerlerin üzerine yazılır
 */
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
}

/*
 * Bu kısımda sistemde yer alan controllerlar, bu controllerların public olup olmadığı tutulur. Eğer public ise true, değilse false değerini alır
 * Aynı zamanda sistemde yer alan action parametreleri de bu kısımda tanımlanır
 */
global $currentUser;
global $controllers;
$controllers = array(   'page' => [
                            'home'=>[
                                'public'=>true,
                                'name'=>'',
                                'icon'=>''
                            ],
                            'error'=>[
                                'public'=>true,
                                'name'=>'',
                                'icon'=>''
                            ],
                            'forbidden'=>[
                                'public'=>true,
                                'name'=>'',
                                'icon'=>''
                            ],
                            'login'=>[
                                'public'=>true,
                                'name'=>'',
                                'icon'=>''
                            ],
                            'register'=>[
                                'public'=>true,
                                'name'=>'',
                                'icon'=>''
                            ],
                            'forgotpassword'=>[
                                'public'=>true,
                                'name'=>'',
                                'icon'=>''
                            ],
                            'logout'=>[
                                'public'=>false,
                                'name'=>'',
                                'icon'=>''
                            ]
                        ],
                        'module' => [
                            'dashboard'=>[
                                'public'=>false,
                                'name'=>T::__('Dashboard',true),
                                'icon'=>'fa-dashboard',
                                'key'=>'dashboard'
                            ],
                            'users'=>[
                                'public'=>false,
                                'name'=>T::__('Users',true),
                                'icon'=>'fa-user',
                                'key'=>'users'
                            ],
                            'user_groups'=>[
                                'public'=>false,
                                'name'=>T::__('User Groups',true),
                                'icon'=>'fa-users',
                                'key'=>'user_groups'
                            ],
                            'view_levels'=>[
                                'public'=>false,
                                'name'=>T::__('View Levels',true),
                                'icon'=>'fa-bars',
                                'key'=>'view_levels'
                            ],
                            'pages'=>[
                                'public'=>false,
                                'name'=>T::__('Pages',true),
                                'icon'=>'fa-file',
                                'key'=>'pages'
                            ],
                            'posts'=>[
                                'public'=>false,
                                'name'=>T::__('Posts',true),
                                'icon'=>'fa-file',
                                'key'=>'posts'
                            ],
                            'forms'=>[
                                'public'=>false,
                                'name'=>T::__('Forms',true),
                                'icon'=>'fa-dashboard',
                                'key'=>'forms'
                            ],
                            'medias'=>[
                                'public'=>false,
                                'name'=>T::__('Medias',true),
                                'icon'=>'fa-dashboard',
                                'key'=>'medias'
                            ],
                            'teams'=>[
                                'public'=>false,
                                'name'=>T::__('Teams',true),
                                'icon'=>'fa-dashboard',
                                'key'=>'teams'
                            ],
                            'languages'=>[
                                'public'=>false,
                                'name'=>T::__('Languages',true),
                                'icon'=>'fa-dashboard',
                                'key'=>'languages'
                            ]
                        ]);

/*
 * Bu kısımda request edilen controller ve action parametreleri ile sistemdekiler kontrol edilir.
 */
if(array_key_exists($controller, $controllers)) { 
    if (array_key_exists($action, $controllers[$controller])) { //eğer belirtilen controller varsa belirtilen actionun o controller içinde olup olmadığına bakılır
        if($controllers[$controller][$action]['public']){ //eğer belirtilen action public ise logine bakılmaksızın direk çağrılır
            call($controller, $action);
        }
        else{ 
            if(AuthHelper::isLogged()){ //eğer belirtilen action public değilse logine bakılır: login varsa çağrılır, yoksa error verilir. 
                $currentUser=Users::getObj($_SESSION['user_id']);
                if(AuthHelper::userHasAccess($_SESSION['user_id'],$controller,$action)){ // kullanıcı bu controller ve actiona erişebilecek mi
                    ViewHelper::setLayout("private"); //görünüm private görünüme çevrilir
                    call($controller,$action);
                }
                else{
                    call('page', 'forbidden');//belirtilen actiona erişim yetkisi olmadığı için 403 verecektir.
                }
                
            }
            else{
                call('page', 'login');//belirtilen action private olduğu için yetkilendirme - login isteyecektir.
            }
        }
    }
    else { //eğer belirtilen action yoksa hata verilir
        call('page', 'error');
    }
}
else{ //eğer belirtilen controller yoksa hata verilir
    call('page', 'error');
}

/*
 * Bu fonksiyon ilgili actionu ve controlleri classlarını oluşturarak çağırır.
 */
function call($controller, $action) {
    
  Functions::requireFile('controllers',$controller.'_controller.php'); //ilgili controlleri çağır
  switch($controller) {
    case 'page':
      $controller = new PageController();
    break;
    case 'module':
      $controller = new ModuleController();
    break;
  }
  $controller->{ $action }();
}