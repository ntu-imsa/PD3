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
	
	//使用者尚未登入 顯示登入頁面
	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
	<div class="hero-unit upload_section">
	<p>PD Problems</p>
	<table class="table table-hover">
		<?php
		?>
				<thead>
					<tr>
						 <th>Problem</th>
						 <th>Submit code</th>
						 <th>Submit pdf</th>
						 <th>Total score</th>
						 <th>Deadline</th>
						 <th>Edit</th>						 
					</tr>
				</thead>
				<tbody>
					<?php
						$query_p = "SELECT p_id, submit_code, submit_pdf, total_score, deadline FROM pd_hw";
						$p_id = mysql_query($query_p);
						while ($fetch_p = mysql_fetch_row($p_id))
						{ 					
							echo '<tr>';
							for($i = 0; $i<5; $i++)
							{
								echo '<td>';
								if($i == 0)
								{
									$append = substr('PD000', 0, -strlen($fetch_p[0]));
									echo $append;
									echo $fetch_p[0];
								}else if($i == 1)
								{
									if($fetch_p[$i] == 1)
										echo "v";
								}else if($i == 2)
								{
									if($fetch_p[$i] == 1)
										echo "v";
								}else
									echo $fetch_p[$i];
								echo '</td>';								
							}
							echo '<td>'; ?>
								<a href= "#" class = "editproblem-btn" name = "<?php echo $append.$fetch_p[0]; ?>">Edit</a>
							
					<?php 
							echo '</td>';
							echo '<tr>';						
						}
					?>					
				</tbody>
		</table>
		<br>
		<p>LAB Problems</p>
		<table class="table table-hover">
		<?php
		?>
				<thead>
					<tr>
						 <th>Problem</th>
						 <th>Submit code</th>
						 <th>Submit pdf</th>
						 <th>Total score</th>
						 <th>Deadline</th>
						 <th>Edit</th>						 
					</tr>
				</thead>
				<tbody>
					<?php
						$query_l = "SELECT lab_id, submit_code, submit_pdf, total_score, deadline FROM lab_hw";
						$l_id = mysql_query($query_l);
						while ($fetch_l = mysql_fetch_row($l_id))
						{ 					
							echo '<tr>';
							for($i = 0; $i<5; $i++)
							{
								echo '<td>';
								if($i == 0)
								{
									$append = substr('LAB000', 0, -strlen($fetch_l[0]));
									echo $append;
									echo $fetch_l[0];
								}else if($i == 1)
								{
									if($fetch_l[$i] == 1)
										echo "v";
								}else if($i == 2)
								{
									if($fetch_l[$i] == 1)
										echo "v";
								}else
									echo $fetch_l[$i];
								echo '</td>';								
							}
							echo '<td>';?>
								<a href= "#" class = "editproblem-btn" name = "<?php echo $append.$fetch_l[0]; ?>">Edit</a>							
					<?php 
							echo '</td>';
							echo '<tr>';						
						}
					?>					
				</tbody>
		</table>
	</div>
	<script src="js/nav.js"></script>	
<?php
	}
?>