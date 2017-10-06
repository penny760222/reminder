<?
class class_error_tags{
    /** 設定基本函數
    */
	var $response = array(// 錯誤代碼
		"E10001" => array(
			"status"=> "E10001",
			"error"=> "ERROR_INS_FAIL",
			"error_msg"=> "新增失敗",
		),
		"E10002" => array(
			"status"=> "E10002",
			"error"=> "ERROR_PARAMS_REQUESTION",
			"error_msg"=> "參數錯誤(必要參數)",
		),
		"E10003" => array(
			"status"=> "E10003",
			"error"=> "ERROR_PARAMS_TAGID",
			"error_msg"=> "參數錯誤- tagid",
		),
		"E10004" => array(
			"status"=> "E10004",
			"error"=> "ERROR_PARAMS_NAME",
			"error_msg"=> "參數錯誤-名稱",
		),
		"E10005" => array(
			"status"=> "E10005",
			"error"=> "ERROR_PARAMS_NULL",
			"error_msg"=> "參數錯誤(不可為空)",
		),
	);
	public function get_error($_status){
		if( !isset($this->response[$_status]) ) return false;
		return $this->response[$_status];
	}
}
?>