<?php
#functions for debug challenge judge

function edit_distance($code1, $code2) {
	$n = strlen($code1);
	$m = strlen($code2);
	$dp = array_fill(0, $n+1, array_fill(0, $m+1, 0));

	for ($i = 0; $i <= $n; $i++)
		$dp[$i][0] = $i;
	for ($i = 0; $i <= $m; $i++)
		$dp[0][$i] = $i;

	for ($i = 1; $i <= $n; $i++)
		for ($j = 1; $j <= $m; $j++)
		{
			if ($code1[$i-1] == $code2[$j-1])
				$dp[$i][$j] = $dp[$i-1][$j-1];
			else
			{
				$dp[$i][$j] = min(
					$dp[$i][$j-1],
					$dp[$i-1][$j],
					$dp[$i-1][$j-1]
				) + 1;
			}
		}
	return $dp[$n][$m];
}

function debug_challenge($code1, $code2, $val) {
	$code1 = preg_replace('/\s/', '', $code1);
	$code2 = preg_replace('/\s/', '', $code2);
	return edit_distance($code1, $code2) <= $val;
}

?>
