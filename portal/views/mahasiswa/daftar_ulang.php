<?php
	if (!empty($empty_val)) {
		echo error_form("Sebelum Daftar Ulang Mohon Melengkapi Data Berikut"). "\n <ul>";
		
		foreach($empty_val as $row) {
			echo "<li>".$this->lang->line($row)."</li>";
		}
		
		echo"</ul>";
		
		?>
		
		<?php if (isset($message)) echo $message;  else $message= '';?>
		<?php echo form_open_multipart(current_url(), array('id'=>'frmPersonal')); ?>
		<fieldset>
			<table>
				<tr>
					<td  width="150px"><label><?php echo $this->lang->line('payment_date');?></label></td>
					<td><?php echo form_input('payment_date'); ?></td>                
				</tr>
				<tr>
					<td><label><?php echo $this->lang->line('bank_name');?></label></td>
					<td><?php echo form_input('bank_name'); ?></td>                
				</tr>		
				<tr>
					<td  width="150px"><label><?php echo $this->lang->line('account_no');?></label></td>
					<td><?php echo form_input('account_no'); ?></td>                
				</tr>				
				<tr>
					<td  width="150px"><label><?php echo $this->lang->line('sender_name');?></label></td>
					<td><?php echo form_input('sender_name'); ?></td>                
				</tr>
				<tr>
					<td colspan="3"><button type="submit">
					<?php echo $this->lang->line('submit');?>
					</button></td>
				</tr>
			</table>				
		</fieldset>	
		
		</form>
<?php
	} 	
?>