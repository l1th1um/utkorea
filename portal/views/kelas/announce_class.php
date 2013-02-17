<table width="100%">
	<tr>
		<td width="120px"><label><?php echo $this->lang->line('title')?></label></td>
		<td><?php echo $row->title?></td>
	</tr>
	<tr>
		<td><label><?php echo $this->lang->line('date')?></label></td>
		<td><?php echo convertHumanDate($row->created,false) ?></td>
	</tr>
    <tr>
		<td><label>Attachment</label></td>
		<td>
            <?php
            if ($icon <> false) 
            {
                echo img(base_url()."assets/core/images/fileicons/".$icon.".png");
                echo anchor(base_url()."attach/".$attach->uuid,$attach->original_file,"style=text-decoration:none;color:#000000;"); 
            }
            else
            {
                echo "-";
            }
            ?>            
        </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<?php
			$news = $row->content;  
			if ($this->config->item('live_site') == 1) {
				$news = str_replace('utkorea/','',$news);
			}			
			echo $news
			?>
		</td>
	</tr>
</table>