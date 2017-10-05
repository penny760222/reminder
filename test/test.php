<?

include_once(dirname(dirname(__FILE__))."/config/config.php");
// test action
$getReminderList = true;
$postReminders = false;
$getReminderSingle = false;
$delReminderSingle = false;
$patchReminderSingle = false;
$getReminderTags = false;
$patchReminderTags = false;
$getreminderCategory = false;
$patchreminderCategory = false;
$delReminderCategory = false;
$getTags = false;
$postTags = false;
$getCategoryList = false;
$postCategoryList = false;
$getCategorySingle = false;
$patchCategorySingle = false;
$deleteCategorySingle = false;

$cls = new test();
if($getReminderList){
	echo $cls->getReminderList();
}
if($postReminders){
	echo $cls->postReminders(array(
		'title' => '我是標題5',
		'remindTime' => '2017-09-20 00:00',
		'tags' => array('我是標籤3'),
		'category' => '我是類別3',
	));
}
if($getReminderSingle){
	echo $cls->getReminderSingle(array(
		'reminder_id' => '5',
	));
}
if($delReminderSingle){
	echo $cls->delReminderSingle(array(
		'reminder_id' => '5',
	));
}
if($patchReminderSingle){
	echo $cls->patchReminderSingle(array(
		'reminder_id' => '30',
		'title' => 'title5',
		'remindTime' => '2017-08-03 12:12',
		'tags' => array('视讯推广','电子推广'),
		'category' => 'category6',
		'isCompleted' => '1',
	));
}
if($getReminderTags){
	echo $cls->getReminderTags(array(
		'reminder_id' => '30',
	));
}
if($patchReminderTags){
	echo $cls->patchReminderTags(array(
		'reminder_id' => '30',
		'tags' => array('SEO优化','电竞推广'),
	));
}
if($getreminderCategory){
	echo $cls->getreminderCategory(array(
		'reminder_id' => '30',
	));
}
if($patchreminderCategory){
	echo $cls->patchreminderCategory(array(
		'reminder_id' => '30',
		'name' => 'category7',
	));
}
if($delReminderCategory){
	echo $cls->delReminderCategory(array(
		'reminder_id' => '30',
	));
}
if($dgetReminders){
	echo $cls->dgetReminders(array(
	));
}
if($getTags){
	echo $cls->getTags(array(
	));
}
if($postTags){
	echo $cls->postTags(array(
		'name' => "我是標籤3",
	));
}
if($getCategoryList){
	echo $cls->getCategoryList(array(
	));
}
if($postCategoryList){
	echo $cls->postCategoryList(array(
		'name' => "我是類別3",
	));
}
if($getCategorySingle){
	echo $cls->getCategorySingle(array(
		'category_id' => '1',
	));
}
if($patchCategorySingle){
	echo $cls->patchCategorySingle(array(
		'category_id' => '1',
		'name' => "我是類別1-11",
	));
}
if($deleteCategorySingle){
	echo $cls->deleteCategorySingle(array(
		'category_id' => '6',
	));
}



class test{
    /** 設定基本函數
    */
    private $host = '127.0.0.1';
    private $apiURL = array(
    	// 提醒事項
    	'reminderList' => '/reminders',
    	'reminderSingle' => '/reminders/{reminder_id}',
    	'reminderTags' => '/reminders/{reminder_id}/tags',
    	'reminderCategory' => '/reminders/{reminder_id}/category',
    	// 標籤
    	'tags' => '/tags',
    	// 類別
    	'categoryList' => '/categorys',
    	'categorySingle' => '/categorys/{category_id}',
    );
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
    private function _init(){
    }	
    /**
     * [ 重定義 host 網址 ]
     */
    public function setAPIURL( $_host ){
    	$this->host = $_host;
    }
	
