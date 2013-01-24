$(function () {

	// Notification Close Button
	$(".close-notification").click(
		function () {
			$(this).parent().fadeTo(350, 0, function () {$(this).slideUp(600);});
			return false;
		}
	);

	// jQuery Tipsy
	$('[rel=tooltip], #main-nav span, .loader').tipsy({gravity:'s', fade:true}); // Tooltip Gravity Orientation: n | w | e | s

	// jQuery Facebox Modal
	$('a[rel*=modal]').facebox();

	// jQuery jWYSIWYG Editor
	$('.wysiwyg').wysiwyg({ iFrameClass:'wysiwyg-iframe' });
	
	// jQuery dataTables
	//$('.datatable').dataTable();

	// Check all checkboxes
	$('.check-all').click(
		function(){
			$(this).parents('form').find('input:checkbox').attr('checked', $(this).is(':checked'));
		}
	)

	// IE7 doesn't support :disabled
	$('.ie7').find(':disabled').addClass('disabled');

	// Menu Dropdown
	$("#main-nav li ul").hide(); //Hide all sub menus
	$("#main-nav li.current a").parent().find("ul").slideToggle("slow"); // Slide down the current sub menu
	$("#main-nav li a").click(
		function () {
			$(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all menus except the one clicked
			$(this).parent().find("ul").slideToggle("normal"); // Slide down the clicked sub menu
			return false;
		}
	);
	$("#main-nav li a.no-submenu").click(
		function () {
			window.location.href=(this.href); // Open link instead of a sub menu
			return false;
		}
	);

	// Widget Close Button
	$(".close-widget").click(
		function () {
			$(this).parent().fadeTo(350, 0, function () {$(this).slideUp(600);});
			return false;
		}
	);

	// Image actions
	$('.image-frame').hover(
		function() { $(this).find('.image-actions').css('display', 'none').fadeIn('fast').css('display', 'block'); }, // Show actions menu
		function() { $(this).find('.image-actions').fadeOut(100); } // Hide actions menu
	);

	// Content box tabs
	$('.tab').hide(); // Hide the content divs
	$('.default-tab').show(); // Show the div with class "default-tab"
	$('.tab-switch a.default-tab').addClass('current'); // Set the class of the default tab link to "current"

	$('.tab-switch a').click(
		function() { 
			var tab = $(this).attr('href'); // Set variable "tab" to the value of href of clicked tab
			$(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
			$(this).addClass('current'); // Add class "current" to clicked tab
			$(tab).siblings('.tab').hide(); // Hide all content divs
			$(tab).show(); // Show the content div with the id equal to the id of clicked tab
			return false;
		}
	);

	// Content box side tabs
	$(".sidetab").hide();// Hide the content divs
	$('.default-sidetab').show(); // Show the div with class "default-sidetab"
	$('.sidetab-switch a.default-sidetab').addClass('current'); // Set the class of the default tab link to "current"
	
	$(".sidetab-switch a").click(
		function() { 
			var sidetab = $(this).attr('href'); // Set variable "sidetab" to the value of href of clicked sidetab
			$(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all sidetabs
			$(this).addClass('current'); // Add class "current" to clicked sidetab
			$(sidetab).siblings('.sidetab').hide(); // Hide all content divs
			$(sidetab).show(); // Show the content div with the id equal to the id of clicked tab
			return false;
		}
	);
	
	//Minimize Content Article
	$("article header h2").css({ "cursor":"s-resize" }); // Minizmie is not available without javascript, so we don't change cursor style with CSS
	$("article header h2").click( // Toggle the Box Content
		function () {
			$(this).parent().find("nav").toggle();
			$(this).parent().parent().find("section, footer").toggle();
		}
	);
    
    $('input[name=date_of_baseline_ct],input[name=date_comparative],input[name=study_date],input[name=date_biopsy],input[name=date_follow_up]').datepicker();
    $( "input[name=date_of_birth]").datepicker({ changeMonth: true, changeYear: true, minDate: "-140y", maxDate: "-1D", yearRange:"-110:+0" });



    jQuery.validator.messages.required = "";

    $('.intake_form').validate();
    
    $('input[name=date_of_birth]').change(function(){
        var birth_date = $(this).val();
        
        year = birth_date.substr(6,4);
        month = birth_date.substr(0,2);
        date = birth_date.substr(3,2);
        
        age = getAge(year,month,date);
        
        $('.age').html(age + " years");
    })
     
    $('input[name=weight],input[name=height]').keyup(function(){
        if ( ($('input[name=height]').val() != "") && ($('input[name=weight]').val() != "") ) {
            bmi = calculateBMI();
            $('.bmi').html(bmi);
        } 
    });
    
    $('#height_unit,#weight_unit').change(function(){
        if ( ($('input[name=height]').val() != "") && ($('input[name=weight]').val() != "") ) {
            bmi = calculateBMI();
            $('.bmi').html(bmi);
        }
    });
    
    $(".pnc_link").click(function(){
        target = $(this).attr("href");
        window.location = target;
    })
    
    $('#spinner1').spinner({ min: 1, max: 150, increment: 'fast' });
	$('#spinner2').spinner({ min: 1, max: 25, increment: 'fast' });
	$('#spinner3a,#spinner3b').spinner({ min: 1, max: 20, increment: 'fast' });
	
    $('input[name=date_of_baseline_check]').click(function(){
        if ($('input[name=date_of_baseline_check]')[0].checked) {
            $('input[name=date_of_baseline_ct]').attr("disabled","disabled");
        } else {            
            $('input[name=date_of_baseline_ct]').removeAttr("disabled");
        }
    });
    
    $('input[name=date_of_comparative_check]').click(function(){
        if ($('input[name=date_of_comparative_check]')[0].checked) {
            $('input[name=date_comparative]').attr("disabled","disabled");
        } else {            
            $('input[name=date_comparative]').removeAttr("disabled");
        }
    });
    
    $('#create_eval').click(function(){
        window.location = $(this).val();        
    });
    
});


function getAge(year,month,day) {
    var today = new Date();
    var birthDate = new Date(year,month,day,0,0,0);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

function calculateBMI() {
    var height = $("input[name='height']").val();
    var weight = $('input[name=weight]').val();
    var height_unit = $('#height_unit').val();
    var weight_unit = $('#weight_unit').val();
    
    if (height_unit == '0') {
        height = height * 0.0254; 
    } else if (height_unit == '1') {
        height = height * 0.01;
    }
    
    // Convert weight to kg
    if (weight_unit == '0') {
        weight = weight * 0.45359237; 
    } 
    
    bmi = number_format(weight/ (height * height));
    
    return bmi;    
}

function number_format( number, decimals, dec_point, thousands_sep ) {    
    var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    var d = dec_point == undefined ? "." : dec_point;
    var t = thousands_sep == undefined ? "," : thousands_sep, s = n < 0 ? "-" : "";
    var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;        

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");

}