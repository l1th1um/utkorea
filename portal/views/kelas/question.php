<a href="javascript: history.go(-1)">Kembali ke kelas</a>
<div style="float: right;padding-bottom: 10px;">
    <?php
        if (in_array(9,$this->session->userdata('role')))
            echo anchor('kelas/create_question/'.$id,'<button class="green">Buat Pertanyaan</button>');
    ?>    
</div>
<div style="clear: both;"></div>
<?php if (isset($message)) echo "<h3>".$message."</h3>";  else $message= '';?>
<?php
    if ($list == false) {
        echo $this->lang->line('no_question');
    }
    else 
    {
?>
<h2 style=";font-size: 14px;padding:10px 0">
	<?php echo $this->lang->line('announcement')?>    			
</h2>
<table>
	<thead>
		<tr>
			<th>Tanggal</th>
			<th>Judul</th>
            <th>Dari</th>
		</tr>
	</thead>
	<tbody>
	<?php
		foreach ($list as $row) {
	?>
	<tr>
		<td style="width: 150px;"><?php echo convertHumanDate($row->created,false)?></td>
		<td><?php echo anchor('javascript://ajax',$row->title,'id="ann_link" alt="'.$row->id.'" ');?></td>
        <td style="width: 250px;"><?php echo user_detail('name',$row->user_id);?></td>
	</tr>
	<?php
		} 
	?>												
	</tbody>	
</table>


<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.simplemodal.js"></script>
<script type='text/javascript'>
		jQuery(function ($) {
		var contact = {
			message: null,
			init: function () {
				$('a#ann_link').click(function (e) {
					e.preventDefault();
					var ann_id = $(this).attr("alt");
                    var uid = "<?php echo $id?>";
					// load the contact form using ajax
					$.post("<?php echo base_url()?>kelas/display_detail_question",{assignment_id:uid, id : ann_id}, function(data){
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

	
</script>
<link href="<?php echo template_path('core'); ?>css/core.css" rel="stylesheet" type="text/css"  media='screen'/>
<?php
}
?>