<?php
    class Subtitles implements DatabaseObject{
        public $pk_subtitle_id;
        public $media_id;
        public $created_by;
        public $created_at;
        public $lang_code;
        public $media_name;
        public $media_description;
        public $or_media_title;
        public $or_media_description;
        public $media_url;
        public $sentences;
        
        public function __construct($pk_subtitle_id, $media_id, $created_by, $created_at, $lang_code, $media_name, $media_description, $or_media_title, $or_media_description, $media_url){
            $this->pk_subtitle_id = $pk_subtitle_id;
            $this->media_id = $media_id;
            $this->created_by  = $created_by;
            $this->created_at  = $created_at;       
            $this->lang_code  = $lang_code;     
            $this->media_name  = $media_name;
            $this->media_description = $media_description; 
            $this->or_media_title  = $or_media_title;
            $this->or_media_description = $or_media_description; 
            $this->media_url = $media_url; 
            $this->sentences  = $this->getSubtitleSentences($pk_subtitle_id);
        }
        public static function insert($params){
            global $currentUser;
            $return=[];
            if ($params === null || empty($params['media_id']) || empty($params['language']) ) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $db = Db::getInstance();

                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_media_id) FROM medias WHERE pk_media_id=:pk_media_id');
                $req->execute(array('pk_media_id' => $params['media_id']));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Media not found!',true);
                    return $return;
                }

                $params['language']=Functions::clearString($params['language']);

                $req = $db->prepare('INSERT INTO subtitles (media_id, created_by, created_at, lang_code, media_name, media_description) VALUES (:media_id, :created_by, NOW(), :lang_code, :media_name, :media_description)');
                $res=$req->execute(array(
                    'media_id' => $params['media_id'],
                    'created_by' => $currentUser->pk_user_id,
                    'lang_code' => $params['language'],
                    'media_name' => $params['media_name'],
                    'media_description' => $params['media_description']));

                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Subtitle added succesfully. You will redirecting edit panel',true);
                    return $return;
                }
                else{
                    $return['status']=false;
                    $return['message']=T::__('An error occured. Please contact with administrators!',true);
                    return $return;
                }   
            }
        }
        public static function update($id,$params){}
        public static function delete($id){}
        public static function getObjList($params){}
        public static function getObj($id){
            try{
                $db = Db::getInstance();
                $id = intval($id);
                $req = $db->prepare('SELECT SB.pk_subtitle_id, SB.media_id, SB.created_by, SB.created_at, SB.lang_code, M.name, M.description FROM subtitles AS SB LEFT JOIN medias AS M ON M.pk_subtitle_id=SB.subtitle_id WHERE SB.pk_subtitle_id = :pk_subtitle_id');
                $req->execute(array('pk_subtitle_id' => $id));
                $obj = $req->fetch();
                if($obj){
                    return new Subtitles( $obj['pk_subtitle_id'],
                                    $obj['media_id'],
                                    $obj['created_by'],
                                    $obj['created_at'],
                                    $obj['lang_code'],
                                    $obj['name'],
                                    $obj['description']);
                }
                else{
                    return [];
                }
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }
        public static function getObjByLangCode($mediaId,$langCode){
            try{
                $mediaId=Functions::clearString($mediaId);
                $langCode=Functions::clearString($langCode);
                $mediaId = intval($mediaId);
                $db = Db::getInstance();
                $req = $db->prepare('SELECT SB.pk_subtitle_id, SB.media_id, SB.created_by, SB.created_at, SB.lang_code, SB.media_name, SB.media_description, M.name AS or_media_title, M.description AS or_media_description, M.media_url FROM subtitles AS SB LEFT JOIN medias AS M ON M.pk_media_id=SB.media_id WHERE SB.media_id = :media_id AND SB.lang_code = :lang_code');
                $req->execute(array('media_id' => $mediaId,'lang_code' => $langCode));
                $obj = $req->fetch();
                if($obj){
                    return new Subtitles( $obj['pk_subtitle_id'],
                                    $obj['media_id'],
                                    $obj['created_by'],
                                    $obj['created_at'],
                                    $obj['lang_code'],
                                    $obj['media_name'],
                                    $obj['media_description'],
                                    $obj['or_media_title'],
                                    $obj['or_media_description'],
                                    $obj['media_url']);
                }
                else{
                    return [];
                }
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }
        public function getSubtitleSentences($subtitleId){
            try{
                $db = Db::getInstance();
                $mediaId = intval($subtitleId);
                $req = $db->prepare('SELECT * FROM sentences WHERE subtitle_id = :subtitle_id');
                $req->execute(array('subtitle_id' => $subtitleId));
                // we create a list of Post objects from the database results
                $list=[];
                foreach($req->fetchAll(PDO::FETCH_ASSOC) as $obj) {
                    $list[$obj['pk_sentence_id']]= $obj;
                }
                return $list;
            }
            catch (PDOException $e){
                return $e->getMessage();
            }
        }
        public static function insertSentences($params){
            global $currentUser;
            $return=[];
            if ($params === null || empty($params['subtitle_id'])) {
                $return['status']=false;
                $return['message']=T::__('Please fill all required fields!',true);
                return $return;
            }
            else{
                $params['subtitle_id']=Functions::clearString($params['subtitle_id']);

                $db = Db::getInstance();
                //check if media exists on db 
                $req = $db->prepare('SELECT COUNT(pk_subtitle_id) FROM subtitles WHERE pk_subtitle_id=:pk_subtitle_id');
                $req->execute(array('pk_subtitle_id' => $params['subtitle_id']));
                if($req->fetchColumn()==0){
                    $return['status']=false;
                    $return['message']=T::__('Media not found!',true);
                    return $return;
                }
                $query="";
                for($i=0;$i<count($params['sentences']);$i++){
                    $sentence=$params['sentences'][$i];
                    if($i==0){
                        $query="DELETE FROM sentences WHERE subtitle_id=:subtitle_id; INSERT INTO sentences (subtitle_id, text, start_time, end_time, order_number) VALUES ";
                    }
                    $query.=sprintf("('%s','%s','%s','%s','%s')",
                                    $params['subtitle_id'],
                                    $sentence['text'],
                                    $sentence['start_time'],
                                    $sentence['end_time'],
                                    $sentence['order_number']);
                    if($i==count($params['sentences'])-1){
                        $query.=";";
                    }
                    else{
                        $query.=", ";
                    }
                }
                $res=false;
                if(!empty($query)){
                    $req = $db->prepare($query);
                    $res=$req->execute(array('subtitle_id'=>$params['subtitle_id']));
                }
                if($res){
                    $return['status']=true;
                    $return['message']=T::__('Sentences saved succesfully!',true);
                    return $return;
                }
                else{
                    $return['status']=false;
                    $return['message']=T::__('An error occured. Please contact with administrators!',true);
                    return $return;
                }   
            }
        }
    }
?>