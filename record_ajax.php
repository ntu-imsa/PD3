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
				$query_rec = "SELECT p_id, status, exec_time, time, score FROM pd_score NATURAL JOIN student 
				              WHERE account = '".$_SESSION['account']."' ORDER BY time DESC";
				$rec = mysql_query($query_rec);
				while ($fetch_rec = mysql_fetch_row($rec)){
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
			<?php
				}		
			?>
			</tbody>
		</table>
		<div id="footer">
			<div class="container">
				<p class="muted credit">© Copyright NTUIM 2013 Spring Program Design Course | All Rights Reserved.</p>
			</div>
		</div>
<?php		
	}
?>