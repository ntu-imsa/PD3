<?php
	session_start() ;
	require_once('lib.inc.php');

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");




	//使用者尚未登入 顯示登入頁面
	if (!isset($_SESSION['account'])){
?>
		<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Programming Design Online Grading System Ver 2.0</title>
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
							<h1><strong>PDOGS</strong> Programming Design Online Grading System</h1>
							<h2>First time visit? Please <span class="signup">Sign Up</span> with your Student ID or <span class="login">Login</span></h2>
							<?php
								if (isset($_GET['msg'])){
									$msg = array(
										"fail" => 'Login failed !<br>',
										"empty" => 'Enter your account or password !<br>',
										"same" => 'Confirm the password !<br>',
										"err" => 'Account already exist !<br>',
										"sucess" => 'Register success !<br>'
									);
									if(isset( $msg[ $_GET['msg'] ] )){
										echo $msg[$_GET['msg']];
									}
								}
							?>
							<div class="support-note">
								<span class="note-ie">Sorry, only modern browsers are supported.</span>
							</div>
						</header>
						<div class="container">

							<iframe class ="main" src="time.php"
								frameborder="0" width="246" height="21" allowTransparency="true">
							</iframe>

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
						<div  class="container">
                            <img id="dog_img" src="images/dogs3.jpg" />
					    </div>
					</div>
				</div>
				<div id="footer">
					<div class="foot-container">
						<p class="muted credit">© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p>
					</div>
				</div>
				<!--<script src="http://code.jquery.com/jquery.js"></script>-->
				<script src="js/jquery.js"></script>
				<script src="js/signup.js"></script>
			</body>
		</html>

<?php
	}else{
		$query = "SELECT type FROM student WHERE account = :acc";
		$db = getDatabaseConnection();
		$stmt = $db->prepare($query);
		$stmt->execute(
			array(
				":acc" => $_SESSION['account']
			)
		);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		if( $result['type'] == 1 or $result['type'] == 2) {   //使用者登入成功 顯示PDOGS主頁面
		//echo 'have session<br>';
	?>
			<!DOCTYPE html>
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>Programming Design Online Grading System</title>
					<link href="css/bootstrap.css" rel="stylesheet" media="screen">
					<link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
					<link href="css/sticky-footer.css" rel="stylesheet" media="screen">
					<link href="css/main.css" rel="stylesheet" media="screen">
					<link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
				</head>
				<body>
					<div id="wrap">
						<div class="container">
							<div class="page-header">
								<h2>Programming Design Online Grading System</h2>
							</div>
							<div class="navbar">
								<div class="navbar-inner">
									<a class="brand" href="/PD/index.php">PDOGS</a>
									<ul class="nav">
										<!--
										<li id="home-btn" class="active"><a>Home</a></li>
										-->

										<li id="problem-btn"><a>Problem Set</a></li>

										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Submit Homework<b class="caret"></b></a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
											<?php
												$query_pd = 'SELECT `p_id` FROM `pd_hw` WHERE `deadline` > NOW() ORDER BY `p_id`';
												$stmt = $db->query($query_pd);
												$fetch_pd = $stmt->fetchAll(PDO::FETCH_ASSOC);

												$query_lab = 'SELECT `lab_id` FROM `lab_hw` WHERE `deadline` > NOW() ORDER BY `lab_id`';
												$stmt = $db->query($query_lab);
												$fetch_lab = $stmt->fetchAll(PDO::FETCH_ASSOC);

												foreach($fetch_pd as $row){
														?><li class="hw-btn" role = "presentation" name="<?php echo $row['p_id']; ?>">
														<a role="menuitem"  tabindex="-1" ><?php echo $row['p_id']; ?></a></li> <?php
												}

												if(!empty($fetch_lab)){
													echo '<li class="divider" role = "presentation"></li>';
												}

												foreach($fetch_lab as $row){
														?><li class="lab-btn" role = "presentation" name="<?php echo $row['lab_id']; ?>">
														<a role="menuitem" tabindex="-1" ><?php echo $row['lab_id']; ?></a></li><?php
												}

												if ( empty($fetch_pd) and empty($fetch_lab) ){
													?><li role = "presentation"><a role="menuitem" tabindex="-1" >No problem available</a></li><?php
												}
											?>
											</ul>
										</li>

										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Project<b class="caret"></b></a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
											<?php
												$query_project = 'SELECT `deadline` FROM `project` WHERE `onjudge` = 1 AND `deadline` > NOW()';
												$stmt = $db->query($query_project);
												$fetch_project = $stmt->fetch(PDO::FETCH_ASSOC);
												if ( !empty($fetch_project) ){?>
												<li class="project-btn" role = "presentation" name="Submit">
													<a role="menuitem" tabindex="-1" >Submit</a>
												</li><?php
												}
											?>
												<li class="project-btn" role = "presentation" name="Ranking">
													<a role="menuitem" tabindex="-1" >Ranking</a>
												</li>
											</ul>
										</li>

										<li id="record-btn"><a>Records</a></li>

										<li id="score-btn"><a>Scores</a></li>

										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">TA<b class="caret"></b></a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dlabel">
												<li class="createproblem-btn" role = "presentation" name="submit">
													<a role="menuitem" tabindex="-1" >Create Problem</a>
												</li>
											</ul>
										</li>

									</ul>



									<ul class="nav pull-right">
										<li class="divider-vertical"></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php echo $_SESSION['account'];?><b class="caret"></b></a>
											<ul class="dropdown-menu">
											<li><a href="profile.php">Past Problems</a></li>
											<li><a id="chg-pass-btn" href="#">Change Password</a></li>
											<li class="divider"></li>
											<li><a href="logout.php">Logout</a></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
							<div id="load" >
								<span class="spin"><i class="icon-spinner icon-spin icon-2x pull-left"></i>Loading... </span>
							</div>

							<!-- 使用ajax刷新 將所有各功能頁面更新於此div區塊 -->
							<div id="main-content">
								<?php require('home.php'); ?>
							</div>
						</div>
					</div>
					<div id="footer">
						<div class="container">
							<p class="muted credit">© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p>
						</div>
					</div>
					<div id="footer2">
					</div>
				</body>
				<!--<script src="http://code.jquery.com/jquery.js"></script>-->
				<script src="js/jquery.js"></script>
				<script src="js/bootstrap.min.js"></script>
				<script src="js/bootstrap-fileupload.min.js"></script>
				<script src="js/jquery.form.js"></script>
				<script src="js/nav.js"></script>
				<script src="js/upload.js"></script>
			</html>
	<?php
		} else if ($result['type'] == 0 ) {
	    //使用者登入成功 顯示PDOGS主頁面
		//進入助教頁面
		//echo 'have session<br>';
	?>
			<!DOCTYPE html>
			<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>Programming Design Online Grading System</title>
					<link href="css/bootstrap.css" rel="stylesheet" media="screen">
					<link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
					<link href="css/sticky-footer.css" rel="stylesheet" media="screen">
					<link href="css/main.css" rel="stylesheet" media="screen">
					<link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
				</head>
				<body>
					<div id="wrap">
						<div class="container">
							<div class="page-header">
								<h2>Programming Design Online Grading System</h2>
							</div>
							<div class="navbar">
								<div class="navbar-inner">
									<a class="brand" href="/PD/index.php">PDOGS</a>
									<ul class="nav">
										<!--
										<li id="home-btn" class="active"><a>Home</a></li>
										-->
										<li id="users-btn"><a>Users</a></li>

										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Create Problem<b class="caret"></b></a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
												<?php
													$query_pd = 'SELECT p_id FROM pd_hw ORDER BY p_id';
													$pd = mysql_query($query_pd);
													$max = 0 ;
													while ($fetch_pd = mysql_fetch_row($pd)){
														$max ++ ;
													}
													$append = substr('PD000', 0, -strlen($max+1));

													$query_lab = 'SELECT lab_id FROM lab_hw ORDER BY lab_id';
													$lab = mysql_query($query_lab);
													$max2 = 0 ;
													while ($fetch_lab = mysql_fetch_row($lab)){
														$max2 ++ ;
													}
													$append2 = substr('LAB000', 0, -strlen($max2+1));
												?>
												<li class="createproblem-btn" role = "presentation" name="<?php echo $append.($max +1); ?>">
													<a role="menuitem"  tabindex="-1" ><?php echo $append.($max +1); ?></a>
												</li>
												<li class="createproblem-btn" role = "presentation" name="<?php echo $append2.($max2 +1); ?>">
													<a role="menuitem"  tabindex="-1" ><?php echo $append2.($max2 +1); ?></a>
												</li>
											</ul>
										</li>
									    <li id="problemlist-btn"><a>Problem List</a></li>
									    <li id="users-btn"><a>Upload Records</a></li>
									    <li id="users-btn"><a>All Scores</a></li>
									</ul>
									<ul class="nav pull-right">
										<li class="divider-vertical"></li>
										<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi, <?php echo $_SESSION['account'];?><b class="caret"></b></a>
											<ul class="dropdown-menu">
											<li><a href="#">Change Password</a></li>
											<li class="divider"></li>
											<li><a href="logout.php">Logout</a></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
							<div id="load" >
								<span class="spin"><i class="icon-spinner icon-spin icon-2x pull-left"></i>Loading... </span>
							</div>

							<!-- 使用ajax刷新 將所有各功能頁面更新於此div區塊 -->
							<div id="main-content">

							</div>
						</div>
					</div>
					<div id="footer">
						<div class="container">
							<p class="muted credit">© Copyright NTUIM 2013 Spring Programming Design Course | All Rights Reserved.</p>
						</div>
					</div>
					<div id="footer2">
					</div>
				</body>
				<!--<script src="http://code.jquery.com/jquery.js"></script>-->
				<script src="js/jquery.js"></script>
				<script src="js/bootstrap.min.js"></script>
				<script src="js/bootstrap-fileupload.min.js"></script>
				<script src="js/jquery.form.js"></script>
				<script src="js/nav.js"></script>
				<script src="js/upload.js"></script>
			</html>
<?php
		}
	}
?>
