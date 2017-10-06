<?
/**
 *  真正資料儲存層
 */
class class_dal_tags extends class_csql{
    /**
    * [ 建構子 ]
    */
    public function __construct() {
        $this->init();
    }
    /**
    * [ 解構子 ]
    */
    public function __desctruct() {        
    } 
    /**
     * [ 初始化 ]
     */
    private function init() {
    }  

    //介面==================================================================================    
    /**
     * [ 取得標籤 ]
     */
    public function sql_getTags($_id){
        $sql = " select id ";// 編號
        $sql.= " ,name ";// 帳號   
        $sql.= " from tags ";
        $flag= "where";
        if($_id!="0"){ 
            $sql.= " where id = '".$_id."'";
        }             
        $row = $this->Qexecute($sql,$params);
        $sizeof = sizeof($row);
        $data = array();
        for($i=0; $i<$sizeof; $i++) {
            $data[$row[$i]["id"]] = $row[$i]["name"];
        }
        return $data;
    }
    /**
     * [ 新增標籤 ]
     */
    public function sql_InsTag($_name){
        $sql = " insert into tags set ";
        $sql.= "  name = '".$_name."'";// 名稱
        $sql.= " ,build_time = '".time()."'";// 更新時間
        $this->Wmysql($sql);
        return $this->getInserId();
    }
}
?>