<?
include_once(dirname(dirname(dirname(__FILE__)))."/config/config.php");
include_once(WebPath_CONF."/config.rw.php");
Instance::set("format_api_v1",WebPath."/gateway/api_V1.0/","class.format.api","class_format_api");
/**
 *  入口
 */
class class_index {
    private $debug = false;
	/**
	 * [ 建構子 ]
	 */
    public function __construct() {
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
    /**
     * [ debug ]
     */
    public function debug(){
        $this->debug = true;
    }
    public function start(){
        ## 將傳入參數, 轉成內部參數
        $input = $this->_get_input(); // 取得傳入參數
        $params = Instance::get("format_api_v1")->do_input($input); // 客製化傳輸方式解析, EX:json、xml

        ## 處理命令
        $command = $params["command"]; // 命令
        unset( $params["command"] );
        $mode = explode(",",$command)[0]; // 大類
        Instance::get("response")->set_mode($mode); // 設定錯誤大類
        $className = str_replace (',','.',$command); // class 名稱
        
        ## start
        $file = "command/class.".$className.".php";// 各 api 對應命令
        if( file_exists($file) ){  
            include_once($file);
            $result = new class_do_api($params);
            Instance::get("format_api_v1")->do_output();
        }
        if($this->debug){
            echo $_SERVER['REQUEST_METHOD']."<br>\n";
            echo $className."<br>\n";
            echo "input-----------------<br>\n";
            print_r($params);
            echo "source output-----------------<br>\n";
            print_r(Instance::get("response")->get_response());
            echo "output-----------------<br>\n";
            print_r($this->response);
        }

        ## output method 格式未統一,所以多層 format_api_v1 定義各 api 回傳格式, 並轉換錯誤訊息
        return Instance::get("format_api_v1")->get_output();
    }
    /**
     * [ 取得傳入參數 ]
     */
    private function _get_input(){
        parse_str(file_get_contents('php://input'), $input);
        return array_merge($_GET, $_POST, $input);
    }
}
$cls = new class_index();
$cls->debug();
$response = $cls->start();
echo  $response ;
?>