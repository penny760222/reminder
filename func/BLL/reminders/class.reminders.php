<?
/**
 *  商業邏輯層
 */
class class_reminders {

    /** 設定基本函數
    */
	/**
	 * [ 建構子 ]
	 */
    public function __construct(){
    	$this->_init();
    }
    /**
     * [ 解構子 ]
     */
    public function __desctruct(){
    }
	/**
     * [ 初始化 ]
	 */
    private function _init(){
    }	

    // 提醒事項==================================================================================
    /**
    * [ 取得提醒事項列表 ]
    */
    public function getReminders(){

        ## 取得筆數
        $count = Instance::get("dai_reminders")->getReminderCount();// 取得提醒事項筆數

        ## 處理提醒事項列表
        $reminder = array();
        if( $count>0 ){
            $reminderList = $this->doGetReminders(); // 取得提醒事項列表
            $categoryList = Instance::get("dai_categorys")->getcategorys();// 取得類別
            $tagList = Instance::get("dai_tags")->getTags();// 取得標籤
            foreach($reminderList as $reminderId => $v){
                array_push($reminder, array(
                    "id" => $v["id"],
                    "title" => $v["title"],
                    "remindTime" => date("Y-m-d H:i:s",$v["remind_time"]),
                    "isCompleted" => $v["isCompleted"],
                    "isCompleted" => $v["isCompleted"],
                    "tags" => $this->_transferTagsId2Name($v["tags"]),
                    "category" => $this->_transferCategoryId2Name($v["categoryId"]),
                ));
            }
        }

        ## 回傳結果
        return Instance::get("response")->set_Success($reminder);
    }
    /**
     * [ 取得提醒事項 ]
     */
    private function doGetReminders($_reminderId=0){
        $reminders = Instance::get("dai_reminders")->getReminders($_reminderId);//取得主提醒事項           
        $reminderTag = Instance::get("dai_reminders")->getReminderTag($_reminderId);// 取得主提醒事項標籤
        foreach($reminders as $id => $v){
            $tags = array();
            if( isset($reminderTag[$id]) ){
                $tags = $reminderTag[$id];
            }
            $reminders[$id]["tags"] = $tags;
        }
        return $reminders;
    }    

    /**
    * [ 新增提醒事項 ]
    */
    public function postReminder($_params){

        ## 檢查參數
        $requireds = array('title','remindTime','tags','category');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        if( $chk === false ) return ; // 請檢查參數
         
        ## 傳入參數
        $_title = $_params["title"];// 標題
        $_remindTime = strtotime($_params["remindTime"]);// 提醒時間
        $_tagIds = $this->_transferTagsName2Id($_params["tags"]);// 標籤名稱陣列
        if( $_tagIds === false ) return ; // 請檢查參數
        $_categoryId = $this->_transferCategoryName2Id($_params["category"]);// 類別名稱
        if( $_categoryId === false ) return ; // 請檢查參數

        ## 新增提醒事項
        
        $reminderId = Instance::get("dai_reminders")->InsReminder($_title,$_remindTime,$_categoryId);//新增主提醒事項
        if($reminderId>0){
            Instance::get("dai_reminders")->insReminderTag($reminderId,$_tagIds);// 新增主提醒事項標籤
        }
        if( $reminderId<=0 ) return Instance::get("response")->set_Fail("E30001"); // 修改失敗

        ## 取得提醒事項 reload
        $reminderSingle = $this->doGetReminders($reminderId)[$reminderId]; // 取得提醒事項列表
        return Instance::get("response")->set_Success(array(
            "id" => $reminderSingle["id"],
            "title" => $reminderSingle["title"],
            "remindTime" => date("Y-m-d H:i:s",$reminderSingle["remind_time"]),
            "isCompleted" => $reminderSingle["isCompleted"],
            "tags" => $this->_transferTagsId2Name($reminderSingle["tags"]),
            "category" => $this->_transferCategoryId2Name($reminderSingle["categoryId"]),
        ));
    }

    // 將標籤編號轉換成標籤名稱
    private function _transferTagsId2Name($_tagIds){   
        $tagList = Instance::get("dai_tags")->getTags();// 取得標籤
        $tagNames = array();
        foreach($_tagIds as $tagId => $v2){
            if( !isset($tagList[$tagId]) ) continue;
            $tagNames[] = array(
                "id" => $tagId,
                "name" => $tagList[$tagId],
            );
        }
        return $tagNames;
    }
    // 將類別編號轉換成類別名稱
    private function _transferCategoryId2Name($_categoryId){   
        $category = array();   
        $categoryList = Instance::get("dai_categorys")->getcategorys();// 取得類別
        if( isset($categoryList[$_categoryId]) ){
            $category = array(
                "id" => $_categoryId,
                "name" => $categoryList[$_categoryId],
            );
        }
        return $category;
    }

