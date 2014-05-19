<?php
	$acc = mysql_real_escape_string($_POST["account"]) ;
	$pw = md5(mysql_real_escape_string($_POST["password"])) ;
	$cpw = md5(mysql_real_escape_string($_POST["cpw"])) ;

	$student_dir = '.\\student\\'.$acc;
	if ($acc == NULL or $_POST["password"] == NULL or $_POST["cpw"] == NULL)
		header ("Location:index.php?empty=1") ;
	elseif ($pw != $cpw)
		header ("Location:index.php?same=1") ;
	else{

	require_once('db.inc.php');

	$valid = "SELECT * FROM student WHERE account = '".$acc."'" ;
	echo $acc;
	$valid2 = mysql_query($valid) ;
	if ($same = mysql_fetch_row($valid2)){
		header ("Location:index.php?err=1") ;
	} else {
		$uid = "SELECT MAX(s_id) FROM student ;" ;
		$max = mysql_query($uid) ;
		$fetch_max = mysql_fetch_row($max);
		$value = $fetch_max[0]+1 ;
		$query = "INSERT INTO student(s_id, account, password, type) VALUES ('$value', '$acc', '$pw', 1) " ;
		$result = mysql_query($query) ;
		$check = "SELECT * FROM student WHERE account = '$acc' AND password = '$pw' " ;
		$success = mysql_query($check) ;

		//�ЫبϥΪ̸��Ƨ�
		$return = 0;
		$command = "MD ".$student_dir;
		system($command, $return);

		if ($result_rowc = mysql_fetch_row($success) and file_exists($student_dir))
			header("Location:index.php?success=1") ;
		}
	}
?>
