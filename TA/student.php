<?php
	session_start() ;
	require_once('db.inc.php');

	date_default_timezone_set('Asia/Taipei');
	$datetime = date ("Y-m-d H:i:s");

	//使用者尚未登入 顯示登入頁面
	if (!isset($_SESSION['account'])){
		header ("Location:index.php") ;
	} else {
?>
	<html>
		<head>
			<link href="css/bootstrap.css" rel="stylesheet" media="screen">
			<link href="css/font-awesome.min.css" rel="stylesheet" media="screen">
			<link href="css/sticky-footer.css" rel="stylesheet" media="screen">
			<link href="css/main.css" rel="stylesheet" media="screen">
			<link href="css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
		</head>
	<body>
	<div class="hero-unit upload_section">
	<table class="table table-hover">
		<?php
		?>
				<thead>
					<tr>
						 <th>Student ID</th>
						 <th>Account</th>
						 <th>Type</th>
						 <th>delete </th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query_s = "SELECT s_id, account, type FROM student";
						$s_id = mysql_query($query_s);
						while ($fetch_s = mysql_fetch_row($s_id))
						{
							echo '<tr>';
							for($i = 0; $i<3; $i++)
							{
								echo '<td>';
								if($i==2)
								{
									if($fetch_s[$i] == 0)
										echo "TA";
									else if($fetch_s[$i] == 1)
										echo "student";
									else
										echo "passerby";
								}else{
									echo $fetch_s[$i];
								}
								echo '</td>';
							}
							echo '<td>';
							echo '<a href= "#" >link</a>';
							echo '</td>';
							echo '</tr>';
						}
					?>
				</tbody>
		</table>
	</div>
	</body>
	</html>
<?php
	}
?>
