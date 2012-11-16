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
			
});	