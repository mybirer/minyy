<?php
class ViewLevels implements DatabaseObject {
    public $pk_view_level_id;
    public $title;
    public $groups;
    public $modules;

    public function __construct($pk_view_level_id,$title,$groups,$modules){
        $this->pk_view_level_id=$pk_view_level_id;
        $this->title=$title;
        $this->groups=$groups;
        $this->modules=$modules;
    }
    public static function insert($params){
        $return=[];
        if ($params === null || empty($params['title'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill all required fields!",true);
            return $return;
        }
        $tempArray=[];
        $params['title']=Functions::clearString($params['title']);
        foreach($params['groups'] as $gObj){
            $tempArray[]=(int) Functions::clearString($gObj);
        }
        $params['groups']=json_encode($tempArray);
        $tempArray=[];
        foreach($params['modules'] as $gObj){
            $tempArray[]=Functions::clearString($gObj);
        }
        $params['modules']=json_encode($tempArray);
        $db = Db::getInstance();
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_view_level_id) FROM view_levels WHERE title=:title');
        $req->execute(array('title' => $params['title']));
        $req->execute(); 
        if($req->fetchColumn()>0){
            $return['status']=false;
            $return['message']=T::__("This name already exists! Please type different name!",true);
            return $return;
        }
        //if not, save it
        $req = $db->prepare('INSERT INTO view_levels (title,groups,modules) VALUES (:title,:groups,:modules)');
        $res=$req->execute(array('title' => $params['title'],
                                'groups' => $params['groups'],
                                'modules' => $params['modules']));
        if($res){
            $return['status']=true;
            $return['message']=T::__("The view level created succesfully",true);
            return $return;
        }
        $return['status']=false;
        $return['message']=T::__("An error occured. Please contact with administrators!",true);
        return $return;
    }
    public static function update($id,$params){
        $return=[];
        if ($params === null || empty($params['title'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill all required fields!",true);
            return $return;
        }
        $id=Functions::clearString($id);
        $tempArray=[];
        $params['title']=Functions::clearString($params['title']);
        foreach($params['groups'] as $gObj){
            $tempArray[]=(int) Functions::clearString($gObj);
        }
        $params['groups']=json_encode($tempArray);
        $tempArray=[];
        foreach($params['modules'] as $gObj){
            $tempArray[]=Functions::clearString($gObj);
        }
        $params['modules']=json_encode($tempArray);
        $db = Db::getInstance();
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_view_level_id) FROM view_levels WHERE pk_view_level_id=:id');
        $req->execute(array('id' => $id));
        if($req->fetchColumn()==0){
            $return['status']=false;
            $return['message']=T::__("View level not found!",true);
            return $return;
        }
        $req = $db->prepare('UPDATE view_levels SET title=:title, groups=:groups, modules=:modules WHERE pk_view_level_id=:id ');
        $res=$req->execute(array('id' => $id,
                                'title' => $params['title'],
                                'groups' => $params['groups'],
                                'modules' => $params['modules']));
        if($res){
            $return['status']=true;
            $return['message']=T::__(sprintf("View Level: %s The view level updated succesfully!",$params['title']),true);
            return $return;
        }
        $return['status']=false;
        $return['message']=T::__("An error occured. Please contact with administrators!",true);
        return $return;
    }
    public static function delete($id){
        $db=Db::getInstance();        
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_view_level_id) FROM view_levels WHERE pk_view_level_id=:id');
        $req->execute(array('id' => $id));
        if($req->fetchColumn()==0){
            $return['status']=false;
            $return['message']=T::__("View level not found!",true);
            return $return;
        }    
        $req = $db->prepare('DELETE FROM view_levels WHERE pk_view_level_id=:id');
        $res=$req->execute(array('id'=>$id));
        if($res){
            $return['status']=true;
            $return['message']=T::__(sprintf("ID: %s The view level deleted succesfully!",$id),true);
            return $return;
        }
        $return['status']=false;
        $return['message']=T::__("An error occured. Please contact with administrators!",true);
        return $return;
    }
    public static function getObjList($params){
        $list = [];

        $order_dirs=array("desc","asc");
        $key=array_search($params["order_dir"],$order_dirs);
        $order_dir=$order_dirs[($key) ? $key : 0];

        $order_columns=array("pk_view_level_id", "title");
        $key=array_search($params["order_by"],$order_columns);
        $order_by=$order_columns[($key) ? $key : 0];

        $limit=$params["limit"] ? $params["limit"] : "20";
        $offset=$params["offset"] ? $params["offset"] : "0";

        $query="SELECT * FROM view_levels";
        if(!empty($params['search_term'])){
            $query.=" WHERE lower(concat(pk_view_level_id, '', title)) LIKE :search_term";
        }
        $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

        $db = Db::getInstance();
        $req = $db->prepare($query);
        $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        if(!empty($params['search_term'])){
            $req->bindValue(':search_term', "%".Functions::replaceLiteralChars($params['search_term'])."%", PDO::PARAM_STR);
        }
        $req->execute();
        // we create a list of Post objects from the database results
        foreach($req->fetchAll() as $obj) {
            $list[] = new ViewLevels( $obj['pk_view_level_id'],
                                $obj['title'],
                                $obj['groups'],
                                $obj['modules']);
        }
        return $list;
    }
    public static function getObj($id){
        try{
            $db = Db::getInstance();
            $id = intval($id);
            $req = $db->prepare('SELECT * FROM view_levels WHERE pk_view_level_id = :id');
            $req->execute(array('id' => $id));
            $obj = $req->fetch();
            if($obj){
                return new ViewLevels( $obj['pk_view_level_id'],
                                $obj['title'],
                                $obj['groups'],
                                $obj['modules']);
            }
            else{
                return [];
            }
        }
        catch (PDOException $e){
            return $e->getMessage();
        }
    }
    public static function getTotal($search_term) {
      $query="SELECT COUNT(pk_view_level_id) FROM view_levels";
      if(!empty($search_term))
        $query.=" WHERE lower(concat(pk_view_level_id, '', title)) LIKE :search_term";
      $db = Db::getInstance();
      $req = $db->prepare($query);
      if(!empty($search_term))
        $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
      
      $req->execute();
      $res=$req->fetch();
      return (int) $res[0];
    }
}