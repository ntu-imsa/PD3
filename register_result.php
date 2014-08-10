<?php

	require_once('includes/lib.inc.php');

	// Check if registration has been disabled
	if(REG_ENABLED == false){
		header("Location:index.php?msg=disabled");
		exit();
	}

	// 使用RegEx過濾帳號，方便建立資料夾以及避免 remote code execution
	$acc = filterString($_POST["account"]);
	$pw = md5($_POST["password"]) ;
	$cpw = md5($_POST["cpw"]) ;

	$student_dir = '.\\student\\'.$acc;
	if ($acc == NULL or $_POST["password"] == NULL or $_POST["cpw"] == NULL){
		// 帳號以及密碼皆不能為空
		header("Location:index.php?msg=empty");
	} else if ($pw != $cpw){
		// 兩次密碼確認要相同
		header("Location:index.php?msg=same");
	} else {

		$db = getDatabaseConnection();
		// 查詢帳號是否已經被註冊
		$query = "SELECT * FROM student WHERE account = :acc";
		$stmt = $db->prepare($query);
		$stmt->execute(
			array(
				":acc" => $acc
			)
		);
		$result = $stmt->fetch();
		if (!empty($result)){
			// 帳號已被註冊
			header ("Location:index.php?msg=err");
		} else {
			// 新增帳號到資料庫，s_id會自動增加，所以不用指定
			$query = "INSERT INTO student(account, password, type) VALUES (:acc, :pw, 1)";
			$stmt = $db->prepare($query);
			$stmt->execute(
				array(
					":acc" => $acc,
					":pw" => $pw
				)
			);
			// 取得s_id，確認已新增成功
			$uid = $db->lastInsertId();

			// 新增學生個人資料夾
			$return = 0;
			$command = "MD ".$student_dir;
			system($command, $return);

			if ($uid != 0 and file_exists($student_dir)){
				// 導向註冊成功頁面
				header("Location:index.php?msg=success");
			}
		}
	}
?>
