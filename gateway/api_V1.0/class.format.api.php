<?
class class_format_api{
	private $response = array(
		"error_code" => "1000",
		"error_message" => "未定義",
	);
	private $error;			// 定義錯誤代碼
    /**
    * [ 建構子 ]
    */
	public function __construct(){
		$this->init();
		// 定義錯誤代碼
		$this->error=array(
			"def" => "未定義",		
			"1001" => "無效的參數",		
			"1002" => "不存在的資料",
		);
	}
    /**
    * [ 解構子 ]
    */
	public function __desctruct(){        
    }
    /**
     * [ 初始化 ]
     */
	public function init(){
	}
    /**
     * [ 解析傳入參數: json、xml.... ]
     */
	public function do_input($_params){
		return $_params;
	}
    /**
     * [ 解析傳入參數: json、xml.... ]
     */
	public function do_output(){
        $_output = Instance::get("response")->get_response();
        $status = $_output["status"];
        if( $status=="0" ){
        	$this->response = $_output["result"];
        }else{
            ## 失敗: 將內部錯誤訊息, 轉換成 api 錯誤訊息
            $errorCode = "1001";
            $error_msg = $_output["error_msg"];
            if( $error_msg=="ERROR_DATA_NULL" ) $errorCode = "1002";
        	$errorMsg = $this->error["def"]; //錯誤訊息
        	if( isset($this->error[$errorCode]) ){ 
                $errorMsg = $this->error[$errorCode];
            }
        	$this->response = array(
        		"error_code" => $errorCode,
        		"error_message" => $errorMsg,
        	);
        }
	}
    /**
     * [ 取得 oputut ]
     */
	public function get_output(){
        return json_encode($this->response);
	}
}
?>