<header>
	<h2><?php echo $classname; ?></h2>
</header>
<a href="javascript: history.go(-1)">Kembali ke kelas</a>
<div style="clear:both;"></div>
<div style="width:400px;float:left">
<table>
	<thead>
		<tr>
			<td>Pertemuan</td>
			<td>Absensi</td>
		</tr>
	</thead>
<?php
	for($i=1;$i<=8;$i++){
?>
	<tr>
		<td><?php echo $i; ?></td>
		<td><?php echo in_array($i,$absensi)?'Hadir':'Tidak Hadir'; ?></td>
	</tr>
<?php } ?>
</table>
</div>

