<?php
    class Topics implements DatabaseObject{

        public $pk_topic_id;
        public $title;
        public $content;
        public $team_id;
        public $team_name;
        public $created_at;
        public $created_by;
        public $created_by_username;
        public $created_by_fullname;
        public $message_count;
        public $last_message_id;
        public $last_message_userid;
        public $last_message_username;
        public $last_message_fullname;
        public $status;

        public function __construct($pk_topic_id,$title,$content,$team_id,$team_name,$created_at,$created_by,$created_by_username,$created_by_fullname,$message_count,$last_message_id,$last_message_userid,$last_message_username,$last_message_fullname,$status){
			$this->pk_topic_id = $pk_topic_id;
			$this->title = $title;
			$this->content = $content;
			$this->team_id = $team_id;
            $this->team_name = $team_name;
			$this->created_at = $created_at;
			$this->created_by = $created_by;
			$this->created_by_username = $created_by_username;
			$this->created_by_fullname = $created_by_fullname;
			$this->message_count = $message_count;
            $this->last_message_id = $last_message_id;
            $this->last_message_userid = $last_message_userid;
			$this->last_message_username = $last_message_username;
			$this->last_message_fullname = $last_message_fullname;
            $this->status = $status;
		}

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['title']) || empty($params['content']) || empty($params['team_id']) || empty($params['created_by']) || empty($params['status'])) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                $req = $db->prepare('INSERT INTO team_topics (title, content,team_id, created_at, created_by,status) VALUES (:title, :content,:team_id, NOW(), :created_by, :status)');
                $res=$req->execute(array(
                    'title' => $params['title'],
                    'content' => $params['content'],
                    'team_id' => $params['team_id'],
                    'created_by' => $params['created_by'],
                    'status' => $params['status']));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Your Topic created succesfully.',true);
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
            if ($id === null || $params === null || empty($params['title']) || empty($params['conrent']) || empty($params['created_by']) || empty($params['status'])) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_topic_id) FROM minyy.team_topics WHERE pk_topic_id=:pk_topic_id');
                $req->execute(array('pk_topic_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Team Topic not found!',true);
                    return $return;
                }

                $req = $db->prepare('UPDATE minyy.team_topics SET title = :title, content = :content, status = :status  WHERE  pk_topic_id = :pk_topic_id');
                $res=$req->execute(array(
                    'title' => $params['title'],
                    'content' => $params['content'],
                    'status' => $params['status'],
                    'pk_topic_id' => $pk_topic_id));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Your topic updated succesfully.',true);
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
            $req = $db->prepare('SELECT COUNT(pk_topic_id) FROM minyy.team_topics WHERE pk_topic_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__('Topic not found!',true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM minyy.team_topics WHERE pk_topic_id=:id');
            $res=$req->execute(array('id'=>$id));
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf('ID: %s The topic deleted succesfully!',$id),true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__('An error occured. Please contact with administrators!',true);
                return $return;
            }
        }

        //default olarak liste çekilirken content bilgisi boş döner.
        public static function getObjList($params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_topic_id','title', 'team_id','team_name','created_at', 'created_by','created_by_username','status','created_by_fullname','status');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tt.pk_topic_id,tt.title,tt.team_id,tt.name AS \'team_name\',tt.created_at,tt.created_by,tt.status,
		u.username AS \'created_by_username\',u.fullname AS \'created_by_fullname\' ,
        (SELECT COUNT(pk_tt_message_id) FROM team_topic_messages AS ttm WHERE ttm.topic_id=tt.pk_topic_id) AS \'message_count\' ,
        last_message.pk_tt_message_id AS \'last_message_id\', last_message.last_message_userid,last_message.last_message_username,last_message.last_message_fullname
FROM team_topics AS tt 
LEFT JOIN users AS u ON tt.created_by = u.pk_user_id
LEFT JOIN teams AS t ON tt.team_id = t.pk_team_id
LEFT JOIN (SELECT ttm.pk_tt_message_id ,ttm.topic_id,ttm.created_by AS \'last_message_userid\',us.username AS \'last_message_username\',us.fullname AS \'last_message_fullname\' 
			FROM team_topic_messages AS ttm
            LEFT JOIN users AS us ON ttm.created_by = us.pk_user_id 
            ORDER BY ttm.created_at DESC LIMIT 1) AS last_message ON last_message.topic_id=tt.pk_topic_id';

            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_topic_id, '', title, '', team_id , '', team_name, '',created_at, '', created_by , '', created_by_username , '', status , '', created_by_fullname)) LIKE :search_term";
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
                $list[] = new Topics( $obj['pk_topic_id'],
                                    $obj['title'],
                                    '',//content
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['message_count'],
                                    $obj['last_message_id'],
                                    $obj['last_message_userid'],
                                    $obj['last_message_username'],
                                    $obj['last_message_fullname'],
                                    $obj['status']);
            }
            return $list;
        }

        //bir topic için mesaj detayını gösterir
        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT tt.* ,u.username AS \'created_by_username\',u.fullname AS \'created_by_fullname\',(SELECT COUNT(pk_tt_message_id) FROM team_topic_messages AS ttm WHERE ttm.topic_id=tt.pk_topic_id) AS \'message_count\'
