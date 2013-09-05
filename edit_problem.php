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

	
	//使用者尚未登入 顯示登入頁面
	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
<html>
<head>
	<link href="css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
	<link href="css/sticky-footer.css" rel="stylesheet" media="screen">
	<link href="css/main.css" rel="stylesheet" media="screen">
	<link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
</head>
	<body>
	<div class="hero-unit upload_section">
	<p><?php $_POST['edit'] ;?></p>
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
					<input type="file" class="upload" name="upload"/>
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				<a class="btn fileupload-exists upload-button" >Upload</a>
			</div>
		</div>
		<br>
		<div class="checkbox">
      		<label>
        	<input type="checkbox" name="submit[]" value="1"> Submit code
      		</label>   
      		<label>
        	<input type="checkbox"  name="submit[]" value="1"> Submit pdf
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
					<input type="file" class="upload" name="upload"/>
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				<a class="btn fileupload-exists upload-button" >Upload</a>
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
					<input type="file" class="upload" name="upload">
				</span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				<a class="btn fileupload-exists upload-button" >Upload</a>
			</div>
		</div>
		<input class="btn btn-default" type="submit" value="Create">
			

	</div>
<?php
	}
?>