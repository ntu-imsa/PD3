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
?>
		<!DOCTYPE html>
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
						<?php if (isset ($_GET['fail'])) echo 'Login fail !<br>'; ?>
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
	//echo 'have session<br>';
?>
		<!DOCTYPE html>
		<html>
			<head>
				<title>程式設計批改系統</title>
				<link href="css/bootstrap.css" rel="stylesheet" media="screen">
				<link href="css/sticky-footer.css" rel="stylesheet" media="screen">
				<link href="css/main.css" rel="stylesheet" media="screen">
				<link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
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
						<li id="home-btn" class="active"><a>Home</a></li>
						<li class="dropdown">
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
									?><li class="hw-btn" role = "presentation"><a role="menuitem"  tabindex="-1" ><?php echo $append.$fetch_pd[0]; ?></a></li><?php
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
									?><li class="lab-btn" role = "presentation"><a role="menuitem" tabindex="-1" ><?php echo $append.$fetch_lab[0]; ?></a></li><?php
								}
							?>	
						  </ul>
						</li>
						 
						<li id="record-btn"><a>查閱上傳紀錄</a></li>
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
				<!-- 以下放公告等等的 -->
				  <div id="main-content">
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
			<script src="js/nav.js"></script>

		  </body>
		</html>
<?php
	}
?>