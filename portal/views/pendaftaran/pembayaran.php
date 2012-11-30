<link href="<?php echo template_path('core')?>css/core.css" rel="stylesheet" type="text/css"  media='screen'/>

<?php if (isset($message)) echo $message;  else $message= '';?>

<?php if ($show_form):?>
<h3>Konfimasi Pembayaran Mahasiswa Baru</h3>
                <div class="form-box-top"></div>
                <div class="form-box">
                    <div id="contactFormArea">
						                            
                    
<?php echo form_open_multipart(current_url(), array('class'=>'fancy')); ?>
	<fieldset>
	<ol>
		<li>
			<label class="element">
				No Pendaftaran
			</label>
			<div class="element">
				<?php echo form_input('nim',$this->input->post('nim'),'id="noReg"')?>												
			</div>			
		</li>
		<li class='check_el'>
			<label class="element">
				&nbsp;
			</label>
			<div class="element">				
				<input type="button" name="checkBtn" value="Cek" class="fancy_button" id="check" />								
			</div>			
		</li>
	</ol>		
	<ol class='payment_form' style='display:none'>
		<li>
			<label class="element">
				<label><?php echo $this->lang->line('payment_date');?></label>
			</label>
			<div class="element">
				<?php echo form_input('payment_date',$this->input->post('payment_date'),'style="width:8em"'); ?>
			</div>
		</li>
		<li>
			<label class="element">
				<label><?php echo $this->lang->line('bank_name');?></label>
			</label>
			<div class="element">
				<?php echo form_input('bank_name',$this->input->post('bank_name')); ?>
			</div>
		</li>
		<li>
			<label class="element">
				<label><?php echo $this->lang->line('account_no');?></label>
			</label>
			<div class="element">
				<?php echo form_input('account_no',$this->input->post('account_no')); ?>
			</div>
		</li>
		<li>
			<label class="element">
				<label><?php echo $this->lang->line('sender_name');?></label>
			</label>
			<div class="element">
				<?php echo form_input('sender_name',$this->input->post('sender_name')); ?>
			</div>
		</li>
		<li>
			<label class="element">
				&nbsp;
			</label>
			<div class="element">
				<input type="submit" name="submitRegBtn" value="Submit" class="fancy_button" />
			</div>
		</li>
	</ol>	       
    </fieldset>    
</form>
</div>
                      
</div>
<div class="form-box-bottom"></div>
<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery-ui-1.8.19.custom.css" />
<script src="<?php echo admin_tpl_path()?>js/jqueryui/js/jquery-ui-1.9.1.custom.min.js"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#check').click(function(event){			
			var no_reg = $('#noReg').val();
  		 
			if (no_reg.length == 0) {
				alert('Masukkan No Pendaftaran Anda')
			} else if ( (no_reg.length != 9) || (no_reg.substr(0,5) != "UTKOR") || ( isNaN( no_reg.substr(5,4) ) ) ) {
				alert('No Pendaftaran Anda Salah');
			} else {
				$.post("<?php echo base_url()?>pendaftaran/check_registration_status", { reg_code: no_reg},function(data) {
					if (data == false) {
						alert("Maaf, No Pendaftaran Tidak Ditemukan");
					} else {						
						$.post("<?php echo base_url()?>pendaftaran/check_payment_status", { nim: no_reg},function(data2) {
							if (data2 != 0) {
								alert("Anda Sudah Melakukan Pembayaran, Cek Status Pembayaran di Halaman Depan");
							} else {
								$('#noReg').attr("readonly","readonly");
								$('.payment_form').show('slow');
								$('.check_el').hide();	
							}							
						});								
					}				   
				});
				
			}
		})
		
		$( "input[name=payment_date]" ).datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '2012:2013',
				dateFormat: "dd/mm/yy"
		});
		
		$(".fancy").validate({
						  rules:{
								  no_reg : "required",
								  payment_date : "required",
								  bank_name : "required",								  
								  account_no: {required: true,number: true},
								  sender_name : "required"								  
								}
		});
	})
</script>
<?php endif;?>