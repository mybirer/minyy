<?php
interface DatabaseObject{
    public static function insert($params);
    public static function update($id,$params);
    public static function delete($id);
    public static function getObjList($params);
    public static function getObj($id);
}
interface ModuleInterface{
    public static function add();
    public static function edit($id);
    public static function remove($id);
    public static function getList($params=array());
}