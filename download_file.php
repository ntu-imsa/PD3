<?php
	session_start() ;
	require_once('db.inc.php');

	$acc = mysql_real_escape_string($_SESSION['account']);
	$problem_num = $_GET['num'];
	$file_type = $_GET['type'];

//	$problem_dir = '.\\student\\'.$acc.'\\'.$_POST['hwID'];
//	$upfile = $problem_dir.'\\'.$acc.'-'.$_POST['hwID'].'.cpp';
//	$pdffile = $problem_dir.'\\'.$acc.'-'.$_POST['hwID'].'.pdf';

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
		$file_name = $acc."-".$problem_num.".".$file_type;
		$file_dir = ".\\student\\".$acc."\\".$problem_num."\\";
		if (!file_exists($file_dir.$file_name)) {
			echo "no file";
			exit;
		} else {
			$file = fopen($file_dir . $file_name,"r");
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: ".filesize($file_dir . $file_name));
			Header("Content-Disposition: attachment; filename=" . $file_name);
			echo fread($file,filesize($file_dir . $file_name));
			fclose($file);
			exit;
		}

	}
?>
