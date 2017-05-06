<?php
    class Posts implements DatabaseObject {

        public $pk_post_id;
        public $author_id;
        public $author_name;
        public $post_date;
        public $post_title;
        public $post_alias;
        public $post_content;
        public $post_status;
        public $comment_status;
        public $modified_by;
        public $modified_date;
        public $guid;
        public $post_type;
        public $comment_count;
        public $post_params;

        public function __construct($pk_post_id,$author_id,$author_name,$post_date,$post_title,$post_alias,$post_content,$post_status,$comment_status,$modified_by,$modified_date,$guid,$post_type,$comment_count,$post_params){
            $this->pk_post_id=$pk_post_id;
            $this->author_id=$author_id;
            $this->author_name=$author_name;
            $this->post_date=$post_date;
            $this->post_title=$post_title;
            $this->post_alias=$post_alias;
            $this->post_content=$post_content;
            $this->post_status=$post_status;
            $this->comment_status=$comment_status;
            $this->modified_by=$modified_by;
            $this->modified_date=$modified_date;
            $this->guid=$guid;
            $this->post_type=$post_type;
            $this->comment_count=$comment_count;
            $this->post_params=$post_params;
        }

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['author_id']) || empty($params['post_title']) || empty($params['post_alias']) || empty($params['post_content']) || empty($params['post_status']) || empty($params['comment_status']) || empty($params['guid']) || empty($params['post_type'])) {
                $return['status']=false;
                $return['message']=T::__("Please fill all required fields!",true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if alias exists on db 
                $req = $db->prepare('SELECT COUNT(pk_post_id) FROM posts WHERE post_alias=:post_alias');
                $req->execute(array('post_alias' => $params['post_alias']));
                $req->execute(); 
                if($req->fetchColumn()>0){
                    $return['status']=false;
                    $return['message']=T::__("This alias already exists! You have to save your post with different alias!",true);
                    return $return;
                }

                //if not, save it
                $req = $db->prepare('INSERT INTO posts (author_id,post_date,post_title,post_alias,post_content,post_status,comment_status,guid,post_type,post_params) VALUES (:author_id , NOW() , :post_title , :post_alias , :post_content , :post_status , :comment_status , :guid , :post_type , :post_params )');
                $res=$req->execute(array(
                    'author_id' => $params['author_id'],
                    'post_title' => htmlspecialchars($params['post_title']),
                    'post_alias' => htmlspecialchars($params['post_alias']),
                    'post_content' => htmlspecialchars($params['post_content']),
                    'post_status' => $params['post_status'],
                    'comment_status' => $params['comment_status'],
                    'guid' => $params['guid'],
                    'post_type' => $params['post_type'],
                    'post_params' => $params['post_params']));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__("Your post created succesfully.",true);
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
            if ($params === null || empty($params['modified_by']) || empty($params['post_title']) || empty($params['post_alias']) || empty($params['post_content']) || empty($params['post_status']) || empty($params['comment_status']) || empty($params['guid']) || empty($params['post_type'])) {
                $return['status']=false;
                $return['message']=T::__("Please fill all required fields!",true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if alias exists on db 
                $req = $db->prepare('SELECT COUNT(pk_post_id) FROM posts WHERE pk_post_id=:pk_post_id');
                $req->execute(array('pk_post_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__("Post not found!",true);
                    return $return;
                }
                //if not, save it
                $req = $db->prepare('UPDATE posts SET post_title = :post_title ,post_alias = :post_alias ,post_content = :post_content ,post_status = :post_status ,comment_status = :comment_status ,modified_by = :modified_by ,modified_date = NOW() ,post_type = :post_type ,post_params = :post_params WHERE pk_post_id = :id');
                $res=$req->execute(array(
                    'post_title' => htmlspecialchars($params['post_title']),
                    'post_alias' => htmlspecialchars($params['post_alias']),
                    'post_content' => htmlspecialchars($params['post_content']),
                    'post_status' => $params['post_status'],
                    'comment_status' => $params['comment_status'],
                    'modified_by' => $params['modified_by'],
                    'post_type' => $params['post_type'],
                    'post_params' => $params['post_params'],
                    'id' => $id));
                if($res){
                    $return['status']=true;
                    $return['message']=T::__("Your post updated succesfully.",true);
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
            $req = $db->prepare('SELECT COUNT(pk_post_id) FROM posts WHERE pk_post_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__("Post not found!",true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM posts WHERE pk_post_id=:id');
            $res=$req->execute(array('id'=>$id));
            if($res){
                $return['status']=true;
                $return['message']=T::__(sprintf("ID: %s The post deleted succesfully!",$id),true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__("An error occured. Please contact with administrators!",true);
                return $return;
            }
        }

        //post content'ler çekilmiyor
        public static function getObjList($params){
            $list = [];

            $order_dirs=array("desc","asc");
            $key=array_search($params["order_dir"],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array("pk_post_id","author_id", "post_date", "modified_by", "modified_date", "post_type", "comment_count");
            $key=array_search($params["order_by"],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params["limit"] ? $params["limit"] : "20";
            $offset=$params["offset"] ? $params["offset"] : "0";

            $query="SELECT p.pk_post_id,p.author_id,u.username,p.post_date,p.post_title,p.post_alias,p.post_status,p.comment_status,p.modified_by,p.modified_date,p.guid,p.post_type,p.comment_count,p.post_params FROM minyy.posts as p LEFT JOIN minyy.users as u on p.author_id=u.pk_user_id";
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_post_id, '', author_id, '', post_title , '', post_content, '', post_date, '', modified_by, '', modified_date, '', post_type , '', comment_count)) LIKE :search_term";
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
                $list[] = new Posts( $obj['pk_post_id'],
                                    $obj['author_id'],
                                    $obj['username'],
                                    $obj['post_date'],
                                    $obj['post_title'],
                                    $obj['post_alias'],
                                    '',//burası post_content
                                    $obj['post_status'],
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['post_type'],
                                    $obj['comment_count'],
                                    $obj['post_params']);
            }
            return $list;
        }


        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT p.* , u.username FROM minyy.posts as p LEFT JOIN minyy.users as u on p.author_id=u.pk_user_id WHERE p.pk_post_id = :pk_post_id');
                $req->execute(array('pk_post_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new Posts( $obj['pk_post_id'],
                                    $obj['author_id'],
                                    $obj['username'],
                                    $obj['post_date'],
                                    $obj['post_title'],
                                    $obj['post_alias'],
                                    $obj['post_content'],
                                    $obj['post_status'],
                                    $obj['comment_status'],
                                    $obj['modified_by'],
                                    $obj['modified_date'],
                                    $obj['guid'],
                                    $obj['post_type'],
                                    $obj['comment_count'],
                                    $obj['post_params']);
                }
                else{
                    return [];
                }
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }

        public static function commentCountInc($id,$value = 1){
            $db = Db::getInstance();

            //check if alias exists on db 
            $req = $db->prepare('SELECT COUNT(pk_post_id) FROM posts WHERE pk_post_id=:pk_post_id');
            $req->execute(array('pk_post_id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__("Post not found!",true);
                return $return;
            }
            //if not, save it
            $req = $db->prepare('UPDATE posts SET comment_count = comment_count + :value WHERE pk_post_id = :id');
            $res=$req->execute(array(
                'value' => $value,
                'id' => $id));
            if($res){
                $return['status']=true;
                $return['message']=T::__("Your post updated succesfully.",true);
                return $return;
            }
            else{
                $return['status']=false;
                $return['message']=T::__("An error occured. Please contact with administrators!",true);
                return $return;
            }  
        }
        public static function getTotal($search_term) {
            $query="SELECT COUNT(pk_post_id) FROM posts";
            if(!empty($search_term))
                $query.=" WHERE lower(concat(pk_post_id, '', author_id, '', post_title , '', post_content, '', post_date, '', modified_by, '', modified_date, '', post_type , '', comment_count)) LIKE :search_term";
            $db = Db::getInstance();
            $req = $db->prepare($query);
            if(!empty($search_term))
                $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
            
            $req->execute();
            $res=$req->fetch();
            return (int) $res[0];
        }

        public static function getCommentCount($id){
            $db = Db::getInstance();

            //check if alias exists on db 
            $req = $db->prepare('SELECT comment_count FROM posts WHERE pk_post_id=:pk_post_id');
            $req->execute(array('pk_post_id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__("Post not found!",true);
                return $return;
            }
            //if not, run
            $return['status']=true;
            $return['message']=T::__($req->fetch()->comment_count,true);
            return $return;
        }
        
    }
?>