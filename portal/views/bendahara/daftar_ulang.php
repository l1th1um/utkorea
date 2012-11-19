<?php
	if ($list == FALSE) {
		echo "<h1 align='center'>Belum Ada Pembayaran</h1>";
	} else {

?>
<table width="100%">
	<thead>
		<th width='30px'>No</th>
		<th>NIM</th>
		<th>Nama</th>	
		<th width='120px'>Bank</th>		
		<th width='180px'>No Account</th>
		<th width='200px'>Nama Pengirim</th>
		<th width='150px'>Tanggal Transfer</th>
		<th width='100px'>Status</th>
	</thead>
	<tbody>
		<tr>
			<td>1</td>
			<td>13205962</td>
			<td>Deni Sugandi</td>
			<td>Hana Bank</td>
			<td>100 123 1231</td>
			<td>Deni Sugandi</td>
			<td>14 Desember 2012</td>
			<td><button>Unverified</button></td>
		</tr>

	</tbody>
</table>
<?php 
	}
?>