<table>
	<thead>
	<tr>
		<th>No</th>
		<th>Kepada</th>
		<th>Pesan</th>
		<th>Waktu</th>
	</tr>
	</thead>
	<tbody>
		<?php 
			$i = 1;
			foreach ($data as $row) {
				echo "<tr>
						<td width='15px'>$i</td>
						<td width='300px'>(".$row->phone.")</td>
						<td>".$row->message."</td>
						<td width='250px'>".$row->datestamp."</td>
					</tr>";	
				$i++;
			}
		?>
	</tbody>
</table>