    // 將標籤名稱轉換成標籤編號
    private function _transferTagsName2Id($_tagNames){
        $tagIds = array();
        $len = sizeof($_tagNames);
        if( $len>0 ){
            $tagList = Instance::get("dai_tags")->getTags();// 取得標籤
            for($i=0; $i<$len; $i++){
                $tagName = $_tagNames[$i];
                $flag = false;
                foreach($tagList as $tagId =>$tagname){
                    if( $tagName!=$tagname ) continue;
                    $flag = true;
                    $tagIds[] = $tagId;
                    break;
                }
                if( $flag===false ){
                    Instance::get("response")->set_Fail("E30002"); // 請檢查參數
                    return false;
                }
            }
        }
        return $tagIds;
    }
    // 將類別名稱轉換成類別編號
    private function _transferCategoryName2Id($_categoryName){      
        if($_categoryName=="") return "0";
        $categoryList = Instance::get("dai_categorys")->getcategorys();// 取得類別
        foreach($categoryList as $id =>$categoryName){
            if( $_categoryName==$categoryName ) return $id;
        }
        Instance::get("response")->set_Fail("E30003"); // 請檢查參數
        return false;
    }
    /**
    * [ 取得單筆提醒事項 by Id ]
    */
    public function getRemindersingle($_params){
        ## 傳入參數
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_reminderId = $_params["id"];
        ## 取得列表
        $reminderSingle = $this->doGetReminders($_reminderId)[$_reminderId]; // 取得提醒事項列表
        if( $reminderSingle==false ){
            Instance::get("response")->set_Fail("E30004"); // 請檢查參數
            return false;
        }     
        ## 回傳結果
        return Instance::get("response")->set_Success(array(
            "id" => $reminderSingle["id"],
            "title" => $reminderSingle["title"],
            "remindTime" => date("Y-m-d H:i:s",$reminderSingle["remind_time"]),
            "isCompleted" => $reminderSingle["isCompleted"],
            "tags" => $this->_transferTagsId2Name($reminderSingle["tags"]),
            "category" => $this->_transferCategoryId2Name($reminderSingle["categoryId"]),
        ));
    }
    /**
     *  [ 修改提醒事項 ]
     */
    public function patchReminder($_params){

        ## 檢查參數
        $requireds = array('id','title','remindTime','isCompleted','tags','category');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        if( $chk === false ) return ; // 請檢查參數
         
        ## 傳入參數 
        $_reminderId = $_params["id"];// 標題
        $_title = $_params["title"];// 標題
        $_isCompleted = $_params["isCompleted"];// 標題
        $_remindTime = strtotime($_params["remindTime"]);// 提醒時間
        $_tagIds = $this->_transferTagsName2Id($_params["tags"]);// 標籤名稱陣列
        if( $_tagIds === false ) return ; // 請檢查參數
        $_categoryId = $this->_transferCategoryName2Id($_params["category"]);// 類別名稱
        if( $_categoryId === false ) return ; // 請檢查參數

        ## 修改提醒事項
        // $eff = Instance::get("dai_reminders")->doUpdReminder($_reminderId,$_title,$_remindTime,$_isCompleted,$_categoryId,$_tagIds);
        $eff = Instance::get("dai_reminders")->updReminder($_reminderId,$_title,$_remindTime,$_isCompleted,$_CategoryId); // 修改主提醒事項
        if( $eff==false ) return Instance::get("response")->set_Fail("E30005"); // 修改失敗
        Instance::get("dai_reminders")->updReminderTag($_reminderId,$_tagIds); // 修改主提醒事項標籤

        ## reload
        $reminderSingle = $this->doGetReminders($_reminderId)[$_reminderId]; // 取得提醒事項列表
        return Instance::get("response")->set_Success(array(
            "id" => $reminderSingle["id"],
            "title" => $reminderSingle["title"],
            "remindTime" => date("Y-m-d H:i:s",$reminderSingle["remind_time"]),
            "isCompleted" => $reminderSingle["isCompleted"],
            "tags" => $this->_transferTagsId2Name($reminderSingle["tags"]),
            "category" => $this->_transferCategoryId2Name($reminderSingle["categoryId"]),
        ));
    }
    /**[ 檢查傳入參數 ]
     */
    private function _do_chk_params($requireds,$_params){
        // 檢查必要參數是否存在
        foreach($requireds as $k => $v){
            if( !isset($_params[$v]) ){
                Instance::get("response")->set_Fail("E30006",$v); // 請檢查參數
                return false;
            } 
        }
        // 檢查參數是否合法
        foreach($_params as $k=> $v){
            $chk = $this->_chk_params($k , $v);
            if( $chk === false ) return false;
        }
        return true;
    } 
    /**[ 檢查傳入參數 ]
     */
    private function _chk_params($_key , $_val){
        switch($_key){
            case 'id':
                $chk = Instance::get("func")->chkInt($_val); 
                if( !$chk ){
                    Instance::get("response")->set_Fail("E30007"); // 請檢查參數
                    return false;
                } 
                break;
            case 'title':
                $len = mb_strlen( $_val, "utf-8");
                if( $len <1 || $len > 20 ){
                    Instance::get("response")->set_Fail("E30008"); // 請檢查參數
                    return false;
                } 
                break;
            case 'remindTime':
                $chk = Instance::get("func")->chkDate($_val); 
                if( !$chk ){
                    Instance::get("response")->set_Fail("E30009"); // 請檢查參數
                    return false;
                } 
                break;
            case 'tags':
                if( !is_array($_val) ){
                    Instance::get("response")->set_Fail("E30010"); // 請檢查參數
                    return false;
                } 
                break;
            case 'category':
                // if( $_val!="" ){
                //     Instance::get("response")->set_Fail("E30011"); // 請檢查參數
                //     return false;
                // } 
                break;
            case 'isCompleted':
                if( $_val!=0 &&  $_val!=1){
                    Instance::get("response")->set_Fail("E30012"); // 請檢查參數
                    return false;
                } 
                break;

            default:
                if($_val == ""){
                    Instance::get("response")->set_Fail("E30013"); // 請檢查參數
                    return false;
                } 
                break;
        }
        return true;
    }
    /**
     *  [ 刪除提醒事項 ]
     */
    public function delReminder($_params){        
        ## 傳入參數
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_reminderId = $_params["id"];
        $eff = Instance::get("dai_reminders")->doDelReminder($_reminderId);
        if( $eff===false ) return Instance::get("response")->set_Fail("E30014"); // 修改失敗
        return Instance::get("response")->set_Success();
    }



