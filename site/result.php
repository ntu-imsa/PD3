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
	// if (isset ($_GET['err']))
		// echo 'the account has been used!<br>';
	// if (isset ($_GET['success']))
		// echo 'Register success!<br>';
	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		if (isset($_FILES['upload'])){   // 選取檔案上傳
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
			
			if (file_exists($upfile)){
				$command = 'g++ '.$upfile.' -o '.$exefile.' -enable-auto-import 2> '.$compile_logfile;
				//$command = 'g++ '.$upfile.' -o '.$exefile.' 2> '.$compile_logfile;
				system($command, $return);
				//echo 'compile return:'.$return.'<br>';
				if ($return == 0){	//如果成功編譯出.exe檔 執行.exe 輸入測資為$testfile 標準輸出轉向至$outputfile 標準錯誤轉向至$run_logfile
					$command = $exefile.' < '.$testfile.' > '.$outputfile.' 2> '.$run_logfile;
					system($command, $return);
					//echo 'runtime return:'.$return.'<br>';
					if ($return == 0){  //如果執行成功  比對結果
						$command = 'python judge.py '.$_SESSION['account'].' '.$_POST['problem_num'];
						$score = exec($command,$return);
						$status = 'Success';
					} else {
						//runtime error
						$status = 'Runtime Error';
					}
				} else {
					//compile error
					$status = 'Compile Error';
				}
			} else {
				//upload error
				$status = 'System Upload Error';
			}
			$query = "SELECT s_id FROM student WHERE account = '".$_SESSION['account']."'" ;
			$id = mysql_query($query);
			$fetch_id = mysql_fetch_row($id);
			//echo $_POST['problem_num'][4];
			$insert = "INSERT INTO pd_score(s_id, p_id, status, time, score) 
				VALUES ('$fetch_id[0]', '$num', '$status', '$datetime', '$score')" ;
			$success = mysql_query($insert);
			}
		else if (!isset($POST['upload']) ){
			echo 'no upload';
		}
	
?>      <!-- 改作業序號看這裡 -->
        <div class="hero-unit upload_section">
          <table class="table table-hover">
				   <thead>
					<tr>
					  <th>上傳題號</th>
					  <th>狀態</th>
					  <th>執行時間</th>
					  <th>上傳時間</th>
					  <th>分數</th>
					</tr>
				 </thead>
				 <tbody>
					<?php 
						
						$query_rec = "SELECT p_id, status, exec_time, time, score FROM pd_score NATURAL JOIN student WHERE account = '".$_SESSION['account']."' ORDER BY time DESC";
						$rec = mysql_query($query_rec);
						$fetch_rec = mysql_fetch_row($rec);
						$append = substr('PD000', 0, -strlen($fetch_rec[0]));
						if ($fetch_rec[1] == 'Success'){
							?><tr class="success"><?php
						} else if ($fetch_rec[1] == 'Compile Error'){
							?><tr class="warning"><?php
						} else if ($fetch_rec[1] == 'Runtime Error'){
							?><tr class="error"><?php
						} ?>
							<td><?php echo $append.$fetch_rec[0];?></td>
							<td><?php echo $fetch_rec[1];?></td>
							<td><?php echo $fetch_rec[2].'s';?></td>
							<td><?php echo $fetch_rec[3];?></td>
							<td><?php echo $fetch_rec[4];?></td>
						</tr>
				
					
					
				 </tbody>
					</table>
    </div>
   <script src="js/bootstrap-fileupload.min.js"></script>
<?php
	
	}
?>