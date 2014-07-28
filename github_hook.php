<?php

// GitHub hook will POST to this endpoint in order to trigger auto pull

function cidr_match($ip, $cidr)
{
    list($subnet, $mask) = explode('/', $cidr);

    if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1) ) == ip2long($subnet))
    {
        return true;
    }

    return false;
}

function exec_background($cmd) {

	// http://php.net/manual/en/function.exec.php#86329
	// This will run shell command in background

    if (substr(php_uname(), 0, 7) == "Windows"){
        pclose(popen("start /B ". $cmd, "r"));
    }
    else {
        exec($cmd . " > /dev/null &");
    }
}

// Make sure request comes from GitHub hook

if(cidr_match($_SERVER['REMOTE_ADDR'], '192.30.252.0/22')){
		exec_background('git pull');
}else{
	header('HTTP/1.1 401 Unauthorized');
	echo 'Access Denined';
}

?>
