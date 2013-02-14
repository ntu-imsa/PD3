<!DOCTYPE html>
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
		echo 'no session<br>';
	?>
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Program Design Course Site</title>
        <link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <link rel="stylesheet" type="text/css" href="css/sticky-footer.css"  media="screen"/>
		<script src="js/modernizr.custom.63321.js"></script>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
	<body>
	
    
        <div id="wrap">
        <div class="container">
			
			<header>
			
				<h1>Program Design<strong> Online Judge</strong> System</h1>
				<h2>First time visit? Please <span class="signup">Sign Up</span> with your Student ID or <span class="login">Login</span></h2>
				
				<div class="support-note">
					<span class="note-ie">Sorry, only modern browsers.</span>
				</div>
				
			</header>
			<div class="container">
				<iframe class ='main' src="http://free.timeanddate.com/clock/i3i2qw9c/n241/tltw/fn6/tct/pct/tt0/tm1/th1" frameborder="0" width="246" height="21" allowTransparency="true"></iframe>

			<section class="main">
             	<form class="form-1" action="login.php" method = "POST">
					<p class="field">
						<input type="text" name="account" placeholder="Your Student ID ex.b01705001">
						<i class="icon-user icon-large"></i>
					</p>
					<p class="field">
							<input type="password" name="password" placeholder="Password">
							<i class="icon-lock icon-large"></i>
					</p>									
					<p class="submit">
						
						<button type="submit" name="submit"><i class="icon-arrow-right icon-large"></i></button>
					</p>
				</form>
		     </section>
			
        </div>
       </div>
   </div>
   <div id="footer">
      <div class="foot-container">
        <p class="muted credit">© Copyright NTUIM 2013 Spring Program Design Course | All Rights Reserved.</p>
      </div>
    </div>
  		<script src="http://code.jquery.com/jquery.js"></script>
  		<script src="js/signup.js"></script>
    </body>
</html>
	
	<?php
	} else {
	echo 'have session<br>';
	?>
<html>
  <head>
    <title>程式設計批改系統</title>
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/sticky-footer.css" rel="stylesheet" media="screen">
  </head>
  <body>
	<div id="wrap"> <!--把footer推到最底下的div-->

    <div class="container"> 
      <div class="page-header">
         <h2>Program Design Online Judge System</h2>
      </div>
        <div class="navbar">
          <div class="navbar-inner">
            <a class="brand" href="#">PDOJS</a>
              <ul class="nav">
                <li class="active"><a href="index_login.html">Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    課堂作業
                      <b class="caret"></b>
                    </a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li role = "presentation"><a role="menuitem" tabindex="-1" href="upload.html">PD001</a></li>
                    <li role = "presentation"><a role="menuitem" tabindex="-1" href="upload.html">PD002</a></li>
                  </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    實習課作業
                      <b class="caret"></b>
                    </a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li role = "presentation"><a role="menuitem" tabindex="-1" href="upload.html">LAB001</a></li>
                    <li role = "presentation"><a role="menuitem" tabindex="-1" href="upload.html">LAB002</a></li>
                  </ul>
                </li>
                 
                <li><a href="#">查閱成績</a></li>
              </ul>
              <ul class="nav pull-right">
                      <li class="divider-vertical"></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, b96705029<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">修改密碼</a></li>
                          <li class="divider"></li>
                          <li><a href="#">登出</a></li>
                        </ul>
                      </li>
              </ul>
          </div>
        </div>
        <!-- 以下放公告等等的 -->
          <table class="table table-hover">
           <thead>
            <tr>
              <th>上傳題號</th>
              <th>狀態</th>
              <th>exe_time</th>
              <th>上傳時間</th>
            </tr>
         </thead>
         <tbody>
            <tr class="success">
              <td>PD002</td>
              <td>Sucess</td>
              <td>0.5s</td>
              <td>2013/2/13 12:43</td>
            </tr>

            <tr class="warning">
              <td>LAB001</td>
              <td>Compile Error</td>
              <td>0.5s</td>
              <td>2013/2/14 15:43</td>
            </tr>

            <tr class="error">
              <td>PD001</td>
              <td>Runtime Error</td>
              <td>0.5s</td>
              <td>2013/2/14 15:43</td>
            </tr>
            
         </tbody>
            </table>
  </div>
</div>
	<div id="footer">
      <div class="foot-container">
        <p class="muted credit">© Copyright NTUIM 2013 Spring Program Design Course | All Rights Reserved.</p>
      </div>
    </div>
  		<script src="http://code.jquery.com/jquery.js"></script>
  		<script src="js/signup.js"></script>
    </body>
</html>

	<?php
	}
	
	?>