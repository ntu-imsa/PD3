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
					
					$query_rec = "SELECT p_id, status, exec_time, time, score FROM pd_score NATURAL JOIN student 
								 WHERE account = '".mysql_real_escape_string($_SESSION['account'])."' ORDER BY time DESC LIMIT 0, 15";
					
					$rec = mysql_query($query_rec);
					while ($fetch_rec = mysql_fetch_row($rec)){
						$append = substr('PD000', 0, -strlen($fetch_rec[0]));
						if ($fetch_rec[1] == 'Accepted'){
							?><tr class="accept"><?php
						} else if ($fetch_rec[1] == 'Compilation error' or $fetch_rec[1] == 'Runtime error'){
							?><tr class="error"><?php
						}  else if ($fetch_rec[1] == 'Time limit exceed'){
							?><tr class="time_exceed"><?php
						} else if ($fetch_rec[1] == 'Wrong answer'){
							?><tr class="wrong_answer"><?php
						} else if ($fetch_rec[1] == 'System upload error'){
							?><tr class="upload_error"><?php
						} ?>
							<td><?php echo $append.$fetch_rec[0];?></td>
							<td><?php echo $fetch_rec[1];?></td>
							<td><?php echo $fetch_rec[2].'s';?></td>
							<td><?php echo $fetch_rec[3];?></td>
							<td><?php echo $fetch_rec[4];?></td>
						</tr>
				<?php
					}		
				?>
				</tbody>
			</table>
		</div>
		
<?php		
	}
?>