<?php

	session_start() ;
	$db_host = 'localhost' ;
	$db_database = 'PD Course' ;
	$db_username = 'root' ;
	$connection = mysql_connect($db_host, $db_username, '');
	if (!$connection)
		die ("connection failed".mysql_error()) ;
	mysql_query("SET NAMES 'utf8'");
	$selection = mysql_select_db($db_database) ;
	if (!$selection)
		die ("selection failed".mysql_error()) ;
	
	
	if (isset($_POST['textarea'])){
		echo 'textarea'.$_POST['textarea'] ;
		//$fp = fopen('C:\\xampp\\htdocs\\func\\ori\\1.txt', 'w');
		//fwrite($fp, $_POST['textarea']);
		//fclose($fp);
		
		
		//$return = 1;
		//$command = "C:\\xampp\\htdocs\\func\\print.py";
		//system($command,$return);
	
		//$command = "C:\\xampp\\htdocs\\func\\StopSymbol.py";
		//system($command,$return);
		// sleep(1);
		 //$command = "java -jar C:\\xampp\\htdocs\\func\\IR_project.jar ";
		 //$result = system($command,$return);
		 #echo $return;
		 // $System = java("IRProject");
           // $System->getSinglePageInf();
		// if ($result){
			// echo nl2br($result);
		// } else {
			// echo "fail";
		// }
		//sleep(2);
		//$command = "C:\\xampp\\htdocs\\func\\StopWord.py";//	system($command,$return);
		//	$command = "C:\\xampp\\htdocs\\func\\singleTest.py";
		//	system($command,$return);
		//echo $return;
		//sleep(2);
		//$file_handle = fopen("C:\\xampp\\htdocs\\result\\1.txt", "r");
		//while (!feof($file_handle)) {
		//$type = fgets($file_handle);
		//echo $line;
		//}
		//fclose($file_handle);
	}
	else if (isset($_FILES['upload'])){
		echo 'file upload success';
		//echo $_FILES['file'];
		//move_uploaded_file($_FILES['uploadfile'], '/hw/1.cpp');
		
		$upfile = '.\\hw\\'.$_FILES['upload']['name'];
		move_uploaded_file($_FILES['upload']['tmp_name'], $upfile);
	
		$return = 1;
		$command = "g++ C:\\xampp\\htdocs\\hw\\".$_FILES['upload']['name']." -o C:\\xampp\\htdocs\\hw\\hello.exe --enable-auto-import";
		system($command,$return);
		$command = "hello.exe > output.txt"
		system($command,$return);
		$command = 
		
	}
	else if (!isset($_FILES['upload']) and !isset($_POST['textarea'])){
		echo 'no upload';
	}

?>