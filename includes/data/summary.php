<?php
/**
 * Data model for retriving a summary of statistics
 * @author Daniel15 <daniel at dan.cx>
 */
class Data_Summary
{
	/**
	 * Get the statistics for a certain day
	 * @param	date	Minimum date
	 * @return	Array of data
	 */
	public static function day($date)
	{
		// Calculate the last second of this day
		$end_date = mktime(23, 59, 59, date('m', $date), date('d', $date), date('Y', $date));
		
		return self::summary($date, $end_date);
	}
	
	/**
	 * Get the statistics for a certain month
	 * @param	date	Minimum date
	 * @return	Array of data
	 */
	public static function month($date)
	{
		// Calculate end of this month
		$end_date = mktime(23, 59, 59, date('m', $date) + 1, 0, date('Y', $date));
		
		return self::summary($date, $end_date);
	}
	
	/**
	 * Get a summary of host traffic data for a certain time period
	 * @param	date	Start of this time perioud
	 * @param	date	End of this time period
	 * @return	Array of data
	 */
	private static function summary($start_date, $end_date)
	{
		$query = Database::getDB()->prepare('
			SELECT ip, SUM(bytes_out) bytes_out, SUM(bytes_in) bytes_in
			FROM ' . Config::$database['prefix'] . 'combined
			WHERE date BETWEEN :start_date AND :end_date
			GROUP BY ip
			ORDER BY SUM(bytes_out) + SUM(bytes_in) DESC');
			
		$query->execute(array(
			'start_date' => Database::date($start_date),
			'end_date' => Database::date($end_date),
			//'end_date' => Database::date(strtotime('midnight tomorrow - 1 second')),
		));
		
		$data = array();
		$totals = (object)array(
			'bytes_out' => 0,
			'bytes_in' => 0,
			'bytes_total' => 0,
		);
		
		while ($row = $query->fetchObject())
		{
			// Check if this IP is on the list of IPs that should be shown
			if (!in_array($row->ip, Config::$include_ips))
				continue;
			
			$row->bytes_total = $row->bytes_in + $row->bytes_out;
			$data[] = $row;
			
			$totals->bytes_in += $row->bytes_in;
			$totals->bytes_out += $row->bytes_out;
			$totals->bytes_total += $row->bytes_total;
		}
		
		return (object)array(
			'data' => $data,
			'totals' => $totals
		);
	}
	
	/**
	 * Get the statistics for a certain month, grouped by day and host
	 * @param	date	Minimum date
	 * @return	Array of data
	 */
	public static function month_by_day($start_date)
	{
		// Calculate end of this month
		$end_date = mktime(23, 59, 59, date('m', $start_date) + 1, 0, date('Y', $start_date));
		
		$query = Database::getDB()->prepare('
			SELECT ip, UNIX_TIMESTAMP(date) AS date, SUM(bytes_out) bytes_out, SUM(bytes_in) bytes_in
			FROM ' . Config::$database['prefix'] . 'combined
			WHERE date BETWEEN :start_date AND :end_date
			GROUP BY ip, DAY(date)
			ORDER BY date, ip');
			
		$query->execute(array(
			'start_date' => Database::date($start_date),
			'end_date' => Database::date($end_date),
		));
		
		// Start with an empty array for all the days of the month
		$day_base = date('Y-m-', $start_date);
		$days = array();
		for ($i = 1, $count = date('t', $start_date); $i <= $count; $i++)
		{
			$days[$day_base . str_pad($i, 2, '0', STR_PAD_LEFT)] = 0;
		}

		$data = array();
		while ($row = $query->fetchObject())
		{
			// Check if this IP is on the list of IPs that should be shown
			if (!in_array($row->ip, Config::$include_ips))
				continue;
				
			// Does this host have a data entry yet?
			if (!isset($data[$row->ip]))
				$data[$row->ip] = $days;
			
			$row->bytes_total = $row->bytes_in + $row->bytes_out;
			$data[$row->ip][date('Y-m-d', $row->date)] =  $row->bytes_total;
		}
		
		return $data;
	}
}
?>