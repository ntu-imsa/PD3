<?
require_once('db.inc.php');

$query = 'SELECT student.group_num, pd_score.p_id, max(pd_score.score) as max_score FROM pd_score, student WHERE pd_score.s_id = student.s_id GROUP by p_id, group_num ORDER BY group_num';
$result = mysql_query($query);
$rows = array();
while($r = mysql_fetch_assoc($result)) {
	$rows[] = $r;
}
echo  json_encode($rows);
?>
