<?
/**
 *  中介層 (分配 DB、 redis、寫檔 )
 */
class class_dai_tags{
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
     * [ 取得標籤 ]
     */
    public function getTags($_id=0){
        return Instance::get("dal_tags")->sql_getTags($_id);
    }
    /**
     * [ 新增標籤 ]
     */
    public function InsTag($_name){
        return Instance::get("dal_tags")->sql_InsTag($_name);
    }
}

?>