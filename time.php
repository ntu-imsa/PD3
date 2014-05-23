<!doctype html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript">
  function init(){
    setInterval(updateTime,1000);
  }
  function updateTime(){
    var d = new Date();
    var days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    var dateString = days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()]+ ' '+ d.getFullYear() + ' '+ d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    document.getElementById("t1").innerHTML = dateString;
    }
  </script>
  <style type="text/css">
#c1 {text-align:center;display:block;margin:0px auto;background-color:transparent;padding:1px;border:none;}
#t1c,#t1 {white-space:nowrap;font-family:'Century Gothic',AvantGarde,'Avant Garde',sans-serif;font-size:14px;color:#000;text-decoration:none;}
.t100 {width:100%;height:100%;}
.tab {margin: 0 auto;}
body {border:none;margin:0px;padding:0px;overflow:hidden;background-color:transparent;}
</style></head>
<body onload="init()" allowTransparency=true style="background:transparent">
  <table cellpadding=0 cellspacing=0 border=0 class="tab t100" id=c2>
    <tr><td id=c1 valign=middle><span id=t1>Friday, 23 May 2014, 15:08:52</span></a></td></tr>
  </table>
</body></html>
