<?php
/**
 * Viewing a summary of statistics by day
 * @author Daniel15 <daniel at dan.cx>
 */

require __DIR__ . '/includes/core.php';

// Querystring parameters
$year = !empty($_GET['year']) ? (int) $_GET['year'] : date('Y');
$month = !empty($_GET['month']) ? (int) $_GET['month'] : date('m');
$day = !empty($_GET['day']) ? (int) $_GET['day'] : date('d');

$date = mktime(0, 0, 0, $month, $day, $year);

$data = Data_Summary::day($date);

View::factory('day')
	->set('date', $date)
	->set('data', $data)
	->render();
?>