FROM team_topics AS tt
LEFT JOIN users AS u ON tt.created_by=u.pk_user_id
 WHERE tt.pk_topic_id = :pk_topic_id');
                $req->execute(array('pk_topic_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new Topics( $obj['pk_topic_id'],
                                    $obj['title'],
                                    $obj['content'],
                                    $obj['team_id'],
                                    '',//team_name
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['message_count'],
                                    -1,//last_message_id
                                    -1,//last_message_userid
                                    '',//last_message_username
                                    '',//last_message_fullname
                                    $obj['status']);
                }
                else{
                    return [];
                }
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }

        
        
        //count döndürür. 
        //type-> 'user' 'team' 'user_and_team' 'all' değerlerini alabilir. 
        //'all' için id'nin bir önemi yoktur Bütün topiclerin sayısını döndürür.
        //'user' sadece kullanıcının oluşturduğu topic sayısını döndürür. id->user id olmalıdır
        //'team' sadece teams içindeki topic sayısını döndürür id->team id olmalıdır
        //'user_and_team' kullanıcının erişiminin olduğu bütün topiclerin sayısını döndürür.
        //bunlar kullanıcının üyesi olduğu takımların açtığı topiclerin ve kendi oluşturduğu topiclerin 
        //sayısı olacaktır id->user id olmalıdır.
        public static function getTotal($id,$type,$search_term){
            $count = -1;
            $type=trim($type);
            if($type==null || $type=='' || ($type!='user' && $type!='team' && $type!='user_and_team' && $type!='all')){
                return count;
            }
            if($type!='all' && $id==null) 
                return count;
            
            $db = Db::getInstance();
            $query="SELECT COUNT(pk_topic_id) FROM team_topics AS topics";

            switch ($type){
                case 'user':
                    $query.=' WHERE topics.created_by=:id';
                    break;
                case 'team':
                    $query.=' WHERE topics.team_id=:id';
                    break;
                case 'user_and_team':
                    $query.=' LEFT JOIN teams AS t ON t.pk_team_id=topics.team_id  
                    LEFT JOIN team_members AS tm ON t.pk_team_id=tm.team_id  
                    LEFT JOIN users AS u ON u.pk_user_id=tm.user_id 
                    WHERE (t.created_by=:id or tm.user_id=:id)';//search_term in mantıklı çalışması için parantez yaptık
                    break;
                case 'all':

                    break;
            }
            if(!empty($search_term) && $type=='all')
                $query.=" WHERE lower(concat(pk_topic_id, '', title , '', content, '', team_id, '', created_at, '', created_by)) LIKE :search_term";

            if(!empty($search_term) && $type!='all')
                $query.=" AND lower(concat(pk_topic_id, '', title , '', content, '', team_id, '', created_at, '', created_by)) LIKE :search_term";

            $req = $db->prepare($query);
            if($type!='all')
                $req->bindValue(':id', $id, PDO::PARAM_INT);
            if(!empty($search_term))
                $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
            
            $req->execute();
            $res=$req->fetch();
            return (int) $res[0];
            
        }

        
        //kullanıcının kendi oluşturduğu topicler çekilir. (created_by değerine göre çekilir)
        public static function getUserTopics($userId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_topic_id','title', 'team_id','team_name','created_at','status');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tt.pk_topic_id,tt.title,tt.team_id,tt.name AS \'team_name\',tt.created_at,tt.created_by,tt.status,
		u.username AS \'created_by_username\',u.fullname AS \'created_by_fullname\' ,
        (SELECT COUNT(pk_tt_message_id) FROM team_topic_messages AS ttm WHERE ttm.topic_id=tt.pk_topic_id) AS \'message_count\' ,
        last_message.pk_tt_message_id AS \'last_message_id\', last_message.last_message_userid,last_message.last_message_username,last_message.last_message_fullname
FROM team_topics AS tt 
LEFT JOIN users AS u ON tt.created_by = u.pk_user_id
LEFT JOIN teams AS t ON tt.team_id = t.pk_team_id
LEFT JOIN (SELECT ttm.pk_tt_message_id ,ttm.topic_id,ttm.created_by AS \'last_message_userid\',us.username AS \'last_message_username\',us.fullname AS \'last_message_fullname\' 
			FROM team_topic_messages AS ttm
            LEFT JOIN users AS us ON ttm.created_by = us.pk_user_id 
            ORDER BY ttm.created_at DESC LIMIT 1) AS last_message ON last_message.topic_id=tt.pk_topic_id
            WHERE tt.created_by=:userId';
            if(!empty($params['search_term'])){
                $query.=" AND lower(concat(pk_topic_id, '', title, '', team_id , '', team_name, '',created_at ,'', status)) LIKE :search_term";
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
                $list[] = new Topics( $obj['pk_topic_id'],
                                    $obj['title'],
                                    '',//content
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['message_count'],
                                    $obj['last_message_id'],
                                    $obj['last_message_userid'],
                                    $obj['last_message_username'],
                                    $obj['last_message_fullname'],
                                    $obj['status']);
            }
            return $list;
        }

        //bir takımın bütün topic öğeleri çekilir. (Team id'ye göre)
        public static function getTeamTopics($teamId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_topic_id','title', 'created_by','created_by_username','created_by_fullname','created_at','status','message_count');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tt.pk_topic_id,tt.title,tt.team_id,tt.name AS \'team_name\',tt.created_at,tt.created_by,tt.status,
		u.username AS \'created_by_username\',u.fullname AS \'created_by_fullname\' ,
        (SELECT COUNT(pk_tt_message_id) FROM team_topic_messages AS ttm WHERE ttm.topic_id=tt.pk_topic_id) AS \'message_count\' ,
        last_message.pk_tt_message_id AS \'last_message_id\', last_message.last_message_userid,last_message.last_message_username,last_message.last_message_fullname
FROM team_topics AS tt 
LEFT JOIN users AS u ON tt.created_by = u.pk_user_id
LEFT JOIN teams AS t ON tt.team_id = t.pk_team_id
LEFT JOIN (SELECT ttm.pk_tt_message_id ,ttm.topic_id,ttm.created_by AS \'last_message_userid\',us.username AS \'last_message_username\',us.fullname AS \'last_message_fullname\' 
			FROM team_topic_messages AS ttm
            LEFT JOIN users AS us ON ttm.created_by = us.pk_user_id 
            ORDER BY ttm.created_at DESC LIMIT 1) AS last_message ON last_message.topic_id=tt.pk_topic_id
            WHERE tt.team_id=:teamId ';
            if(!empty($params['search_term'])){
                $query.="  AND lower(concat(pk_topic_id, '', title, '', created_by , '', created_by_username,'', created_by_fullname , '',created_at ,'', status , '' , message_count)) LIKE :search_term";
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
                $list[] = new Topics( $obj['pk_topic_id'],
                                    $obj['title'],
                                    '',//content
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['message_count'],
                                    $obj['last_message_id'],
                                    $obj['last_message_userid'],
                                    $obj['last_message_username'],
                                    $obj['last_message_fullname'],
                                    $obj['status']);

            }
            return $list;
        }

        //bir kullanıcının erişiminin olduğu bütün medya öğeleri çekilir.(Kendi yüklediği medyalar da olabilir, üyesi olduğu herhangi bir takımın medyası da olabilir hepsi çekilir)
        public static function getAllUserMedias($userId,$params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_topic_id','title', 'team_id','team_name','created_at','status');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tt.pk_topic_id,tt.title,tt.team_id,tt.name AS \'team_name\',tt.created_at,tt.created_by,tt.status,
		u.username AS \'created_by_username\',u.fullname AS \'created_by_fullname\' ,
        (SELECT COUNT(pk_tt_message_id) FROM team_topic_messages AS ttm WHERE ttm.topic_id=tt.pk_topic_id) AS \'message_count\' ,
        last_message.pk_tt_message_id AS \'last_message_id\', last_message.last_message_userid,last_message.last_message_username,last_message.last_message_fullname
FROM team_topics AS tt 
LEFT JOIN users AS u ON tt.created_by = u.pk_user_id
LEFT JOIN teams AS t ON tt.team_id = t.pk_team_id
LEFT JOIN (SELECT ttm.pk_tt_message_id ,ttm.topic_id,ttm.created_by AS \'last_message_userid\',us.username AS \'last_message_username\',us.fullname AS \'last_message_fullname\' 
			FROM team_topic_messages AS ttm
            LEFT JOIN users AS us ON ttm.created_by = us.pk_user_id 
            ORDER BY ttm.created_at DESC LIMIT 1) AS last_message ON last_message.topic_id=tt.pk_topic_id
            WHERE ( m.created_by=:userId or tm.user_id=:userId or t.created_by=:userId) ';
            if(!empty($params['search_term'])){
                $query.=" AND lower(concat(pk_topic_id, '', title, '', team_id , '', team_name, '',created_at ,'', status)) LIKE :search_term";
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
                $list[] = new Topics( $obj['pk_topic_id'],
                                    $obj['title'],
                                    '',//content
                                    $obj['team_id'],
                                    $obj['team_name'],
                                    $obj['created_at'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['message_count'],
                                    $obj['last_message_id'],
                                    $obj['last_message_userid'],
                                    $obj['last_message_username'],
                                    $obj['last_message_fullname'],
                                    $obj['status']);

            }
            return $list;
        }

    }
?>