<?php
    class Topics implements DatabaseObject{
        public static function insert($params){}
        public static function update($id,$params){}
        public static function delete($id){}
        public static function getObjList($params){}
        public static function getObj($id){}
        
        //count döndürür. 
        //type-> 'user' 'team' 'user_and_team' 'all' değerlerini alabilir. 
        //'all' için id'nin bir önemi yoktur
        //'user' sadece kullanıcının oluşturduğu topic sayısını döndürür. id->user id olmalıdır
        //'team' sadece teams içindeki topic sayısını döndürür id->team id olmalıdır
        //'user_and_team' kullanıcının erişiminin olduğu bütün topiclerin sayısını döndürür.
        //bunlar kullanıcının üyesi olduğu takımların yüklediği medyalar olacaktır id->user id olmalıdır.
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
    }
?>