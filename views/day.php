<?php
$this->page_id = 'summary-day';
?>
<h1>Statistics for <?php echo date('Y-m-d', $this->date); ?></h1>

<?php require('summary.php'); ?>