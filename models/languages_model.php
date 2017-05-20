<?php
    class Languages implements DatabaseObject{
        public $pk_lang_id;
        public $lang_name;
        public $lang_code;
        public $lang_status;

        public function __construct($pk_lang_id,$lang_name,$lang_code,$lang_status){
            $this->pk_lang_id=$pk_lang_id;
            $this->lang_name=$lang_name;
            $this->lang_code=$lang_code;
            $this->lang_status=$lang_status;
        }
        public static function insert($params){}
        public static function update($id,$params){}
        public static function delete($id){}
        public static function getObjList($params){
            $list = [];

            $order_dirs=array("desc","asc");
            $key=array_search($params["order_dir"],$order_dirs);
            $order_dir=$order_dirs[($key) ? $key : 0];

            $order_columns=array("pk_lang_id","lang_name", "lang_code", "lang_status");
            $key=array_search($params["order_by"],$order_columns);
            $order_by=$order_columns[($key) ? $key : 0];

            $limit=$params["limit"] ? $params["limit"] : "1000";
            $offset=$params["offset"] ? $params["offset"] : "0";

            $query="SELECT pk_lang_id,lang_name,lang_code,lang_status FROM languages";
            if(!empty($params['search_term'])){
                $query.=" WHERE lower(concat(pk_lang_id, '', lang_name, '', lang_code , '', lang_status)) LIKE :search_term";
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

            foreach($req->fetchAll() as $obj) {
                if(isset($params['return_as_array']) && $params['return_as_array']=="true"){
                    $list[$obj['lang_code']] = array( "pk_lang_id"=>$obj['pk_lang_id'],
                                        "lang_name"=>$obj['lang_name'],
                                        "lang_code"=>$obj['lang_code'],
                                        "lang_status"=>$obj['lang_status']);
                }
                else{
                    $list[] = new Languages( $obj['pk_lang_id'],
                                        $obj['lang_name'],
                                        $obj['lang_code'],
                                        $obj['lang_status']);
                }
            }
            return $list;
        }
        public static function getObj($lang_code){
            try{
                $db = Db::getInstance();
                $lang_code = Functions::clearString($lang_code);
                $req = $db->prepare('SELECT * FROM languages WHERE pk_lang_code = :pk_lang_code');
                $req->execute(array('pk_lang_id' => $lang_code));
                $obj = $req->fetch();
                if($obj){
                    return new Languages( $obj['pk_lang_id'],
                                    $obj['lang_name'],
                                    $obj['lang_code'],
                                    $obj['lang_status']);
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