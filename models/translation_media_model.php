<?php
    class TranslationMedia implements DatabaseObject{
        public $pk_tm_id;
        public $tm_name;
        public $tm_description ;
        public $creation_date ;
        public $pk_user_id ;
        public $username;
        public $pk_media_source_id ;
        public $media_source_name ;
        public $pk_media_type_id ;
        public $media_type_name ;
        public $tm_url ;
        public $pk_lang_id ;
        public $lang;
        public $pk_team_id ;
        public $team_name;
        public $native_translation_id;//Ana dildeki altyazı

        public function __construct($pk_tm_id, $tm_name, $tm_description , $creation_date , $pk_user_id , $username , $pk_media_source_id , $media_source_name , $pk_media_type_id , $media_type_name , $tm_url , $pk_lang_id , $lang, $pk_team_id , $team_name , $native_translation_id){
            $this->pk_tm_id = pk_tm_id;
            $this->tm_name = tm_name;
            $this->tm_description  = tm_description;
            $this->creation_date  = creation_date;
            $this->pk_user_id  = pk_user_id;
            $this->username = username;
            $this->pk_media_source_id  = pk_media_source_id;
            $this->media_source_name  = media_source_name;
            $this->pk_media_type_id  = pk_media_type_id;
            $this->media_type_name  = media_type_name;
            $this->tm_url  = tm_url;
            $this->pk_lang_id  = pk_lang_id;
            $this->lang  = lang;
            $this->pk_team_id  = pk_team_id;
            $this->team_name = team_name;
            $this->native_translation_id = native_translation_id;
        }

        public static function insert($params){
            $return=[];
            if ($params === null || empty($params['pk_user_id']) || empty($params['pk_media_source_id']) || empty($params['pk_media_type_id']) || empty($params['tm_url']) ) {
                $return['status']=false;
                $return['message']=T::__("Please fill all required fields!",true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                $req = $db->prepare('INSERT INTO translation_media(tm_name, tm_description, creation_date, pk_user_id, pk_media_source_id, pk_media_type_id, tm_url, pk_lang_id, pk_team_id, native_translation_id)VALUES(:tm_name, :tm_description, DATE() , :pk_user_id, :pk_media_source_id, :pk_media_type_id, :tm_url, :pk_lang_id, :pk_team_id, :native_translation_id)');
                $res=$req->execute(array(
                    'tm_name' => $params['tm_name'],
                    'tm_description' => $params['tm_description'],
                    'pk_user_id' => $params['pk_user_id'],
                    'pk_media_source_id' => $params['pk_media_source_id'],
                    'pk_media_type_id' => $params['pk_media_type_id'],
                    'tm_url' => $params['tm_url'],
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
            if ($id === null || $params === null || empty($params['pk_user_id']) || empty($params['pk_media_source_id']) || empty($params['pk_media_type_id']) || empty($params['tm_url']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_tm_id) FROM translation_media WHERE pk_tm_id=:pk_tm_id');
                $req->execute(array('pk_tm_id' => $id));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Media not found!',true);
                    return $return;
                }
                
                $req = $db->prepare('UPDATE translation_media SET tm_name = :tm_name, tm_description = :tm_description, pk_user_id = :pk_user_id, pk_media_source_id = :pk_media_source_id, pk_media_type_id = :pk_media_type_id, tm_url = :tm_url, pk_lang_id = :pk_lang_id, pk_team_id = :pk_team_id, native_translation_id = :native_translation_id WHERE  pk_tm_id = :id');
                $res=$req->execute(array(
                    'tm_name' => $params['tm_name'],
                    'tm_description' => $params['tm_description'],
                    'pk_user_id' => $params['pk_user_id'],
                    'pk_media_source_id' => $params['pk_media_source_id'],
                    'pk_media_type_id' => $params['pk_media_type_id'],
                    'tm_url' => $params['tm_url'],
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
            $req = $db->prepare('SELECT COUNT(pk_tm_id) FROM translation_media WHERE pk_tm_id=:id');
            $req->execute(array('id' => $id));
            if($req->fetchColumn()==0){
                $return['status']=false;
                $return['message']=T::__('Media not found!',true);
                return $return;
            }    
            $req = $db->prepare('DELETE FROM translation_media WHERE pk_tm_id=:id');
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

            $order_columns=array('pk_tm_id','pk_user_id', 'creation_date', 'pk_media_source_id', 'pk_media_type_id', 'pk_lang_id', 'pk_team_id','tm_url');
            $key=array_search($params['order_by'],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params['limit'] ? $params['limit'] : '20';
            $offset=$params['offset'] ? $params['offset'] : '0';

            $query='SELECT tm.*,u.username,t.team_name,lang.lang_name,ms.media_source_name,mt.media_type_name FROM minyy.translation_media as tm LEFT JOIN minyy.users as u on tm.pk_user_id=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=tm.pk_team_id LEFT JOIN minyy.languages as lang on tm.pk_lang_id=lang.pk_lang_id LEFT JOIN minyy.media_sources as ms on ms.pk_media_source_id=tm.pk_media_source_id LEFT JOIN minyy.media_types as mt on mt.pk_media_type_id=tm.pk_media_type_id ';
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_tm_id, '', pk_user_id, '', creation_date , '', pk_media_source_id, '', pk_media_type_id, '', pk_lang_id, '', pk_team_id, '', tm_url)) LIKE :search_term";
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
                $list[] = new TranslationMedia( $obj['pk_tm_id'],
                                    $obj['tm_name'],
                                    $obj['tm_description'],
                                    $obj['creation_date'],
                                    $obj['pk_user_id'],
                                    $obj['username'],
                                    $obj['pk_media_source_id'],
                                    $obj['media_source_name'],
                                    $obj['pk_media_type_id'],
                                    $obj['media_type_name'],
                                    $obj['tm_url'],
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
                $req = $db->prepare('SELECT tm.*,u.username,t.team_name,lang.lang_name,ms.media_source_name,mt.media_type_name FROM minyy.translation_media as tm LEFT JOIN minyy.users as u on tm.pk_user_id=u.pk_user_id LEFT JOIN minyy.teams as t on t.pk_team_id=tm.pk_team_id LEFT JOIN minyy.languages as lang on tm.pk_lang_id=lang.pk_lang_id LEFT JOIN minyy.media_sources as ms on ms.pk_media_source_id=tm.pk_media_source_id LEFT JOIN minyy.media_types as mt on mt.pk_media_type_id=tm.pk_media_type_id WHERE p.pk_tm_id = :pk_tm_id');
                $req->execute(array('pk_tm_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new TranslationMedia( $obj['pk_tm_id'],
                                    $obj['tm_name'],
                                    $obj['tm_description'],
                                    $obj['creation_date'],
                                    $obj['pk_user_id'],
                                    $obj['username'],
                                    $obj['pk_media_source_id'],
                                    $obj['media_source_name'],
                                    $obj['pk_media_type_id'],
                                    $obj['media_type_name'],
                                    $obj['tm_url'],
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