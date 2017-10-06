<?   
/**
 * [ 產生實體時,自動呼叫的function,藉由此機制,include該類別存在的檔案 ]
 * @param  [type] $_classname [類的名稱]
 * @return [void]
 */
function __autoload($_classname){
	Instance::do_class_import($_classname);	//可解決class繼承時,父類別include的問題
}
class Instance{
	private static $instance;	//記錄class跟自定義key的關係
	private static $instance_classname;	//記錄classname跟自定義key之間的關係
	function __construct(){}
	function __destruct(){}

	/**
	 * [ 設定class 資料 ]
	 * @param  [string] $_class_key [class 索引,類的識別名稱]
	 * @param  [string] $_path [資料夾路徑]
	 * @param  [string] $_file [檔案名稱]
	 * @param  [string] $_className [類別名稱]
	 * @return [void]
	 */ 
	static function set($_class_key,$_path="",$_file=false,$_className=false){
		$tmp=array(
			"path"=>$_path,	//路徑
			"instance"=>false
		);
		if($_file==false){
			$_file=strtolower("class.$_class_key");
			$_file=preg_replace('/_/','.',$_file);	//檔案: $_className:abc_dd $file=class.abc.dd.php
		}
		$_file.=".php";
		if($_className==false) $_className="class_$_class_key";

		$tmp["file"]=$_file;//檔案
		$tmp["class"]=$_className;	//class 名稱
		$tmp["full"]=$tmp["path"].$_file;	//全路徑
		if(!file_exists($tmp["full"])){
			return false;
		}
		$tmp["import"]=false;	
		self::$instance[$_class_key]=$tmp;
		self::$instance_classname[$_className]=$_class_key;
		return $tmp;
	}
	static function do_class_import($_className){
		$class_key=self::$instance_classname[$_className];	//藉由$instance_classname  取得該類別在陣列中,識別的名稱
		$instance=self::$instance[$class_key];	//藉由類的識別名稱取得相關資訊
		if(gettype($instance)=="NULL"){	//	找不到設定
			return false;
		}
		if($instance["import"]==false) include_once($instance["full"]);
		self::$instance[$class_key]["import"]=true;
	} 
	/**
	 * [ 產生實體 ]
	 * @param  [string] $_class_key [class 索引]
	 * @return [class]
 	*/
	static function get_new($_class_key){
		$instance=self::$instance[$_class_key];
		if(gettype($instance)=="NULL"){
			throw new Exception ('Driver not found'); //丟出錯誤
			return false;
		}
		$args = func_get_args();
		array_shift($args);

		$class = new ReflectionClass($instance["class"]);
		if(count($args)>0){
			return $class->newInstanceArgs($args);
		}else{
			return $class->newInstance();
		}
		return $class;

		//给所有的参数键值加个前缀
		$keys = array_keys($args);
		array_walk($keys, create_function('&$value, $key, $prefix', '$value = $prefix . $value;'), '$arg_');
	 
		//动态构造实例化类的函数，主要是动态构造参数的个数
		$paramStr = implode(', ',$keys);
		$newClass=create_function($paramStr, "return new {$className}({$paramStr});");
	 
		//实例化对象并返回
		return call_user_func_array($newClass, $arguments);
	}
	/**
	 * [ 產生實體 ]
	 * @param  [type] $_class_key [class 索引]
	 * @return [class]
	 */
	static function get($_class_key){ 
		$instance=self::$instance[$_class_key];
		if($instance==null){
			$tmp=explode("_",$_class_key);
			$instance=self::set("$_class_key",BIZ.$tmp[0]."/");
		}
		if($instance==null) throw new Exception ($_class_key.' Driver not found'); //丟出錯誤
		if($instance["instance"]===false){
			$args = func_get_args();
			self::$instance[$_class_key]["instance"]=call_user_func_array(array(self, 'get_new'),$args);
		}
		return self::$instance[$_class_key]["instance"];
	}
}
?>