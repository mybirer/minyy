<?php
class Users implements DatabaseObject {
    public $pkUserID;
    public $userName;
    public $password;
    public $email;
    public $lastVisit;
    public $fullName;
    public $registrationDate;
    public $langID;

    public function __construct($pkUserID,$userName,$password,$email,$lastVisit,$fullName,$registrationDate,$langID){
        $this->$pkUserID=$pkUserID;
        $this->$userName=$userName;
        $this->$password=$password;
        $this->$email=$email;
        $this->$lastVisit=$lastVisit;
        $this->$fullName=$fullName;
        $this->$registrationDate=$registrationDate;
        $this->$langID=$langID;
    }
    public static function insert($params){
        try{
            $db=Db::getInstance();           
            $req = $db->prepare('INSERT INTO users (userName, password, email, lastVisit, fullName, registrationDate, langID) VALUES
        (:userName, :password, :email, :lastVisit, :fullName, NOW(), :langID)');
            // the query was prepared, now we replace :id with our actual $id value
            $res=$req->execute(array('userName'=>$obj['userName'],
                                    'password'=>$obj['password'],
                                    'email'=>$obj['email'],
                                    'lastVisit'=>$obj['lastVisit'],
                                    'fullName'=>$obj['fullName'],
                                    'langID'=>$obj['langID']));
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
        return $db->lastInsertId();
    }
    public static function update($id,$params){
        try{
            $db=Db::getInstance();            
            $req = $db->prepare('UPDATE users SET userName=:userName, password=:password, email=:email, lastVisit=:lastVisit, fullName=:fullName, langID=:langID WHERE pkUserID=:id');
            $res=$req->execute(array('userName'=>$obj['userName'],
                                    'password'=>$obj['password'],
                                    'email'=>$obj['email'],
                                    'lastVisit'=>$obj['lastVisit'],
                                    'fullName'=>$obj['fullName'],
                                    'langID'=>$obj['langID'],
                                    'id'=>$id));
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
        return $id;
    }
    public static function delete($id){
        try{
            $db=Db::getInstance();            
            $req = $db->prepare('DELETE FROM users WHERE id=:id');
            $res=$req->execute(array('id'=>$id));
        }
        catch(PDOException $e){
            return $e->getMessage();
        }
        return $id;
    }
    public static function getObjList($id,$params){
        $list = [];

        $order_dirs=array("desc","asc");
        $key=array_search($params["order_dir"],$order_dirs);
        $order_dir=$order_dirs[($key) ? $key : 0];

        $order_columns=array("pkUserID", "userName", "email", "lastVisit", "fullName", "registrationDate");
        $key=array_search($params["order_by"],$order_columns);
        $order_by=$order_columns[($key) ? $key : 0];

        $limit=$params["limit"] ? $params["limit"] : "20";
        $offset=$params["offset"] ? $params["offset"] : "0";

        $query="SELECT * FROM users";
        if(!empty($search_term)){
            $query.=" WHERE lower(concat(pkUserID, '', userName, '', email, '', lastVisit, '', fullName, '', registrationDate)) LIKE :search_term";
        }
        $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

        $db = Db::getInstance();
        $req = $db->prepare($query);
        $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
        $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
        if(!empty($search_term)){
            $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
        }
        $req->execute();
        // we create a list of Post objects from the database results
        foreach($req->fetchAll() as $obj) {
            $list[] = new Users( $obj['pkUserID'],
                                $obj['userName'],
                                $obj['password'],
                                $obj['email'],
                                $obj['lastVisit'],
                                $obj['fullName'],
                                $obj['registrationDate'],
                                $obj['langID']);
        }
        return $list;
    }
    public static function getObj($id){
        try{
          $db = Db::getInstance();
          $id = intval($id);
          $req = $db->prepare('SELECT * FROM users WHERE id = :id');
          $req->execute(array('id' => $id));
          $obj = $req->fetch();
          return new Users( $obj['pkUserID'],
                            $obj['userName'],
                            $obj['password'],
                            $obj['email'],
                            $obj['lastVisit'],
                            $obj['fullName'],
                            $obj['registrationDate'],
                            $obj['langID']);
      }
      catch (PDOException $e){
          return $e->getMessage();
      }
    }
}