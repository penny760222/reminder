<?
// $csql = new class_csql();
abstract class class_csql {


    /** 設定基本函數
    */
   var $sth = false;  
   var $count = false;  
   var $lastId = false;  

	/**
	 * [ 建構子 ]
	 */
    public function __construct() {
		global $link;// 沒有DB 連線, 不能執行 sql
		if(gettype($link) == "NULL"){
			Instance::get("response")->set_Fail("E000"); // 請檢查參數
			$output = Instance::get("response")->get_response();
			echo json_encode($output);
			exit;
		}
    }
    /**
     * [ 解構子 ]
     */
    public function __desctruct() {        
    }

	/**
	 * [ 指定取出 sql 資料的型態  ,輸出 按照對象的形式 ]
	 */
	private function _get_obj_fetchAll(){
		return $this->sth->fetchAll(PDO::FETCH_OBJ);
	}
	/**
	 * [ 指定取出 sql 資料的型態  ,輸出 按照對象的形式 ]
	 */
	private function _get_obj_fetch(){
		return $this->sth->fetch(PDO::FETCH_OBJ);
	}
	/**
	 * [ 指定取出 sql 資料的型態 輸出 關聯數組形式 ]
	 */
	private function _get_assoc_fetchAll(){
		return $this->sth->fetchAll(PDO::FETCH_ASSOC);
	}
	/**
	 * [ 指定取出 sql 資料的型態 輸出 關聯數組形式 ]
	 */
	private function _get_assoc_fetch(){
		return $this->sth->fetch(PDO::FETCH_ASSOC);
	}
	/**
	 * [ 指定取出 sql 資料的型態 ]
	 */
	private function _get_query_result($_method){
		switch ($_method) {
			case 'afth':
				$result = $this->_get_assoc_fetch();
				break;
			case 'ofth':
				$result = $this->_get_obj_fetch();
				break;
			case 'assoc':
				$result = $this->_get_assoc_fetchAll();
				break;
			case 'obj':
				$result = $this->_get_obj_fetchAll();
				break;
			default:
				$result = $this->_get_assoc_fetchAll();
				break;
		}
		return $result;
	}

	
	/**
	 * [ 取得查詢結果 ]
	public function get_result($_method=''){
		return $this->_get_query_result($_method);
	}
	 */


	/**
	 * [ 查詢SQL ]
	 * @param [type] $_sql    [sql 語法]
	 * @param string $_method [取出 sql 資料的型態: def:assoc]
	 */
	public function Qquery($_sql,$_method=''){
		global $link;		
		$sth = $link->query($_sql);
		$this->sth = $sth;
		$data = $this->_get_query_result($_method);
		return $data;
	}

	/**
	 * [ 查詢 ]
	 */
	public function Qexecute($_sql, $_params=array(), $_method=''){
		global $link;	
		$sth = $link->prepare($_sql);  
		$this->sth = $sth;
        $sth->execute($_params); 
		$result = $this->_get_query_result($_method);
		return $result;
	}


	/**
	 * [ 新增、刪除、修改 ]
	 */
	public function Wmysql($_sql, $_params=array()){
		global $linkW;
		try {
			// echo $_sql."<br>\n";
			$sth = $linkW->prepare($_sql);
			$result = $sth->execute($_params); 
			if($result === true) {
			    $eff = $sth->rowCount(); // 回傳影響列數
			    // echo $eff."<br>\n";
			    if( $eff>= 1 ){
			    	$this->lastId = $linkW->lastInsertId();//
			    	// $this->write_log($_sql, $_params);
			    	return $eff;	
			    }
			}
	        throw new Exception($error);
		} catch (Exception $e) {
			// echo $e."<br>\n";
		}
		return false;
	}


	/**
	 * [ 新增 ID ]
	 */
	public function getInserId(){
		return $this->lastId;
	}
	/**
	 * [ 新增 log_sql ]
	private function write_log($_sql, $_params){
		global $linkW;
		$log = $this->pdo_sql_debug($_sql,$placeholders);
	    $sql = " insert into log_sql set ";// 公告編號
        $sql.= "  site = '".Instance::get("verify")->get_site()."'";// 站台
	    $sql.= " ,log = '".$log."'";// 種類 (1:活動, 2:公告, 3:系統)  
	    $sql.= " ,build_time = '".time()."'";// 更新時間
	    $sql.= " ,op_mid = '".Instance::get("verify")->get_user_mid()."'";// 操作者編號
	    $sql.= " ,op_ip = '".Instance::get("verify")->get_user_ip()."'";// 操作者ip
	    try {
	  	 	// echo $sql."<br>\n";
	    	$sth = $linkW->prepare($sql);
	        $result = $sth->execute($_params); 
	        throw new Exception($error);
	    } catch (Exception $e) {
	    }
	}
	function pdo_sql_debug($sql,$placeholders=array()){
		if( is_array($placeholders) ){
		    foreach($placeholders as $k => $v){
		        $sql = preg_replace('/:'.$k.'/',"'".$v."'",$sql);
		    }
	    }
		$sql = str_replace ('"',"",$sql);
		$sql = str_replace ("'",'',$sql);
	    return $sql;
	}
	 */
}
?>