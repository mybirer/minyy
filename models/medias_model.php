<?php
    class Medias implements DatabaseObject{
        public $pk_media_id;
        public $name;
        public $description ;
        public $created_at ;
        public $pk_user_id ;
        public $username;
        public $pk_media_source_id ;
        public $media_source_name ;
        public $pk_media_type_id ;
        public $media_type_name ;
        public $media_url ;
        public $pk_lang_id ;
        public $lang;
        public $pk_team_id ;
        public $team_name;
        public $native_translation_id;//Ana dildeki altyazı

        public function __construct($pk_media_id, $name, $description , $created_at , $pk_user_id , $username , $pk_media_source_id , $media_source_name , $pk_media_type_id , $media_type_name , $media_url , $pk_lang_id , $lang, $pk_team_id , $team_name , $native_translation_id){
            $this->pk_media_id = $pk_media_id;
            $this->name = $name;
            $this->description  = $description;
            $this->media_url  = $media_url;            
            $this->created_at  = $created_at;
            $this->pk_user_id  = $pk_user_id;
            $this->username = $username; //custom add
            $this->pk_media_source_id  = $pk_media_source_id;
            $this->media_source_name  = $media_source_name;
            $this->pk_media_type_id  = $pk_media_type_id;
            $this->media_type_name  = $media_type_name;
            $this->pk_lang_id  = $pk_lang_id;
            $this->lang  = $lang;
            $this->pk_team_id  = $pk_team_id;
            $this->team_name = $team_name;
            $this->native_translation_id = $native_translation_id;
        }

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['pk_user_id']) || empty($params['pk_media_source_id']) || empty($params['pk_media_type_id']) || empty($params['media_url']) ) {
                $return['status']=false;
                $return['message']=T::__("Please fill all required fields!",true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                $req = $db->prepare('INSERT INTO medias (name, description, created_at, pk_user_id, pk_media_source_id, pk_media_type_id, media_url, pk_lang_id, pk_team_id, native_translation_id)VALUES(:name, :description, DATE() , :pk_user_id, :pk_media_source_id, :pk_media_type_id, :media_url, :pk_lang_id, :pk_team_id, :native_translation_id)');
                $res=$req->execute(array(
                    'name' => $params['name'],
                    'description' => $params['description'],
                    'pk_user_id' => $params['pk_user_id'],
                    'pk_media_source_id' => $params['pk_media_source_id'],
                    'pk_media_type_id' => $params['pk_media_type_id'],
                    'media_url' => $params['media_url'],
                    'pk_lang_id' => $params['pk_lang_id'],
                    'pk_team_id' => $params['pk_team_id'],
                    'native_translation_id' => $params['native_translation_id']));
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
            if ($id === null || $params === null || empty($params['pk_user_id']) || empty($params['pk_media_source_id']) || empty($params['pk_media_type_id']) || empty($params['media_url']) ) {
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
                
                $req = $db->prepare('UPDATE medias SET name = :name, description = :description, pk_user_id = :pk_user_id, pk_media_source_id = :pk_media_source_id, pk_media_type_id = :pk_media_type_id, media_url = :media_url, pk_lang_id = :pk_lang_id, pk_team_id = :pk_team_id, native_translation_id = :native_translation_id WHERE  pk_media_id = :id');
                $res=$req->execute(array(
                    'name' => $params['name'],
                    'description' => $params['description'],
                    'pk_user_id' => $params['pk_user_id'],
                    'pk_media_source_id' => $params['pk_media_source_id'],
                    'pk_media_type_id' => $params['pk_media_type_id'],
                    'media_url' => $params['media_url'],
                    'pk_lang_id' => $params['pk_lang_id'],
                    'pk_team_id' => $params['pk_team_id'],
                    'native_translation_id' => $params['native_translation_id'],
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

        public static function getObjList($params){
            $list = [];

            $order_dirs=array('desc','asc');
            $key=array_search($params['order_dir'],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array('pk_media_id','pk_user_id', 'created_at', 'pk_media_source_id', 'pk_media_type_id', 'pk_lang_id', 'pk_team_id','media_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tm.*,u.username,t.team_name,lang.lang_name,ms.media_source_name,mt.media_type_name FROM minyy.medias as tm LEFT JOIN minyy.users as u on tm.pk_user_id=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=tm.pk_team_id LEFT JOIN minyy.languages as lang on tm.pk_lang_id=lang.pk_lang_id LEFT JOIN minyy.media_sources as ms on ms.pk_media_source_id=tm.pk_media_source_id LEFT JOIN minyy.media_types as mt on mt.pk_media_type_id=tm.pk_media_type_id ';
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_media_id, '', pk_user_id, '', created_at , '', pk_media_source_id, '', pk_media_type_id, '', pk_lang_id, '', pk_team_id, '', media_url)) LIKE :search_term";
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
                                    $obj['created_at'],
                                    $obj['pk_user_id'],
                                    $obj['username'],
                                    $obj['pk_media_source_id'],
                                    $obj['media_source_name'],
                                    $obj['pk_media_type_id'],
                                    $obj['media_type_name'],
                                    $obj['media_url'],
                                    $obj['pk_lang_id'],
                                    $obj['lang'],
                                    $obj['pk_team_id'],
                                    $obj['team_name'],
                                    $obj['native_translation_id']);
            }
            return $list;
        }

        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT tm.*,u.username,t.team_name,lang.lang_name,ms.media_source_name,mt.media_type_name FROM minyy.medias as tm LEFT JOIN minyy.users as u on tm.pk_user_id=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=tm.pk_team_id LEFT JOIN minyy.languages as lang on tm.pk_lang_id=lang.pk_lang_id LEFT JOIN minyy.media_sources as ms on ms.pk_media_source_id=tm.pk_media_source_id LEFT JOIN minyy.media_types as mt on mt.pk_media_type_id=tm.pk_media_type_id WHERE p.pk_media_id = :pk_media_id');
                $req->execute(array('pk_media_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new TranslationMedia( $obj['pk_media_id'],
                                    $obj['name'],
                                    $obj['description'],
                                    $obj['created_at'],
                                    $obj['pk_user_id'],
                                    $obj['username'],
                                    $obj['pk_media_source_id'],
                                    $obj['media_source_name'],
                                    $obj['pk_media_type_id'],
                                    $obj['media_type_name'],
                                    $obj['media_url'],
                                    $obj['pk_lang_id'],
                                    $obj['lang'],
                                    $obj['pk_team_id'],
                                    $obj['team_name'],
                                    $obj['native_translation_id']);
                }
                else{
                    return [];
                }
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }

    }
?>