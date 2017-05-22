<?php
    class Comments implements DatabaseObject{
        public $pk_comment_id;
        public $object_id;
        public $module_name;
        public $parent_comment_id;
        public $created_by;
        public $created_by_username;
        public $created_by_fullname;
        public $created_at;
        public $content;
        public $comment_status;
        public $modified_by;
        public $modified_by_username;
        public $modified_by_fullname;
        public $modified_date;
        public $guid;
        public $comment_params;
        public $child_comments=array();

        public function __construct($pk_comment_id, $object_id, $module_name,$parent_comment_id, $created_by, $created_by_username, $created_by_fullname, $created_at, $content, $comment_status, $modified_by, $modified_by_username, $modified_by_fullname, $modified_date, $guid, $comment_params){
            $this->pk_comment_id = $pk_comment_id;
            $this->object_id = $object_id;
            $this->module_name = $module_name;
            $this->parent_comment_id = $parent_comment_id;
            $this->created_by = $created_by;
            $this->created_by_username = $created_by_username;
            $this->created_by_fullname = $created_by_fullname;
            $this->created_at = $created_at;
            $this->content = $content;
            $this->comment_status = $comment_status;
            $this->modified_by = $modified_by;
            $this->modified_by_username = $modified_by_username;
            $this->modified_by_fullname = $modified_by_fullname;
            $this->modified_date = $modified_date;
            $this->guid = $guid;
            $this->comment_params = $comment_params;
        }

        public static function insert($params){
            global $currentUser;
            $return=[];
            if ($params === null || empty($params['object_id']) || empty($params['created_by']) || empty($params['content']) || empty($params['comment_status']) || empty($params['guid']) || empty($params['module_name'])) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();
                $req = $db->prepare('INSERT INTO comments (object_id,module_name, parent_comment_id, created_by, created_at, content, comment_status, guid, comment_params) VALUES (:object_id , :module_name, :parent_comment_id , :created_by , NOW(), :content , :comment_status , :guid , :comment_params )');
                $res=$req->execute(array(
                    'object_id' => $params['object_id'],
                    'module_name' => $params['module_name'],
                    'parent_comment_id' => $params['parent_comment_id'],
                    'created_by' => $params['created_by'],
                    'content' => htmlspecialchars($params['content']),
                    'comment_status' => $params['comment_status'],
                    'guid' => $params['guid'],
                    'comment_params' => $params['comment_params']));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Your comment saved succesfully.',true);
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
            if (empty($id) || empty($params) || empty($params['content']) || empty($params['comment_status']) || empty($params['modified_by']) || empty($params['comment_params'])) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_comment_id) FROM comments WHERE pk_comment_id=:pk_comment_id');
                $req->execute(array('pk_comment_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Comment not found!',true);
                    return $return;
                }

                $req = $db->prepare('UPDATE comments SET content = :content , comment_status = :comment_status , modified_by = :modified_by , modified_date = NOW() , comment_params = :comment_params  WHERE pk_comment_id = :pk_comment_id');
                $res=$req->execute(array(
                    'content' => htmlspecialchars($params['content']),
                    'comment_status' => $params['comment_status'],
                    'modified_by' => $params['modified_by'],
                    'comment_params' => $params['comment_params'],
                    'id' => $id));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Comment has been updated succesfully.',true);
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
            $req = $db->prepare('SELECT COUNT(pk_comment_id) FROM comments WHERE pk_comment_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__('Comment not found!',true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM comments WHERE pk_comment_id=:id');
            $res=$req->execute(array('id'=>$id));
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf('ID: %s The comment deleted succesfully!',$id),true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__('An error occured. Please contact with administrators!',true);
                return $return;
            }
        }

        //var olan bütün yorumlar çekilir
        //content boş gelir -- content getModuleComments() metodunda çekilir
        public static function getObjList($params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_comment_id','object_id', 'module_name', 'created_by', 'created_at', 'comment_status','modified_by','modified_date','created_by_username','created_by_fullname','modified_by_username','modified_by_fullname');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT 	c.pk_comment_id,c.object_id,c.module_name,c.parent_comment_id,c.created_by,c.created_at,c.comment_status,c.modified_by,c.modified_date,c.guid,c.comment_params,u1.username AS \'created_by_username\',u1.fullname AS \'created_by_fullname\',
		u2.username AS \'modified_by_username\', u2.fullname AS \'modified_by_fullname\' 
FROM comments AS c 
LEFT JOIN users AS u1 ON c.created_by=u1.pk_user_id
LEFT JOIN users AS u2 ON c.modified_by=u2.pk_user_id';
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_comment_id, '', object_id, '', module_name , '', created_by, '', created_at, '', comment_status, '', modified_by, '', modified_date, '', created_by_username, '', created_by_fullname, '', modified_by_username, '', modified_by_fullname)) LIKE :search_term";
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
                $list[] = new Comments( $obj['pk_comment_id'],
                                    $obj['object_id'],
                                    $obj['module_name'],
                                    $obj['parent_comment_id'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['created_at'],
                                    '',//$obj['content'] contentler boş dönüyor
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_by_username'],
                                    $obj['modified_by_fullname'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['comment_params']);

            }
            return $list;
        }

        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT c.*,u1.username AS \'created_by_username\',u1.fullname AS \'created_by_fullname\', u2.username AS \'modified_by_username\', u2.fullname AS \'modified_by_fullname\' FROM comments AS c 
