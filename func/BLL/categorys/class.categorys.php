<?
/**
 *  邏輯層
 */
class class_categorys {


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
        $this->DAI = Instance::get("dai_categorys");
    }	

    // ==================================================================================
    /**
    * [ 取得類別列表 ]
    */
    public function getCategorys($_params){
        global $ARG;

        ## 取得列表
        $categorys = array();
        $categoryslist = $this->DAI->getCategorys();
        foreach($categoryslist as $categoryId => $v){
            array_push($categorys, array(
                "id" => $categoryId,
                "name" => $v,
            ));
        }

        ## 回傳結果
        return Instance::get("response")->set_Success($categorys);
    }

    /**
    * [ 新增類別 ]
    */
    public function postCategorys($_params){

        ## 檢查參數
        $requireds = array('name');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        if( $chk === false ) return ; // 請檢查參數
         
        ## 傳入參數
        $_name = $_params["name"];

        ## 新增類別
        $categoryId = $this->DAI->InsCategory($_name);
        if( $categoryId<=0 ) return Instance::get("response")->set_Fail("E20001"); // 修改失敗

        return Instance::get("response")->set_Success(array(
            "id"=>$categoryId,
            "name"=>$_name,
        ));
    }

    /**
    * [ 取得單筆類別 by Id ]
    */
    public function getCategorySingle($_params){

        ## 傳入參數
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_cagetoryId = $_params["id"];
        ## 取得列表
        $categorySingle = $this->DAI->getCategorys($_cagetoryId)[$_cagetoryId];
        if( $categorySingle==false ){
            Instance::get("response")->set_Fail("E20002"); // 請檢查參數
            return false;
        }
        ## 回傳結果
        return Instance::get("response")->set_Success(array(
            "id" => $_cagetoryId,
            "name" => $categorySingle,
        ));
    }
    /**
     *  [ 修改類別 ]
     */
    public function patchCategory($_params){

        ## 檢查參數
        $requireds = array('id','name');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        if( $chk === false ) return ; // 請檢查參數
         
        ## 傳入參數 
        $_categoryId = $_params["id"];  
        $_name = $_params["name"];   

        ## 修改類別
        $eff = $this->DAI->updCategory($_categoryId,$_name);
        if( $eff===false ) return Instance::get("response")->set_Fail("E20003"); // 修改失敗

        return Instance::get("response")->set_Success(array(
            "id"=>$_categoryId,
            "name"=>$_name,
        ));
    }
    /**[ 檢查傳入參數 ]
     */
    private function _do_chk_params($requireds,$_params){
        // 檢查必要參數是否存在
        foreach($requireds as $k => $v){
            if( !isset($_params[$v]) ){
                Instance::get("response")->set_Fail("E200043",$v); // 請檢查參數
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
                    Instance::get("response")->set_Fail("E20005"); // 請檢查參數
                    return false;
                } 
                break;
            case 'name':
                $len = mb_strlen( $_val, "utf-8");
                if( $len <1 || $len > 20 ){
                    Instance::get("response")->set_Fail("E20006"); // 請檢查參數
                    return false;
                } 
                break;
            default:
                if($_val == ""){
                    Instance::get("response")->set_Fail("E20007"); // 請檢查參數
                    return false;
                } 
                break;
        }
        return true;
    }
    /**
     *  [ 刪除類別 ]
     */
    public function delCategory($_params){        
        ## 傳入參數
        $requireds = array('id');// 必須參數
        $chk = $this->_do_chk_params($requireds,$_params);
        $_categoryId = $_params["id"];
        $eff = $this->DAI->delCategory($_categoryId);
        if( $eff===false ) return Instance::get("response")->set_Fail("E20008"); // 修改失敗
        Instance::get("dai_reminders")->delReminderCategory($_categoryId);
        return Instance::get("response")->set_Success();
    }
}
?>