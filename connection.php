<?php
defined('_MYINC') or die();

class Db
{
    private static $instance = NULL;
    private function __construct() {}
    private function __clone() {}
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=utf8',DB_SERVER,DB_NAME), DB_USER, DB_PASS, $pdo_options);
            self::$instance->exec("SET NAMES 'utf8'");
            self::$instance->exec("SET CHARACTER SET utf8");
            self::$instance->exec("SET COLLATION_CONNECTION = 'utf8_general_ci'");
        }
        return self::$instance;
    }
}
try{
    Db::getInstance();
}
catch(PDOException $e){
    die('Veritabanına bağlanılamadı. Lütfen sistem yöneticisi ile irtibata geçiniz...');
}
?>