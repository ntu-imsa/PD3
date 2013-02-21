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
					
					//查詢class hw 總題數
					$query_num = "SELECT COUNT(*) FROM pd_hw";
					$num = mysql_query($query_num);
					$fetch_num = mysql_fetch_row($num);
					$problem_set = "";
					for ($i = 1; $i < (int)$fetch_num[0]; $i++){
						$problem_set =  $problem_set."'".$i."',";
					}
					$problem_set = $problem_set."'".$fetch_num[0]."'";
					//查詢使用者每個題目最新上傳的狀態和成績
					$query_score = "SELECT p_id, status, time, exec_time, score FROM pd_score WHERE time IN (SELECT MAX(time) FROM pd_score WHERE s_id = ".$fetch_id[0]." AND p_id IN (".$problem_set.") GROUP BY p_id) ORDER BY p_id ";
					$score = mysql_query($query_score);
					
					//將結果顯示在畫面
					if ($score != False)
						$fetch_score = mysql_fetch_row($score);
					for ($i = 1; $i <= (int)$fetch_num[0]; $i++){
						$append = substr('PD000', 0, -strlen((string)$i));
						if ( $fetch_score != NULL and $i == (int)$fetch_score[0]){
							if ($fetch_score[1] == 'Accepted'){
								?><tr class="accept"><?php
							} else if ($fetch_score[1] == 'Compilation error'){
								?><tr class="compile_error"><?php
							} else if ($fetch_score[1] == 'Runtime error'){
								?><tr class="runtime_error"><?php
							} else if ($fetch_score[1] == 'Time limit exceed'){
								?><tr class="time_exceed"><?php
							} else if ($fetch_score[1] == 'Wrong answer'){
								?><tr class="wrong_answer"><?php
							} else if ($fetch_score[1] == 'System upload error'){
								?><tr class="upload_error"><?php
							} ?>
								<td><?php echo $append.$fetch_score[0];?></td>
								<td><?php echo $fetch_score[1];?></td>
								<td><?php echo $fetch_score[2].'s';?></td>
								<td><?php echo $fetch_score[3];?></td>
								<td><?php echo $fetch_score[4];?></td>
							</tr><?php
							$fetch_score = mysql_fetch_row($score);
						} else {
							
							?><tr>
								<td><?php echo $append.$i;?></td>
								<td><?php echo "No submit"; ?></td>
								<td><?php echo "";?></td>
								<td><?php echo "";?></td>
								<td><?php echo "";?></td>
							</tr><?php
						}
					}		
				?>
				</tbody>
			</table>
			<br>
			<p>LAB Problems</p>
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
					//查詢lab hw 總題數
					$query_num = "SELECT COUNT(*) FROM lab_hw";
					$num = mysql_query($query_num);
					$fetch_num = mysql_fetch_row($num);
					$problem_set = "";
					for ($i = 1; $i < (int)$fetch_num[0]; $i++){
						$problem_set =  $problem_set."'".$i."',";
					}
					$problem_set = $problem_set."'".$fetch_num[0]."'";
					//查詢使用者每個題目最新上傳的狀態和成績
					$query_score = "SELECT lab_id, status, time, exec_time, score FROM lab_score WHERE time IN (SELECT MAX(time) FROM lab_score WHERE s_id = ".$fetch_id[0]." AND lab_id IN (".$problem_set.") GROUP BY lab_id ) ORDER BY lab_id ";
					$score = mysql_query($query_score);
					
					//將結果顯示在畫面
					//if ($score != False)
						$fetch_score = mysql_fetch_row($score);
					for ($i = 1; $i <= (int)$fetch_num[0]; $i++){
						$append = substr('LAB000', 0, -strlen((string)$i));
						if ( $fetch_score != NULL and $i == (int)$fetch_score[0]){
							if ($fetch_score[1] == 'Accepted'){
								?><tr class="accept"><?php
							} else if ($fetch_score[1] == 'Compilation error'){
								?><tr class="compile_error"><?php
							} else if ($fetch_score[1] == 'Runtime error'){
								?><tr class="runtime_error"><?php
							} else if ($fetch_score[1] == 'Time limit exceed'){
								?><tr class="time_exceed"><?php
							} else if ($fetch_score[1] == 'Wrong answer'){
								?><tr class="wrong_answer"><?php
							} else if ($fetch_score[1] == 'System upload error'){
								?><tr class="upload_error"><?php
							} ?>
								<td><?php echo $append.$fetch_score[0];?></td>
								<td><?php echo $fetch_score[1];?></td>
								<td><?php echo $fetch_score[2].'s';?></td>
								<td><?php echo $fetch_score[3];?></td>
								<td><?php echo $fetch_score[4];?></td>
							</tr><?php
							$fetch_score = mysql_fetch_row($score);
						} else {
							
							?><tr>
								<td><?php echo $append.$i;?></td>
								<td><?php echo "No submit"; ?></td>
								<td><?php echo "";?></td>
								<td><?php echo "";?></td>
								<td><?php echo "";?></td>
							</tr><?php
						}
					}		
				?>
				</tbody>
			</table>
		</div>
		
		<div id="footer">
			<div class="container">
				<p class="muted credit">© Copyright NTUIM 2013 Spring Program Design Course | All Rights Reserved.</p>
			</div>
		</div>
<?php		
	}
?>