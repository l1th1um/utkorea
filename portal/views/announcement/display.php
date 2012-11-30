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
		<td>
			<?php
			$news = $row->news;  
			if ($this->config->item('live_site') == 1) {
				$news = str_replace('utkorea/','',$news);
			}
			
			echo $news
			?>
		</td>
	</tr>
</table>