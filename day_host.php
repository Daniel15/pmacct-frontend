<?php
/**
 * Viewing traffic to a specific host for a specific day
 * @author Daniel15 <daniel at dan.cx>
 */

require __DIR__ . '/includes/core.php';

// Querystring parameters
$year = !empty($_GET['year']) ? (int) $_GET['year'] : date('Y');
$month = !empty($_GET['month']) ? (int) $_GET['month'] : date('m');
$day = !empty($_GET['day']) ? (int) $_GET['day'] : date('d');
$ip = $_GET['ip'];

$date = mktime(0, 0, 0, $month, $day, $year);

$data = Data_Host::day($ip, $date);

View::factory('host/day')
	->set('ip', $ip)
	->set('date', $date)
	->set('data', $data)
	->render();
?>