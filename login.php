<?php
	session_start() ;
	require_once('lib.inc.php');

	$query = "SELECT * FROM `student` WHERE `account`= :account AND password = :password";
	$db = getDatabaseConnection();
	$stmt = $db->prepare($query);
	$stmt->execute(
		array(
			":account" => $_POST['account'],
			":password" => md5($_POST['password'])
		)
	);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if (!empty($result))
	{

		$_SESSION['account'] = $result['account'] ;

		header ("Location:index.php") ;
	}
	else
	{
		header ("Location:index.php?fail=1") ;
	}
?>
