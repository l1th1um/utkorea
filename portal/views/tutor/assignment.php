<h1>Tahun Ajaran <?php echo setting_val('time_period')?></h1>
<?php echo form_open();?>
<?php echo form_dropdown('major',$major,'id="major"')?>
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
		 
    	$( "select[name=major]").change(function(){
    		if ($(this).val() != 0) $('#container').load('<?php base_url()?>assignment_major/'+$(this).val())
    	});
    });
</script>