    // 提醒事項標籤==================================================================================

    /**
     * [ 取得提醒事項單則標籤 ]
     */
    public function getReminderTags($_params){   
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_reminderId = $_params["id"];
        $tagIds = Instance::get("dai_reminders")->getReminderTag($_reminderId)[$_reminderId];
        $tags = $this->_transferTagsId2Name($tagIds);
        return Instance::get("response")->set_Success($tags);
    }

    /**
     * [ 修改提醒事項單則標籤 ]
     */
    public function patchReminderTags($_params){   
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_reminderId = $_params["id"];
        $_tagIds = $this->_transferTagsName2Id($_params["tags"]);// 標籤名稱陣列
        if( $_tagIds === false ) return ; // 請檢查參數
        $eff = Instance::get("dai_reminders")->updReminderTag($_reminderId,$_tagIds);
        if( $eff===false ) return Instance::get("response")->set_Fail("E30015"); // 修改失敗

        ## reload
        $tagIds = Instance::get("dai_reminders")->getReminderTag($_reminderId)[$_reminderId];
        $tags = $this->_transferTagsId2Name($tagIds);
        $tagname = array();
        foreach($tags as $k => $v){
            $tagname[] = $v["name"];
        }
        return Instance::get("response")->set_Success($tagname);
    }





    // 提醒事項標籤類別==================================================================================

    /**
     * [ 取得提醒事項單則標籤 ]
     */
    public function getReminderCategory($_params){   
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_reminderId = $_params["id"];
        $reminder = Instance::get("dai_reminders")->getReminders($_reminderId)[$_reminderId];
        // print_r($reminder);
        $category = array();
        $categoryId = $reminder["categoryId"]-0;
        if($categoryId>0){
            $category = $this->_transferCategoryId2Name($reminder["categoryId"]);
        }
        return Instance::get("response")->set_Success($category);
    }

    /**
     * [ 修改提醒事項單則類別 ]
     * */
    public function patchReminderCategory($_params){   
        $requireds = array('id','name');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_reminderId = $_params["id"];
        $_categoryName = $_params["name"];
        $categoryId = $this->_transferCategoryName2Id($_categoryName);// 類別名稱陣列
        if( $categoryId === false ) return ; // 請檢查參數
        $eff = Instance::get("dai_reminders")->updReminderCategory($_reminderId,$categoryId);
        if( $eff===false ) return Instance::get("response")->set_Fail("E30016"); // 修改失敗

        ## reload
        $reminder = Instance::get("dai_reminders")->getReminders($_reminderId)[$_reminderId];
        $category = array();
        $categoryId = $reminder["categoryId"]-0;
        if($categoryId>0){
            $category = $this->_transferCategoryId2Name($reminder["categoryId"]);
        }
        return Instance::get("response")->set_Success($category);
    }
    /**
     *  [ 刪除提醒事項 ]
     */
    public function delReminderCategory($_params){        
        ## 傳入參數
        $_reminderId = $_params["id"];
        $categoryId =" 0";
        $eff = Instance::get("dai_reminders")->updReminderCategory($_reminderId,$categoryId);
        if( $eff===false ) return Instance::get("response")->set_Fail("E30017"); // 修改失敗
        return Instance::get("response")->set_Success();
    }

}
?>