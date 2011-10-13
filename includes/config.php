<?php
// Configuration

class Config
{
	static $database = array(
		'host' => 'localhost',
		'name' => 'ninja_pmacct',
		'username' => 'root',
		'password' => 'password',
		'prefix' => 'acct_v7_',
	);
	
	// IPs to include in the statistics
	// Set this to a blank array to show all IPs
	static $include_ips = array(
		'66.232.109.156', '66.232.109.157', '66.232.109.158', '66.232.109.159', '66.232.109.160', 
		'66.232.109.161', '66.232.109.162', '66.232.109.163', '66.232.109.164', '66.232.109.165',
		'66.232.109.166', '66.232.109.167'
	);
}
?>