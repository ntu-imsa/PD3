<?php
require_once('includes/lib.inc.php');

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
	echo '<th colspan="3">'.$name.'</th>';
}
echo '</tr><tr><th colspan="4"></th>';
foreach($problem as $name=>$row)
{
	echo '<th>Simple</th><th>Extreme</th><th>Tries</th>';
}
echo '</tr></thead><tbody>';


//$query = 'SELECT student.group_num, pd_score.p_id, MAX(pd_score.score) AS max_score FROM pd_score, student WHERE pd_score.s_id = student.s_id GROUP by p_id, group_num ORDER BY group_num';
$query = 'SELECT student.group_num, `group`.group_name, pd_score.p_id, pd_score.score, pd_score.result, pd_score.status
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
		$isAC[$user][$prob] = false;
	}

	$tries_pending[$user][$prob] += 1;

	if($maxscore[$user][$prob] < $r['score'])
	{
		$maxscore[$user][$prob] = $r['score'];
		$firstid[$user][$prob] = $cnt;
		$tries[$user][$prob] += $tries_pending[$user][$prob];
		$tries_pending[$user][$prob] = 0;
		if($r['status'] == 'Accepted'){
			$isAC[$user][$prob] = true;
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
		if($isAC[$user][$prob] == true){
			$team[$user]->penalty += $tries[$user][$prob] - 1;
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
		$number = (int)$row['data_number'];

		if( !isset($firstid[$usr][$probid]) )
		{
			for($i=0; $i<$number; $i++)
				echo '<td></td>';
			continue;
		}

		$submission_id = $firstid[$usr][$probid];
		$results = explode(",", $rows[$submission_id]['result']);
		$totalPenalty = 0;
		$totalTry = 0;

		for($i=0; $i<$number; $i++)
		{
			if( isset($results[$i]) ){
				$tmpstr = $results[$i];
				$totalTry += $tries[$usr][$probid];
				if($isAC[$usr][$probid] != true){
					$totalPenalty += $tries_pending[$usr][$probid] - 1;
					if($results[$i] == 0)
						$class = 'error';
					else
						$class = 'wrong_answer';
				}else{
					$class = 'accept';
				}
			}else{
				$tmpstr = '';
				$tmpstr2 = '';
			}
			echo "<td class=\"$class\">$tmpstr</td>";
		}
		// total tries
		echo "<td>$totalPenalty/$totalTry</td>";
	}

	echo '</tr>';
$rank++;
}

echo '</tbody></table>';

//header("Content-Type: application/json");
//echo json_encode($rows, JSON_PRETTY_PRINT);



?>
