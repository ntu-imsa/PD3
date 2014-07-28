<?php
	session_start() ;
	require_once('lib.inc.php');

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
		<div class="hero-unit upload_section">
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

					$query_pd = "SELECT p_id, status, exec_time, time, score FROM pd_score NATURAL JOIN student
								 WHERE account = '".mysql_real_escape_string($_SESSION['account'])."' ORDER BY time DESC LIMIT 0, 15";
					$pd = mysql_query($query_pd);
					$query_lab = "SELECT lab_id, status, exec_time, time, score FROM lab_score NATURAL JOIN student
								 WHERE account = '".mysql_real_escape_string($_SESSION['account'])."' ORDER BY time DESC LIMIT 0, 15";
					$lab = mysql_query($query_lab);
					$count = 0;
					$fetch_pd = mysql_fetch_row($pd);
					$fetch_lab = mysql_fetch_row($lab);
					while ( $count < 15 ){
						if ($fetch_pd[3] > $fetch_lab[3]){
							if ($fetch_pd[1] == 'Accepted'){
								?><tr class="accept"><?php
							} else if ($fetch_pd[1] == 'Compilation error' or $fetch_pd[1] == 'Runtime error'){
								?><tr class="error"><?php
							}  else if ($fetch_pd[1] == 'Time limit exceed'){
								?><tr class="time_exceed"><?php
							} else if ($fetch_pd[1] == 'Wrong answer'){
								?><tr class="wrong_answer"><?php
							} else if ($fetch_pd[1] == 'System upload error'){
								?><tr class="upload_error"><?php
							} ?>
								<td><?php echo $fetch_pd[0];?></td>
								<td><?php echo $fetch_pd[1];?></td>
								<td><?php echo $fetch_pd[2].'s';?></td>
								<td><?php echo $fetch_pd[3];?></td>
								<td><?php echo $fetch_pd[4];?></td>
							</tr> <?php
							$fetch_pd = mysql_fetch_row($pd);
						} else {
							if ($fetch_lab[1] == 'Accepted'){
								?><tr class="accept"><?php
							} else if ($fetch_lab[1] == 'Compilation error' or $fetch_lab[1] == 'Runtime error'){
								?><tr class="error"><?php
							}  else if ($fetch_lab[1] == 'Time limit exceed'){
								?><tr class="time_exceed"><?php
							} else if ($fetch_lab[1] == 'Wrong answer'){
								?><tr class="wrong_answer"><?php
							} else if ($fetch_lab[1] == 'System upload error'){
								?><tr class="upload_error"><?php
							} ?>
								<td><?php echo $fetch_lab[0];?></td>
								<td><?php echo $fetch_lab[1];?></td>
								<td><?php echo $fetch_lab[2].'s';?></td>
								<td><?php echo $fetch_lab[3];?></td>
								<td><?php echo $fetch_lab[4];?></td>
							</tr> <?php
							$fetch_lab = mysql_fetch_row($lab);
						}
						$count++;
						if ($fetch_pd == null and $fetch_lab == null)
							break;
					}
				?>
				</tbody>
			</table>
		</div>

<?php
	}
?>
