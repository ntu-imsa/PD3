<?php 
	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'pdogsserver' ;
	$connection = mysql_connect($db_host, $db_username, 'pdogsserver');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;


	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		$acc = mysql_real_escape_string($_SESSION['account']);
		$query = "SELECT password FROM student WHERE account = '".$acc."'"; 
		$q_pass = mysql_query($query);
		$password = mysql_fetch_row($q_pass);
?>
	<div></div>

<?php		
	}
?>