<table width="100%">
	<tr>
		<td width="120px"><label><?php echo $this->lang->line('from')?></label></td>
		<td><?php echo user_detail('name',$row->user_id);?></td>
	</tr>
    <tr>
		<td width="120px"><label><?php echo $this->lang->line('title')?></label></td>
		<td><?php echo $row->title?> ( <?php echo convertHumanDate($row->created,false) ?> )</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<?php
			$news = $row->content;  
			if ($this->config->item('live_site') == 1) {
				$news = str_replace('utkorea/','',$news);
			}echo $news
			?>
		</td>
	</tr>
</table>
<div style="float: right;">
    <textarea name="response" style="width: 500px;height:100px"></textarea>
    <p style="text-align: right;">
        <button class="green">Response</button>
    </p>
</div>
