<?
/**
 *  中介層 (分配 DB、 redis、寫檔 )
 */
class class_dai_categorys{
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
     * [ 取得類別 ]
     */
    public function getCategorys($_id=0){
        return Instance::get("dal_categorys")->sql_getCategorys($_id);
    }
    /**
     * [ 新增類別 ]
     */
    public function InsCategory($_name){
        return Instance::get("dal_categorys")->sql_InsCategory($_name);
    }
    /**
     * [ 修改類別 ]
     */
    public function updCategory($_id,$_name){
        return Instance::get("dal_categorys")->sql_updCategory($_id,$_name);
    }    
    /**
     * [ 刪除類別 ]
     */
    public function delCategory($_id){
        return Instance::get("dal_categorys")->sql_delCategory($_id);
    }
}

?>