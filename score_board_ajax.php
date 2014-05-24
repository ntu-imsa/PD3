<?php
require_once('db.inc.php');

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


echo '<table border="1">';
echo '<tr><th>User</th><th>Score</th><th>Penalty</th>';
foreach($problem as $name=>$row)
{
	$number = (int)$row['data_number'];

	for($i=1; $i<=$number; $i++)
		echo sprintf('<th>%s - %d</th>', $name, $i);
}
echo '</tr>';


//$query = 'SELECT student.group_num, pd_score.p_id, MAX(pd_score.score) AS max_score FROM pd_score, student WHERE pd_score.s_id = student.s_id GROUP by p_id, group_num ORDER BY group_num';
$query = 'SELECT student.group_num, pd_score.p_id, pd_score.score, pd_score.result 
FROM pd_score, student 
WHERE pd_score.s_id = student.s_id
ORDER BY pd_score.time ASC';

//[user][problem] = score
//
$cnt = 0;
$rows = array();
$maxscore = array();
$firstid = array();

$result = mysql_query($query);
$rows = array();
while($r = mysql_fetch_assoc($result)) {
	
	$rows[$cnt] = $r;

	$user = $r['group_num'];
	$prob = $r['p_id'];
	
	if( !isset($maxscore[$user][$prob]) )
		$maxscore[$user][$prob] = -1;
	if($maxscore[$user][$prob] < $r['score'])
	{
		$maxscore[$user][$prob] = $r['score'];
		$firstid[$user][$prob] = $cnt;
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
		//$team[$user]->penalty += $rows[$id].time???
	}
}

usort($team, "comp");

foreach($team as $score)
{
	$usr = $score->group;
	echo '<tr>';
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

		for($i=0; $i<$number; $i++)
		{
			if( isset($results[$i]) ) $tmpstr = $results[$i];
			else $tmpstr = '';
			echo sprintf("<td>%s</td>", $tmpstr);
		}
	}

	echo '</tr>';

}

echo '</table>';

//header("Content-Type: application/json");
//echo json_encode($rows, JSON_PRETTY_PRINT);



?>