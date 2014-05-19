<?php
session_start() ;
require_once('db.inc.php');

date_default_timezone_set('Asia/Taipei');
$datetime = date ("Y-m-d H:i:s");

if (!isset($_SESSION['account'])){
	header ("Location:index.php") ;
} else {
	$acc = mysql_real_escape_string($_SESSION['account']);
	$group_query = "SELECT group_num FROM student WHERE account = '".$acc."'" ;
	$group = mysql_query($group_query);
	$fetch_group = mysql_fetch_row($group);
	$group_num = $fetch_group[0];

	$project_query = "SELECT * FROM project WHERE onjudge = '1'";
	$project = mysql_query($project_query);
	$fetch_project = mysql_fetch_row($project);
	$append = substr('PJ000', 0, -strlen($fetch_project[0]));
	$project_id = $append.$fetch_project[0];

	$exist_query = "SELECT count(*) FROM `group` WHERE group_num = ".$group_num ;
	$exist = mysql_query($exist_query);
	$fetch_exist = mysql_fetch_row($exist);
	if ($fetch_exist[0] == '0'){

		$insert = "INSERT INTO `group`(group_num)
						VALUES ('$group_num')" ;
		$result = mysql_query($insert);
		if (!$result) {
    		die('Invalid query: ' . mysql_error());
		}
		$insert = "INSERT INTO project_group(project_id, group_num)
						VALUES ('$fetch_project[0]', '$group_num')" ;
		mysql_query($insert);
	}


	$problem_dir = '.\\project\\'.$project_id.'\\'.$group_num;
	$log_dir = '.\\project\\'.$project_id.'\\'.$group_num.'\\log';
	$ans_dir = '.\\project\\'.$project_id.'\\'.$group_num.'\\answer';

	if (!is_dir($problem_dir))
		mkdir($problem_dir);

	if (!is_dir($log_dir))
		mkdir($log_dir);

	if (!is_dir($ans_dir))
		mkdir($ans_dir);

	$judge_dir = '.\\judgement\\'.$project_id;
	$upfile = $problem_dir.'\\'.$project_id.'.cpp';
	$pdffile = $problem_dir.'\\'.$project_id.'.pdf';
	$exefile = $problem_dir.'\\'.$project_id.'.exe';
	$exename = $project_id.'.exe';
	$compile_logfile = $problem_dir.'\\log\\compile_err_log.txt';
	$run_logfile = $problem_dir.'\\log\\run_err_log.txt';
	$all_logfile = '.\\judgement\\upload_log.txt';
	$outputfile = $problem_dir.'\\answer\\output.txt';
	$resultfile = $problem_dir.'\\answer\\score.txt';
	$exec_timefile = $problem_dir.'\\answer\\exec_time.txt';
	$testfile = $judge_dir.'\\testing_data.txt';


	if (file_exists($exefile)) unlink($exefile);
	if (file_exists($outputfile)) unlink($outputfile);
	if (file_exists($resultfile)) unlink($resultfile);


	$status = '';
	$score = 0;
	$exec_result = 0;
	$return = -1;



		if (isset($_FILES['pdfupload'])){  //pdf 檔案上傳
			if ( $fetch_project[2] > $datetime ){  //如果還沒超過死線
				if (file_exists($pdffile)) unlink($pdffile);
				move_uploaded_file($_FILES['pdfupload']['tmp_name'], $pdffile);
			}
		}
		if (isset($_FILES['upload'])){   // 程式碼檔案上傳
			if (file_exists($upfile)) unlink($upfile);
			move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);

			//如果繳交的題目還沒超過死線
			if ( $fetch_project[2] > $datetime ){
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
						$command = 'python timeout.py '.$exefile.' '.$testfile.' '.$outputfile.' '.$run_logfile.' '.$exec_timefile.' '.$exename.' 10';
						if ($exec_result = exec($command, $return)){     //如果執行成功  比對結果
							if ($exec_result != NULL and $exec_result == 'Time limit exceed'){

								$status = 'Time limit exceed';
								$exec_result = 10;
							} else if ($exec_result != NULL and $exec_result == 'Runtime error'){
								$status = 'Runtime error';
								$exec_result = 0;
							} else{
								//project需要檢查input格式是否正確
								$command_judge = 'python .\\judgement\\'.$project_id.'\\judge.py '.$group_num.' '.$project_id;
								$isDefect = exec($command_judge, $return);
								if ($isDefect == 'False'){
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
				fwrite($fp, '['.$datetime.'] : '.$acc.' in group '.$group_num.' submits a file for problem '.$project_id."\n");
				fclose($fp);
				if ($status != 'Accepted' and $status != 'Wrong answer'){
					$update = "UPDATE project_group SET ";
					for ($temp = 1; $temp <= 20; $temp++){
						$update = $update.'distance'.mysql_real_escape_string($temp).'= -1';
						if ($temp != 20)
							$update = $update.', ';
					}
					$update = $update." WHERE group_num = '$group_num' AND project_id = ".$fetch_project[0];
					$success = mysql_query($update);
					if (!$success) {
	    				die('Invalid query: ' . mysql_error());
					}
				}


				$update = "UPDATE project_group SET status = '$status', time = '$datetime', exec_time = '$exec_result' WHERE group_num = '$group_num'";
				//echo $update;
				$success = mysql_query($update);
				if (!$success) {
    				die('Invalid query: ' . mysql_error());
				}
				$update = "UPDATE project SET isUpdate = 1";
				$success = mysql_query($update);
				if (!$success) {
    				die('Invalid query: ' . mysql_error());
				}

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
						<th>Project</th>
						<th>Status</th>
						<th>Run time</th>
						<th>Submission date</th>
					</tr>
				</thead>
				<tbody> <?php

				$query_rec = "SELECT  status, exec_time, time FROM project_group
					          WHERE group_num = ".$group_num;
				$rec = mysql_query($query_rec);
				$fetch_rec = mysql_fetch_row($rec);
				if ($fetch_rec[0] == 'Accepted'){
					?><tr class="accept"><?php
				} else if ($fetch_rec[0] == 'Compilation error' or $fetch_rec[1] == 'Runtime error'){
					?><tr class="error"><?php
				} else if ($fetch_rec[0] == 'Time limit exceed'){
					?><tr class="time_exceed"><?php
				} else if ($fetch_rec[0] == 'Wrong answer'){
					?><tr class="wrong_answer"><?php
				} else if ($fetch_rec[0] == 'System upload error'){
					?><tr class="upload_error"><?php
				} ?>
				<td><?php echo $project_id;?></td>
				<td><?php echo $fetch_rec[0];?></td>
				<td><?php echo $fetch_rec[1],'s';?></td>
				<td><?php echo $fetch_rec[2];?></td>
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
