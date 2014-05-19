<?php
	session_start() ;
	require_once('db.inc.php');

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
