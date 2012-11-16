<?php
	if ($list == FALSE) {
		echo "<h1 align='center'>Belum Ada Pembayaran</h1>";
	} else {

?>
<table width="100%">
	<thead>
		<th width='30px'>No</th>
		<th>Nama</th>
		<th width='120px'>Bank</th>		
		<th width='180px'>No Account</th>
		<th width='200px'>Nama Pengirim</th>
		<th width='150px'>Tanggal Transfer</th>
		<th width='100px'>Status</th>
	</thead>
	<tbody>
		<?php
			$i = 1;
			foreach ($list as $row) {
				if ($row->verified == 1) {
					$status = "<button class='blue small'>Verified</button>";
				} else {
					$status = "<button>Unverified</button>";
				}
		?>
			<tr>
				<td><?php echo $i;?></td>	
				<td>UTKOR<?php echo $row->reg_code;?></td>
				<td><?php echo $row->name;?></td>
				<td><?php echo $row->email;?></td>
				<td><?php echo convertHumanDate($row->reg_time);?></td>
				<td><?php echo $status;?></td>
				<td><?php echo $status;?></td
			</tr>
		<?php
				$i++;
			} 
		?>
	</tbody>
</table>
<?php 
	}
?>