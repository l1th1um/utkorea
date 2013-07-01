<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/simplemodal.css" />
<div style="color:red">
<?php echo validation_errors(); ?>
</div>
<?php if (isset($message)) echo $message;  else $message= '';?>
<?php
	if (!empty($empty_val)) {
		echo error_form("Sebelum Daftar Ulang Mohon Melengkapi Data Berikut"). "\n";
?>



	<?php echo form_open_multipart(current_url(), array('id'=>'frmEditData')); ?>
	<fieldset>
		<table>
		<?php
			foreach (range('1970',date('Y')) as $v) {
				$year_graduate[$v] = $v;
			}
			
			//print_r($empty_val);
			foreach($empty_val as $row) {
				if($row!='remarks'){
				echo '<tr><td width="150px"><label>'.$this->lang->line($row).'</label><td>';
					if($row=='ijasah_image' or $row=='passport_image' or $row=='photo_image'){
						echo form_upload(array('name'=>$row.'_file','class'=>'fileupload','data-url'=>base_url().'pendaftaran/do_upload/'.$row.'_file')).'&nbsp;'.form_error($row);
						echo '<br /><span style="font-size:8pt;color:#666666;"><i>Ukuran Maks. 10MB (gif, png, jpg, jpeg)</i></span>';
						echo '<input type="hidden" name="'.$row.'" />';
						echo '<div id="'.$row.'_file_cnt" class="image_container"></div>';
					}else if($row=='address_id' or $row=='address_kr'){
						echo form_textarea(array('rows'=>5,'cols'=>45,'name'=>$row)).'&nbsp;'.form_error($row);
						echo '<br /><span style="font-size:8pt;color:#666666;"><i>Minimal 10 Karakter</i></span>';
					}else if($row=='last_education_major'){						
						$data_edu = array('name' => 'last_education_major',
										  'value' => $this->input->post('last_education_major'),
										  'style' => 'width:3em',
										  'maxlength' => '3',
										  'readonly' => 'readonly');
						echo form_input($data_edu);
						echo "<div>Klik 
								<a href='javascript://' class='contact'>
									<img src='".template_path('core')."images/search.png' alt='' style='border:0;background-color:transparent' />
								</a>
							Untuk Memilih Jurusan
							<div class='hint'>
								Pilih kode jurusan sesuai jurusan pada ijazah terakhir. Misalnya jika anda lulusan SMA pilih 101, SMEA pilih 104
							</div></div>";
					}else if($row=='year_graduate'){					
						echo form_dropdown($row,$year_graduate,$this->input->post('year_gaduate'));
					}else if($row=='last_education'){
						echo form_dropdown('last_education',lang_list('education_list'),$this->input->post('last_education'));
					}else if($row=='marital_status'){
						echo form_dropdown('marital_status',lang_list('marital_status_list'),$this->input->post('marital_status'));
					}else if($row=='employment'){
						echo form_dropdown('employment',lang_list('employment_list'),$this->input->post('employment'));
					}else if($row=='religion'){
						echo form_dropdown('religion',lang_list('religion_list'),$this->input->post('religion'));
					}else if($row=='gender'){ ?>
						
						<div class="element">
							<?php
								$gender1 = TRUE;
								$gender2 = FALSE;
								
								if ($this->input->post($row) == 'P') 
								{
									$gender1 = FALSE;
									$gender2 = TRUE;
								}
							?>
							<?php echo form_radio('gender','L',$gender1);?>
							<label>Laki-Laki</label>&nbsp;&nbsp;
							<?php echo form_radio('gender','P',$gender2);?>
							<label>Perempuan</label>
						</div>					
<?php				}else{
						echo form_input(array('name'=>$row,'value'=>$this->input->post($row))).'&nbsp;'.form_error($row);
					}
				echo '</td></tr>';
			}}
		?>			
		<input type="hidden" name="formhdn" value="0" />
		<tr>
					<td colspan="3"><button type="submit">
					<?php echo $this->lang->line('submit');?>
					</button></td>
				</tr>
		</table>
	</fieldset>
	</form>	
		
	<div id="edu_list-form"></div>	
	
	<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.simplemodal.js"></script>
	<script type='text/javascript' src="<?php echo template_path('core')?>js/check_edu.js"></script>
	<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.fileupload.js"></script>
	<script type="text/javascript" >
	$(document).ready(function(){
		
			$( "input[name=birth_date]" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '1975:1995',
				dateFormat: "yy-mm-dd"
			});
		
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
	})
</script>	
		
<?php
	}else{ 	
?>		
		
		<?php 
			//echo success_form("Data Anda telah disimpan. Silahkan Lakukan konfirmasi Pembayaran"). "\n"; 
			if ($is_paid == 0):
		?>
		
		<?php echo form_open_multipart(current_url(), array('id'=>'frmPersonal')); ?>
		<fieldset>

			<table>			

				<tr>
					<td  width="150px"><label><?php echo $this->lang->line('payment_date');?></label></td>
					<td><?php echo form_input('payment_date','','readonly="readonly" style="width:8em"'); ?></td>                
				</tr>
				<tr>
					<td><label><?php echo $this->lang->line('bank_name');?></label></td>
					<td><?php echo form_input('bank_name'); ?></td>                
				</tr>		
				<tr>
					<td  width="150px"><label><?php echo $this->lang->line('account_no');?></label></td>
					<td><?php echo form_input('account_no'); ?>&nbsp;<span style="font-size:8pt;"><i>Masukan hanya angka tanpa (-) ataupun spasi</i></span></td>                
				</tr>				
				<tr>		
					<td  width="150px"><label><?php echo $this->lang->line('sender_name');?></label></td>
					<td><?php echo form_input('sender_name'); ?></td>                
				</tr>
				<tr>		
					<td  width="150px"><label>Biaya</label></td>
					<td><?php echo form_input(array('name'=>'amount','value'=>'100,000','readonly'=>'readonly')); ?></td>                
				</tr>
				<tr>
					<td colspan="3"><button type="submit">
					<?php echo $this->lang->line('submit');?>
					</button></td>
				</tr>
				<input type="hidden" name="formhdn" value="1" />
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
			echo success_form("Anda sudah melakukan pembayaran dan menunggu konfirmasi bendahara UT Korea Selatan"); 
		else:
			echo success_form("Anda sudah melakukan pembayaran. Terima Kasih");
		endif; 
	?>
<?php } ?>