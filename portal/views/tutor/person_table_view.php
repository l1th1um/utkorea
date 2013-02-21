<table>
	<tr>
		<td valign="top" rowspan="<?php echo count($data)-2; ?>"><img src="<?php echo site_url()."assets/uploads/".$data['photo']; ?>" width="200" /></td>
		<td><?php echo $this->lang->line('name') ?></td><td><?php echo $data['name']; ?></td>
	</tr>	
	<?php foreach($data as $key=>$value){ if(!in_array($key,array('name','username','staff_id','password','photo','group_id','major_id','teach_major','channel','subject'))){?>
	<tr>
		<?php if(!in_array($key,array('passport_image','ijasah_image'))) { 
			if($key=='status') {
			?>			
				<td><?php echo $this->lang->line($key); ?></td><td><?php echo ($value=='Aktif')?'<button class="blue small" style="width:140px">Aktif</button>':'<button class="red small" style="width:140px">Tidak Aktif</button>'; ?></td>
			<?php }elseif($key=='verified'){?>
				<td><?php echo $this->lang->line($key); ?></td><td><?php echo ($value)?'<button class="blue small" style="width:140px">Verified</button>':'<button class="unverified" class="red small" style="width:140px">Not Verified<input type="hidden" value="
				'.$data['reg_code'].'" /></button>'; ?></td>
			<?php }elseif($key=='region'){ ?>
				<td><?php echo $this->lang->line($key); ?></td><td><?php echo $value; ?></td>
			<?php }else if($key=='major'){
						echo '<td width="120px">'.$this->lang->line($key).'</td><td>'.form_dropdown('major',major_list(),$value,'disabled="disabled"').'</td>';
					}else if($key=='last_education'){
						echo '<td>'.$this->lang->line($key).'</td><td>'.form_dropdown('last_education',lang_list('education_list'),$value,'disabled="disabled"').'</td>';
					}else if($key=='marital_status'){
						echo '<td>'.$this->lang->line($key).'</td><td>'.form_dropdown('marital_status',lang_list('marital_status_list'),$value,'disabled="disabled"').'</td>';
					}else if($key=='employment'){
						echo '<td>'.$this->lang->line($key).'</td><td>'.form_dropdown('employment',lang_list('employment_list'),$value,'disabled="disabled"').'</td>';
					}else if($key=='religion'){
						echo '<td>'.$this->lang->line($key).'</td><td>'.form_dropdown('religion',lang_list('religion_list'),$value,'disabled="disabled"').'</td>';
					}else{ ?>
				<td>
					<?php
					 	if ($key == 'reg_code') {
					 		$value = "UTKOR".$value;
					 	} else if ( ($key == 'reg_time') || ($key == 'verified_time') ) {
					 		$value = convertHumanDate($value);	
					 	} 
						
						echo $this->lang->line($key); ?></td><td><?php echo $value; 
					?>
				</td>
			<?php } ?>
		<?php }else{ ?>
		<td><?php echo $this->lang->line($key); ?></td><td><?php echo anchor('assets/uploads/'.$value, 'Download', 'title="Download File" target="_blank"'); ?></td>
		<?php } ?>
	</tr>
	<?php }} ?>

</table>