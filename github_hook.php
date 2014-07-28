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


if(cidr_match($_SERVER['REMOTE_ADDR'], '192.30.252.0/22')){

	// Make sure request comes from GitHub hook

}

?>
