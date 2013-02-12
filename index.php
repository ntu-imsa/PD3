
<?php
	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'PD Course' ;
	$db_username = 'root' ;
	$connection = mysql_connect($db_host, $db_username, '');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;


		
	echo "
		<form method = 'POST' action = 'upload.php'>
		<td colspan = 18><textarea name='textarea' cols='80' rows='30'></textarea></td>
		<input type = 'submit' value = '上傳'> </input>
		</form>
		<br>
		<form enctype='multipart/form-data'	method = 'POST' action = 'upload.php'>
		<input type = 'file' name = 'upload'></input>
		<input type = 'submit' value = '上傳'> </input>
		</form>"
?>
