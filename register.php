<?php
	if (isset($_GET["empty"]))
		echo 'No attribute can be empty!' ;	
	if (isset($_GET["fail"]))
		echo 'passwords are not the same.' ;
	if (isset($_GET["err"]))
		echo 'account already used, please try another.' ;
	echo "<form method = 'post' action = 'register_result.php'>" ;
	echo "Account: <input name = 'account' type = 'text' /><br />" ;
	echo "Password: <input name = 'password' type = 'password' /><br />" ;
	echo "Confirm Password: <input name = 'cpw' type = 'password'><br />" ;
	echo "<input name = 'submit' type = 'submit'></form>" ;
	//echo "<a href='login1.php'>Back</a>"
?>
