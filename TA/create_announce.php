<?php
	session_start() ;
	require_once('../includes/lib.inc.php');

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
  } else {
		$db = getDatabaseConnection();
		$query = "INSERT INTO announce(date, content) VALUES(NOW(), :cont)";
		$stmt = $db->prepare($query);
		$stmt->execute(
			array("cont" => $_POST['content'])
		);
	}
?>
