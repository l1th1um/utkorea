<?php if($success){ ?>
	<?php echo success_form("Data Anda berhasil telah disimpan"). "\n"; ?>
	<div style="clear:both;"></div>
<?php } ?>

<?php echo form_open_multipart(current_url(), array('id'=>'frmPersonal')); ?>
	
	<?php if(!isset($data['photo'])) { ?>
		<img src="http://localhost/utkorea/assets/chromatron/img/sample_user.png" alt="User Avatar" class='avatar' />
	<?php }else{ ?>
		<img src="<?php echo base_url('assets/uploads/').'/'.$data['photo']; ?>" alt="Profile Picture" title="Profile Picture" width="90px" style="float:left;margin-right:8px;" />
	<?php } ?>
	
<fieldset>
	<table>		
		<tr>
			<td><label><?php echo $this->lang->line('name');?></label></td>
			<td><?php echo form_input('name',$data['name'],'size="55"'); ?>&nbsp;<?php echo form_error('name'); ?></td>                
		</tr>		
		<tr>
			<td  width="150px"><label><?php echo $this->lang->line('address');?></label></td>
			<td><?php echo form_textarea('address',$data['address']); ?>&nbsp;<?php echo form_error('address'); ?></td>                
		</tr>
		<tr>
			<td><label><?php echo $this->lang->line('email');?></label></td>
			<td><?php echo form_input('email',$data['email'],'size="55"'); ?>&nbsp;<?php echo form_error('email'); ?></td>                
		</tr>
		<tr>
			<td><label><?php echo $this->lang->line('phone');?></label></td>
			<td><?php echo form_input('phone',trim($data['phone'])); ?>&nbsp;<?php echo form_error('phone'); ?></td>                
		</tr>
		<tr>
			<td><label>New Photo</label></td>
			<td><?php echo form_upload(array('name'=>'photo_file','class'=>'fileupload','data-url'=>base_url().'pendaftaran/do_upload/photo_file')).'&nbsp;'.form_error('photo');
					  echo '<br /><span style="font-size:8pt;color:#666666;"><i>Ukuran Maks. 10MB (gif, png, jpg, jpeg)</i></span>';
					  echo '<input type="hidden" name="photo" />';
					  echo '<div id="photo_file_cnt" class="image_container"></div>'; ?></td>                
		</tr>
		<?php if(!is_numeric($this->session->userdata('username'))){ ?>
		<tr>
			<td><label>Nomor Rekening</label></td>
			<td><?php echo form_input('account',$data['account']); ?>&nbsp;<?php echo form_error('account'); ?></td>      	
		</tr>	
		<tr>
			<td><label>Nama Bank</label></td>
			<td><?php echo form_input('bank',$data['bank']); ?>&nbsp;<?php echo form_error('bank'); ?></td>      	
		</tr>		
		<tr>
			<td><label>Afiliasi</label></td>
			<td><?php echo form_input('affiliation',$data['affiliation']); ?>&nbsp;<?php echo form_error('affiliation'); ?></td>      	
		</tr>		
		<?php }else{ ?>
		<tr>
			<td><label>Tanggal Lahir</label></td>
			<td><?php echo form_input('birth_date',$data['birth_date']); ?>&nbsp;<?php echo form_error('birth_date'); ?><br />
				<span style="font-size:8pt">Format : Tahun-Bulan-Hari</span>
			</td>      	
		</tr>	
		<?php } ?>
		<tr>
			<td colspan="3"><button type="submit">
			<?php echo $this->lang->line('save');?>
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
	$('.fileupload').fileupload({
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
				var hidden_field = $(this).attr('name').substr(0,$(this).attr('name').length-5);				
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
