var timerId = 0;
var server_time, diff = 0;

function pad(val) {
	return ("0"+val).slice(-2);
}

function show() {
	var d = new Date((server_time + diff)*1000);
	$("#server-time").text(
		"Current Time: " + 
		(1900 + d.getYear()) + "-" +
		pad(d.getMonth()+1) + "-" +
		pad(d.getDate()) + " " +
		pad(d.getHours()) + ":" +
		pad(d.getMinutes()) + ":" +
		pad(d.getSeconds())
	);
}

function getServerTime() {
	$.get("./now.php", function(data) {
		server_time = Number(data);
		diff = 0;
		clearInterval(timerId);
		timerId = setInterval(function() {
			diff++;
			show();
		}, 1000);
	});
	setTimeout("getServerTime()", 900000);
}

getServerTime();