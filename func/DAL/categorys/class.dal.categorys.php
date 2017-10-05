<?
/**
 *  真正資料儲存層
 */
class class_dal_categorys extends class_csql{
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
     * [ 取得類別 ]
     */
    public function sql_getCategorys($_id){
        $sql = " select id ";// 編號
        $sql.= " ,name ";// 帳號   
        $sql.= " from categorys ";
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
     * [ 新增類別 ]
     */
    public function sql_InsCategory($_name){
        $sql = " insert into categorys set ";
        $sql.= "  name = '".$_name."'";// 名稱
        $sql.= " ,build_time = '".time()."'";// 更新時間
        // echo $sql."<br>\n";
        $this->Wmysql($sql);
        return $this->getInserId();
    }
    /**
     * [ 修改類別 ]
     */
    public function sql_updCategory($_id,$_name){
        $sql = " update categorys set ";
        $sql.= "  name = '".$_name."'";// 名稱   
        $sql.= " ,op_time = '".time()."'";// 更新時間
        $sql.= " where id = '".$_id."'";
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }
    /**
     * [ 刪除類別 ]
     */
    public function sql_delCategory($_id){
        $sql = " delete from categorys ";
        $sql.= " where id = '".$_id."'"; 
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }
}
?>