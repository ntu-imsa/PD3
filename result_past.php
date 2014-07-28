<?php
	session_start() ;
	require_once('lib.inc.php');

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else if (!isset($_POST['past_id'])) {?>
		<div class="hero-unit upload_section">
			<h3>Wrong Problem ID, Please Submit Again</h3>
		</div><?php
	} else {
		$query = "SELECT past_id FROM past_hw WHERE past_id = '".$_POST['past_id']."'" ;
		$id = mysql_query($query);
		$fetch_id = mysql_fetch_row($id);
		if ($fetch_id[0] == ''){?>
			<div class="hero-unit upload_section">
				<h3>Wrong Problem ID, Please Submit Again</h3>
			</div><?php
		} else {

			//echo $_POST['past_id'];
			$acc = mysql_real_escape_string($_SESSION['account']);
			$past = '.\\student\\'.$acc.'\\past\\';
			$problem_dir = $past.$_POST['past_id'];
			$log_dir = $problem_dir.'\\log';
			$ans_dir = $problem_dir.'\\answer';

			if (!is_dir($past))
				mkdir($past);

			if (!is_dir($problem_dir))
				mkdir($problem_dir);

			if (!is_dir($log_dir))
				mkdir($log_dir);

			if (!is_dir($ans_dir))
				mkdir($ans_dir);

			$judge_dir = '.\\past\\'.$_POST['past_id'];
			$upfile = $problem_dir.'\\'.$acc.'-'.$_POST['past_id'].'.cpp';
			$pdffile = $problem_dir.'\\'.$acc.'-'.$_POST['past_id'].'.pdf';
			$exefile = $problem_dir.'\\'.$acc.'-'.$_POST['past_id'].'.exe';
			$exename = $acc.'-'.$_POST['past_id'].'.exe';
			$compile_logfile = $problem_dir.'\\log\\compile_err_log.txt';
			$run_logfile = $problem_dir.'\\log\\run_err_log.txt';
			$all_logfile = '.\\past\\upload_log.txt';
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
			$ID = $_POST['past_id'];

			$query = "SELECT deadline FROM past_hw WHERE past_id = '".$ID."'";
			$command_judge = 'python pastjudge.py '.$acc.' '.$_POST['past_id'].' '.$ID;
			$query_score = "SELECT total_score FROM past_hw WHERE past_id = '".$ID."'";

			if (isset($_FILES['upload'])){   // 程式碼檔案上傳
				move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);
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
									//ex. python judge.py b01705001 PD13-3
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
					fwrite($fp, '['.$datetime.'] : '.$acc.' submits a file for problem '.$_POST['past_id']."\n");
					fclose($fp);
					$query = "SELECT s_id FROM student WHERE account = '".$acc."'" ;
					$id = mysql_query($query);
					$fetch_id = mysql_fetch_row($id);
					$insert = "INSERT INTO past_score(s_id, past_id, status, time, exec_time, score) VALUES ('$fetch_id[0]', '$ID', '$status', '$datetime', '$exec_result', '$score')" ;
					$success = mysql_query($insert);

			}
			if (isset($_FILES['upload'])){
				?>	<!-- 改作業序號看這裡 -->
					<div class="hero-unit upload_section">
						<table class="table table-hover"><?php
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
								$query_rec = "SELECT past_id, status, exec_time, time, score FROM past_score NATURAL JOIN student WHERE account = '".$acc."' ORDER BY time DESC";

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
	}
?>
