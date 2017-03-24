<?php
defined('_MYINC') or die();
/*
 * Burada controller ve action değişkenlerinin default değerleri tanımlanıyor.$_COOKIE
 * Eğer kullanıcı giriş yapmamışsa page controlleri ile home actionu çağrılır
 * Eğer kullanıcı giriş yapmışsa module controlleri ile dashboard actionu çağrılır
 * Varsayılan olarak do parametresi listele olarak tanımlanır
 */
$controller = AuthHelper::isLogged() ? 'module' : 'page';
$action     = AuthHelper::isLogged() ? 'dashboard' : 'home';
/*
 * Eğer kullanıcı get ile controller, action ve do belirtmişse belirtilen değerler default değerlerin üzerine yazılır
 */
if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
}

/*
 * Bu kısımda sistemde yer alan controllerlar, bu controllerların public olup olmadığı tutulur. Eğer public ise true, değilse false değerini alır
 * Aynı zamanda sistemde yer alan action ve do parametreleri de bu kısımda tanımlanır
 */
$controllers = array( 'page' => ['home'=>true, 'error'=>true, 'login'=>true, 'register'=>true, 'logout'=>false],
                      'module' => ['dashboard'=>false, 'users'=>false, 'pages'=>false, 'posts'=>false, 'forms'=>false, 'medias'=>false, 'teams'=>false, 'languages'=>false],
                      'do' => ['list'=>false, 'add'=>false, 'edit'=>false,'remove'=>false]);

/*
 * Bu kısımda request edilen controller, action ve do parametreleri ile sistemdekiler kontrol edilir.
 */
if(array_key_exists($controller, $controllers)) { 
    if (in_array($action, $controllers[$controller])) { //eğer belirtilen controller varsa belirtilen actionun o controller içinde olup olmadığına bakılır
        if($controllers[$controller][$action]){ //eğer belirtilen action public ise logine bakılmaksızın direk çağrılır
            call($controller, $action);
        }
        else{ 
            if(AuthHelper::isLogged()){ //eğer belirtilen action public değilse logine bakılır: login varsa çağrılır, yoksa error verilir
                ViewHelper::setLayout("private"); //görünüm private görünüme çevrilir
                call($controller,$action);
            }
            else{
                call('page', 'error');
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
  require_once('controllers/' . $controller . '_controller.php'); //ilgili controlleri çağır
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