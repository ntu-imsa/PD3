<?php
require_once('db.inc.php');

$query = 'SELECT student.group_num, pd_score.p_id, MAX(pd_score.score) AS max_score FROM pd_score, student WHERE pd_score.s_id = student.s_id GROUP by p_id, group_num ORDER BY group_num';
$result = mysql_query($query);
$rows = array();
while($r = mysql_fetch_assoc($result)) {
	$rows[] = $r;
}
header("Content-Type: application/json");
echo json_encode($rows, JSON_PRETTY_PRINT);
?>
