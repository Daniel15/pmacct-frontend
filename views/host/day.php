<?php
$this->page_id = 'host-day';
?>
<h1>Statistics for <?php echo $this->ip; ?> (<?php echo gethostbyaddr($this->ip); ?>) on <?php echo date('Y-m-d', $this->date); ?></h1>

<div id="host_graph"></div>

<table id="host">
	<thead>
		<tr>
			<th>Time</th>
			<th>In</th>
			<th>Out</th>
			<th>Total</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Totals</th>
			<td><?php echo Format::decimal_size($this->data->totals->bytes_in); ?></td>
			<td><?php echo Format::decimal_size($this->data->totals->bytes_out); ?></td>
			<td><?php echo Format::decimal_size($this->data->totals->bytes_total); ?></td>
		</tr>
	</tfoot>
	<tbody>
<?php
foreach ($this->data->data as $row)
{
	echo '
		<tr data-in="', $row->bytes_in, '" data-out="', $row->bytes_out, '" data-total="', $row->bytes_total, '">
			<td>', date('H:i', $row->date), ' - ', date('H:i', $row->date + (60 * 60)), '</td>
			<td>', Format::decimal_size($row->bytes_in), '</td>
			<td>', Format::decimal_size($row->bytes_out), '</td>
			<td>', Format::decimal_size($row->bytes_total), '</td>
		</tr>';
}
?>
	</tbody>
</table>