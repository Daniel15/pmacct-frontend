<?php
$this->page_id = 'summary-month';
?>
<h1>Statistics for <?php echo date('F Y', $this->date); ?></h1>

<?php require('summary.php'); ?>

<div id="byday"></div>
