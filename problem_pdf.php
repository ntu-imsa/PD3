<?php
	session_start() ;
	require_once('lib.inc.php');

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		$query_past = "SELECT past_id FROM past_hw";
		$past_id = mysql_query($query_past);

?>

		<div class="hero-unit upload_section">
			<p>Past Problems</p>
			<table class="table table-hover">
				<!--<input type='text' name='past_id' class='past-id' value='<?php echo $_POST['pastID']?>'>-->
				<p><?php echo $_POST['pastID']?></p>
				<embed src='./past/<?php echo $_POST['pastID']?>/<?php echo $_POST['pastID']?>.pdf' height="600" width="820">
				<button type='button' class='btn btn-link btn-large submit-past-btn' name='<?php echo $_POST['pastID']?>'>Submit This Problem!</button>
			</table>

		</div>
		<script src="js/past.js"></script>
<?php
	}
?>
