﻿<?php 
	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'pdogsserver' ;
	$connection = mysql_connect($db_host, $db_username, 'pdogsserver');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		$acc = mysql_real_escape_string($_SESSION['account']);
		$problem_dir = '.\\student\\'.$acc.'\\'.$_POST['problem_num']; 
		$log_dir = '.\\student\\'.$acc.'\\'.$_POST['problem_num'].'\\log';
		$ans_dir = '.\\student\\'.$acc.'\\'.$_POST['problem_num'].'\\answer';
			
		if (!is_dir($problem_dir))
			mkdir($problem_dir);
				
		if (!is_dir($log_dir))
			mkdir($log_dir);
				
		if (!is_dir($ans_dir))
			mkdir($ans_dir);
			
		$judge_dir = '.\\judgement\\'.$_POST['problem_num'];
		$upfile = $problem_dir.'\\'.$acc.'-'.$_POST['problem_num'].'.cpp';
		$pdffile = $problem_dir.'\\'.$acc.'-'.$_POST['problem_num'].'.pdf';
		$exefile = $problem_dir.'\\'.$acc.'-'.$_POST['problem_num'].'.exe';
		$exename = $acc.'-'.$_POST['problem_num'].'.exe';
		$compile_logfile = $problem_dir.'\\log\\compile_err_log.txt';
		$run_logfile = $problem_dir.'\\log\\run_err_log.txt';
		$all_logfile = '.\\judgement\\upload_log.txt';
		$outputfile = $problem_dir.'\\answer\\output.txt';
		$resultfile = $problem_dir.'\\answer\\score.txt';
		$exec_timefile = $problem_dir.'\\answer\\exec_time.txt';
		$testfile = $judge_dir.'\\testing_data.txt';
			
		if (file_exists($upfile)) unlink($upfile);
		if (file_exists($exefile)) unlink($exefile);
		if (file_exists($outputfile)) unlink($outputfile);
		if (file_exists($resultfile)) unlink($resultfile);
		if (file_exists($pdffile)) unlink($pdffile);	
		
		$status = '';
		$score = 0;
		$exec_result = 0;
		$return = -1;
		$fc = $_POST['problem_num'][0];
		$ID = $_POST['problem_num'];
		//根據是PD作業或是LAB作業取出題號
		
		if ($fc == "P"){
			$query = "SELECT deadline FROM pd_hw WHERE p_id = '".$_POST['problem_num']."'";
			$command_judge = 'python judge.py '.$acc.' '.$_POST['problem_num'];   
			$query_score = "SELECT total_score FROM pd_hw WHERE p_id = '".$_POST['problem_num']."'";
		} else if($fc == "L"){
			$query = "SELECT deadline FROM lab_hw WHERE lab_id = '".$_POST['problem_num']."'";
			$command_judge = 'python labjudge.py '.$acc.' '.$_POST['problem_num'];  
			$query_score = "SELECT total_score FROM lab_hw WHERE lab_id = '".$_POST['problem_num']."'";
		}
		$time = mysql_query($query);
		$fetch_time = mysql_fetch_row($time);
		
		if (isset($_FILES['pdfupload'])){  //pdf 檔案上傳	
			if ( $fetch_time[0] > $datetime ){  //如果還沒超過死線
				move_uploaded_file($_FILES['pdfupload']['tmp_name'], $pdffile);
			}
		}
		if (isset($_FILES['upload'])){   // 程式碼檔案上傳
			move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);
			
			//如果繳交的題目還沒超過死線
			if ( $fetch_time[0] > $datetime ){
				//編譯.cpp檔
				if (file_exists($upfile)){
					$fp = fopen($compile_logfile, 'a');
					fwrite($fp, '['.$datetime.'] :'."\n");
					fclose($fp);
					$fp = fopen($run_logfile, 'a');
					fwrite($fp, '['.$datetime.'] :'."\n");
					fclose($fp);
					//$command = 'g++ '.$upfile.' -o '.$exefile.' -enable-auto-import 2>> '.$compile_logfile;
					$command = 'g++ '.$upfile.' -o '.$exefile.'  2>> '.$compile_logfile;
					system($command, $return);
					if ($return == 0){	       
						//如果成功編譯出.exe檔 執行程式
						//ex. hw.exe < testing_data.txt > output.txt 2>> log.txt
						//$command = $exefile.' < '.$testfile.' > '.$outputfile.' 2>> '.$run_logfile;  
						//$command = 'python timeout.py '.$exefile.' '.$testfile.' '.$outputfile.' '.$run_logfile.' '.$exec_timefile.' '.$exename.' 2>> '.$run_logfile;
						$command = 'python timeout.py '.$exefile.' '.$testfile.' '.$outputfile.' '.$run_logfile.' '.$exec_timefile.' '.$exename.' 3';
						if ($exec_result = exec($command, $return)){      //如果執行成功  比對結果
							if ($exec_result != NULL and $exec_result == 'Time limit exceed'){
								$status = 'Time limit exceed';
								$exec_result = 3;
							} else if ($exec_result != NULL and $exec_result == 'Runtime error'){
								$status = 'Runtime error';
								$exec_result = 0;
							} else{
								//ex. python judge.py b01705001 PD14-1
								$score = exec($command_judge, $return);
								$s = mysql_query($query_score);
								$fetch_s = mysql_fetch_row($s);
								if ($score == $fetch_s[0]){
									$status = 'Accepted';
								} else {
									$status = 'Wrong answer';
								}
							}
						} else {
							//runtime error
							$status = 'Runtime error';
						}
					} else {
						//compile error
						$status = 'Compilation error';
					}
				} else {
					//upload error
					$status = 'System upload error';
				}
				$fp = fopen($all_logfile, 'a');
				fwrite($fp, '['.$datetime.'] : '.$acc.' submits a file for problem '.$_POST['problem_num']."\n");
				fclose($fp);
				$query = "SELECT s_id FROM student WHERE account = '".$acc."'" ;
				$id = mysql_query($query);
				$fetch_id = mysql_fetch_row($id);
				//echo $_POST['problem_num'][4];	
				if ($fc == "P"){
					$insert = "INSERT INTO pd_score(s_id, p_id, status, time, exec_time, score) 
						VALUES ('$fetch_id[0]', '$ID', '$status', '$datetime', '$exec_result', '$score')" ;
				} else if($fc == "L"){
					$insert = "INSERT INTO lab_score(s_id, lab_id, status, time, exec_time, score) 
						VALUES ('$fetch_id[0]', '$ID', '$status', '$datetime', '$exec_result', '$score')" ;
				}
				$success = mysql_query($insert);
			} else {   //超過死線
				echo "<div class='hero-unit upload_section'><p>deadline is passed!</p></div>";
			}
		}
		if (isset($_FILES['upload']) or isset($_FILES['pdfupload'])){
			?>	<!-- 改作業序號看這裡 -->
				<div class="hero-unit upload_section">
					<table class="table table-hover"><?php 
					if (isset($_FILES['pdfupload'])){ ?>
						<p>PDF file is submitted successfully!</p>
						<br> <?php 
					} 
					if (isset($_FILES['upload'])){?>
						<thead>
							<tr>
								<th>Problem</th>
								<th>Status</th>
								<th>Run time</th>
								<th>Submission date</th>
								<th>Score</th>
							</tr>
						</thead>
						<tbody> <?php 
							if ($fc == "P"){
								$query_rec = "SELECT p_id, status, exec_time, time, score FROM pd_score NATURAL JOIN student 
											WHERE account = '".$acc."' ORDER BY time DESC";
							} else if ($fc == "L"){
								$query_rec = "SELECT lab_id, status, exec_time, time, score FROM lab_score NATURAL JOIN student 
											WHERE account = '".$acc."' ORDER BY time DESC";
							}
							$rec = mysql_query($query_rec);
							$fetch_rec = mysql_fetch_row($rec);
							
							if ($fetch_rec[1] == 'Accepted'){
								?><tr class="accept"><?php
							} else if ($fetch_rec[1] == 'Compilation error' or $fetch_rec[1] == 'Runtime error'){
								?><tr class="error"><?php
							} else if ($fetch_rec[1] == 'Time limit exceed'){
								?><tr class="time_exceed"><?php
							} else if ($fetch_rec[1] == 'Wrong answer'){
								?><tr class="wrong_answer"><?php
							} else if ($fetch_rec[1] == 'System upload error'){
								?><tr class="upload_error"><?php
							} ?>
								<td><?php echo $fetch_rec[0];?></td>
								<td><?php echo $fetch_rec[1];?></td>
								<td><?php echo $fetch_rec[2].'s';?></td>
								<td><?php echo $fetch_rec[3];?></td>
								<td><?php echo $fetch_rec[4];?></td>
							</tr>
						</tbody> <?php 
					} ?>
					</table>
				</div>  <?php
		}
		if (!isset($_FILES['upload']) and !isset($_FILES['pdfupload']) ){ //沒有上傳 理論上不會發生 因為沒辦法按下upload鈕
			echo 'no upload';
		}
	}
?>