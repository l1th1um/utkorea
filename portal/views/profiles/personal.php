<?php if (isset($message)) echo $message;  else $message= '';?>
<form method="post" action="<?php echo current_url();?>" id="frmPersonal">
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
</fieldset>	

</form>

<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.ui.widget.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.iframe-transport.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.fileupload.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.ocupload-1.1.2.js"></script>
<script type='text/javascript'>
$(document).ready(function(){
	$('.avatar').fileupload({
			dataType: 'json',
			maxFileSize: 10000,
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			progress: function () {
				var loader = $(this).attr('name') +'_loader';
				$(this).after("<img src='<?php echo template_path('triveo')?>images/loading.gif' class='"+ loader +"' />");
			},
			error: function (e, data) {
				alert("Error");
			},
			done: function (e, data) {					
				var cont = $(this).attr('name') +'_cnt';
				var loader = $(this).attr('name') +'_loader';
				var hidden_field = $(this).attr('name') +'_image';
				$(this).after("<img src='<?php echo template_path('triveo')?>images/tick_small.png' />");
				
				$('.'+ loader).hide();
				$.each(data.result, function (index, file) {
					
					$("<img src='"+ file.thumbnail_url +"'/>").appendTo('#' + cont);						
					$("input[name=" + hidden_field + "]").val(file.name);
				});
			}
		});				
});	
</script>
