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
	
	if (!$_SESSION['account']){
		header ("Location:login.php") ;
	} else if (isset($_POST['textarea'])){
		// 使用textarea上傳
		echo "Hello, ".$_SESSION['account']."<br>";
		echo 'textarea'.$_POST['textarea'] ;
		
	}
	else if (isset($_FILES['upload'])){
		// 選取檔案上傳
		
		
		$problem_dir = '.\\student\\'.$_SESSION['account'].'\\'.$_POST['problem_num']; 
		if (!is_dir($problem_dir)){
			$return = 0;
			$command = "MD ".$problem_dir;
			system($command, $return);
		}
		$judge_dir = '.\\judgement\\'.$_POST['problem_num'];
		$upfile = $problem_dir.'\\hw.cpp';
		$exefile = $problem_dir.'\\hw.exe';
		$logfile = $problem_dir.'\\log.txt';
		$testfile = $judge_dir.'\\testing_data.txt';
		$outputfile = $problem_dir.'\\output.txt';
		move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);
		
		// if (!file_exists($logfile)){
			// $fp = fopen($logfile, 'w');
			// fclose($fp);
		// }
	
		$return = 1;
		
		$command = 'g++ '.$upfile.' -o '.$exefile.' -enable-auto-import 2> '.$logfile;
		//echo $command;
		system($command,$return);
		if (file_exists($exefile)){
			$command = $exefile.' < '.$testfile.' > '.$outputfile;
			system($command,$return);
		} else {
			//compile error
		}
		
		echo "Hello, ".$_SESSION['account']."<br>";
		echo 'file upload success';
	}
	else if (!isset($_FILES['upload']) and !isset($_POST['textarea'])){
		echo 'no upload';
	}

?>