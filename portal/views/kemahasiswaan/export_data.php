<?php if (isset($message)) { echo "<pre>";print_r($message);echo "</pre>";}  else $message= '';?>
<?php
echo num_to_letter(1);
echo num_to_letter(27);

?>
<form method="post" action="<?php echo current_url();?>" id="frmChangePwd">
<fieldset>
	<table>
		<tr>
			<td style='width:80px'><label><?php echo $this->lang->line('major');?></label></td>
			<td style='width:300px'><?php echo form_dropdown('major',$major)?></td>
			<td style='width:80px'><label><?php echo $this->lang->line('period');?></label></td>
			<td><?php echo form_dropdown('period',$period)?></td>
			<td style='width:80px'><label><?php echo $this->lang->line('status');?></label></td>
			<td><?php echo form_dropdown('status',$status)?></td>
		</tr>
		<tr>
			<td><label>Field</label></td>
			<td colspan='5'>
				<table width="100%">
					<tr>
						<?php 
							$i = 1;
							foreach($field as $row) {
								$checked = false;
								$extra = "";
								
								if ( ($row == 'nim') || ($row == 'name') ) {
									$checked = true;
									$extra = "readonly = 'readonly' ";	
								}
								
								echo "<td>".form_checkbox('row[]',$row,$checked,$extra). " ".$this->lang->line($row)."</td>";
								
								if ($i % 6 == 0) echo "</tr><tr>";
								
								$i++;
							}
						?>		
					</tr>
				</table>
				
			</td>
		</tr>
		<tr>
			<td colspan="6"><button type="submit">
			<?php echo $this->lang->line('submit');?>
			</button></td>
		</tr>
	</table>	
</fieldset>	

</form>