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
<div style="float:left;width:450px;margin-left:10px;">
	<header>
		<h3>Nilai</h3>
	</header>
	<center>Belum ada data</center>
</div>
