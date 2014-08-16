<?php
	session_start() ;
	require_once('../includes/lib.inc.php');

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
    } else {
?>
	<div class="hero-unit upload_section">
		<form method="POST" action = "TA/create_announce.php" id="fileUploadForm" enctype="multipart/form-data">
			<textarea class="form-control" name="content" rows="15" style="width:100%"></textarea>
			<a class="btn fileupload-exists upload-button" >Submit</a>
		</form>
		<script src="js/upload.js"></script>
	</div>
<?php
	}
?>