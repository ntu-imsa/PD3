<?php
	session_start() ;
	require_once('includes/lib.inc.php');

	$acc = mysql_real_escape_string($_SESSION['account']);
	$ID = isset($_POST['pastID']);

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
		<form method="POST" action="result_past.php" id="fileUploadForm" enctype="multipart/form-data">
			<div class="hero-unit upload_section">
				<h4> Submit Problem ID: </h4>
				<input type='text' name='past_id' class='past_id' value='<?php if ($ID) {echo $_POST['pastID'];}?>'>
				<h4 class="hw"> File format: .c or .cpp </h4>
				<h4 class="hw"> File size: max 3MBs</p>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input span3">
								<i class="icon-file fileupload-exists"></i>
								<span class="fileupload-preview"></span>
							</div>
							<span class="btn btn-file">
								<span class="fileupload-new">Select file</span>
								<span class="fileupload-exists">Change File</span>
								<input type="file" class="upload" name="upload"/>
							</span>
							<a class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
							<a class="btn fileupload-exists upload-button" >Upload</a>
						</div>
					</div>
			</div>
		</form>
		<script src="js/upload.js"></script>
<?php
	}
?>
