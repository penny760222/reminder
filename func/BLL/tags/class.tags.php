<?
/**
 *  邏輯層
 */
class class_tags {
    /** 設定基本函數
    */
    var $DAI;
	/**
	 * [ 建構子 ]
	 */
    public function __construct() {
    	$this->_init();
    }
    /**
     * [ 解構子 ]
     */
    public function __desctruct() {        
    }
	/**
     * [ 初始化 ]
	 */
    private function _init() {
        $this->DAI = Instance::get("dai_tags");
    }	
    // ==================================================================================
    /**
    * [ 取得標籤列表 ]
    */
    public function getTags($_params){

        ## 取得列表
        $tags = array();
        $tagslist = $this->DAI->getTags();
        foreach($tagslist as $tagId => $v){
            array_push($tags, array(
                "id" => $tagId,
                "name" => $v,
            ));
        }
        ## 回傳結果
        return Instance::get("response")->set_Success($tags);
    }
    /**
    * [ 新增標籤 ]
    */
    public function postTags($_params){

        ## 檢查參數
        $requireds = array('name');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        if( $chk === false ) return ; // 請檢查參數
         
        ## 傳入參數
        $_name = $_params["name"];

        ## 新增標籤
        $tagId = $this->DAI->InsTag($_name);
        if( $tagId<=0 ) return Instance::get("response")->set_Fail("E10001"); // 修改失敗

        return Instance::get("response")->set_Success(array(
            "id"=>$tagId,
            "name"=>$_name,
        ));
    }
    /**[ 檢查傳入參數 ]
     */
    private function _do_chk_params($requireds,$_params){
        // 檢查必要參數是否存在
        foreach($requireds as $k => $v){
            if( !isset($_params[$v]) ){
                Instance::get("response")->set_Fail("E10002",$v); // 請檢查參數
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
                    Instance::get("response")->set_Fail("E10003"); // 請檢查參數
                    return false;
                } 
                break;
            case 'name':
                $len = mb_strlen( $_val, "utf-8");
                if( $len <1 || $len > 20 ){
                    Instance::get("response")->set_Fail("E10004"); // 請檢查參數
                    return false;
                } 
                break;
            default:
                if($_val == ""){
                    Instance::get("response")->set_Fail("E10005"); // 請檢查參數
                    return false;
                } 
                break;
        }
        return true;
    }
}
?>