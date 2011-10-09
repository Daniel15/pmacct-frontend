<?php
/**
 * Viewing a summary of statistics by month, grouped by day and host
 * @author Daniel15 <daniel at dan.cx>
 */

require __DIR__ . '/includes/core.php';

// Querystring parameters
$year = !empty($_GET['year']) ? (int) $_GET['year'] : date('Y');
$month = !empty($_GET['month']) ? (int) $_GET['month'] : date('m');

$start_date = mktime(0, 0, 0, $month, 1, $year);

$data = Data_Summary::month_by_day($start_date);

header('Content-Type: text/json');
echo json_encode((object)array(
	// Get day values
	'days' => array_keys(reset($data)),
	'data' => $data,
));
?>