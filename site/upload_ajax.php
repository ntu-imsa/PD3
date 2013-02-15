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

	if (isset ($_GET['err']))
		echo 'the account has been used!<br>';
	if (isset ($_GET['success']))
		echo 'Register success!<br>';
	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>      <!-- 改作業序號看這裡 -->
        <div class="hero-unit upload_section">
          <p class="hw-id"> 作業序號放這裡 </p>
         <div class="fileupload fileupload-new" data-provides="fileupload">
          <div class="input-append">
            <div class="uneditable-input span3">
              <i class="icon-file fileupload-exists"></i>
              <span class="fileupload-preview"></span>
            </div>
              <span class="btn btn-file">
                <span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span>
                <input type="file">
              </span>
              <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
          </div>
      </div>
    </div>
   <script src="js/bootstrap-fileupload.min.js"></script>
<?php
	}
?>