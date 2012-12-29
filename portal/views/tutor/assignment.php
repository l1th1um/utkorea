<h1>Tahun Ajaran <?php echo setting_val('time_period')?></h1>
<?php echo form_open();?>
<?php echo form_dropdown('region',$region,'','id="region" class="assign_tutor" ')?>&nbsp;
<?php echo form_dropdown('major',$major,'','id="major" class="assign_tutor"')?>
<?php echo form_close();?>

<div id='container'>
	<div id='ajax_load' style='width:100%;text-align: center;display:none'>
		<img src='<?php echo template_path('core')?>images/loader.gif' style='border:none'/>
	</div>
</div>


 <script>
    $(function() {
    	$().ajaxStart(function(){
		   $('#ajax_load').show();
		});
		
		$().ajaxStop(function(){
		   $('#ajax_load').hide();
		});
		 
    	$( ".assign_tutor").change(function(){
    		reg_val = $('#region').val();
    		major_val = $('#major').val();
    		
    		if ( (reg_val != 0) &&  (major_val != 0) ) $('#container').load('<?php base_url()?>assignment_major/'+major_val+'/'+reg_val)
    	});
    });
</script>