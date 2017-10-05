<?
/**
 *  真正資料儲存層
 */
class class_dal_reminders extends class_csql{
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
     * [ 取得提醒事項筆數 ]
     */
    public function sql_getReminderCount(){
        $sql = " select count(id) as count";        
        $sql.= " from reminders ";
        // echo $sql."<br>\n";
        $data = $this->Qexecute($sql,$params,'afth');
        return $data["count"];
    } 
    /**
     * [ 取得主提醒事項 ]
     */
    public function sql_getReminders($_id){
        $sql = " select id ";// 編號
        $sql.= " ,title ";// 標題   
        $sql.= " ,remind_time ";// 提醒時間   
        $sql.= " ,isCompleted ";// 是否完成   
        $sql.= " ,categoryId ";// 類別名稱   
        $sql.= " from reminders ";    
        if($_id>0){ 
            $sql.= " where id = '".$_id."'";
        }     
        // echo $sql."<br>\n";
        $row = $this->Qexecute($sql,$params);
        $sizeof = sizeof($row);
        $data = array();
        for($i=0; $i<$sizeof; $i++) {
            $data[$row[$i]["id"]] = $row[$i];
        }
        return $data;
    }
    /**
     * [ 取得主提醒事項標籤 ]
     */
    public function sql_getReminderTag($_reminderId){
        $sql = " select  id";// 編號
        $sql.= " ,reminderId ";// 主編號   
        $sql.= " ,tagId ";// 標籤編號   
        $sql.= " from reminders_tag ";   
        if($_reminderId!="0"){ 
            $sql.= " where reminderId = '".$_reminderId."'";
        }              
        // echo $sql."<br>\n";
        $row = $this->Qexecute($sql,$params);
        $sizeof = sizeof($row);
        $data = array();
        for($i=0; $i<$sizeof; $i++) {
            $data[$row[$i]["reminderId"]][$row[$i]["tagId"]] = $row[$i]["tagId"];
        }
        return $data;
    }


    
    /**
     * [ 新增主提醒事項 ]
     */
    public function sql_InsReminder($_title,$_remindTime,$_CategoryId){
        $sql = " insert into reminders set ";
        $sql.= "  title = '".$_title."'";// 標題
        $sql.= " ,remind_time = '".$_remindTime."'";// 提醒時間
        $sql.= " ,isCompleted = 'N'";// 是否完成
        $sql.= " ,CategoryId = '".$_CategoryId."'";// 類別編號
        $sql.= " ,build_time = '".time()."'";// 更新時間
        // echo $sql."<br>\n";
        $this->Wmysql($sql);
        return $this->getInserId();
    }
    /**
     * [ 新增主提醒事項標籤 ]
     */
    public function sql_insReminderTag($_reminderId,$_tags){
        $len = sizeof($_tags);
        $sqlVal = array();
        for($i=0; $i<$len; $i++){
           array_push($sqlVal,"('".$_reminderId."','".$_tags[$i]."')");
        }
        $sql = " insert into reminders_tag ";
        $sql.= " (reminderId, tagId) " ;
        $sql.= " VALUES ".join(",",$sqlVal);
        // echo $sql."<br>\n";
        $this->Wmysql($sql);
        return $this->getInserId();
    }



    /**
     * [ 修改主提醒事項 ]
     */
    public function sql_updReminder($_reminderId,$_title,$_remindTime,$_isCompleted,$_CategoryId){
        $sql = " update reminders set ";
        $sql.= "  title = '".$_title."'";// 標題
        $sql.= " ,remind_time = '".$_remindTime."'";// 提醒時間
        $sql.= " ,isCompleted = '".$_isCompleted."'";// 提醒時間
        $sql.= " ,CategoryId = '".$_CategoryId."'";// 類別編號
        $sql.= " ,op_time = '".time()."'";// 更新時間
        $sql.= " where id = '".$_reminderId."'";
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }



    /**
     * [ 刪除主提醒事項 ]
     */
    public function sql_delReminder($_reminderId){
        $sql = " delete from reminders ";
        $sql.= " where id = '".$_reminderId."'"; 
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }
    /**
     * [ 刪除主提醒事項標籤 ]
     */
    public function sql_delReminderTag($_reminderId){
        $sql = " delete from reminders_tag ";
        $sql.= " where reminderId = '".$_reminderId."'"; 
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }



    /**
     * [ 修改提醒事項類別 ]
     */
    public function sql_updReminderCategory($_reminderId,$_categoryId){
        $sql = " update reminders set ";
        $sql.= " CategoryId = '".$_categoryId."'";// 類別編號
        $sql.= " ,op_time = '".time()."'";// 更新時間
        $sql.= " where id = '".$_reminderId."'";
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }
    /**
     * [ 刪除提醒事項類別 ]
     */
    public function sql_delReminderCategory($_categoryId){
        $sql = " update reminders set ";
        $sql.= " CategoryId = '0'";// 類別編號
        $sql.= " ,op_time = '".time()."'";// 更新時間
        $sql.= " where CategoryId = '".$_categoryId."'";
        // echo $sql."<br>\n";
        return $this->Wmysql($sql);
    }
}
?>