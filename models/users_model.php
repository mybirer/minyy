<?php
class Users implements DatabaseObject {
    public $pk_user_id;
    public $username;
    public $password;
    public $email;
    public $last_visit;
    public $fullname;
    public $registration_date;
    public $groups;
    public $modules;

    public function __construct($pk_user_id,$username,$password,$email,$last_visit,$fullname,$registration_date){
        $this->pk_user_id=$pk_user_id;
        $this->username=$username;
        $this->password=$password;
        $this->email=$email;
        $this->last_visit=$last_visit;
        $this->fullname=$fullname;
        $this->registration_date=$registration_date;
        $this->groups=$this->getUserGroups($pk_user_id);
        $this->modules=$this->getUserModules($pk_user_id);
    }
    public static function insert($params){
        $return=[];
        if ($params === null || empty($params['username']) || empty($params['fullname']) || empty($params['password']) || empty($params['repassword']) || empty($params['email'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill all required fields!",true);
            return $return;
        }
        elseif(empty($params['terms'])){
            $return['status']=false;
            $return['message']=T::__("Please agree the terms",true);
            return $return;
        }
        elseif($params['password'] != $params['repassword']){
            $return['status']=false;
            $return['message']=T::__("Passwords don't match!",true);
            return $return;
        }
        else{
            $params['username']=Functions::clearString($params['username']);
            $params['fullname']=Functions::clearString($params['fullname']);
            $params['email']=Functions::clearString($params['email']);
            $params['password']=md5($params['password']);
            $db = Db::getInstance();
            //check if credentials are exists on db 
            $req = $db->prepare('SELECT COUNT(pk_user_id) FROM users WHERE username=:username OR email=:email');
            $req->execute(array(
                'username' => $params['username'],
                'email' => $params['email']));
            $req->execute(); 
            if($req->fetchColumn()>0){
                $return['status']=false;
                $return['message']=T::__("This username or email already exists! You can login with your credentials!",true);
                return $return;
            }
            //if not, save it
            $req = $db->prepare('INSERT INTO users (username,password,email,fullname,registration_date) VALUES (:username,:password,:email,:fullname,NOW())');
            $res=$req->execute(array(
                'username' => $params['username'],
                'fullname' => $params['fullname'],
                'email' => $params['email'],
                'password' => $params['password']));
            if($res && !empty($params['groups'])){
                $id = $db->lastInsertId();
                $groupSqlArr=[];
                foreach($params['groups'] as $gObj){
                    $groupSqlArr[]=sprintf("(%s,%s)",$id,Functions::clearString($gObj));
                }
                $groupSql=implode(",",$groupSqlArr);
                try{
                    $req2 = $db->prepare(sprintf('INSERT INTO user_usergroup_map (pk_user_id,pk_group_id) VALUES %s',$groupSql));
                    $res2 = $req2->execute();
                    $return['status']=true;
                    $return['message']=T::__("The account created succesfully. You can login with your account",true);
                    return $return;
                }
                catch(Exception $e){
                    //delete yarım kalmış öğeleri
                    $req3=$db->prepare('DELETE FROM user_usergroup_map WHERE pk_user_id=:id ; DELETE FROM users WHERE pk_user_id=:id2');
                    $req3->execute(array('id' => $id,'id2' => $id));

                    $return['status']=false;
                    $return['message']=T::__("An error occured. Please contact with administrators!",true);
                    return $return;
                }
            }
            else if($res){
                $return['status']=true;
                $return['message']=T::__("The account created succesfully. You can login with your account",true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__("An error occured. Please contact with administrators!",true);
                return $return;
            }
        }
    }
    public static function update($id,$params){
        $return=[];
        if ($params === null || empty($params['username']) || empty($params['fullname']) || empty($params['email'])) {
            $return['status']=false;
            $return['message']=T::__("Please fill all required fields!",true);
            return $return;
        }
        if(!empty($params['password']) && ($params['password'] != $params['repassword'])){
            $return['status']=false;
            $return['message']=T::__("Passwords don't match!",true);
            return $return;
        }
        else{
            $id=Functions::clearString($id);
            $params['username']=Functions::clearString($params['username']);
            $params['fullname']=Functions::clearString($params['fullname']);
            $params['email']=Functions::clearString($params['email']);
            $db = Db::getInstance();
            //check if credentials are exists on db 
            $req = $db->prepare('SELECT COUNT(pk_user_id) FROM users WHERE pk_user_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__("User not found!",true);
                return $return;
            }
            //if exists, save it
            //if typed password then change the query
            if(!empty($params['password'])){
                $params['password']=md5($params['password']);
                $req = $db->prepare('UPDATE users SET username=:username,password=:password,email=:email,fullname=:fullname WHERE pk_user_id=:id ');
                $res=$req->execute(array(
                    'id' => $id,
                    'username' => $params['username'],
                    'fullname' => $params['fullname'],
                    'email' => $params['email'],
                    'password' => $params['password']));
            }
            else{
                $req = $db->prepare('UPDATE users SET username=:username,email=:email,fullname=:fullname WHERE pk_user_id=:id ');
                $res=$req->execute(array(
                    'id' => $id,
                    'username' => $params['username'],
                    'fullname' => $params['fullname'],
                    'email' => $params['email']));
            }
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf("Username: %s The account updated succesfully!",$params['username']),true);
                if(!empty($params['groups'])){
                    $groupSqlArr=[];
                    foreach($params['groups'] as $gObj){
                        $groupSqlArr[]=sprintf("(%s,%s)",$id,Functions::clearString($gObj));
                    }
                    $groupSql=implode(",",$groupSqlArr);
                    try{
                        $req4=$db->prepare('DELETE FROM user_usergroup_map WHERE pk_user_id=:id');
                        $req4->execute(array('id' => $id));
                        $req2 = $db->prepare(sprintf('INSERT INTO user_usergroup_map (pk_user_id,pk_group_id) VALUES %s',$groupSql));
                        $res2 = $req2->execute();
                        $return['status2']=true;
                        $return['message2']=T::__("Groups updated successfully.",true);
                    }
                    catch(Exception $e){
                        //delete yarım kalmış öğeleri
                        $req3=$db->prepare('DELETE FROM user_usergroup_map WHERE pk_user_id=:id');
                        $req3->execute(array('id' => $id));
                        
                        $return['status2']=false;
                        $return['message2']=T::__("Groups cannot updated. Please try again!",true);
                    }
                }
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__("An error occured. Please contact with administrators!",true);
                return $return;
            }
        }
    }
    public static function delete($id){
        $db=Db::getInstance();        
        //check if credentials are exists on db 
        $req = $db->prepare('SELECT COUNT(pk_user_id) FROM users WHERE pk_user_id=:id');
        $req->execute(array('id' => $id));
        if($req->fetchColumn()==0){
            $return['status']=false;
            $return['message']=T::__("User not found!",true);
            return $return;
        }    
        $req = $db->prepare('DELETE FROM users WHERE pk_user_id=:id');
        $res=$req->execute(array('id'=>$id));
        if($res){
            $return['status']=true;
            $return['message']=T::__(sprintf("ID: %s The account deleted succesfully!",$id),true);
            return $return;
        }
        else{
            $return['status']=false;
            $return['message']=T::__("An error occured. Please contact with administrators!",true);
            return $return;
        }
    }
    public static function getObjList($params){
        $list = [];

        $order_dirs=array("desc","asc");
        $key=array_search($params["order_dir"],$order_dirs);
        $order_dir=$order_dirs[($key) ? $key : 0];

        $order_columns=array("pk_user_id", "username", "email", "last_visit", "fullname", "registration_date");
        $key=array_search($params["order_by"],$order_columns);
        $order_by=$order_columns[($key) ? $key : 0];

        $limit=$params["limit"] ? $params["limit"] : "20";
        $offset=$params["offset"] ? $params["offset"] : "0";

        $query="SELECT * FROM users";
        if(!empty($params['search_term'])){
            $query.=" WHERE lower(concat(pk_user_id, '', username, '', email, '', last_visit, '', fullname, '', registration_date)) LIKE :search_term";
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
            $list[] = new Users( $obj['pk_user_id'],
                                $obj['username'],
                                $obj['password'],
                                $obj['email'],
                                $obj['last_visit'],
                                $obj['fullname'],
                                $obj['registration_date']);
        }
        return $list;
    }
    public static function getObj($id){
        try{
            $db = Db::getInstance();
            $id = intval($id);
            $req = $db->prepare('SELECT * FROM users WHERE pk_user_id = :pk_user_id');
            $req->execute(array('pk_user_id' => $id));
            $obj = $req->fetch();
            if($obj){
                return new Users( $obj['pk_user_id'],
                                    $obj['username'],
                                    $obj['password'],
                                    $obj['email'],
                                    $obj['last_visit'],
                                    $obj['fullname'],
                                    $obj['registration_date']);
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
      $query="SELECT COUNT(pk_user_id) FROM users";
      if(!empty($search_term))
        $query.=" WHERE lower(concat(pk_user_id, '', username, '', email, '', last_visit, '', fullname, '', registration_date)) LIKE :search_term";
      $db = Db::getInstance();
      $req = $db->prepare($query);
      if(!empty($search_term))
        $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
      
      $req->execute();
      $res=$req->fetch();
      return (int) $res[0];
    }
    public function getUserGroups($id){
        try{
            $db = Db::getInstance();
            $id = intval($id);
            $req = $db->prepare('SELECT * FROM user_usergroup_map WHERE pk_user_id = :pk_user_id');
            $req->execute(array('pk_user_id' => $id));
            // we create a list of Post objects from the database results
            $list=[];
            foreach($req->fetchAll() as $obj) {
                $list[]= $obj['pk_group_id'];
            }
            return $list;
        }
        catch (PDOException $e){
            return $e->getMessage();
        }
    }
    public function getUserModules($id){
        $modules=[];
        $params=[
            "search_term"=>"",
            "order_by"=>"name",
            "order_dir"=>"asc",
            "limit"=>"1000",
            "offset"=>"0"
        ];
        $viewLevels=ViewLevels::getObjList($params);
        foreach($viewLevels as $viewObj){
            $voGroups=json_decode($viewObj->groups);
            $voModules=json_decode($viewObj->modules);
            foreach($this->groups as $uoGroup){
                if(in_array($uoGroup,$voGroups)){
                    $modules=array_merge($modules,$voModules);
                }
            }
        }
        $modules=array_merge(array_unique($modules));
        asort($modules);
        global $controllers;
        foreach($modules as $kmodule=>$vmodule){
            $modules[$kmodule]=$controllers['module'][$vmodule];
        }
        return $modules;
    }
}