<?
class class_error_reminders{
    /** 設定基本函數
    */
	var $response = array(// 錯誤代碼
		"E30001" => array(
			"status"=> "E30001",
			"error"=> "ERROR_INS_FAIL",
			"error_msg"=> "新增失敗",
		),
		"E30002" => array(
			"status"=> "E30002",
			"error"=> "ERROR_PARAMS_TAGNAME",
			"error_msg"=> "參數錯誤-提醒事項標籤名稱",
		),
		"E30003" => array(
			"status"=> "E30003",
			"error"=> "ERROR_PARAMS_CATEGORYNAME",
			"error_msg"=> "參數錯誤-提醒事項類別名稱",
		),
		"E30004" => array(
			"status"=> "E30004",
			"error"=> "ERROR_DATA_NULL",
			"error_msg"=> "提醒事項不存在",
		),
		"E30005" => array(
			"status"=> "E30005",
			"error"=> "ERROR_REMINDER_UPD_FAIL",
			"error_msg"=> "提醒事項修改失敗",
		),
		"E30006" => array(
			"status"=> "E30006",
			"error"=> "ERROR_PARAMS_REQUESTION",
			"error_msg"=> "參數錯誤(必要參數)",
		),
		"E30007" => array(
			"status"=> "E30007",
			"error"=> "ERROR_PARAMS_REMINDERID",
			"error_msg"=> "參數錯誤- reminderId",
		),
		"E30008" => array(
			"status"=> "E30008",
			"error"=> "ERROR_PARAMS_TITLE",
			"error_msg"=> "參數錯誤-標題",
		),
		"E30009" => array(
			"status"=> "E30009",
			"error"=> "ERROR_PARAMS_REMINDTIME",
			"error_msg"=> "參數錯誤(提醒時間)",
		),
		"E30010" => array(
			"status"=> "E30010",
			"error"=> "ERROR_PARAMS_TAGS",
			"error_msg"=> "參數錯誤(標籤)",
		),
		"E30011" => array(
			"status"=> "E30011",
			"error"=> "ERROR_PARAMS_CATRGORY",
			"error_msg"=> "參數錯誤(類別)",
		),
		"E30012" => array(
			"status"=> "E30012",
			"error"=> "ERROR_PARAMS_ISCOMPLETED",
			"error_msg"=> "參數錯誤(是否完成)",
		),
		"E30013" => array(
			"status"=> "E30013",
			"error"=> "ERROR_PARAMS_NULL",
			"error_msg"=> "參數錯誤(不可為空)",
		),
		"E30014" => array(
			"status"=> "E30014",
			"error"=> "ERROR_REMINDER_DELETE",
			"error_msg"=> "刪除提醒事項失敗",
		),
		"E30015" => array(
			"status"=> "E30015",
			"error"=> "ERROR_REMINDER_TAG_UPD_FAIL",
			"error_msg"=> "修改提醒事項單則標籤失敗",
		),
		"E30016" => array(
			"status"=> "E30016",
			"error"=> "ERROR_DATA_NULL",
			"error_msg"=> "提醒事項類別不存在",
		),
		"E30017" => array(
			"status"=> "E30017",
			"error"=> "ERROR_REMINDER_CATEGORY_DELETE",
			"error_msg"=> "刪除提醒事項類別失敗",
		),
	);
	public function get_error($_status){
		if( !isset($this->response[$_status]) ) return false;
		return $this->response[$_status];
	}
}
?>