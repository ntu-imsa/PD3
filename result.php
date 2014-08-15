<?php
	session_start() ;
	require_once('includes/lib.inc.php');
  require_once('includes/dc.inc.php');

	$score = 0;
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
			mkdir($problem_dir, 0777, true);

		if (!is_dir($log_dir))
			mkdir($log_dir, 0777, true);

		if (!is_dir($ans_dir))
			mkdir($ans_dir, 0777, true);

		$judge_dir = '.\\judgement\\'.$_POST['problem_num'];
		$upfile = $problem_dir.'\\'.$acc.'-'.$_POST['problem_num'].'.cpp';
		$pdffile = $problem_dir.'\\'.$acc.'-'.$_POST['problem_num'].'.pdf';
		$exefile = $problem_dir.'\\'.$acc.'-'.$_POST['problem_num'].'.exe';
		$exename = $acc.'-'.$_POST['problem_num'].'.exe';
		$compile_logfile = $problem_dir.'\\log\\compile_err_log.txt';
		$run_logfile = $problem_dir.'\\log\\run_err_log.txt';
		$all_logfile = '.\\judgement\\upload_log.txt';
		#$outputfile = $problem_dir.'\\answer\\output.txt';
		$outputfile = $problem_dir.'\\answer\\'.$_POST['problem_num'];
		$resultfile = $problem_dir.'\\answer\\result.txt';
		$scorefile = $problem_dir.'\\answer\\score.txt';
		$exec_timefile = $problem_dir.'\\answer\\exec_time.txt';
		$testfile = $judge_dir.'\\'.$_POST['problem_num'];
		$specialjudge = $judge_dir.'\\judge.exe ';

		$status = '';
		$score = 0;
		$exec_result = 0;
		$exec_time = 0;
		$return = -1;
		$fc = $_POST['problem_num'][0];
		$ID = $_POST['problem_num'];
		$datanum = 0;
		$status_arr = array();
		$time_arr = array();
		$score_arr = array();
		$public_score_arr = array();
		//根據是PD作業或是LAB作業取出題號
		
		$table = ($fc == "P" ? "pd_hw" : "lab_hw");
		$db = getDatabaseConnection();
		$query = "SELECT deadline, type, data_number FROM $table WHERE p_id = :pid";
		$stmt = $db->prepare($query);
		$stmt->execute(array("pid" => $_POST['problem_num']));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		

		if ($fc == "P"){
			$command_judge = ($result['type'] != 1 ? 'python judge.py ' : $specialjudge).$acc.' '.$_POST['problem_num'];
		} else if($fc == "L"){
			$command_judge = 'python labjudge.py '.$acc.' '.$_POST['problem_num'];
		}

	if ( $result['deadline'] > $datetime ){  //如果還沒超過死線
		if (isset($_FILES['pdfupload']) && file_exists($_FILES['pdfupload']['tmp_name']) && is_uploaded_file($_FILES['pdfupload']['tmp_name'])){
			// pdf 檔案上傳，如果沒有上傳檔案，就不要進行處理
			// 有上傳的話，先把server上已存在的刪掉
			if (file_exists($pdffile)) unlink($pdffile);
			move_uploaded_file($_FILES['pdfupload']['tmp_name'], $pdffile);
		}
		if (isset($_FILES['upload']) && file_exists($_FILES['upload']['tmp_name']) && is_uploaded_file($_FILES['upload']['tmp_name'])) $upload = 1;
		else if (isset($_POST['code'])) $upload = 2;
		else $upload = 0;
		
		if ($upload > 0){
			// 程式碼檔案上傳，如果沒有上傳檔案，就不要進行處理
			// 有上傳的話，先把server上已存在的刪掉
			if (file_exists($upfile)) unlink($upfile);
			if (file_exists($exefile)) unlink($exefile);
			if (file_exists($outputfile)) unlink($outputfile);
			if (file_exists($resultfile)) unlink($resultfile);
			if ($upload == 1) move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);
			else file_put_contents($upfile, $_POST['code']);
			$all_result = '';

			//編譯.cpp檔
				if (file_exists($upfile)){
					$fp = fopen($compile_logfile, 'a');
					fwrite($fp, '['.$datetime.'] :'."\n");
					fclose($fp);
					$fp = fopen($run_logfile, 'a');
					fwrite($fp, '['.$datetime.'] :'."\n");
					fclose($fp);
					//$command = 'g++ '.$upfile.' -o '.$exefile.' -enable-auto-import 2>> '.$compile_logfile;
					$command = 'g++ "'.$upfile.'" -O2 -Wl,--stack,214748364 -static -std=c++11 -I .\interactive -o "'.$exefile.'"  2>> "'.$compile_logfile.'"';
					system($command, $return);
					if ($return == 0){
						//如果成功編譯出.exe檔 執行程式
						//ex. hw.exe < testing_data.txt > output.txt 2>> log.txt
						//$command = $exefile.' < '.$testfile.' > '.$outputfile.' 2>> '.$run_logfile;
						//$command = 'python timeout.py '.$exefile.' '.$testfile.' '.$outputfile.' '.$run_logfile.' '.$exec_timefile.' '.$exename.' 2>> '.$run_logfile;
						//先開啟score.txt把檔案清空
						$finalstatus = 0;
						//先抓總共有幾筆測資
						//這裡需要一個for迴圈來跑多筆測資
						
						
						$datanum = $result['data_number'];
						$testdatainfo = fopen($judge_dir.'\\testing_data.txt', "r");
						exec('python txtCleaner.py '.$exec_timefile);
						exec('python txtCleaner.py '.$resultfile);
						exec('python txtCleaner.py '.$scorefile);
						for($i = 0 ; $i < $datanum ; $i++){
							$status_arr[$i] = "";
							$time_arr[$i] = 0;
							$score_arr[$i] = 0;
							$public_score_arr[$i] = 0;
							$teststr = fgets($testdatainfo, 100);
							$tmpscore = 0;
							preg_match_all("/\d+/", $teststr, $testarr);
							$public_score_arr[$i] = $testarr[0][2];
							$command = 'python timeout.py "'.$exefile.'" "'.$testfile.'.'.$i.'.in" "'.$outputfile.'.'.$i.'.out" '.$run_logfile.' '.$exec_timefile.' "'.$exename.'" '.$testarr[0][0];
							if ($exec_result = exec($command, $return)){      //如果執行成功  比對結果
								if ($exec_result != NULL and $exec_result == 'Time limit exceed'){
									$status = 'Time limit exceed';
									if($finalstatus < 2) $finalstatus = 2;
									$exec_result = $testarr[0][0];
									$exec_time += $exec_result;
									$time_arr[$i] = $exec_result;
									exec('python putzero.py '.$scorefile);
								} else if ($exec_result != NULL and $exec_result == 'Runtime error'){
									$status = 'Runtime error';
									if($finalstatus < 3) $finalstatus = 3;
									$exec_result = 0;
									exec('python putzero.py '.$scorefile);
								} else {
									//ex. python judge.py b01705001 PD14-1
									$tmpscore = exec($command_judge.' '.$i.' '.$testarr[0][1], $return);
									if ($result['type'] == 3) { //debug challenge
										if (!debug_challenge("$judge_dir\\origin.cpp", $upfile, $testarr[0][3]))
											$tmpscore = 0;
									}
									if ($tmpscore == $testarr[0][1]){
										$status = 'Accepted';
									} else {
										$status = 'Wrong answer';
										if($finalstatus < 1) $finalstatus = 1;
									}
									$score += $tmpscore;
									$score_arr[$i] = $tmpscore;
									$exec_time += $exec_result;
								}
								$time_arr[$i] = $exec_result;
							} else {
								//runtime error
								$status = 'Runtime error';
								if($finalstatus < 3) $finalstatus = 3;
								exec('python putzero.py '.$scorefile);
							}
							$status_arr[$i] = $status;
							$fp = fopen($resultfile,"a");
							fputs($fp, $status."\r\n");
							$all_result .= sprintf("%d,", $tmpscore);// << this should be the real score you got!
							fclose($fp);
						}
						//回報total結果
						switch($finalstatus){
							case 0:
								$status = 'Accepted';
							break;
							case 1:
								$status = 'Wrong answer';
							break;
							case 2:
								$status = 'Time limit exceed';
							break;
							case 3:
								$status = 'Runtime error';
							break;
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
					$insert = "INSERT INTO pd_score(s_id, p_id, status, time, exec_time, score, result)
						VALUES ('$fetch_id[0]', '$ID', '$status', '$datetime', '$exec_time', '$score', '$all_result')" ;
				} else if($fc == "L"){
					$insert = "INSERT INTO lab_score(s_id, lab_id, status, time, exec_time, score, result)
						VALUES ('$fetch_id[0]', '$ID', '$status', '$datetime', '$exec_time', '$score', '$all_result')" ;
				}
				$success = mysql_query($insert);

		}
	} else {   //超過死線
				echo "<div class='hero-unit upload_section'><p>deadline is passed!</p></div>";
	}

		if ($upload > 0 or isset($_FILES['pdfupload'])){
			?>	<!-- 改作業序號看這裡 -->
				<div class="hero-unit upload_section">
					<table class="table table-hover"><?php
					if (isset($_FILES['pdfupload'])){ ?>
						<p>PDF file is submitted successfully!</p>
						<br> <?php
					}
					if ($upload > 0){?>
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
							</tr><tr><td> </td></tr>
							<?php
								for($i = 0 ; $i < $datanum ; $i++){
									if($public_score_arr[$i] == 1){
										if ($status_arr[$i] == 'Accepted'){
											?><tr class="accept"><?php
										} else if ($status_arr[$i] == 'Compilation error' or $fetch_rec[1] == 'Runtime error'){
											?><tr class="error"><?php
										} else if ($status_arr[$i] == 'Time limit exceed'){
											?><tr class="time_exceed"><?php
										} else if ($status_arr[$i] == 'Wrong answer'){
											?><tr class="wrong_answer"><?php
										} else if ($status_arr[$i] == 'System upload error'){
											?><tr class="upload_error"><?php
										} ?>
											<td><?php echo 'Test Data '.($i+1);?></td>
											<td><?php echo $status_arr[$i];?></td>
											<td><?php echo $time_arr[$i].'s';?></td>
											<td></td>
											<td><?php echo $score_arr[$i];?></td>
											</tr>
										<?php
									}else{
										?><tr class="data_hidden">
										<td><?php echo 'Test Data '.($i+1);?></td>
										<td><?php echo 'Data Hidden'?></td>
										<td></td>
										<td></td>
										<td></td>
										</tr>
										<?php
									}
								}
							?>
						</tbody> <?php
					} ?>
					</table>
				</div>  <?php
		}
		if ($upload == 0 and !isset($_FILES['pdfupload']) ){ //沒有上傳 理論上不會發生 因為沒辦法按下upload鈕
			echo 'no upload';
		}
	}
?>
