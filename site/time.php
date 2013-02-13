<span id="clock"> 
<SCRIPT LANGUAGE="JavaScript"> 
    function getthedate(){ 
        var mydate=new Date(); 
        var hours=mydate.getHours(); 
        var minutes=mydate.getMinutes(); 
        var seconds=mydate.getSeconds(); 
        var dn="AM"; 
        if (hours>=12) dn="PM"; 
        if (hours>12) hours=hours-12;        
        if (hours==0) hours=12; 
        if (minutes<=9) minutes="0"+minutes; 
        if (seconds<=9)    seconds="0"+seconds; 
        

        var cdate="<b>Local Time</b> "+hours+":"+minutes+":"+seconds+" "+dn+"<BR>"; 
        if (document.all) 
            document.all.clock.innerHTML=cdate; 
        else if (document.getElementById) 
            document.getElementById("clock").innerHTML=cdate; 
        else 
            document.write(cdate); 
    } 
    if (!document.all&&!document.getElementById) getthedate(); 

    function goforit(){ 
        if (document.all||document.getElementById) setInterval("getthedate()",1000); 
    } 
    window.onload=goforit; 
</SCRIPT> 
</span> 

<?php 

        $thetimeis = getdate(time()); 
            $thehour = $thetimeis['hours']; 
            $theminute = $thetimeis['minutes']; 
            $thesecond = $thetimeis['seconds']; 
        if($thehour > 12){ 
            $thehour = $thehour - 12; 
            $dn = "PM"; 
        }else{ 
            $dn = "AM"; 
        } 
        
echo "$thehour: $theminute:$thesecond $dn"; 
?>    
</p>