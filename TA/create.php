<?php
	session_start() ;
	require_once('../includes/lib.inc.php');

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
    } else {
		$pid = $_POST['p-id'];
		$problem_dir = "..\\judgement\\$pid";
		$pdf = "..\\problem\\$pid.pdf";
		$testdata = "$problem_dir\\$pid";
		$num = (int)$_POST['datanum'];

		if (!is_dir($problem_dir))
			mkdir($problem_dir);
?>
	<div class="hero-unit upload_section">
<?
		if (isset($_FILES['pdfupload']))
			move_uploaded_file($_FILES['pdfupload']['tmp_name'], $pdf);
		$hidden = array_fill(0, $num, 1);
		if (isset($_POST['tdhid'])) {
			foreach ($_POST['tdhid'] as $x)
				$hidden[$x] = 0;
		}
		$total = 0;
		$file = fopen("$problem_dir\\testing_data.txt", "w");
		for ($i = 0; $i < $num; $i++) {
			fwrite($file, "10 ".$_POST['score'][$i+1]." ".$hidden[$i]."\n");
			$total += (int)$_POST['score'][$i+1];
			move_uploaded_file($_FILES['tdinput']['tmp_name'][$i], "$testdata.$i.in");
			move_uploaded_file($_FILES['tdoutput']['tmp_name'][$i], "$testdata.$i.out");
		}
		fclose($file);


		$submitcode = isset($_POST ['submitcode']) ? 1 : 0;
		$submitpdf = isset($_POST ['submitpdf']) ? 1 : 0;
		$type = $_POST['type'];
		$deadline = $_POST['deadline'];
		$table = ($pid[0] == 'P' ? "pd_hw" : "lab_hw");

		$db = getDatabaseConnection();
		$query = "INSERT INTO :table VALUES(:pid, :submitcode, :submitpdf, :num, :type, :total, :deadline)";
		$stmt = $db->prepare($query);
		$stmt->execute(
			array(
				"table" => $table,
				"pid" => $pid,
				"submitcode" => $submitcode,
				"submitpdf" => $submitpdf,
				"num" => $num,
				"type" => $type,
				"total" => $total,
				"deadline" => $deadline
			)
		);
?>
			<?=$pid?> is created!
	</div>
<?
	}
?>
