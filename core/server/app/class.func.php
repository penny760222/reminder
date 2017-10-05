<?
class class_func {

	// 只含英
	public function chkEn($val){
		return preg_match("/^[a-zA-Z]+$/",$val);
	}

	//英文開頭
	public function chkEnPrefix($val){	
		return preg_match("/^[a-zA-Z]/",$val);
	}

	//只含英數
	public function chkEnNum($val){	
		return preg_match("/^[0-9a-zA-Z]+$/",$val);
	}

	//正整數
	public function chkNatural($val){	
		// return preg_match("/^[0-9]+$/",$val);
		return preg_match("/^[0-9]*[1-9][0-9]*$/",$val);
	}

	//整數
	public function chkInt($val){	
		return preg_match("/^-?[0-9]+$/",$val);
	}

	//浮點數
	public function chkFloat($val){
		return preg_match("//-?[0-9]+(.[0-9])?[0-9]*$/",$val);
	}

	//浮點數只到小數點第一位
	public function chkFloat1($val){
		return preg_match("/^-?[0-9]+(.[0-9]{1})?$/",$val);
	}

	//浮點數(負)
	public function chkFloatNegative($val){
		return preg_match("/^-[0-9]+(.[0-9])?[0-9]*$/",$val);
	}

	//浮點數(正)
	public function chkFloatPlus($val){
		return preg_match("/^[0-9]+(.[0-9])?[0-9]*$/",$val);
	}

	//只含英數混合
	public function chkEnNumMix($val){
		if(chkEnNum($val)){
			if(preg_match("/[0-9]+/",$val) && preg_match("/[a-zA-Z]+/",$val)){
				return true;
			}
		}
		return false;
	}
	
	//只含纯数字
	public function chkNum($val){	
		return preg_match("[0-9]", $val);
	}	

	//檢查 e-mail
	public function chkMail($val){	
		return filter_var($val, FILTER_VALIDATE_EMAIL);
		// return preg_match("/^[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(.[a-zA-Z0-9-]+)*$",$val);
		// return preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $val);
	}

    //四捨五入
    public function my_Round($_value,$_pow){
    	$_value=$_value-0;
    	return round($_value*(pow(10,$_pow)))/pow(10,$_pow);
    }

    /**
     * [ 無條件進位 ]
     * @param  [type] $_value   [數字]
     * @param  [type] $_pow  	[進位位數]
     * my_Ceil(1.321,2);		無條件進位到小數第2位=>1.33
     */
    public function my_Ceil($_value,$_pow){
    	$_value=$_value-0;
	    return ceil($_value*pow(10, $_pow))/pow(10, $_pow);
    }

    /**
     * [ 無條件捨去 ]
     * @param  [type] $_value   [數字]
     * @param  [type] $_pow  	[進位位數]
     * my_floor(1.326,2);		無條件捨去到小數第2位=>1.32
     */
    public function my_floor($_value, $_pow){
    	$_value=$_value-0;
	    return floor($_value*pow(10, $_pow))/pow(10, $_pow);
	}

	// 檢查網址
	public function is_url($val){
		return preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%
		=~_|]/i",$val);
	}

	// 去空白
	public function trim($val){
		$val = str_replace(" ", "", $val); 
		return  $val;
	}

	// 取代
    public function replace($_str,$_params){
        foreach( $_params as $k =>$v ){
            $_str = str_replace ('{'.$k.'}',$v,$_str);
        }
        return $_str;
    }
    // 由左邊補 $_pow 位數零
    public function pad($_value, $_pow){
    	return str_pad($_value,$_pow,'0',STR_PAD_LEFT);
    }
	/*
	// 檢查日期	 
	public function chkDate($val){	
		return preg_match("/^[0-9]{4}-[1-12]{2}-[1-31]{2} [0-24]{2}:[0-59]{2}$/", $val);
	}
	*/
	public function chkDate($date_time){
	    $check = false;
	    if (strtotime($date_time)){
	    	//不管檢查時間或日期格式，都只取第一個陣列值
	        list($first) = explode(" ", $date_time);
	        //如果包含「:」符號，表示只檢查時間
	        if (strpos($first, ":")){
	            //strtotime函數已經檢查過，直接給true
	            $check = true;
	        }else{
	            //將日期分年、月、日，區隔符用「-/」都適用
	            list($y, $m, $d) = preg_split("/[-\/]/", $first);
	            //檢查是否為4碼的西元年及日期邏輯(潤年、潤月、潤日）
	            if (substr($date_time, 0, 4)==$y && checkdate($m, $d, $y)){
	                $check = true;
	            }
	        }
	    }
	 	return $check;
	}
}
?>