	private function _do_method($_method,$_action,$_params=array()){
		$url = $this->_transter_apiUrl($_action,$_params);
		unset($_params["reminder_id"]);
		unset($_params["category_id"]);
		// echo 'method='.$_method."<br>\n";
		// echo 'action='.$_action."<br>\n";
		// echo 'url='.$url."<br>\n";
		// echo 'params=<br>\n';
		// print_r($_params);
		if( $url===false ) return ;
		try{
		    switch ($_method) {
		        case "GET":
		        	$response = Instance::get('remote')->do_get($url,$_params);
		            break;
		        case "POST":
		        	$response = Instance::get('remote')->do_post($url,$_params);
		            break;
		        case "PUT":
		        	$response = Instance::get('remote')->do_put($url,$_params);
		            break;
		        case "DELETE":
		        	$response = Instance::get('remote')->do_delete($url,$_params);
		            break;
		        case "PATCH":
		        	$response = Instance::get('remote')->do_patch($url,$_params);
		            break;
		    }	    
		}catch(Exception $e){
		};
		return $response;
	}
	/**
	 * [ 取代網誌 ]
	 */
	private function _transter_apiUrl($_action,$_params){
		$api = $this->apiURL;
		if( !isset($api[$_action]) ) return false;
		$url = $this->host.$api[$_action];		
		return Instance::get('func')->replace($url,$_params);
	}



    // 提醒事項 ==================================================================================
    // get
    public function getReminderList(){
    	return $this->_do_method('GET','reminderList',array(
    	));
    } 
    // post
    public function postReminders($_params){
    	return $this->_do_method('POST','reminderList',array(
    		'title' => $_params['title'],
    		'remindTime' => $_params['remindTime'],
    		'tags' => $_params['tags'],
    		'category' => $_params['category'],
    	));
    }
    // 提醒事項單筆 ==================================================================================
    // get
    public function getReminderSingle($_params){
    	return $this->_do_method('GET','reminderSingle',array(
    		'reminder_id' => $_params['reminder_id'],
    	));
    } 
    // delete
    public function delReminderSingle($_params){
    	return $this->_do_method('DELETE','reminderSingle',array(
    		'reminder_id' => $_params['reminder_id'],
    	));
    }
    // PATCH
    public function patchReminderSingle($_params){
    	return $this->_do_method('PATCH','reminderSingle',array(
    		'reminder_id' => $_params['reminder_id'],
    		'title' => $_params['title'],
    		'remindTime' => $_params['remindTime'],
    		'isCompleted' => $_params['isCompleted'],
    		'tags' => $_params['tags'],
    		'category' => $_params['category'],
    	));
    }
    // 提醒事項標籤 ==================================================================================
    // get
    public function getReminderTags($_params){
    	return $this->_do_method('GET','reminderTags',array(
    		'reminder_id' => $_params['reminder_id'],
    	));
    } 
    // PATCH
    public function patchReminderTags($_params){
    	return $this->_do_method('PATCH','reminderTags',array(
    		'reminder_id' => $_params['reminder_id'],
    		'tags' => $_params['tags'],
    	));
    }
    // 提醒事項類別 ==================================================================================
    // get
    public function getreminderCategory($_params){
    	return $this->_do_method('GET','reminderCategory',array(
    		'reminder_id' => $_params['reminder_id'],
    	));
    } 
    // PATCH
    public function patchreminderCategory($_params){
    	return $this->_do_method('PATCH','reminderCategory',array(
    		'reminder_id' => $_params['reminder_id'],
    		'name' => $_params['name'],
    	));
    }
    // delete
    public function delReminderCategory($_params){
    	return $this->_do_method('DELETE','reminderCategory',array(
    		'reminder_id' => $_params['reminder_id'],
    	));
    }
    // 標籤 ==================================================================================
    // get
    public function getTags($_params){
    	return $this->_do_method('GET','tags',array(
    		'reminder_id' => $_params['reminder_id'],
    	));
    } 
    // post
    public function postTags($_params){
    	return $this->_do_method('POST','tags',array(
    		'name' => $_params['name'],
    	));
    }
    // 類別 ==================================================================================
    // get
    public function getCategoryList($_params){
    	return $this->_do_method('GET','categoryList',array(
    	));
    } 
    // post
    public function postCategoryList($_params){
    	return $this->_do_method('POST','categoryList',array(
    		'name' => $_params['name'],
    	));
    }
    // 類別單筆 ==================================================================================
    // get
    public function getCategorySingle($_params){
    	return $this->_do_method('GET','categorySingle',array(
    		'category_id' => $_params['category_id'],
    	));
    } 
    // patch
    public function patchCategorySingle($_params){
    	return $this->_do_method('PATCH','categorySingle',array(
    		'category_id' => $_params['category_id'],
    		'name' => $_params['name'],
    	));
    }
    // delete
    public function deleteCategorySingle($_params){
    	return $this->_do_method('DELETE','categorySingle',array(
    		'category_id' => $_params['category_id'],
    	));
    }
}
