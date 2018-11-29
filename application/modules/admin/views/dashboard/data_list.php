<table class="table">
	<thead>
		<tr>
			<th>Tags</th> <th><center>Total Opportunities</center></th> <th><center>Total Expected Revenue</center></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$jumlah = 0;
		$total = 0;
		if (count($opportunities_salesperson) > 0){
			foreach ($opportunities_salesperson as $key => $ops) {
					?>
					<tr>
						<td><?=$ops->first_name." ".$ops->last_name;?></td>
						<td style="text-align: right;"><?=number_format($ops->count_id, 0, '.', ',');?></td>
						<td style="text-align: right;">
							<?=number_format($ops->sum_expected_revenue, 2, '.', ',');?>
						</td>
					</tr>
					<?php
					$jumlah = $jumlah + $ops->count_id;
					$total = $total + $ops->sum_expected_revenue;
			}
		}
		?>
		<tr>
			<th>Total</th>
			<th style="text-align: right;"><?=$jumlah;?></th>
			<th style="text-align: right;"><?=number_format($total, 2, '.', ',');?></th>
		</tr>
	</tbody>
</table>