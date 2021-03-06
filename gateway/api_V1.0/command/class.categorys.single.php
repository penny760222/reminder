<?
class class_do_api{

    /**
     * [ 建構子 ]
     */
    public function __construct($_params) {
        $this->_init($_params);
    }
    /**
     * [ 解構子 ]
     */
    public function __desctruct(){       
    }
    /**
     * [ 初始化 ]
     */
    private function _init($_params){
        $this->_do_exec($_params);
    }   
    private function _do_exec($_params){
        $reqMethod = $_SERVER['REQUEST_METHOD']; // 方法
        switch ($reqMethod) {
            case "GET":
                return Instance::get("categorys")->getCategorySingle($_params);
            case "PATCH":
                return Instance::get("categorys")->patchCategory($_params);
            case "DELETE":
                return Instance::get("categorys")->delCategory($_params);
            default:
                return Instance::get("format_api_v1")->set_error(-2); 
        } 
    }
}
?>