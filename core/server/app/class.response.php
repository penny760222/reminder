<?
class class_response{
    /** 設定基本函數
    */
	private $error = false; // 錯誤代碼
	private $output = array(//輸出
		"status"=> '-999',
		"error"=> "ERROR_STATUS_UNKNOW",
		"error_msg"=> "未知錯誤，請聯絡客服",
	);
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
	/**定義成功訊息
	 */
	private function _do_Success($_result,$_status){
		$this->output = array(
			"status"=> $_status,
			"result"=> $_result
		);
	}
	/**定義失敗訊息
	 */
	private function _do_Error($_status,$_error){
		if($this->error!=false) $output = $this->error->get_error($_status); // 取得定義的錯誤值
		if( isset($output["status"] )){
			$this->output = $output;	
		}else{
			$this->output = array(				
				"status"=> $_status,
				"error"=> 'ERROR_DEFINE',
				"error_msg"=> 'ERROR MESSAGE UNDEFINED',
			);
		}
		if( $_error!="" ) $this->output['error_msg'].="--$_error";
	}
	/**
	 * [ 設定錯誤大類 ]
	 */
	public function set_mode($_mode){
		$this->error = Instance::get("error_".$_mode);
	}
	/**
	 * [ 設定成功回傳值 ]
	 */
	public function set_Success($_result=array(),$_status=0){
		$this->_do_Success($_result,$_status);
		return $this->output;
	}
	/**
	 * [ 設定失敗回傳值 ]
	 */
	public function set_Fail($_status,$_error=''){
		$this->_do_Error($_status,$_error);
		return $this->output;
	}
	/**
	 * [ output ]
	 */
	public function get_response(){
		return $this->output;
	}
}
?>