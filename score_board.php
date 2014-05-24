<!doctype html>
<html>
  <head>
    <title>IM PDAO Scoreboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/scoreboard.css" rel="stylesheet" media="screen">
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

					// set update time
						var d = new Date();
						var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
						var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
						var dateString = days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()]+ ' '+ d.getFullYear() + ' '+ d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
						document.getElementById("lastUpdTime").innerHTML = dateString;

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
  <div class="container-narrow">

        <div class="masthead">
            <h3 class="muted">IM PDAO Scoreboard</h3>
        </div>

        <hr>

<div id="scoreboard"></div>
<hr>
<div class="footer">
	<p>Last updated: <span id="lastUpdTime"></span></p>
</div>
</div>
</body>
</html>
