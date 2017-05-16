<?php
    class Teams implements DatabaseObject{

        public $pk_team_id;
        public $name;
        public $description;
        public $created_at;
        public $created_by;
        public $created_by_username;
        public $member_count;
        public function __construct($pk_team_id, $name, $description , $created_at, $created_by,$created_by_username,$member_count){
            $this->pk_team_id = $pk_team_id;
            $this->name = $name;
            $this->description  = $description;
            $this->created_at  = $created_at;       
            $this->created_by  = $created_by; 
            $this->created_by_username = $created_by_username;
            $this->member_count = $member_count;
        }

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['name']) || empty($params['created_by']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                $req = $db->prepare('INSERT INTO teams (name, description, created_at, created_by) VALUES (:name, :description, NOW(), :created_by)');
                $res=$req->execute(array(
                    'name' => $params['name'],
                    'description' => $params['description'],
                    'created_by' => $params['created_by']));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Team created succesfully.',true);
                    return $return;
                }
                else{
                    $return['status']=false;
                    $return['message']=T::__('An error occured. Please contact with administrators!',true);
                    return $return;
                }   
            }
        }
        public static function update($id,$params){
            $return=[];
            if ($id === null || $params === null || empty($params['name']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_team_id) FROM minyy.teams WHERE pk_team_id=:pk_team_id');
                $req->execute(array('pk_team_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Team not found!',true);
                    return $return;
                }

                $req = $db->prepare('UPDATE minyy.teams SET name = :name, description = :description WHERE  pk_team_id = :id');
                $res=$req->execute(array(
                    'name' => $params['name'],
                    'description' => $params['description'],
                    'id' => $id));
                if($res){ //eğer temel bilgileri güncellemede başarılı olduysa bundan sonraki kısımda memberleri dbye ekliyor. member eklemeden önce daha önceki memberları siliyor sonrasında da yeni memberları listeye ekliyor. herhangi bir sorun olursa member listesine eklediği kayıtları da siliyor
                //todo burada veri kaybı olabilir.
                    $return['status']=true;
                    $return['message']=T::__('Team updated succesfully.',true);
                    if(!empty($params['members']) && !empty($params['types'])){
                        $groupSqlArr=[];
                        foreach($params['members'] as $gKey=>$gObj){
                            $groupSqlArr[]=sprintf("(NOW(),%s,%s,'%s')",$id,Functions::clearString($gObj),Functions::clearString($params['types'][$gKey]));
                        }
                        $groupSql=implode(",",$groupSqlArr);
                        try{
                            $req4=$db->prepare('DELETE FROM team_members WHERE team_id=:id');
                            $req4->execute(array('id' => $id));
                            $req2 = $db->prepare(sprintf('INSERT INTO team_members (since,team_id,user_id,type) VALUES %s',$groupSql));
                            $res2 = $req2->execute();
                            $return['status2']=true;
                            $return['message2']=T::__("Members updated successfully.",true);
                        }
                        catch(Exception $e){
                            //delete yarım kalmış öğeleri
                            $req3=$db->prepare('DELETE FROM team_members WHERE team_id=:id');
                            $req3->execute(array('id' => $id));
                            
                            $return['status2']=false;
                            $return['message2']=T::__("Members cannot updated. Please try again!",true);
                        }
                    }
                    return $return;
                }
                else{
                    $return['status']=false;
                    $return['message']=T::__('An error occured. Please contact with administrators!',true);
                    return $return;
                }   
            }
        }
        public static function delete($id){
            // TO-DO 11.05.2017 -> takım silinirken bağlı olunan bütün medya ve team_member öğeleri bununla beraber yapılan çeviriler de silinecek mi (siliniyor mu? foreign key constraints buna müsade ediyor mu)
            $db=Db::getInstance();        
            //check if team is exists on db 
            $req = $db->prepare('SELECT COUNT(pk_team_id) FROM minyy.teams WHERE pk_team_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__('Team not found!',true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM minyy.teams WHERE pk_team_id=:id');
            $res=$req->execute(array('id'=>$id));
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf('ID: %s The team deleted succesfully!',$id),true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__('An error occured. Please contact with administrators!',true);
                return $return;
            }
        }
        public static function getObjList($params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_team_id','name','description', 'created_at', 'created_by');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT t.*,u.username, (SELECT COUNT(tm.pk_team_member_id) FROM minyy.team_members AS tm WHERE tm.team_id=t.pk_team_id) AS \'member_count\' FROM minyy.teams as t LEFT JOIN minyy.users as u on t.created_by=u.pk_user_id';
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_team_id, '', name, '', description , '', created_at, '', created_by )) LIKE :search_term";
            }
            $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

            $db = Db::getInstance();
            $req = $db->prepare($query);
            $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
            $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
            if(!empty($params['search_term'])){
                $req->bindValue(':search_term', '%'.Functions::replaceLiteralChars($params['search_term']).'%', PDO::PARAM_STR);
            }
            $req->execute();
            // we create a list of Post objects from the database results
            foreach($req->fetchAll() as $obj) {
                $list[] = new Teams( $obj['pk_team_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['member_count']);

            }
            return $list;
        }

        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT t.*,u.username, (SELECT COUNT(tm.pk_team_member_id) FROM minyy.team_members AS tm WHERE tm.team_id=t.pk_team_id) AS \'member_count\'  FROM minyy.teams as t LEFT JOIN minyy.users as u on t.created_by=u.pk_user_id WHERE t.pk_team_id = :pk_team_id');
                $req->execute(array('pk_team_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new Teams( $obj['pk_team_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['member_count']);
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
            $query="SELECT COUNT(pk_team_id) FROM minyy.teams";
            if(!empty($search_term))
                $query.=" WHERE lower(concat(pk_team_id, '', name, '', description , '', created_at, '', created_by )) LIKE :search_term";
            $db = Db::getInstance();
            $req = $db->prepare($query);
            if(!empty($search_term))
                $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
            
            $req->execute();
            $res=$req->fetch();
            return (int) $res[0];
        }

        
        public static function getUserTeams($userId,$params,$queryType){
            /*
            $queryType == 'created_teams' =>  kullanıcının kendi oluşturduğu takımlar gösterilecek
            $queryType == 'joined_teams' =>  kullanıcının üyesi olduğu takımlar çekilecek
            $queryType == 'all_teams' =>  kullanıcının oluşturduğu ve üyesi olduğu bütün takımları gösterir
            */
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_team_id','name','description', 'created_at', 'created_by');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query;

            if($queryType == 'created_teams'){

                //kullanıcının kendi oluşturduğu takımlar gösterilecek
                $query='SELECT t.*,u.username, (SELECT COUNT(tm.pk_team_member_id) FROM minyy.team_members AS tm WHERE tm.team_id=t.pk_team_id) AS \'member_count\'  FROM minyy.teams as t LEFT JOIN minyy.users as u on t.created_by=u.pk_user_id';

                if(!empty($params['search_term'])){
                    $query.=" WHERE t.created_by=:userId and lower(concat(pk_team_id, '', name, '', description , '', created_at, '', created_by )) LIKE :search_term";
                }

            }else if($queryType == 'joined_teams'){

                //kullanıcının üyesi olduğu takımlar çekilecek
                $query='SELECT t.*,u.username, (SELECT COUNT(tm.pk_team_member_id) FROM minyy.team_members AS tm WHERE tm.team_id=t.pk_team_id) AS \'member_count\'  FROM minyy.teams as t LEFT JOIN minyy.users as u on t.created_by=u.pk_user_id LEFT JOIN minyy.team_members as tm on t.pk_team_id=tm.team_id';

                if(!empty($params['search_term'])){
                    $query.=" WHERE tm.user_id=:userId and lower(concat(pk_team_id, '', name, '', description , '', created_at, '', created_by )) LIKE :search_term";
                }

            }else if($queryType == 'all_teams'){

                //kullanıcının oluşturduğu ve üyesi olduğu bütün takımları gösterir
                $query='SELECT t.*,u.username, (SELECT COUNT(tm.pk_team_member_id) FROM minyy.team_members AS tm WHERE tm.team_id=t.pk_team_id) AS \'member_count\'  FROM minyy.teams as t LEFT JOIN minyy.users as u on t.created_by=u.pk_user_id LEFT JOIN minyy.team_members as tm on t.pk_team_id=tm.team_id';
                if(!empty($params['search_term'])){
                    $query.=" WHERE (tm.user_id=:userId or tm.created_by=:userId) and lower(concat(pk_team_id, '', name, '', description , '', created_at, '', created_by )) LIKE :search_term";
                }

            }
            $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

            $db = Db::getInstance();
            $req = $db->prepare($query);
            $req->bindValue(':userId', intval($userId), PDO::PARAM_INT);
            $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
            $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
            if(!empty($params['search_term'])){
                $req->bindValue(':search_term', '%'.Functions::replaceLiteralChars($params['search_term']).'%', PDO::PARAM_STR);
            }
            $req->execute();
            // we create a list of Post objects from the database results
            foreach($req->fetchAll() as $obj) {
                $list[] = new Teams( $obj['pk_team_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['member_count']);

            }
            return $list;
        }
    }
?>