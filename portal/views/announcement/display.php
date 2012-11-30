<table width="100%">
	<tr>
		<td width="120px"><label><?php echo $this->lang->line('title')?></label></td>
		<td><?php echo $row->title?></td>
	</tr>
	<tr>
		<td><label><?php echo $this->lang->line('date')?></label></td>
		<td><?php echo convertHumanDate($row->created_time,false) ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo $row->news ?></td>
	</tr>
</table>