<?php
	session_start() ;
	require_once('db.inc.php');

	$pdf = '.\\problem\\'.$_POST['hwID'].'.pdf';
	$testingdata = '.\\judgement\\'.$_POST['hwID'].'\\testing_data.txt';
	$answer = '.\\judgement\\'.$_POST['hwID'].'\\answer.txt';

	//使用者尚未登入 顯示登入頁面
	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
<form method="POST" action = "edit.php" id="fileUploadForm" enctype="multipart/form-data">
	<div class="hero-unit upload_section">
	<p class="hw-id"> 作業序號放這裡 </p>
	<?php 	$len = strlen($_POST['hwID']);
			$num = (int)($_POST['hwID'][$len-3].$_POST['hwID'][$len-2].$_POST['hwID'][$len-1]);
			if ($len == 5)
				$query = "SELECT submit_code, submit_pdf, total_score, deadline FROM pd_hw WHERE p_id = '".$num."'";
			else if ($len == 6)
				$query = "SELECT submit_code, submit_pdf, total_score, deadline FROM lab_hw WHERE lab_id = '".$num."'";
			$status = mysql_query($query);
			$fetch_status = mysql_fetch_row($status);
	?>
	<p class="hw"> Problem </p>
	<p class="hw"> File format: .pdf </p>
	<?php	if (file_exists($pdf))
				echo "<p> Problem has been uploaded . </p>";
			else
				echo "<p> You haven't uploaded yet. </p>"; ?>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3">
					<i class="icon-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
	  			</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change File</span>
					<input type="file" class="pdfupload" name="pdfupload"/>
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
			</div>
		</div>
		<br>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="submitcode" value="1"
				<?php if ($fetch_status[0] == 1)
					echo "checked";   ?>
				> Submit code
			</label>
			<label>
				<input type="checkbox"  name="submitpdf" value="1"
				<?php if ($fetch_status[1] == 1)
					echo "checked";   ?>
				> Submit pdf
			</label>
		</div>
		<br>
    	<p class="hw"> Total Score </p>
    	<input class="form-control" id="focusedInput" type="text" value="<?php echo $fetch_status[2]; ?>" name="score">
    	<br>
    	<br>
    	<p class="hw"> Testing Data </p>
		<p class="hw"> File format: .txt </p>
		<?php	if (file_exists($testingdata))
				echo "<p> Testing Data has been uploaded. </p>";
			else
				echo "<p> You haven't uploaded yet. </p>"; ?>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3">
					<i class="icon-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
	  			</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change File</span>
					<input type="file" class="tdupload" name="tdupload"/>
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
			</div>
		</div>
		<br>
    	<p class="hw"> Answer</p>
		<p class="hw"> File format: .cpp </p>
		<?php	if (file_exists($answer))
				echo "<p> Answer has been uploaded. </p>";
			else
				echo "<p> You haven't uploaded yet. </p>"; ?>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3">
					<i class="icon-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
	  			</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change File</span>
					<input type="file" class="ansupload" name="ansupload">
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
			</div>
		</div>
		<a class="btn fileupload-exists upload-button" >Edit</a>

</form>

<?php
	}
?>
