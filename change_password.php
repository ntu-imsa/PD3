<?php
	session_start() ;
	require_once('db.inc.php');

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
