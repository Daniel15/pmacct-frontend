<?php
/**
 * Data formatting functions
 * @author Daniel15 <daniel at dan.cx>
 */
class Format
{
	private static $size_units = array('bytes', 'KB', 'MB', 'GB', 'TB', 'PB');
	
	/**
	 * Show number of bytes nicely formatted. Uses decimal numbers (powers of 1000)
	 * @param	int		Number to format
	 * @return Formatted string
	 */
	public static function decimal_size($bytes)
	{
		return self::size($bytes, 1000);
	}
	
	/**
	 * Show number of bytes nicely formatted. Uses decimal numbers (powers of 1024)
	 * @param	int		Number to format
	 * @return Formatted string
	 */
	public static function binary_size($bytes)
	{
		return self::size($bytes, 1024);
	}
	
	private static function size($bytes, $base)
	{
		// Ensure there's no dividing by zero!
		if ($bytes == 0)
			return '0 bytes';
		
		// Work out unit to use
		$unit = floor(log($bytes, $base));
		
		return round($bytes / pow($base, $unit), 2) . ' ' . self::$size_units[$unit];
	}
}
?>