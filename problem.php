<?php
	session_start() ;
  require_once('includes/lib.inc.php');

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		$query_pd = "SELECT p_id FROM pd_hw";
		$pd_id = mysql_query($query_pd);

		$query_lab = "SELECT lab_id FROM lab_hw";
		$lab_id = mysql_query($query_lab);

?>

		<div class="hero-unit upload_section">
			<p>PD Problems</p>
			<table class="table table-hover">
				<?php
				$count = 0;
				while ($fetch_pd = mysql_fetch_row($pd_id)){
					if ($count%3 == 0) echo '<tr>';?>
					<td><a href='./problem/<?php echo $fetch_pd[0]; ?>.pdf' target='_blank'><?php echo $fetch_pd[0]; ?></a></td>
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
			<p>LAB Problems</p>
			<table class="table table-hover">
				<?php
				$count = 0;
				while ($fetch_lab = mysql_fetch_row($lab_id)){
					if ($count%3 == 0) echo '<tr>';?>
					<td><a href='./problem/<?php echo $fetch_lab[0]; ?>.pdf' target='_blank'><?php echo $fetch_lab[0]; ?></a></td>
					<?php
					if ($count%3 == 2){
						echo '</tr>';
						$count = 0;
					} else {
						$count++;
					}
				}
				if ($count < 2) echo '</tr>';
				?>
			</table>
		</div>

<?php
	}
?>
