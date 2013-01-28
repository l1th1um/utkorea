<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/simplemodal.css" />
<?php if (isset($message)) echo $message;  else $message= '';?>
<?php if ($is_paid == 0): ?>		
<?php echo form_open_multipart(current_url(), array('id'=>'frmPersonal')); ?>
<i>Biaya yang harus dibayarkan adalah biaya kuliah (₩450.000) di kurangi dengan jumlah uang yang sudah pernah anda bayarkan saat daftar ulang</i>
<fieldset>
	<table>
		<tr>
			<td  width="150px"><label>Biaya Kuliah</label></td>
			<td>
				<?php foreach($amount as $row){
					echo '<input type="radio" name="amount" value="'.$row.'" checked="checked"" />&nbsp;₩'.$row.'<br />';
				}?>				
			</td>                
		</tr>
		<tr>
			<td  width="150px"><label><?php echo $this->lang->line('payment_date');?></label></td>
			<td><?php echo form_input('payment_date','','style="width:8em"'); ?></td>                
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
<script type="text/javascript" >
$(document).ready(function(){		
		$( "input[name=payment_date]" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '2012:2013',
		dateFormat: "dd/mm/yy"

		});
});
</script>
<?php
	elseif ($is_paid == 1):
		echo success_form("Anda sudah melakukan pembayaran biaya studi dan menunggu konfirmasi bendahara UT Korea Selatan"); 
	else:
		echo success_form("Anda sudah melakukan pembayaran. Terima Kasih");
	endif; 
?>