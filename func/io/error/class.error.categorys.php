<?
class class_error_categorys{
    /** 設定基本函數
    */
	var $response = array(// 錯誤代碼
		"E20001" => array(
			"status"=> "E20001",
			"error"=> "ERROR_INS_FAIL",
			"error_msg"=> "新增失敗",
		),
		"E20002" => array(
			"status"=> "E20002",
			"error"=> "ERROR_DATA_NULL",
			"error_msg"=> "資料不存在",
		),
		"E20003" => array(
			"status"=> "E20003",
			"error"=> "ERROR_UPD_FAIL",
			"error_msg"=> "修改失敗",
		),
		"E20004" => array(
			"status"=> "E20004",
			"error"=> "ERROR_PARAMS_REQUESTION",
			"error_msg"=> "參數錯誤(必要參數)",
		),
		"E20005" => array(
			"status"=> "E20005",
			"error"=> "ERROR_PARAMS_CATRGORYID",
			"error_msg"=> "參數錯誤- categoryid",
		),
		"E20006" => array(
			"status"=> "E20006",
			"error"=> "ERROR_PARAMS_NAME",
			"error_msg"=> "參數錯誤-名稱",
		),
		"E20007" => array(
			"status"=> "E20007",
			"error"=> "ERROR_PARAMS_NULL",
			"error_msg"=> "參數錯誤(不可為空)",
		),
		"E20008" => array(
			"status"=> "E20008",
			"error"=> "ERROR_DELETE",
			"error_msg"=> "刪除失敗",
		),
	);
	public function get_error($_status){
		if( !isset($this->response[$_status]) ) return false;
		return $this->response[$_status];
	}
}
?>