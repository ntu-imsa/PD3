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

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {

		$problem_dir = '.\\problem\\'.$_POST['problem_num']; 
		$pdf = $problem_dir.'\\'.$_POST['problem_num'].'.pdf';
		$testingdata = $problem_dir.'\\'.$_POST['problem_num'].'.txt';
		$answer = $problem_dir.'\\'.$_POST['problem_num'].'.cpp';
?>
		<div class="hero-unit upload_section">
	<?php
		if (isset($_FILES['pdfupload'])){
			if (file_exists($pdf)) unlink($pdf);
			move_uploaded_file($_FILES['pdfupload']['tmp_name'], $pdf);
			echo "PDF is uploaded. <br>";

		}
		if (isset($_FILES['tdupload'])){
			if (file_exists($testingdata)) unlink($testingdata);
			move_uploaded_file($_FILES['tdupload']['tmp_name'], $testingdata);
			echo "Testing Data is uploaded. <br>";
		}
		if (isset($_FILES['ansupload'])){
			if (file_exists($answer)) unlink($answer);
			move_uploaded_file($_FILES['ansupload']['tmp_name'], $answer);
			echo "Answer is uploaded. <br>";
		}

			$submitcode = @$_POST ['submitcode']; 
			$submitpdf = @$_POST ['submitpdf']; 
			$score = $_POST ['score'];
			$len = strlen($_POST['problem_num']);
			$num = (int)($_POST['problem_num'][$len-3].$_POST['problem_num'][$len-2].$_POST['problem_num'][$len-1]);

		if ($len == 5){
			$update = "UPDATE pd_hw 
					SET submit_code = '$submitcode', submit_pdf = '$submitpdf', total_score = '$score'
					WHERE p_id = '".$num."' " ;
		}else if ($len == 6){
			$update = "UPDATE lab_hw 
					SET submit_code = '$submitcode', submit_pdf = '$submitpdf', total_score = '$score'
					WHERE lab_id = '".$num."' " ;
		}
		$success = mysql_query($update);
		?>
			<p><?php echo $_POST['problem_num'] ?> is updated !</p>
		</div>

<?php
	}
?>
