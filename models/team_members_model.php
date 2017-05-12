<?php
    class TeamMembers implements DatabaseObject{

        public $pk_team_member_id;
        public $since;
        public $team_id;
        public $team_name;
        public $user_id;
        public $username;
        public $type;

        public function __construct($pk_team_member_id, $since, $team_id , $team_name, $user_id,$username,$type){
            $this->pk_team_member_id = $pk_team_member_id;
            $this->since = $since;
            $this->team_id  = $team_id;
            $this->team_name  = $team_name;       
            $this->user_id  = $user_id; 
            $this->username = $username;
            $this->type = $type;
        }

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['user_id']) || empty($params['team_id']) || empty($params['type']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                $req = $db->prepare('INSERT INTO minyy.team_members (since, team_id, user_id, type) VALUES (NOW(), :team_id, :user_id , :type)');
                $res=$req->execute(array(
                    'team_id' => $params['team_id'],
                    'user_id' => $params['user_id'],
                    'type' => $params['type']));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Your team created succesfully.',true);
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
            if ($id === null || $params === null || empty($params['type']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_team_member_id) FROM minyy.team_members WHERE pk_team_member_id=:pk_team_member_id');
                $req->execute(array('pk_team_member_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Member not found!',true);
                    return $return;
                }

                $req = $db->prepare('UPDATE minyy.team_members SET type = :type WHERE  pk_team_member_id = :id');
                $res=$req->execute(array(
                    'type' => $params['type'],
                    'id' => $id));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Member updated succesfully.',true);
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
            $req = $db->prepare('SELECT COUNT(pk_team_member_id) FROM minyy.team_members WHERE pk_team_member_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__('Member not found!',true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM minyy.team_members WHERE pk_team_member_id=:id');
            $res=$req->execute(array('id'=>$id));
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf('ID: %s The member deleted succesfully!',$id),true);
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

            $order_columns=array('pk_team_member_id','since','team_id', 'user_id', 'type');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tm.*,u.username FROM minyy.team_members as tm LEFT JOIN minyy.users as u on tm.user_id = u.pk_user_id';
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_team_member_id, '', since, '', team_id , '', user_id, '', type )) LIKE :search_term";
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
                $list[] = new TeamMembers( $obj['pk_team_member_id'],
                                    $obj['since'],
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['user_id'],
                                    $obj['username'],
                                    $obj['type']);

            }
            return $list;
        }

        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT tm.*,u.username FROM minyy.team_members as tm LEFT JOIN minyy.users as u on tm.user_id = u.pk_user_id WHERE t.pk_team_member_id = :pk_team_member_id');
                $req->execute(array('pk_team_member_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new TeamMembers( $obj['pk_team_member_id'],
                                    $obj['since'],
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['user_id'],
                                    $obj['username'],
                                    $obj['type']);
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
            $query="SELECT COUNT(pk_team_member_id) FROM minyy.team_members";
            if(!empty($search_term))
                $query.=" WHERE lower(concat(pk_team_member_id, '', since, '', team_id , '', user_id, '', type )) LIKE :search_term";
            $db = Db::getInstance();
            $req = $db->prepare($query);
            if(!empty($search_term))
                $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
            
            $req->execute();
            $res=$req->fetch();
            return (int) $res[0];
        }

        
        public static function getTeamMembers($teamId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_team_member_id','since','team_id', 'user_id', 'type');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            //kullanıcının kendi oluşturduğu takımlar gösterilecek
            $query='SELECT tm.*,u.username FROM minyy.team_members as tm LEFT JOIN minyy.users as u on tm.user_id=u.pk_user_id';

            if(!empty($params['search_term'])){
                $query.=" WHERE tm.team_id=:teamId and lower(concat(pk_team_member_id, '', since, '', team_id , '', user_id, '', type )) LIKE :search_term";

            $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

            $db = Db::getInstance();
            $req = $db->prepare($query);
            $req->bindValue(':teamId', intval($teamId), PDO::PARAM_INT);
            $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
            $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
            if(!empty($params['search_term'])){
                $req->bindValue(':search_term', '%'.Functions::replaceLiteralChars($params['search_term']).'%', PDO::PARAM_STR);
            }
            $req->execute();
            // we create a list of Post objects from the database results
            foreach($req->fetchAll() as $obj) {
                $list[] = new TeamMembers( $obj['pk_team_member_id'],
                                    $obj['since'],
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['user_id'],
                                    $obj['username'],
                                    $obj['type']);

            }
            return $list;
        }
    }
?>