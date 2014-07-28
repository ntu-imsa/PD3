<?php
require('db.inc.php');

function getDatabaseConnection() {
  $dbh = new PDO(
		"mysql:host=". DBHOST. ";dbname=". DBNAME. ";charset=utf8", DBUSER, DBPASS,
		array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET time_zone = \'+08:00\''
		)
	);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}

function filterString($str){
  return preg_replace("/[^a-zA-z0-9_\-]/", "", $str);
}

?>
