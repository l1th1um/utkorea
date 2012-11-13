<?php if (isset($message)) echo $message;  else $message= '';?>
<?php echo form_open_multipart(current_url(), array('id'=>'frmPersonal')); ?>
	<img src="http://localhost/utkorea/assets/chromatron/img/sample_user.png" alt="User Avatar" class='avatar'>
	
<fieldset>
	<table>
		<tr>
			<td  width="150px"><label><?php echo $this->lang->line('username');?></label></td>
			<td><input type="password" name="password" /></td>                
		</tr>
		<tr>
			<td><label><?php echo $this->lang->line('name');?></label></td>
			<td><input type="text" name="new_password" /></td>                
		</tr>		
		<tr>
			<td  width="150px"><label><?php echo $this->lang->line('address');?></label></td>
			<td><?php echo form_textarea('address'); ?></td>                
		</tr>
		<tr>
			<td><label><?php echo $this->lang->line('email');?></label></td>
			<td><?php echo form_input('email'); ?></td>                
		</tr>
		<tr>
			<td><label><?php echo $this->lang->line('phone');?></label></td>
			<td><?php echo form_input('email'); ?></td>                
		</tr>
		<tr>
			<td colspan="3"><button type="submit">
			<?php echo $this->lang->line('send_to');?>
			</button></td>
		</tr>
	</table>
	
	<div>
	<input type='file' name='avatar_img' id='avatar_img'  class="fileupload" data-url="<?php echo base_url()?>pendaftaran/do_upload/ktp" />
	</div>	
</fieldset>	

</form>

<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.ui.widget.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.iframe-transport.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.fileupload.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.ocupload-1.1.2.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
	$('#avatar_img').fileupload();
	
	$('.avatar').click(function(){
		$('#avatar_img').trigger('click');		
	});

				
  		
});	
</script>
