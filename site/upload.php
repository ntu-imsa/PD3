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
?>
<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>程式設計批改系統</title>
      <link href="css/bootstrap.css" rel="stylesheet" media="screen">
      <link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
      <link href="css/sticky-footer.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div id="wrap"> 
    <div class="container">      
      <div class="page-header">
            <h2>Program Design Online Judge System</h2>
      </div>
        <div class="navbar">
          <div class="navbar-inner">
            <a class="brand" href="#">PDOJS</a>
             <ul class="nav">
                <li><a href="index.php">Home</a></li>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    繳交課堂作業
                      <b class="caret"></b>
                    </a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <?php 
						$query_pd = 'SELECT p_id FROM pd_hw';
						$pd = mysql_query($query_pd);
						while ($fetch_pd = mysql_fetch_row($pd)){
							$append = substr('PD000', 0, -strlen($fetch_pd[0]));
							?><li role = "presentation"><a role="menuitem" tabindex="-1" href="upload.php"><?php echo $append.$fetch_pd[0]; ?></a></li><?php
						}
					?>	
                  </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    繳交實習課作業
                      <b class="caret"></b>
                    </a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <?php 
						$query_lab = 'SELECT lab_id FROM lab_hw';
						$lab = mysql_query($query_lab);
						while ($fetch_lab = mysql_fetch_row($lab)){
							$append = substr('LAB000', 0, -strlen($fetch_lab[0]));
							?><li role = "presentation"><a role="menuitem" tabindex="-1" href="upload.php"><?php echo $append.$fetch_lab[0]; ?></a></li><?php
						}
					?>	
                  </ul>
                </li>
                 
                <li><a href="record.php">查閱上傳紀錄</a></li>
              </ul>
              <ul class="nav pull-right">
                      <li class="divider-vertical"></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php echo $_SESSION['account'];?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">修改密碼</a></li>
                          <li class="divider"></li>
                          <li><a href="logout.php">登出</a></li>
                        </ul>
                      </li>
              </ul>
          </div>
        </div>
       
        <!-- 改作業序號看這裡 -->
        <div class="hero-unit upload_section">
          <p> 作業序號放這裡 </p>
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
  
</div>
</div>
    <div id="footer">
      <div class="container">
        <p class="muted credit">© Copyright NTUIM 2013 Spring Program Design Course | All Rights Reserved.</p>
      </div>
    </div>
  <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
   <script src="js/bootstrap-fileupload.min.js"></script>
  </body>
</html>
<?php
	}
?>