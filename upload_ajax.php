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
	
	$acc = mysql_real_escape_string($_SESSION['account']);
	$problem_dir = '.\\student\\'.$acc.'\\'.$_POST['hwID']; 
	$upfile = $problem_dir.'\\'.$acc.'-'.$_POST['hwID'].'.cpp';
	$pdffile = $problem_dir.'\\'.$acc.'-'.$_POST['hwID'].'.pdf';

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>      
		<form method="POST" action="result.php" id="fileUploadForm" enctype="multipart/form-data">
			<div class="hero-unit upload_section">
				<p class="hw-id"> 作業序號放這裡 </p> <?php 
				$len = strlen($_POST['hwID']);
				$num = (int)($_POST['hwID'][$len-3].$_POST['hwID'][$len-2].$_POST['hwID'][$len-1]);
				if ($len == 5)
					$query = "SELECT submit_code, submit_pdf FROM pd_hw WHERE p_id = '".$num."'";
				else if ($len == 6) 
					$query = "SELECT submit_code, submit_pdf FROM lab_hw WHERE lab_id = '".$num."'";
				$submit = mysql_query($query);
				$fetch_submit = mysql_fetch_row($submit);
				if ($fetch_submit[0] == true){ //需要上傳cpp檔 ?>
					<p class="hw"> File format: .c or .cpp </p>
					<p class="hw"> File size: max 3MBs</p>
					<div class="fileupload fileupload-new" data-provides="fileupload"> <?php
						if (file_exists($upfile)){ ?>
							<div>
								<a href="download_file.php? num= <?php echo $_POST['hwID'];?>&type=cpp" target="_blank">Submitted cpp file</a><br>
							</div> <?php 
						} ?>
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
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
							<a class="btn fileupload-exists upload-button" >Upload</a>
						</div>
					</div> <?php
				}
				if ($fetch_submit[1] == true){ //需要上傳pdf檔?>
					<p class="hw"> File format: .pdf </p>
					<p class="hw"> File size: max 3MBs</p>
					<div class="fileupload fileupload-new" data-provides="fileupload"> <?php
						if (file_exists($pdffile)){ ?>
							<div>
								<a href="download_file.php?num=<?php echo $_POST['hwID'];?>&type=pdf" target="_blank">Submitted pdf file</a>
							</div> <?php 
						} ?>
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
							<a class="btn fileupload-exists upload-button" >Upload</a>
						</div>
					</div> <?php 
					
				} ?>
			</div>
		</form>
		<script src="js/upload.js"></script>
<?php
	}
?>