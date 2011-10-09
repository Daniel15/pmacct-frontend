<?php
/**
 * Data model for retrieving statistics for a particular host
 * @author Daniel15 <daniel at dan.cx>
 */
class Data_Host
{
	/**
	 * Get the statistics for a certain day
	 * @param	string	IP address of host
	 * @param	date	Minimum date
	 * @return	Array of data
	 */
	public static function day($ip, $date)
	{
		// Calculate the last second of this day
		$start_date = $date;
		$end_date = mktime(23, 59, 59, date('m', $date), date('d', $date), date('Y', $date));
		
		$query = Database::getDB()->prepare('
			SELECT ip, UNIX_TIMESTAMP(date) AS date, bytes_out, bytes_in
			FROM ' . Config::$database['prefix'] . 'combined
			WHERE date BETWEEN :start_date AND :end_date
				AND ip = :ip
			ORDER BY date DESC');
			
		$query->execute(array(
			'start_date' => Database::date($start_date),
			'end_date' => Database::date($end_date),
			'ip' => $ip
		));
		
		$data = array();
		$totals = (object)array(
			'bytes_out' => 0,
			'bytes_in' => 0,
			'bytes_total' => 0,
		);
		
		while ($row = $query->fetchObject())
		{
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
}
?>