<?
class class_remote{
    /**
     * [ 建構子 ]
     */
    public function __construct() {
    }
    /**
     * [ 解構子 ]
     */
    public function __desctruct(){       
    }
    /**
     * [ method GET ]
     */
    public function do_get($_api_request_url,$_api_request_parameters){
    	return $this->curlCallAPI('GET', $_api_request_url, $_api_request_parameters);
    }
    /**
     * [ method POST ]
     */
    public function do_post($_api_request_url,$_api_request_parameters){
    	return $this->curlCallAPI('POST', $_api_request_url, $_api_request_parameters);
    }
    /**
     * [ method PUT ]
     */
    public function do_put($_api_request_url,$_api_request_parameters){
    	return $this->curlCallAPI('PUT', $_api_request_url, $_api_request_parameters);
    }
    /**
     * [ method DELETE ]
     */
    public function do_delete($_api_request_url,$_api_request_parameters){
    	return $this->curlCallAPI('DELETE', $_api_request_url, $_api_request_parameters);
    }
    /**
     * [ method PATCH ]
     */
    public function do_patch($_api_request_url,$_api_request_parameters){
    	return $this->curlCallAPI('PATCH', $_api_request_url, $_api_request_parameters);
    }
    /**
     * [ CURL ]
     */
	private function curlCallAPI($method_name, $_api_request_url, $_api_request_parameters){		 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);	
	    switch ($method_name) {
	        case "GET":
		  		$_api_request_url .= '?' . http_build_query($_api_request_parameters);
	            break;
	        case "POST":
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_api_request_parameters));
	            break;
	        case "PUT":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_api_request_parameters));
	            break;
	        case "DELETE":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_api_request_parameters));
	            break;
	        case "PATCH":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_api_request_parameters));
	            break;
	    }
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
		curl_setopt($ch, CURLOPT_URL, $_api_request_url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$api_response = curl_exec($ch);
		$api_response_info = curl_getinfo($ch);
		curl_close($ch);
		return $api_response;
	}
}
?>
