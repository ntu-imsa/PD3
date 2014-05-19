<?php
	session_start() ;
	require_once('db.inc.php');

	//ini_set("display_errors", "Off"); // 顯示錯誤是否打開( On=開, Off=關 )
	//error_reporting(E_ALL & ~E_NOTICE);

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
		<div class="hero-unit upload_section">
			<p>PD Problems</p>
			<table class="table table-hover">
				<thead>
					<tr>
						 <th>Problem</th>
						 <th>Status</th>
						 <th>Run time</th>
						 <th>Submission date</th>
						 <th>Score</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$acc = mysql_real_escape_string($_SESSION['account']);
					//查詢使用者s_id
					$query_id = "SELECT s_id FROM student WHERE account = '".$acc."'";
					$id = mysql_query($query_id);
					$fetch_id = mysql_fetch_row($id);

					$year = 13;
					$gonext = True;
					while ($gonext) {
						$query_ID = "SELECT past_id FROM past_hw WHERE past_id LIKE 'PD".(string)$year."%'";
						$ID = mysql_query($query_ID);
						$num = mysql_num_rows($ID);
						$fetch_ID = mysql_fetch_row($ID);

						$problem_set = "'".$fetch_ID[0]."'";
						while ($fetch_ID = mysql_fetch_row($ID)){
							$problem_set =  $problem_set.",'".$fetch_ID[0]."'";
						}

						//查詢使用者每個題目最新上傳的狀態和成績
						$query_score = "SELECT past_id, status, exec_time, time, score FROM past_score WHERE time IN (SELECT MAX(time) FROM past_score WHERE s_id = ".$fetch_id[0]." AND past_id IN (".$problem_set.") GROUP BY past_id) ORDER BY past_id ";
						$score = mysql_query($query_score);
						$fetch_score = NULL;

						//將結果顯示在畫面
						if ($num){
							$fetch_score = mysql_fetch_row($score);
						} else {
							$gonext = False;
						}

						$ID = mysql_query($query_ID);
						for ($i = 1; $i <= $num; $i++){
							$fetch_ID = mysql_fetch_row($ID);
							if ( $fetch_score != NULL and $fetch_ID[0] == $fetch_score[0]){
								//如果該題有上傳紀錄 顯示最新一次上傳成績與狀態
								if ($fetch_score[1] == 'Accepted'){
									?><tr class="accept"><?php
								} else if ($fetch_score[1] == 'Compilation error' or $fetch_score[1] == 'Runtime error'){
									?><tr class="error"><?php
								}  else if ($fetch_score[1] == 'Time limit exceed'){
									?><tr class="time_exceed"><?php
								} else if ($fetch_score[1] == 'Wrong answer'){
									?><tr class="wrong_answer"><?php
								} else if ($fetch_score[1] == 'System upload error'){
									?><tr class="upload_error"><?php
								} ?>
									<td><?php echo $fetch_score[0];?></td>
									<td><?php echo $fetch_score[1];?></td>
									<td><?php echo $fetch_score[2].'s';?></td>
									<td><?php echo $fetch_score[3];?></td>
									<td><?php echo $fetch_score[4];?></td>
								</tr><?php
								$fetch_score = mysql_fetch_row($score);
							} else {
								//如果該題沒有上傳紀錄 顯示No submit
								?><tr>
									<td><?php echo $fetch_ID[0];?></td>
									<td><?php echo "No submit"; ?></td>
									<td><?php echo "";?></td>
									<td><?php echo "";?></td>
									<td><?php echo "";?></td>
								</tr><?php
							}
						}
						$query_ID = "SELECT past_id FROM past_hw WHERE past_id LIKE 'EX".(string)$year."%'";
						$ID = mysql_query($query_ID);
						$num = mysql_num_rows($ID);
						$fetch_ID = mysql_fetch_row($ID);

						$problem_set = "'".$fetch_ID[0]."'";
						while ($fetch_ID = mysql_fetch_row($ID)){
							$problem_set =  $problem_set.",'".$fetch_ID[0]."'";
						}

						//查詢使用者每個題目最新上傳的狀態和成績
						$query_score = "SELECT past_id, status, exec_time, time, score FROM past_score WHERE time IN (SELECT MAX(time) FROM past_score WHERE s_id = ".$fetch_id[0]." AND past_id IN (".$problem_set.") GROUP BY past_id) ORDER BY past_id ";
						$score = mysql_query($query_score);
						$fetch_score = NULL;

						//將結果顯示在畫面
						if ($num){
							$fetch_score = mysql_fetch_row($score);
						} else {
							$gonext = False;
						}


						$ID = mysql_query($query_ID);
						for ($i = 1; $i <= $num; $i++){
							$fetch_ID = mysql_fetch_row($ID);
							if ( $fetch_score != NULL and $fetch_ID[0] == $fetch_score[0]){
								//如果該題有上傳紀錄 顯示最新一次上傳成績與狀態
								if ($fetch_score[1] == 'Accepted'){
									?><tr class="accept"><?php
								} else if ($fetch_score[1] == 'Compilation error' or $fetch_score[1] == 'Runtime error'){
									?><tr class="error"><?php
								}  else if ($fetch_score[1] == 'Time limit exceed'){
									?><tr class="time_exceed"><?php
								} else if ($fetch_score[1] == 'Wrong answer'){
									?><tr class="wrong_answer"><?php
								} else if ($fetch_score[1] == 'System upload error'){
									?><tr class="upload_error"><?php
								} ?>
									<td><?php echo $fetch_score[0];?></td>
									<td><?php echo $fetch_score[1];?></td>
									<td><?php echo $fetch_score[2].'s';?></td>
									<td><?php echo $fetch_score[3];?></td>
									<td><?php echo $fetch_score[4];?></td>
								</tr><?php
								$fetch_score = mysql_fetch_row($score);
							} else {
								//如果該題沒有上傳紀錄 顯示No submit
								?><tr>
									<td><?php echo $fetch_ID[0];?></td>
									<td><?php echo "No submit"; ?></td>
									<td><?php echo "";?></td>
									<td><?php echo "";?></td>
									<td><?php echo "";?></td>
								</tr><?php
							}
						}


						$year++;
					}?>
				</tbody>
			</table>

		</div>


<?php
	}
?>
