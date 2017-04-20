<?php
interface DatabaseObject{
    public static function insert($params);
    public static function update($id,$params);
    public static function delete($id);
    public static function getObjList($id,$params);
    public static function getObj($id);
}