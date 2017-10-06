<?
// proArg();
$clsFilter = new class_filter();
class class_filter{

	// 建構子
    public function __construct() {
    	$this->proArg();
    }


	//if (!strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")) exit;
	private function proFilterStr($str){
		if(strlen($str)>=30000){
			echo "much chars";
			exit;
		}
		$patterns = array(
			"/;/i",
			"/--/i",
			"/\'/i",
			"/\`/i",
			"/\*/i",
			// "/=/i",
			"/like /i",
			"/drop /i",
			"/insert /i",
			"/select /i",
			"/database /i",
			"/delete /i",
			"/truncate /i",
			"/update /i",
			"/or /i",
			"/information_schema /i"
		);
		$str=preg_replace($patterns, "", $str);
        $str = join("%",explode("!#!",$str));
		return $str;
	}

	private function proArg(){
		global $_GET,$_POST,$ARG,$_COOKIE;
		if($ARG==""){return 0;}
		$ARG=$this->proFilterAry($ARG,true,true);
		$_COOKIE=$this->proFilterAry($_COOKIE,true);
	}
	private function proFilterAry($_ary,$_global=false,$_PG=false){
		if(is_array($_ary)){
			foreach($_ary as $k=>$v){
				$_ary[$k]=$this->proFilterAry($v);
				if($_PG==true){
					if($_GET[$k]) $_GET[$k]=$_ary[$k];
					if($_POST[$k]) $_POST[$k]=$_ary[$k];
				}
				if($_global==true) unset($GLOBALS[$k]);
			}
		}else{
			return $this->proFilterStr($_ary);
		}
		return $_ary;
	}

	private function proFilterAry2(&$G){
		foreach($G as $k => $v){$G[$k]=$this->proFilterStr($v);}
	}

	private function getData($name){
		$s = $this->proFilterStr($_GET[$name]);
		if($s == "") $s = $this->proFilterStr($_POST[$name]);
		return $s;
	}
}
?>
