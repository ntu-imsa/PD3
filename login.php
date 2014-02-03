<?php
	session_start() ;
	
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'root' ;
	$connection = mysql_connect($db_host, $db_username, 'pdogsserver');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;
	
	$acc = mysql_real_escape_string($_POST['account'] );
	$pw = md5(mysql_real_escape_string($_POST['password']));
	//$pw = $_POST['password'];
	
	$query = "SELECT * FROM student
	          WHERE account='$acc' AND password ='$pw';";
	$result = mysql_query($query) ;
	if ($result_row = mysql_fetch_row(($result)))
	{

		$_SESSION['account'] = $acc ;
		
		header ("Location:index.php") ;
	}
	else
	{
		header ("Location:index.php?fail=1") ;
	}
?>