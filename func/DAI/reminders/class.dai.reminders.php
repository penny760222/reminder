<?
/**
 *  中介層 (分配 DB、 redis、寫檔 )
 */
class class_dai_reminders{
	/**
	 * [ 建構子 ]
	 */
    public function __construct() {
    }
    /**
     * [ 解構子 ]
     */
    public function __desctruct() {        
    }
    //api 介面==================================================================================
    /**
     * [ 取得提醒事項筆數 ]
     */
    public function getReminderCount(){
        return Instance::get("dal_reminders")->sql_getReminderCount();
    }   
    /**
     * [ 取得主提醒事項 ]
     */
    public function getReminders($_reminderId){  
        return Instance::get("dal_reminders")->sql_getReminders($_reminderId);//取得主提醒事項 
    }     
    /**
     * [ 取得主提醒事項標籤 ]
     */
    public function getReminderTag($_reminderId){  
        return Instance::get("dal_reminders")->sql_getReminderTag($_reminderId);// 取得主提醒事項標籤
    }
    /**
     * [ 新增主提醒事項 ]
     */
    public function insReminder($_title,$_remindTime,$_CategoryId){
        return Instance::get("dal_reminders")->sql_InsReminder($_title,$_remindTime,$_CategoryId);
    }
    /**
     * [ 新增主提醒事項標籤 ]
     */
    public function insReminderTag($_reminderId,$_tags){
        return Instance::get("dal_reminders")->sql_insReminderTag($_reminderId,$_tags);
    }
    
    /**
     * [ 修改主提醒事項 ]
     */
    public function updReminder($_reminderId,$_title,$_remindTime,$_isCompleted,$_CategoryId){
        return Instance::get("dal_reminders")->sql_updReminder($_reminderId,$_title,$_remindTime,$_isCompleted,$_CategoryId); // 修改主提醒事項
    }  


    /**
     * [ 修改提醒事項標籤 ]
     */
    public function updReminderTag($_reminderId,$_tags){
        Instance::get("dal_reminders")->sql_delReminderTag($_reminderId); // 刪除主提醒事項標籤
        return Instance::get("dal_reminders")->sql_insReminderTag($_reminderId,$_tags); // 新增主提醒事項標籤
    } 


    /**
     * [ 刪除提醒事項 ]
     */
    public function doDelReminder($_reminderId){
        $eff = Instance::get("dal_reminders")->sql_delReminder($_reminderId); // 刪除主提醒事項
        if($eff>0) Instance::get("dal_reminders")->sql_delReminderTag($_reminderId); // 刪除主提醒事項標籤
        return $eff;
    }

    /**
     * [ 修改提醒事項類別 ]
     */
    public function updReminderCategory($_reminderId,$_categoryId){
        return Instance::get("dal_reminders")->sql_updReminderCategory($_reminderId,$_categoryId); // 修改提醒事項類別
    } 

    /**
     * [ 刪除提醒事項類別 ]
     */
    public function delReminderCategory($_categoryId){
        return Instance::get("dal_reminders")->sql_delReminderCategory($_categoryId); // 修改提醒事項類別
    } 
}