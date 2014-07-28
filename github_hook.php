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

// Make sure request comes from GitHub hook

if(cidr_match($_SERVER['REMOTE_ADDR'], '192.30.252.0/22')){

	$auth_digest = 'a5fa2247b5a3d4d23e3420f722278ef5dc672258';
	if(isset($_SERVER['Authorization']) && sha1($_SERVER['Authorization']) == $auth_digest){
		system("git pull");
	}
}

?>
