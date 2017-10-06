<?
	
	## 写入 DB
	$DB_HOST = "localhost";	// 连线
	// $DB_HOST = "ftp.iesball.com";	// 连线
	$DB_NAME = "reminder";// DB名称
	$DB_USER = "reminder";// 登入者帐号
	$DB_PASSWORD = "reminder";// 登入者密码
	$DB_ENCODING = 'utf8';// 编码
	$DB_OPTION = array(
		## PDO::ATTR_ERRMODE: 错误报告 
		## PDO::ERRMODE_SILENT: 不显示错误信息，只显示错误码。 
		## PDO::ERRMODE_WARNING: 显示警告跟错误。 
		## PDO::ERRMODE_EXCEPTION: 抛出异常。 				  
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

		## MySQL 前置设定 
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ". $DB_ENCODING ,

		## 开启 DB 长连接 
		// PDO::ATTR_PERSISTENT => true,

		## MySQL 查询缓冲区
		// PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>false

		## PDO::ATTR_CASE: 返回的资料栏位名称设定 
		## PDO::CASE_LOWER: 栏位名称全部转换成小写 
		## PDO::CASE_NATURAL: 使用原始栏位名称(预设) 
		## PDO:: CASE_UPPER: 栏位名称全部转换成大写   
		// PDO::ATTR_CASE => PDO::CASE_NATURAL,

		## PDO::ATTR_ORACLE_NULLS : 转换无效的空字串 
		## PDO::NULL_NATURAL: 不转换(预设)。 
		## PDO::NULL_EMPTY_STRING: 空字串转换为 NULL。 
		## PDO::NULL_TO_STRING: NULL 转换为空字串。 			 
		// PDO::ATTR_ORACLE_NULLS=>PDO::NULL_NATURAL ,

		## 设置禁止本地模拟prepare
		PDO::ATTR_EMULATE_PREPARES => false , // 啟用或禁用預處理語句的模擬。 有些驱动不支持或有限度地支持本地预处理。使用此设置强制PDO总是模拟预处理语句（如果为 TRUE ），或试着使用本地预处理语句（如果为 FALSE）。如果驱动不能成功预处理当前查询，它将总是回到模拟预处理语句上。

		## 是否自動提交每個單獨的語句（在OCI，Firebird 以及 MySQL中可用）
		PDO::ATTR_AUTOCOMMIT => true ,

		## 提取的時候將數值轉換為字符串。
		// PDO::ATTR_STRINGIFY_FETCHES => false ,

		## 指定超時的秒數。
		// PDO::ATTR_TIMEOUT => 30 , // 並非所有驅動都支持此選項，這意味著驅動和驅動之間可能會有差異。比如，SQLite等待的時間達到此值後就放棄獲取可寫鎖，但其他驅動可能會將此值解釋為一個連接或讀取超時的間隔。 需要 int 類型。

		## 設置默認的提取模式。
		## PDO::FETCH_ASSOC: 返回一个索引为结果集列名的数组 
		## PDO::FETCH_BOTH (default): 返回一个索引为结果集列名和以0开始的列号的数组 
		## PDO::FETCH_BOUND: 返回 TRUE ，并分配结果集中的列值给 PDOStatement::bindColumn() 方法绑定的 PHP 变量。 
		## PDO::FETCH_CLASS: 返回一个请求类的新实例，映射结果集中的列名到类中对应的属性名。如果 fetch_style 包含 PDO::FETCH_CLASSTYPE（例如：PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE），则类名由第一列的值决定 
		## PDO::FETCH_INTO: 更新一个被请求类已存在的实例，映射结果集中的列到类中命名的属性 
		## PDO::FETCH_LAZY: 结合使用 PDO::FETCH_BOTH 和 PDO::FETCH_OBJ，创建供用来访问的对象变量名 
		## PDO::FETCH_NUM: 返回一个索引为以0开始的结果集列号的数组 
		## PDO::FETCH_OBJ: 返回一个属性名对应结果集列名的匿名对象 
		// PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH , // 關於模式的說明可以在 PDOStatement::fetch() 文檔找到。
	);

	## 读取 DB	
	// query
	try {  
		$link = new PDO(
			"mysql:host=". $DB_HOST .";dbname=". $DB_NAME ."",
			$DB_USER,
			$DB_PASSWORD,
			$DB_OPTION			
		);	 
		// $link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	} catch (PDOException $e) {  
	   // 资料库连结失败  
	   $err = array();
	   $err[] = $e->errorInfo ; // 错误明细  
	   $err[] = $e->getMessage(); // 返回异常资讯  
	   $err[] = $e->getPrevious(); // 返回前一个异常  
	   $err[] = $e->getCode(); // 返回异常程式码  
	   $err[] = $e->getFile(); // 返回发生异常的档案名  
	   $err[] = $e->getLine(); // 返回发生异常的程式码行号  
	   $err[] = $e->getTrace(); // backtrace() 阵列  
	   $err[] = $e->getTraceAsString(); // 已格成化成字串的 getTrace() 资讯   
	   print_r($err);   	     
	   exit;
	}   

	// write
	try {  
		$linkW = new PDO(
			"mysql:host=". $DB_HOST .";dbname=". $DB_NAME ."",
			$DB_USER,
			$DB_PASSWORD,
			$DB_OPTION			
		);	  
	} catch (PDOException $e) {  
	   // 资料库连结失败  
	   $e->errorInfo ; // 错误明细  
	   $e->getMessage(); // 返回异常资讯  
	   $e->getPrevious(); // 返回前一个异常  
	   $e->getCode(); // 返回异常程式码  
	   $e->getFile(); // 返回发生异常的档案名  
	   $e->getLine(); // 返回发生异常的程式码行号  
	   $e->getTrace(); // backtrace() 阵列  
	   $e->getTraceAsString(); // 已格成化成字串的 getTrace() 资讯      	     
	   exit;
	}   
?>
