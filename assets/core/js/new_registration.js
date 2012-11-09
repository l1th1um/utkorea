$(document).ready(function(){
	
	$('.teach_opt').hide();

	$(".fancy").validate({
						  rules:{
								  name : "required",
								  ktp : "required",
								  passport : "required",
								  place_of_birth : "required",
								  address_id : "required",
								  address_kr : "required",
								  phone : "required",
								  email: {required: true,email: true},
								  mother_name : "required",
								}
	});

	
	$('#teach').change(function(){
		if ($(this).val() == '1') {
			$('.teach_opt').show('slow');
		} else {
			$('.teach_opt').hide('fast');
		}	
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