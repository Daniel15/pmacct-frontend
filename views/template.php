<!DOCTYPE html>
<html>
<head>
	<title></title>
	<base href="http://<?php echo $_SERVER['SERVER_NAME'] ?><?php echo dirname($_SERVER['PHP_SELF']) ?>/" />
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/styles.css" />
</head>
<body<?php if (!empty($this->page_id)) echo ' id="' . $this->page_id . '"'; ?>>
	<?php echo $this->body ?>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="js/highcharts.js"></script>
	<script src="js/scripts.js"></script>
</body>
</html>