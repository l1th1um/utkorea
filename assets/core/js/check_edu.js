/*
 * SimpleModal Contact Form
 * http://www.ericmmartin.com/projects/simplemodal/
 * http://code.google.com/p/simplemodal/
 *
 * Copyright (c) 2010 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Revision: $Id: contact.js 254 2010-07-23 05:14:44Z emartin24 $
 */

jQuery(function ($) {
	var contact = {
		message: null,
		init: function () {
			$('a.contact').click(function (e) {
				e.preventDefault();
				// load the contact form using ajax
				$.get("edu_list", function(data){
					// create a modal dialog with the data
					$(data).modal({						
						onShow: contact.show
						//onClose: contact.close
					});
				});
			});
		},	
		show: function (dialog) {
			$("table thead tr").css({"background-color":"#CAE8EA","color":"#4F6B72"});	
			$("table tbody tr:odd").css({"background-color":"#FFFFFF","color":"#4F6B72"});	
			$("table tbody tr:even").css({"background-color":"##F5FAFA","color":"#797268"});	
			
			$('.edu_id').click(function (e) {
				var edu_id = $(this).attr("id");
				
				$('input[name=last_education_major]').val(edu_id);
				$.modal.close();
			});
		},
		close: function (dialog) {
			$('#contact-container .contact-message').fadeOut();
			$('#contact-container .contact-title').html('Goodbye...');
			$('#contact-container form').fadeOut(200);
			$('#contact-container .contact-content').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class="contact-error"></div>').append(contact.message))
				.fadeIn(200);
		}
	};

	contact.init();

});