<?php
/**
 * Core include - Sets up autoloader.
 * @author Daniel15 <daniel at dan.cx>
 */

define('BASEDIR', __DIR__);
set_include_path(BASEDIR . PATH_SEPARATOR . get_include_path());

/**
 * Load the class specified 
 * @param	string		Class to load
 */
function autoload($className)
{
	/* We're using the built-in autoloader as it's faster than a PHP implementation.
	 * Replace underscores with slashes to use a directory structure (FeedSources_Twitter -> includes/FeedSources/Twitter.php)
	 */
	$filename = strtolower(str_replace('_', '/', $className));
	return spl_autoload($filename);
}

spl_autoload_register('autoload');

require __DIR__ . '/config.php';
?>