<?php
require_once('includes/lib.inc.php');
require_once('includes/contest.inc.php');

$problem = array();
$query = 'SELECT * FROM pd_hw';
$result = mysql_query($query);
while($r = mysql_fetch_assoc($result)) {

	$name = $r['p_id'];
	if( !isset($problem[$name]) )
		$problem[$name] = array();

	$problem[$name]['data_number'] = $r['data_number'];
	$problem[$name]['total_score'] = $r['total_score'];
}


echo '<table class="table table-bordered no-wrap"><thead><tr><th>Rank</th><th>User</th><th>Score</th><th>Penalty</th>';
foreach($problem as $name=>$row)
{
	$number = (int)$row['data_number'];
	echo '<th>'.$name.'</th>';
}
echo '</tr></thead><tbody>';


//$query = 'SELECT student.group_num, pd_score.p_id, MAX(pd_score.score) AS max_score FROM pd_score, student WHERE pd_score.s_id = student.s_id GROUP by p_id, group_num ORDER BY group_num';
$query = 'SELECT student.group_num, `group`.group_name, pd_score.p_id, pd_score.score, pd_score.result, pd_score.status, pd_score.time
FROM `group`, pd_score, student
WHERE pd_score.s_id = student.s_id and `group`.group_num = student.group_num
ORDER BY pd_score.time ASC';

//[user][problem] = score
//
$cnt = 0;
$rows = array();
$maxscore = array();
$tries = array();
$tries_pending = array();
$firstid = array();
$isAC = array();

$result = mysql_query($query);
$rows = array();
while($r = mysql_fetch_assoc($result)) {

	$rows[$cnt] = $r;

	$user = $r['group_name'];
	$prob = $r['p_id'];

	if( !isset($maxscore[$user][$prob]) ){
		$maxscore[$user][$prob] = -1;
		$tries_pending[$user][$prob] = 0;
		$tries[$user][$prob] = 0;
		$minute[$user][$prob] = 0;
		$isAC[$user][$prob] = 0;
	}

	$tries_pending[$user][$prob] += 1;

	if($maxscore[$user][$prob] < $r['score'])
	{
		$maxscore[$user][$prob] = $r['score'];
		$firstid[$user][$prob] = $cnt;
		
		$minute[$user][$prob] = (int)((strtotime($r['time']) - STARTTIME) / 60);
		if ($r['score'] > 0) {
			$tries[$user][$prob] = $tries_pending[$user][$prob];
			$isAC[$user][$prob] = 1;
			if ($r['status'] == "Accpeted") {
				$isAC[$user][$prob] = 2;
			}
		}
	}

	$cnt++;
}

class Score{
	public $group;
	public $penalty;
	public $tot_score;

	public function __construct()
	{
		$penalty = 0;
		$tot_score = 0;
	}
};
function comp($x, $y)
{
	if($x->tot_score != $y->tot_score)
	{
		if($x->tot_score > $y->tot_score)
			return -1;
		if($x->tot_score < $y->tot_score)
			return 1;
		return 0;
	}
	else
	{
		if($x->penalty < $y->penalty)
			return -1;
		if($x->penalty < $y->penalty)
			return 1;
		return 0;
	}
}
$team = array();

foreach($firstid as $user=>$ids)
{
	if( !isset($team[$user]) ) $team[$user] = new Score;
	$team[$user]->group = $user;

	foreach($ids as $prob=>$id)
	{
		$team[$user]->tot_score += $maxscore[$user][$prob];
		if($isAC[$user][$prob] > 0){
			$team[$user]->penalty += $minute[$user][$prob] + ($tries[$user][$prob] - 1) * 10;
		}
	}
}

usort($team, "comp");

$rank = 1;

foreach($team as $score)
{
	$usr = $score->group;
	echo '<tr>';
	echo sprintf('<td>%s</td>', $rank);
	echo sprintf('<td>%s</td>', $usr);
	echo sprintf('<td>%d</td><td>%d</td>', $score->tot_score, $score->penalty);

	foreach($problem as $probid=>$row)
	{
		if (!isset($firstid[$usr][$probid])) {
			echo "<td>0/0(0)</td>";
			continue;
		}
		
		$class = array("error", "wrong_answer", "accept");
		$class = $class[$isAC[$usr][$probid]];
		$totalTry = $isAC[$usr][$probid] == 2 ? $tries[$usr][$probid] : $tries_pending[$usr][$probid];
		echo "<td class=\"$class\">".$maxscore[$usr][$probid]."/".$tries[$usr][$probid]."($totalTry)</td>";
	}

	echo '</tr>';
	$rank++;
}

echo '</tbody></table>';

//header("Content-Type: application/json");
//echo json_encode($rows, JSON_PRETTY_PRINT);



?>
