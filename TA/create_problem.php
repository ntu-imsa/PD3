<?php 
	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'pd course' ;
	$db_username = 'pdogsserver' ;
	$connection = mysql_connect($db_host, $db_username, 'pdogsserver');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;
	
	$acc = mysql_real_escape_string($_SESSION['account']);

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>    
	<form method="POST" action = "create.php" id="fileUploadForm" enctype="multipart/form-data">	  
	<div class="hero-unit upload_section">
		<p class="hw-id"> 作業序號放這裡 </p>
		<p class="hw"> Problem </p>
		<p class="hw"> File format: .pdf </p>
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
        	<input type="checkbox" name="submitcode" value="1"> Submit code
      		</label>   
      		<label>
        	<input type="checkbox"  name="submitpdf" value="1"> Submit pdf
      		</label>      		   		
    	</div>
    	<br>
    	<p class="hw"> Total Score </p>
    	<input class="form-control" id="focusedInput" type="text" placeholder="Total Score" name="score">
    	<br>
    	<br>
    	<p class="hw"> Testing Data </p>
		<p class="hw"> File format: .txt </p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3">
					<i class="icon-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
	  			</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change File</span>					
					<input type="file" class="upload" name="tdupload"/>
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>

			</div>
		</div>
		<br>
    	<p class="hw"> Answer</p>
		<p class="hw"> File format: .cpp </p>
		<div class="fileupload fileupload-new" data-provides="fileupload">
			<div class="input-append">
				<div class="uneditable-input span3">
					<i class="icon-file fileupload-exists"></i>
					<span class="fileupload-preview"></span>
	  			</div>
				<span class="btn btn-file">
					<span class="fileupload-new">Select file</span>
					<span class="fileupload-exists">Change File</span>					
					<input type="file" class="upload" name="ansupload">
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>

			</div>
		</div>
		<a class="btn fileupload-exists upload-button" >Create</a>
		
	</form>
	
<?php 
	} 
?>
