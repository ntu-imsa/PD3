<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	function upd()
	{
		$.ajax
		({
			url: 'score_board_ajax.php',
			type: 'GET',
			dataType: 'html',
			success: function(data)
			{
				$('#scoreboard').html(data);
			//	alert('updated');
			},
			error: function()
			{
			//	alert('error!');

			},
		});

	}
	$(document).ready(function()
    {
    	upd();
		setInterval('upd()', 2000);//update every 2 secs
    }
	);
    </script>
</head>
<body>

<div id="scoreboard"></div>

</body>
</html>
