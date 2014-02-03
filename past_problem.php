<?php 
	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'root' ;
	$connection = mysql_connect($db_host, $db_username, 'pdogsserver');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;


	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		$query_past = "SELECT past_id FROM past_hw";
		$past_id = mysql_query($query_past);
		
?>      
		
		<div class="hero-unit upload_section">
			<p>Past Problems</p>
			<table class="table table-hover">	
				<?php
				$count = 0;
				while ($fetch_past = mysql_fetch_row($past_id)){ 
					
					if ($count%3 == 0) echo '<tr>';?>
					<td>
						<button type='button' class='btn btn-link btn-large past-btn' name='<?php echo $fetch_past[0]?>'><?php echo $fetch_past[0]; ?></button>
					</td>
					<?php
					if ($count%3 == 2){
						echo '</tr>';
						$count = 0;
					} else {
						$count++;
					}
				}
				?>
			</table>
			
		</div>
		<script src="js/past.js"></script>
<?php
	}
?>