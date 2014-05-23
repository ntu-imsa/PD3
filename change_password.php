<?php
	session_start() ;
	require_once('db.inc.php');

	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else if (isset($_POST['change'])) {
		$acc = mysql_real_escape_string($_SESSION['account']);
		$query = "SELECT password FROM student WHERE account = '".$acc."'";
		$q_pass = mysql_query($query);
		$password = mysql_fetch_row($q_pass);
		$oldpw = md5(mysql_real_escape_string($_POST['oldpass']));
		$newpw = md5(mysql_real_escape_string($_POST['newpass']));
		if ($password[0] == $oldpw)
		{
			$query = "UPDATE student SET password='$newpw' WHERE account='$acc'";
			mysql_query($query);
			echo "success";
		}
		else
			echo "Wrong password!";
		exit;
	}
?>

	<div class="hero-unit upload_section">
   <div id="msg"></div>
	<form id="chg-pass">
		<label for="oldpass">Old Password</label><input type="password" name="oldpass" id="oldpass" />
		<label for="newpass">New Password</label><input type="password" name="newpass" id="newpass" /><br>
		<input type="hidden" name="change" value="1" />	
		<input id="send-pass-btn" class="btn" type="button" value="送出" />
	</form>
	</div>