LEFT JOIN users AS u1 ON c.created_by=u1.pk_user_id
LEFT JOIN users AS u2 ON c.modified_by=u2.pk_user_id WHERE m.pk_comment_id = :pk_comment_id');
                $req->execute(array('pk_comment_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new Comments( $obj['pk_comment_id'],
                                    $obj['object_id'],
                                    $obj['module_name'],
                                    $obj['parent_comment_id'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['created_at'],
                                    $obj['content'],
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_by_username'],
                                    $obj['modified_by_fullname'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['comment_params']);
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
        //type-> yorum sayısı getirilecek olan nesnenin modül adı olmalı. 'all' değerlerini alabilir.'all' 
        //değeri için bütün yorumların sayısını getirir. 'all' için id'nin bir önemi yoktur

        //eğer bir modül adı girilirse ve id verilirse, o modüldeki id'ye sahip olan nesnenin yorum sayısını
        //döndürür. Örneğin; modül->medias seçilip id->4 denirse id si 4 olan medyanın yorum sayısını getirir.

        // eğer bir modül ismi belirtilip id belirtilmezse, o modülün sahip olduğu bütün yorumları döndürür.
        
        //module_name boş olamaz. module_name->all olduğu zaman id ye herhangi bir atama yapılamaz
        //çünkü mantık hatası olur :) ne yapacan yani aynı id deki yorumları.?
        public static function getTotal($id,$module_name,$search_term){
            $count = -1;

            if(empty($module_name) || ($module_name =='all' && !empty($id))){
                return count;
            }

            $db = Db::getInstance();
            $query='SELECT COUNT(c.pk_comment_id) FROM comments AS c ';

            if($module_name == 'all'){ 
                //module_name all iken id herhangi bir değer alamayacak ve boş olacak
                //(yukarıda kontrolleri yapılıyor) bu yüzden if(empty($id)) eklemiyoruz
                
                if(!empty($search_term) )
                    $query.=" WHERE lower(concat(pk_media_id, '', created_at , '', media_type, '', lang_code, '', pk_team_id, '', media_url)) LIKE :search_term";

            }else{
                $query.=' WHERE c.module_name = :module_name ';
                if(!empty($id))
                    $query.=' AND c.object_id = :id ';
                if(!empty($search_term))
                    $query.=" AND lower(concat(pk_media_id, '', created_at , '', media_type, '', lang_code, '', pk_team_id, '', media_url)) LIKE :search_term";
            }
            $req = $db->prepare($query);
            
            if($module_name != 'all'){
                $req->bindValue(':module_name', trim($module_name), PDO::PARAM_STR);
                if(!empty($id)){
                    $req->bindValue(':id', $id, PDO::PARAM_INT);
                }
            }
            if(!empty($search_term))
                $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
            
            $req->execute();
            $res=$req->fetch();
            return (int) $res[0];
            
        }

        //kullanıcının kendi oluşturduğu yorumlar çekilir. (created_by değerine göre çekilir)
        //module_name all olursa bütün yaptığı yorumlar çekilir
        //eğer herhangi bir modül girilirse sadece o modüle ait yorumlar çekilir
        public static function getUserComments($userId,$module_name,$params){
            $list = [];
            if(empty($userId) || empty($module_name))
                return $list;
            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_media_id' , 'created_at', 'media_type', 'lang_code', 'pk_team_id','media_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT 	c.pk_comment_id,c.object_id,c.module_name,c.parent_comment_id,c.created_by,c.created_at,c.comment_status,c.modified_by,c.modified_date,c.guid,c.comment_params, u2.username AS \'modified_by_username\', u2.fullname AS \'modified_by_fullname\' 
FROM comments AS c 
LEFT JOIN users AS u2 ON c.modified_by=u2.pk_user_id
WHERE c.created_by=:userId ';
            if($module_name!='all')
                $query.=' AND c.module_name=:module_name ';
            
            if(!empty($params['search_term'])){
                $query.=" AND lower(concat(pk_media_id, '', created_at , '', media_type, '', lang_code, '', pk_team_id, '', media_url)) LIKE :search_term";
            }
            $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

            $db = Db::getInstance();
            $req = $db->prepare($query);
            $req->bindValue(':userId', intval($userId), PDO::PARAM_INT);
            if($module_name!='all')
                $req->bindValue(':module_name', $module_name, PDO::PARAM_STR);
            $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
            $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
            if(!empty($params['search_term'])){
                $req->bindValue(':search_term', '%'.Functions::replaceLiteralChars($params['search_term']).'%', PDO::PARAM_STR);
            }
            $req->execute();
            
            foreach($req->fetchAll() as $obj) {
                $list[] = new Comments( $obj['pk_comment_id'],
                                    $obj['object_id'],
                                    $obj['module_name'],
                                    $obj['parent_comment_id'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['created_at'],
                                    '',//$obj['content'] contentler boş dönüyor
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_by_username'],
                                    $obj['modified_by_fullname'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['comment_params']);
            }
            return $list;
        }

        //bir modüldeki yorumları çekmek için kullanılır
        //eğer objectId boş bırakılırsa modülün bütün yorumları çekilir.
        //eğer objectId bir değer alırsa o modüldeki objectId ye sahip nesnenin yorumları çekilir
        //örneğin; module_name->medias olursa ve onjectId boş olursa medias kısmındaki bütün yorumlar çekilir
        //örneğin; module_name->medias olursa ve onjectId 5 olursa medias kısmındaki 5 id sinde sahip medyanın 
        //bütün yorumlar çekilir
        //module_name boş olamaz
        //content'ler çekilir
        public static function getModuleComments($objectId,$module_name,$params){
            $list = [];
            if(empty($module_name))
                return $list;
            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_comment_id' , 'object_id', 'created_by', 'created_at', 'comment_status','modified_by','modified_date');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT 	c.* , u1.username AS \'created_by_username\',u1.fullname AS \'created_by_fullname\',
		u2.username AS \'modified_by_username\', u2.fullname AS \'modified_by_fullname\' 
FROM comments AS c 
LEFT JOIN users AS u1 ON c.created_by=u1.pk_user_id
LEFT JOIN users AS u2 ON c.modified_by=u2.pk_user_id WHERE c.module_name=:module_name ';
            if(!empty($objectId))
                $query.=' AND c.object_id=:objectId ';
            
            if(!empty($params['search_term'])){
                $query.=" AND lower(concat(pk_comment_id, '', object_id , '', created_by, '', created_at, '', comment_status, '', modified_by,'',modified_date)) LIKE :search_term";
            }
            $query.=" ORDER BY $order_by $order_dir LIMIT :offset , :limit";

            $db = Db::getInstance();
            $req = $db->prepare($query);
            $req->bindValue(':module_name', $module_name, PDO::PARAM_STR);
            
            if(!empty($objectId))
                $req->bindValue(':objectId', intval($objectId), PDO::PARAM_INT);
            $req->bindValue(':limit', intval($limit), PDO::PARAM_INT);
            $req->bindValue(':offset', intval($offset), PDO::PARAM_INT);
            if(!empty($params['search_term'])){
                $req->bindValue(':search_term', '%'.Functions::replaceLiteralChars($params['search_term']).'%', PDO::PARAM_STR);
            }
            $req->execute();
            
            foreach($req->fetchAll() as $obj) {
                if(array_key_exists($obj['parent_comment_id'],$list)){
                    $list[$obj['parent_comment_id']]->child_comments[]=new Comments( $obj['pk_comment_id'],
                                    $obj['object_id'],
                                    $obj['module_name'],
                                    $obj['parent_comment_id'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['created_at'],
                                    $obj['content'] ,
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_by_username'],
                                    $obj['modified_by_fullname'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['comment_params']);
                }
                else{
                    $list[$obj['pk_comment_id']] = new Comments( $obj['pk_comment_id'],
                                    $obj['object_id'],
                                    $obj['module_name'],
                                    $obj['parent_comment_id'],
                                    $obj['created_by'],
                                    $obj['created_by_username'],
                                    $obj['created_by_fullname'],
                                    $obj['created_at'],
                                    $obj['content'] ,
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_by_username'],
                                    $obj['modified_by_fullname'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['comment_params']);
                }
            }
            return $list;
        }

    }
?>