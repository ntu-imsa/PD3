<?php

	require_once('lib.inc.php');

	$acc = filterString($_POST["account"]);
	$pw = md5($_POST["password"]) ;
	$cpw = md5($_POST["cpw"]) ;

	$student_dir = '.\\student\\'.$acc;
	if ($acc == NULL or $_POST["password"] == NULL or $_POST["cpw"] == NULL)
		header ("Location:index.php?msg=empty") ;
	else if ($pw != $cpw)
		header ("Location:index.php?msg=same") ;
	else{

	$db = getDatabaseConnection();
	$query = "SELECT * FROM student WHERE account = :acc";
	$stmt = $db->prepare($query);
	$stmt->execute(
		array(
			":acc" => $acc
		)
	);
	$result = $stmt->fetch();
	if (!empty($result)){
		header ("Location:index.php?msg=err") ;
	} else {
		$query = "INSERT INTO student(account, password, type) VALUES (:acc, :pw, 1) " ;
		$stmt = $db->prepare($query);
		$stmt->execute(
			array(
				":acc" => $acc,
				":pw" => $pw
			)
		);
		$uid = $db->lastInsertId();

		$return = 0;
		$command = "MD ".$student_dir;
		system($command, $return);

		if ($uid != 0 and file_exists($student_dir))
			header("Location:index.php?msg=success") ;
		}
	}
?>
