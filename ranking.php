<?php
session_start() ;
require_once('includes/lib.inc.php');

$acc = mysql_real_escape_string($_SESSION['account']);

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
	$fetch_project = mysql_fetch_assoc($project);
	$append = substr('PJ000', 0, -strlen($fetch_project['project_id']));
	$project_id = $append.$fetch_project['project_id'];


	#$return = -1;
	#如果有人上傳後才會執行更新分數和排名的動作
	if ($fetch_project['isUpdate'] == 1){
		$command_count = 'python .\\judgement\\'.$project_id.'\\count_ranking.py '.$fetch_project['project_id'].' '.$group_num;
		try{
			$return = exec($command_count);
		} catch (Exception $e){
			echo $e;
		}

	}
	#查詢組內成績
	$score_query = "SELECT group_num, rank, best_score, worst_score, total_score, status, exec_time
	                FROM project_group  NATURAL JOIN `group`  WHERE group_num = ".$group_num;
	$score = mysql_query($score_query);
	$fetch_score = mysql_fetch_assoc($score);

	#查詢總組數
	$count_query = "SELECT count(*) FROM `group`";
	$count = mysql_query($count_query);
	$fetch_count = mysql_fetch_row($count);
	$n = $fetch_count[0];

	#查詢排行榜
	$rank_query = "SELECT group_num, rank, total_score, status, exec_time
	                FROM project_group  NATURAL JOIN `group` ORDER BY rank";
	$rank = mysql_query($rank_query);




	?>
	<div class="hero-unit upload_section">
			<p class="hw-id"><?php echo $project_id; ?></p>
			<p>Your group's status</p>
			<table class="table table-hover">
				<thead>
					<tr>
						 <th>Rank</th>
						 <th>Group ID</th>
						 <th>Status</th>
						 <th>Best score</th>
						 <th>Worst score</th>
						 <th>Run time</th>
						 <th>Score</th>
					</tr>
				</thead>
				<tbody>
				<?php
					if ( $fetch_score['status'] != ""){
						//如果該題有上傳紀錄 顯示最新一次上傳成績與狀態
						if ($fetch_score['status'] == 'Accepted'){
							?><tr class="accept"><?php
						} else if ($fetch_score['status'] == 'Compilation error' or $fetch_score['status'] == 'Runtime error'){
							?><tr class="error"><?php
						}  else if ($fetch_score['status'] == 'Time limit exceed'){
							?><tr class="time_exceed"><?php
						} else if ($fetch_score['status'] == 'Wrong answer'){
							?><tr class="wrong_answer"><?php
						} else if ($fetch_score['status'] == 'System upload error'){
							?><tr class="upload_error"><?php
						} ?>
							<td><?php echo $fetch_score['rank'];?></td>
							<td><?php echo $fetch_score['group_num'];?></td>
							<td><?php echo $fetch_score['status'];?></td>
							<td><?php echo number_format($fetch_score['best_score'],2);?></td>
							<td><?php echo number_format($fetch_score['worst_score'],2);?></td>
							<td><?php echo $fetch_score['exec_time'],'s';?></td>
							<td><?php echo number_format(0.0-(float)$fetch_score['total_score'],2),'/50';?></td>
						</tr><?php
						$fetch_score = mysql_fetch_row($score);
					} else {
						//如果該題沒有上傳紀錄 顯示No submit
						?><tr>
							<td><?php echo $fetch_score['rank'];?></td>
							<td><?php echo $fetch_score['group_num'];?></td>
							<td><?php echo "No submit"; ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td><?php echo "0";?></td>
						</tr><?php
					}
				?>
				</tbody>
			</table>
			<br>



			<p>Ranking</p>
			<table class="table table-hover">
				<thead>
					<tr>
						 <th>Rank</th>
						 <th>Group ID</th>
						 <!--
						 <th>Student ID</th>
						 <th><?php //echo "";?></th>
						 <th><?php //echo "";?></th>
						 -->
						 <th>Run time</th>
						 <th>Score</th>
					</tr>
				</thead>
				<tbody>
				<?php
					//查詢lab hw 總題數
					for ($i = 1; $i <= $n; $i++){
						$fetch_rank = mysql_fetch_assoc($rank);
						if ( $fetch_rank['status'] != ""){

							//如果該題有上傳紀錄 顯示最新一次上傳成績與狀態
							if ($fetch_rank['status'] == 'Accepted'){
								?><tr class="accept"><?php
							} else if ($fetch_rank['status'] == 'Compilation error' or $fetch_rank['status'] == 'Runtime error'){
								?><tr class="error"><?php
							} else if ($fetch_rank['status'] == 'Time limit exceed'){
								?><tr class="time_exceed"><?php
							} else if ($fetch_rank['status'] == 'Wrong answer'){
								?><tr class="wrong_answer"><?php
							} else if ($fetch_rank['status'] == 'System upload error'){
								?><tr class="upload_error"><?php
							} ?>
								<td><?php echo $fetch_rank['rank'];?></td>
								<td><?php echo $fetch_rank['group_num'];?></td>

								<?php
								//列出前三高分組別的學生學號
								/*
								if ($i <= 3){
									$id_query = "SELECT account FROM student WHERE group_num = ".$fetch_rank['group_num'];
									$id = mysql_query($id_query);
									for ($p = 0; $p < 3; $p++){
										$fetch_id = mysql_fetch_row($id);
										if ($fetch_id[0] != NULL){?>
											<td><?php echo $fetch_id[0];?></td><?php
										} else {?>
											<td><?php echo " ";?></td><?php
										}
									}
								} else {?>
									<td><?php echo " ";?></td>
									<td><?php echo " ";?></td>
									<td><?php echo " ";?></td><?php
								}*/?>
								<td><?php echo $fetch_rank['exec_time'].'s';?></td>
								<td><?php echo number_format(0.0-(float)$fetch_rank['total_score'],2),'/50';?></td>
							</tr><?php
						} else {
							//如果該題沒有上傳紀錄 顯示No submit
							?><tr>
								<td><?php echo $fetch_rank['rank'];?></td>
								<td><?php echo $fetch_rank['group_num'];?></td>
								<td><?php echo " ";?></td>
								<td><?php echo " ";?></td>
								<td><?php echo " ";?></td>
								<td><?php echo " ";?></td>
								<td><?php echo " ";?></td>
							</tr><?php
						}
					}
				?>
				</tbody>
			</table>
		</div>

<?php
}
?>
