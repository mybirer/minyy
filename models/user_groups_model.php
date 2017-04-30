<?php
class UserGroups implements DatabaseObject {
    public $pk_group_id;
    public $name;

    public function __construct($pk_group_id,$name){
        $this->pk_group_id=$pk_group_id;
        $this->name=$name;
    }
    public static function insert($params){
        $return=[];
        if ($params === null || empty($params['name'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill all required fields!",true);
            return $return;
        }
        $params['name']=Functions::clearString($params['name']);
        $db = Db::getInstance();
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_group_id) FROM user_groups WHERE name=:name');
        $req->execute(array('name' => $params['name']));
        $req->execute(); 
        if($req->fetchColumn()>0){
            $return['status']=false;
            $return['message']=T::__("This name already exists! Please type different name!",true);
            return $return;
        }
        //if not, save it
        $req = $db->prepare('INSERT INTO user_groups (name) VALUES (:name)');
        $res=$req->execute(array('name' => $params['name']));
        if($res){
            $return['status']=true;
            $return['message']=T::__("The group created succesfully",true);
            return $return;
        }
        $return['status']=false;
        $return['message']=T::__("An error occured. Please contact with administrators!",true);
        return $return;
    }
    public static function update($id,$params){
        $return=[];
        if ($params === null || empty($params['name'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill all required fields!",true);
            return $return;
        }
        $id=Functions::clearString($id);
        $params['name']=Functions::clearString($params['name']);
        $db = Db::getInstance();
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_group_id) FROM user_groups WHERE pk_group_id=:id');
        $req->execute(array('id' => $id));
        if($req->fetchColumn()==0){
            $return['status']=false;
            $return['message']=T::__("Group not found!",true);
            return $return;
        }
        $req = $db->prepare('UPDATE user_groups SET name=:name WHERE pk_group_id=:id ');
        $res=$req->execute(array('id' => $id,
                                'name' => $params['name']));
        if($res){
            $return['status']=true;
            $return['message']=T::__(sprintf("Group: %s The group updated succesfully!",$params['name']),true);
            return $return;
        }
        $return['status']=false;
        $return['message']=T::__("An error occured. Please contact with administrators!",true);
        return $return;
    }
    public static function delete($id){
        $db=Db::getInstance();        
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_group_id) FROM user_groups WHERE pk_group_id=:id');
        $req->execute(array('id' => $id));
        if($req->fetchColumn()==0){
            $return['status']=false;
            $return['message']=T::__("Group not found!",true);
            return $return;
        }    
        $req = $db->prepare('DELETE FROM user_groups WHERE pk_group_id=:id');
        $res=$req->execute(array('id'=>$id));
        if($res){
            $return['status']=true;
            $return['message']=T::__(sprintf("ID: %s The group deleted succesfully!",$id),true);
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

        $order_columns=array("pk_group_id", "name");
        $key=array_search($params["order_by"],$order_columns);
        $order_by=$order_columns[($key) ? $key : 0];

        $limit=$params["limit"] ? $params["limit"] : "20";
        $offset=$params["offset"] ? $params["offset"] : "0";

        $query="SELECT * FROM user_groups";
        if(!empty($params['search_term'])){
            $query.=" WHERE lower(concat(pk_group_id, '', name)) LIKE :search_term";
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
            $list[] = new UserGroups( $obj['pk_group_id'],
                                $obj['name']);
        }
        return $list;
    }
    public static function getObj($id){
        try{
            $db = Db::getInstance();
            $id = intval($id);
            $req = $db->prepare('SELECT * FROM user_groups WHERE pk_group_id = :id');
            $req->execute(array('id' => $id));
            $obj = $req->fetch();
            if($obj){
                return new UserGroups( $obj['pk_group_id'],
                                    $obj['name']);
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
      $query="SELECT COUNT(pk_group_id) FROM user_groups";
      if(!empty($search_term))
        $query.=" WHERE lower(concat(pk_group_id, '', name)) LIKE :search_term";
      $db = Db::getInstance();
      $req = $db->prepare($query);
      if(!empty($search_term))
        $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
      
      $req->execute();
      $res=$req->fetch();
      return (int) $res[0];
    }
}