<?php
// IPs that we don't want to hit the site
$blacklisted_ips 	= array	(
							'0.0.0.0', 
							'11.843.399.14',
							'123.243.459.4',
							'36.223.93.2',
							);

$visitors_ip 		= get_real_ip();

if (in_array($visitors_ip, $blacklisted_ips)) 
{
    exit("There was an error.");
}
?>