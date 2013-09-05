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

		if (!is_dir($problem_dir))
			mkdir($problem_dir);
		?>
		<div class="hero-unit upload_section">
			<table>
				<tbody>
		<?php
		if (isset($_FILES['pdfupload'])){
			move_uploaded_file($_FILES['pdfupload']['tmp_name'], $pdf);
			$yes1 = 1 ;
		}	
		else{ 
			echo "G_G!!  You didn't upload pdf file.";
			echo "<br>";
			$yes1 = 0 ;
		}
		if (isset($_FILES['tdupload'])){
			move_uploaded_file($_FILES['tdupload']['tmp_name'], $testingdata);
			$yes2 = 1 ;
		}
		else{
			echo "G_G!!  You didn't upload testing data.";
			echo "<br>";
			$yes2 = 0 ;
		} 
		if (isset($_FILES['ansupload'])){
			move_uploaded_file($_FILES['ansupload']['tmp_name'], $answer);
			$yes3 = 1 ;
		}
		else{ 
			echo "G_G!!  You didn't upload answer.";
			$yes3 = 0 ;
		} ?>
				</tbody>
			</table>

		<?php
			$submitcode = @$_POST ['submitcode']; 
			$submitpdf = @$_POST ['submitpdf']; 
			$score = $_POST ['score'];
			$len = strlen($_POST['problem_num']);
			$hw_id = substr($_POST['problem_num'],-2);
			if ($len == 5){
				$insert = "INSERT INTO pd_hw(p_id, submit_code, submit_pdf, total_score, pdf, testing_data, answer) 
							VALUES ('$hw_id', '$submitcode', '$submitpdf', '$score','$yes1', '$yes2', '$yes3')" ;
			}
			else if ($len == 6){					
				$insert = "INSERT INTO lab_hw(lab_id, submit_code, submit_pdf, total_score, pdf, testing_data, answer) 
							VALUES ('$hw_id', '$submitcode', '$submitpdf', '$score', $yes1', '$yes2', '$yes3' )" ;
			}
			$success = mysql_query($insert);		

	}

	if (isset($_FILES['pdfupload']) or isset($_FILES['tdupload']) or isset($_FILES['ansupload'])){
?>	<!-- 改作業序號看這裡 -->
					<br>
					<p><?php echo $_POST['problem_num'] ?> is created !</p>
				</div>
<?php
	}
	else{  ?>					
					<br>
					<p>G_G!! Please try again</p>
				</div>	
<?php
	}
?>
