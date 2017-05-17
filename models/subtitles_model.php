<?php
    class Subtitles implements DatabaseObject{
        public static function insert($params){}
        public static function update($id,$params){}
        public static function delete($id){}
        public static function getObjList($params){}
        public static function getObj($id){}

        //count döndürür. 
        //type-> 'user' 'team' 'user_and_team' 'all' değerlerini alabilir. 
        //'all' için id'nin bir önemi yoktur
        //'user' sadece kullanıcının oluşturduğu çevirilerin sayısını döndürür. id->user id olmalıdır
        //'team' sadece teams içindeki çeviri sayısını döndürür id->team id olmalıdır
        public static function getTotal($id,$type,$search_term){
            $count = -1;
            $type=trim($type);
            if($type==null || $type=='' || ($type!='user' && $type!='team' && $type!='all')){
                return count;
            }
            if($type!='all' && $id==null) 
                return count;
            
            $db = Db::getInstance();
            $query="SELECT COUNT(pk_subtitle_id) FROM subtitles AS s";

            switch ($type){
                case 'user':
                    $query.=' WHERE s.created_by=:id';
                    break;
                case 'team':
                    $query.=' LEFT JOIN medias AS m ON m.pk_media_id=s.media_id WHERE m.pk_team_id=:id';
                    break;
                case 'all':

                    break;
            }
            if(!empty($search_term) && $type=='all')
                $query.=" WHERE lower(concat(pk_subtitle_id, '', media_id , '', created_by, '', created_at, '', lang_code)) LIKE :search_term";

            if(!empty($search_term) && $type!='all')
                $query.=" AND lower(concat(pk_subtitle_id, '', media_id , '', created_by, '', created_at, '', lang_code)) LIKE :search_term";

            $req = $db->prepare($query);
            if($type!='all')
                $req->bindValue(':id', $id, PDO::PARAM_INT);
            if(!empty($search_term))
                $req->bindValue(':search_term', "%".$search_term."%", PDO::PARAM_STR);
            
            $req->execute();
            $res=$req->fetch();
            return (int) $res[0];
            
        }
    }
?>