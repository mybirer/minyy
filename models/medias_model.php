<?php
    class Medias implements DatabaseObject{
        public $pk_media_id;
        public $name;
        public $description;
        public $media_url;
        public $media_type;
        public $created_at ;
        public $created_by ;
        public $username;
        public $lang_code ;
        public $pk_team_id ;
        public $team_name;

        public function __construct($pk_media_id, $name, $description , $media_url, $media_type ,$created_at , $created_by , $username , $lang_code , $pk_team_id , $team_name ){
            $this->pk_media_id = $pk_media_id;
            $this->name = $name;
            $this->description  = $description;
            $this->media_url  = $media_url;       
            $this->media_type  = $media_type;     
            $this->created_at  = $created_at;
            $this->created_by  = $created_by;
            $this->username = $username; 
            $this->lang_code  = $lang_code;
            $this->pk_team_id  = $pk_team_id;
            $this->team_name = $team_name;
        }

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['created_by']) || empty($params['lang_code']) || empty($params['media_type']) || empty($params['media_url']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                $req = $db->prepare('INSERT INTO medias (name, description, media_url, media_type , created_at, created_by, lang_code , pk_team_id) VALUES (:name, :description,:media_url, :media_type, DATE() , :created_by, :lang_code, :pk_team_id)');
                $res=$req->execute(array(
                    'name' => $params['name'],
                    'description' => $params['description'],
                    'media_url' => $params['media_url'],
                    'media_type' => $params['media_type'],
                    'created_by' => $params['created_by'],
                    'lang_code' => $params['lang_code'],
                    'pk_team_id' => $params['pk_team_id']));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Your post created succesfully.',true);
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
            if ($id === null || $params === null || empty($params['created_by']) || empty($params['lang_code']) || empty($params['media_type']) || empty($params['media_url']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_media_id) FROM medias WHERE pk_media_id=:pk_media_id');
                $req->execute(array('pk_media_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Media not found!',true);
                    return $return;
                }

                $req = $db->prepare('UPDATE medias SET name = :name, description = :description, media_url = :media_url, media_type = :media_type, created_by = :created_by, lang_code = :lang_code, pk_team_id = :pk_team_id WHERE  pk_media_id = :id');
                $res=$req->execute(array(
                    'name' => $params['name'],
                    'description' => $params['description'],
                    'media_url' => $params['media_url'],
                    'media_type' => $params['media_type'],
                    'created_by' => $params['created_by'],
                    'media_url' => $params['media_url'],
                    'lang_code' => $params['lang_code'],
                    'pk_team_id' => $params['pk_team_id'],
                    'id' => $id));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Your post updated succesfully.',true);
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
            $db=Db::getInstance();        
            //check if media is exists on db 
            $req = $db->prepare('SELECT COUNT(pk_media_id) FROM medias WHERE pk_media_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__('Media not found!',true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM medias WHERE pk_media_id=:id');
            $res=$req->execute(array('id'=>$id));
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf('ID: %s The media deleted succesfully!',$id),true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__('An error occured. Please contact with administrators!',true);
                return $return;
            }
        }

        //var olan bütün medyalar çekilir
        public static function getObjList($params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_media_id','created_by', 'created_at', 'media_type', 'lang_code', 'pk_team_id','media_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT m.*,u.username,t.name as team_name FROM minyy.medias as m LEFT JOIN minyy.users as u on m.created_by=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=m.pk_team_id ';
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_media_id, '', created_by, '', created_at , '', media_type, '', lang_code, '', pk_team_id, '', media_url)) LIKE :search_term";
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
                $list[] = new TranslationMedia( $obj['pk_media_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['media_url'],
                                    $obj['media_type'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['lang_code'],
                                    $obj['pk_team_id'],
                                    $obj['team_name']);

            }
            return $list;
        }

        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT m.*,u.username,t.name as team_name FROM minyy.medias as m LEFT JOIN minyy.users as u on m.created_by=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=m.pk_team_id WHERE p.pk_media_id = :pk_media_id');
                $req->execute(array('pk_media_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new TranslationMedia( $obj['pk_media_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['media_url'],
                                    $obj['media_type'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['lang_code'],
                                    $obj['pk_team_id'],
                                    $obj['team_name']);
                }
                else{
                    return [];
                }
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }

        //kullanıcının kendi yüklediği medyalar çekilir. (created_by değerine göre çekilir)
        public static function getUserMedias($userId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_media_id' , 'created_at', 'media_type', 'lang_code', 'pk_team_id','media_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT m.*,u.username,t.name as team_name FROM minyy.medias as m LEFT JOIN minyy.users as u on m.created_by=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=m.pk_team_id ';
            if(!empty($params['search_term'])){
                $query.=" WHERE m.created_by=:userId AND lower(concat(pk_media_id, '', created_at , '', media_type, '', lang_code, '', pk_team_id, '', media_url)) LIKE :search_term";
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
            
            foreach($req->fetchAll() as $obj) {
                $list[] = new TranslationMedia( $obj['pk_media_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['media_url'],
                                    $obj['media_type'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['lang_code'],
                                    $obj['pk_team_id'],
                                    $obj['team_name']);
            }
            return $list;
        }

        //bir takımın bütün medya öğeleri çekilir. (Team id'ye göre)
        public static function getTeamMedias($teamId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_media_id','created_by', 'created_at', 'media_type', 'lang_code','media_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT m.*,u.username,t.name as team_name FROM minyy.medias as m LEFT JOIN minyy.users as u on m.created_by=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=m.pk_team_id ';
            if(!empty($params['search_term'])){
                $query.=" WHERE m.pk_team_id=:teamId AND lower(concat(pk_media_id, '', created_by, '', created_at , '', media_type, '', lang_code, '', media_url)) LIKE :search_term";
            }
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
            
            foreach($req->fetchAll() as $obj) {
                $list[] = new TranslationMedia( $obj['pk_media_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['media_url'],
                                    $obj['media_type'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['lang_code'],
                                    $obj['pk_team_id'],
                                    $obj['team_name']);

            }
            return $list;
        }

        //bir kullanıcının erişiminin olduğu bütün medya öğeleri çekilir.(Kendi yüklediği medyalar da olabilir, üyesi olduğu herhangi bir takımın medyası da olabilir hepsi çekilir)
        public static function getAllUserMedias($userId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_media_id','created_by', 'created_at', 'media_type', 'lang_code', 'pk_team_id','media_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT m.* , u.fullname, t.name as team_name FROM minyy.medias as m LEFT JOIN minyy.users as u on m.created_by=u.pk_user_id LEFT JOIN minyy.teams as t on m.pk_team_id=t.pk_team_id LEFT JOIN minyy.team_members as tm on tm.team_id = t.pk_team_id ';
            if(!empty($params['search_term'])){
                $query.=" WHERE ( m.created_by=:userId or tm.user_id=:userId ) and lower(concat(pk_media_id, '', created_by, '', created_at , '', media_type, '', lang_code, '', pk_team_id, '', media_url)) LIKE :search_term";
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
                $list[] = new TranslationMedia( $obj['pk_media_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['media_url'],
                                    $obj['media_type'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['username'],
                                    $obj['lang_code'],
                                    $obj['pk_team_id'],
                                    $obj['team_name']);

            }
            return $list;
        }

    }
?>