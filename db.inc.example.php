<?php

// 資料庫連線相關資訊
$db_host = 'localhost' ;
$db_database = 'pd course' ;
$db_username = 'pdogsserver' ;
$connection = mysql_connect($db_host, $db_username, 'pdogsserver');
if (!$connection)
	die ("connection failed".mysql_error()) ;
mysql_query("SET NAMES 'utf8'");
$selection = mysql_select_db($db_database) ;
if (!$selection)
	die ("selection failed".mysql_error()) ;

?>
