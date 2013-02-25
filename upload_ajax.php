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
		<form method="POST" action="result.php" id="fileUploadForm" enctype="multipart/form-data">
			<div class="hero-unit upload_section">
				<p class="hw-id"> 作業序號放這裡 </p>		  
				<p> File format: .c or .cpp </p>
				<p> File size: max 3MBs</p>
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
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						<a class="btn fileupload-exists upload-button" >Upload</a>
					</div>
				</div>
			</div>
		</form>
		<script src="js/spin.js" type="text/javascript"></script>
		<script src="js/upload.js"></script>
<?php
	}
?>