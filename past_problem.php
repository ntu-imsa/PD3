<?php
	session_start() ;
	require_once('db.inc.php');

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {

?>

		<div class="hero-unit upload_section">
			<h3>Past Problems</h3>

				<?php
				$year = 13;
				$gonext = True;
				$yearcount = 0;
				while ($gonext){
					$query_past = "SELECT past_id FROM past_hw WHERE past_id LIKE 'PD".(string)$year."%'";
					$past_id = mysql_query($query_past);
					if (mysql_num_rows($past_id)){?>
						<h4>PD 20<?php echo $year;?></h4>
						<p>Class Homework</p>
						<table class="table table-hover"><?php
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
						$query_past = "SELECT past_id FROM past_hw WHERE past_id LIKE 'EX".(string)$year."%'";
						$past_id = mysql_query($query_past);
						if (mysql_num_rows($past_id)){?>
							</table>
							<p>Lab Exam</p>
							<table class="table table-hover"><?php
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
						}?>
						</table><?php
						$year++;
					} else {
						$gonext = False;
					}

				}

				?>


		</div>
		<script src="js/past.js"></script>
<?php
	}
?>
