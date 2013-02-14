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
	
	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y/m/d H:i:s");
	//echo $datetime.'<br>';
	
	if (!$_SESSION['account']){            // 使用者未登入，導回login.php
		header ("Location:login.php") ;
	} else if (isset($_POST['textarea'])){ // 使用textarea上傳
		echo "Hello, ".$_SESSION['account']."<br>";
		echo 'textarea'.$_POST['textarea'] ;
	}
	else  if (isset($_FILES['upload'])){   // 選取檔案上傳
		$problem_dir = '.\\student\\'.$_SESSION['account'].'\\'.$_POST['problem_num']; 
		if (!is_dir($problem_dir)){
			$return = 0;
			$command = "MD ".$problem_dir;
			system($command, $return);
		}
		$judge_dir = '.\\judgement\\'.$_POST['problem_num'];
		$upfile = $problem_dir.'\\hw.cpp';
		$exefile = $problem_dir.'\\hw.exe';
		$compile_logfile = $problem_dir.'\\compile_err_log.txt';
		$run_logfile = $problem_dir.'\\run_err_log.txt';
		$testfile = $judge_dir.'\\testing_data.txt';
		$outputfile = $problem_dir.'\\output.txt';
		move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);
		

		$status = '';
		$score = 0;
		$return = -1;
		$num = (int)$_POST['problem_num'][2].$_POST['problem_num'][3].$_POST['problem_num'][4];
		
		//編譯.cpp檔
		//$command = 'g++ '.$upfile.' -o '.$exefile.' -enable-auto-import 2> '.$logfile;
		if (file_exists($upfile)){
			$command = 'g++ '.$upfile.' -o '.$exefile.' 2> '.$compile_logfile;
			system($command, $return);
			echo 'compile return:'.$return.'<br>';
			if ($return == 0){	//如果成功編譯出.exe檔 執行.exe 輸入測資為$testfile 標準輸出轉向至$outputfile 標準錯誤轉向至$run_logfile
				$command = $exefile.' < '.$testfile.' > '.$outputfile.' 2> '.$run_logfile;
				system($command, $return);
				echo 'runtime return:'.$return.'<br>';
				if ($return == 0){  //如果執行成功  比對結果
					$command = 'python judge.py '.$_SESSION['account'].' '.$_POST['problem_num'];
					$score = exec($command,$return);
					$status = 'success';
				} else {
					//runtime error
					$status = 'runtime error';
				}
			} else {
				//compile error
				$status = 'compile error';
			}
		} else {
			//upload error
			$status = 'upload error';
		}
		$query = "SELECT s_id FROM student WHERE account = '".$_SESSION['account']."'" ;
		$id = mysql_query($query);
		$fetch_id = mysql_fetch_row($id);
		echo $_POST['problem_num'][4];
		$insert = "INSERT INTO pd_score(s_id, p_id, status, time, score) 
			VALUES ('$fetch_id[0]', '$num', '$status', '$datetime', '$score')" ;
		$success = mysql_query($insert);
		
	}
	else if (!isset($_FILES['upload']) and !isset($_POST['textarea'])){
		echo 'no upload';
	}

?>