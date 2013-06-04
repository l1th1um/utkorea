<table>
	<thead>
		<tr>
			<td>Nama</td><td>Course</td><td>Region</td><td></td>
		</tr>
	</thead>
<?php foreach($list->result() as $row){ ?>
	<tr>
		<td><?php echo $row->name; ?></td>
		<td><?php echo $row->title; ?></td>
		<td><?php echo (($row->sregion==1)?'Utara':'Selatan'); ?></td>
		<td><a href="<?php echo site_url('tutor/hasil_survey_detail/'.$row->sid); ?>"><button>Lihat</button></a></td>		
	</tr>
<?php } ?>
</table>
