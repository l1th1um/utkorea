<?php echo form_open('','id="assignment"');?>
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Semester 1</a></li>
        <li><a href="#tabs-2">Semester 2</a></li>
        <li><a href="#tabs-3">Semester 3</a></li>
        <li><a href="#tabs-4">Semester 4</a></li>
        <li><a href="#tabs-5">Semester 5</a></li>
        <li><a href="#tabs-6">Semester 6</a></li>
        <li><a href="#tabs-7">Semester 7</a></li>
        <li><a href="#tabs-8">Semester 8</a></li>
    </ul>
  	<?php
  		foreach ($course as $key => $tab) {
    		echo '<div id="tabs-'.$key.'">';
			echo '<fieldset><table>';
			echo '<thead><tr><th>Kode</th><th>Title</th><th>Credit</th><th>Tutor</th></tr></thead><tbody>';
			foreach ($tab as $column => $val) {
			?>
				<tr>
			    	<td width='150px'><?php echo $val->code ?></td>
			        <td><?php echo $val->title ?></td>                
			        <td width='50px'><?php echo $val->credit ?></td>
			        <td>
			        	<?php
			        		if ($val->tutorial == 0) {
			        			echo "UT Pusat";
			        		} else {
			        			$name = 'tutor'.$val->course_id;
			        			echo form_dropdown($name,$tutor);
			        		}
			        	?>
			        </td>
			    </tr>
			<?			        
			}
			echo '</tbody></table></fieldset>'; 
    		echo '</div>';
    	}
    ?>    
</div>

<div style="padding : 20px 0 50px 0">
	<button type="submit">Submit</button>
</div>
<?php echo form_close();?>


<div id="osx-modal-content">
	<div id="osx-modal-title">System Message</div>
	<div class="close"><a href="#" class="simplemodal-close">x</a></div>
	<div id="osx-modal-data">
		<p id='status_content'></p>
		<p><button class="simplemodal-close">Close</button> <span>( Atau Tekan Enter)</span></p>
	</div>
</div>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.simplemodal.js"></script>
<link href="<?php echo template_path('core')?>css/core.css" rel="stylesheet" type="text/css"  media='screen'/>

<script>
    $(function() {
    	$( "#tabs" ).tabs();
    	
    	$('#assignment').submit(function(event){
			event.preventDefault();
			
			
			$.post("<?php echo base_url()?>tutor/save_assignment", 
					{ major: <?php echo $this->uri->segment('3')?>, frmdata:$(this).serialize()}, function(data) {
				
				if (data == 0) {
					message = '<?php echo $this->lang->line('db_error')?>';
				} else {
					message = '<?php echo $this->lang->line('data_saved')?>';
				}
				
			   $('#status_content').html(message);
			   var OSX = {
						container: null,
						init: function () {
								$("#osx-modal-content").modal({
									overlayId: 'osx-overlay',
									containerId: 'osx-container',
									closeHTML: null,
									minHeight: 80,
									opacity: 65, 
									position: ['0',],
									overlayClose: true,
									onOpen: OSX.open,
									onClose: OSX.close
								});							
						},
						open: function (d) {
							var self = this;
							self.container = d.container[0];
							d.overlay.fadeIn('slow', function () {
								$("#osx-modal-content", self.container).show();
								var title = $("#osx-modal-title", self.container);
								title.show();
								d.container.slideDown('slow', function () {
									setTimeout(function () {
										var h = $("#osx-modal-data", self.container).height()
											+ title.height()
											+ 20; // padding
										d.container.animate(
											{height: h}, 
											200,
											function () {
												$("div.close", self.container).show();
												$("#osx-modal-data", self.container).show();
											}
										);
									}, 300);
								});
							})
						},
						close: function (d) {
							var self = this; // this = SimpleModal object
							d.container.animate(
								{top:"-" + (d.container.height() + 20)},
								500,
								function () {
									self.close(); // or $.modal.close();
								}
							);
						}
					};
				
					OSX.init();
			});
    	})
    });
</script>