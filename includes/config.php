<?php
// Configuration

class Config
{
	static $database = array(
		'host' => 'localhost',
		'name' => 'pmacct',
		'username' => 'root',
		'password' => 'password',
		'prefix' => 'acct_v7_',
	);
	
	// IPs to include in the statistics
	// Set this to a blank array to show all IPs
	static $include_ips = array(
		// Only show 10.0.0.1 and 10.0.0.2
		// '10.0.0.1', '10.0.0.2'
	);
}
?>