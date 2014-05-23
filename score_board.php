<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<script src="js/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function()
    {
			var content;
			$.get("score_board_ajax.php", function(data){
				for(var i = 0; i < data.length; i++){
				            content += "index：" + i + "; value： " + data[i]['p_id'];
				}
				alert(content);
			});
    }
	);
    </script>
</head>
<body>
<table>
	<thead>
		<th></th>
	</thead>
	<tbody>
	</tbody>
</table>
</body>
</html>
