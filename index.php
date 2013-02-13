
<?php
	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'root' ;
	$connection = mysql_connect($db_host, $db_username, '');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;

	if (isset ($_GET['err']))
		echo "the account has been used!<br>";
	if (isset ($_GET['success']))
		echo "Register success!<br>";
	
	if (!isset($_SESSION['account'])){
		echo "You must login to use the system!<br>
		<form method = 'post' action = 'login.php'>
		Account: <input name = 'account' type = 'text' /><br />
		Password: <input name = 'password' type = 'password' /><br />
		<input name = 'submit' type = 'submit' />
		<a href='register.php'>Create account</a>";
		
	} else {
		echo "Hello, ".$_SESSION['account']."<br>";
		echo "
		
		<form method = 'POST' action = 'upload.php'>
		<input type = 'textbox' readonly = 'true' value = 'PD001' name = 'problem_num'></input><br>
		<td colspan = 18><textarea name='textarea' cols='80' rows='30'></textarea></td>
		<input type = 'submit' value = '上傳'> </input>
		</form>
		<br>
		<form enctype='multipart/form-data'	method = 'POST' action = 'upload.php'>
		<input type = 'hidden' value = 'PD001' name = 'problem_num'></input><br>
		<input type = 'file' name = 'upload'></input>
		<input type = 'submit' value = '上傳'> </input>
		</form>
		<a href='logout.php'>Logout</a>";
	}
?>
