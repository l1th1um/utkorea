<?php if($class_settings){ ?>
<script type='text/javascript' src='http://www.scribd.com/javascripts/scribd_api.js'></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.fileupload.js"></script>
<script type="text/javascript">
  function getdocscribd(doc_id,access_key){
  	var scribd_doc = scribd.Document.getDoc(doc_id,access_key); 
  
  	scribd_doc.addParam( 'jsapi_version', 2 );  
    scribd_doc.addParam( 'height', 500 );
  	scribd_doc.write('embedded_presentation');	
  	scribd_doc.addEventListener('docReady',function(){
	  		$("#embedded_presentation").append('<a target="_blank" href="<?php echo base_url(); ?>kelas/arsip_download/' + doc_id + '/<?php echo $class_settings->id ?>"><button class="blue" style="float:right;margin:4px;">Download</button></a>');
	  	});
  }  
</script>


<?php if($class_settings->chopt=='ustream') { ?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($file){ 
			$totalc = (count($file)>1)?' '.count($file):'';
			?>
			//getdocscribd(<?php echo $file['result'.$totalc]['doc_id']; ?>, '<?php echo $file['result'.$totalc]['access_key']; ?>' );
		<?php }else{
			echo '$("#embedded_presentation").html("Scribd Service Currently not available");';
		} ?> 
		$.ajax({
			type: "POST",			 
			url: "http://api.ustream.tv/json/channel/<?php echo $class_settings->ustreamch; ?>/getCustomEmbedTag?key=<?php echo $this->config->item('ustream_key'); ?>&params=autoplay:false;mute:false;height:270;width:495",
			dataType: "jsonp",
			success: function(data){
				$("#video").append(data);					
			}	
		});	
		$.ajax({
			type: "POST",			 
			url: "http://api.ustream.tv/json/channel/<?php echo $class_settings->ustreamch; ?>/getValueOf/chat?key=<?php echo $this->config->item('ustream_key'); ?>",
			dataType: "jsonp",
			success: function(data){						
				$("#chat").append(data.embedTag);
				$("#chat").find("embed").attr("width","495");
												
			}	
		});
	});
</script>
<?php }else if($class_settings->chopt=='justin'){ ?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($file){ 
			$totalc = (count($file)>1)?' '.count($file):'';
			?>
			//getdocscribd(<?php echo $file['result'.$totalc]['doc_id']; ?>, '<?php echo $file['result'.$totalc]['access_key']; ?>' );
		<?php }else{
			echo '$("#embedded_presentation").html("Scribd Service Currently not available");';
		} ?> 
		$.ajax({
			type: "POST",	
			url: "http://api.justin.tv/api/channel/show/<?php echo $class_settings->justinch; ?>.json",				
			dataType: "jsonp",
			success: function(data){
				$("#video").append(data.embed_code);					
			}	
		});		
	});
</script>	
<?php }else if($class_settings->chopt=='bambuser'){ ?>	
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($file){ 
			$totalc = (count($file)>1)?' '.count($file):'';
			?>
			//getdocscribd(<?php echo $file['result'.$totalc]['doc_id']; ?>, '<?php echo $file['result'.$totalc]['access_key']; ?>' );
		<?php }else{
			echo '$("#embedded_presentation").html("Scribd Service Currently not available");';
		} ?> 
		$("#video").append('<iframe src="http://embed.bambuser.com/channel/<?php echo $class_settings->bambuserch; ?>?chat=1" width="495" height="270" frameborder="0"></iframe>');		
	});
</script>
<?php } ?>

<header>
		<h2><?php echo $class_settings->title; ?></h2>
		<!--<nav>
			<ul class="tab-switch">
				<li><a id="arsip" href="#">Arsip File</a></li>				
			</ul>
		</nav>-->
	</header>
    
<div style="height:auto;width:100%;position: inherit;">
    <div id="video" style="width:48%;float:left"></div>
    <div id="chat" style="width:48%;;float:left;padding-left:10px"></div>    
</div>
<div style="clear:both"></div>


<div style="height:auto;width:100%;position: inherit;padding-top:10px">
    <div style="width: 48%;float:left;">
        <article class="quarter-block nested clearrm classli" style="height:468px;margin:4px;width:100%;">
        	<header>
        		<h2>Materi Kuliah</h2>
        	</header>
        	<section>			
        		<?php if(!is_numeric($this->session->userdata('username'))){ ?>
        		<div>
	        		<label for="upload">Upload File untuk Kelas ini</label>	
					<span id="uploadagent"></span><br />
					<span style="font-size:8pt;">Format : .doc .docx .ppt .pptx .pdf</span>
				</div>
				<hr />
				<?php } ?>
        			
				<table class="datatable">
			  		<thead>
			  			<tr>
			  				<th>Name</th>
			  				<th>Upload Date</th>
			  			</tr>
			  		</thead>
			  		<tbody></tbody>
			  	</table>
			  	
			  				  	
        	</section>
        </article>
    </div>
    <div style="width: 48%;float:left;padding-left:10px" >
        <div style="width: 100%;">
            <article class="quarter-block nested clearrm classli" style="height:468px;margin:4px;width:100%">
            	<header>
            		<span><h2>Pengumuman</h2></span>
                    <span style="float:right;text-align: right;">
                        <?php
                            echo anchor(base_url()."kelas/announcement/".$id,"Selengkapnya+");
                        ?>
                    </span>
            	</header>
            	<section>
            		<?php
                        if ($announcement == false) 
                        {
                            echo $this->lang->line('no_announcement');
                        } 
                        else
                        {
                    ?>
                            <table style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php
                            foreach ($announcement as $val) {
                                echo "<tr><td>".anchor('javascript://ajax',$val->title,'id="ann_link" alt="'.$val->id.'" ')."</td></tr>";                                
                            }
                            echo "</tbody></table>";
                        }
                    ?>
            	</section>
            </article>
        </div>   
    </div>
</div>
<div style="clear:both"></div>

<div style="height:auto;width:100%;position: inherit;padding-top:10px">
    <div style="width: 48%;float:left;">
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Pertanyaan</h2>
                <span style="float:right;text-align: right;">
                    <?php
                        echo anchor(base_url()."kelas/question/".$id,"Selengkapnya+");
                    ?>
                </span>
        	</header>
        	<section>            
            <?php
                if ($question == false) 
                {
                    echo $this->lang->line('no_question');
                } 
                else
                {
           ?>
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Dari</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            foreach ($question as $val) {
                                echo "<tr><td>".anchor('javascript://ajax',$val->title,'id="question_link" alt="'.$val->id.'" ')."</td>";
                                echo "<td>".user_detail('name',$val->user_id)."</td></tr>";                                
                            }                         
                        }
                    ?>
                    </tbody>
                </table>
        	</section>
        </article>
    </div>
    
    <div style="width: 48%;float:left;padding-left:10px;">
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Tugas</h2>
                <span style="float:right;text-align: right;">
                    <?php
                        echo anchor(base_url()."kelas/task/".$id,"Selengkapnya+");
                    ?>
                </span>
        	</header>
        	<section>
        	<?php
                if ($task == false) 
                {
                    echo $this->lang->line('no_task');
                } 
                else
                {
                    echo "<ol>";
                    foreach ($question as $val) {
                        echo "<li>".anchor('javascript://ajax',$val->title,'id="ann_link" alt="'.$val->id.'" ')."</li>";                                
                    }
                    echo "</ol>";
                }
            ?>
        	</section>
        </article>
    </div>
    <?php if(is_numeric($this->session->userdata('username'))){ ?>
    <div style="width: 48%;float:left;" >
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Lainnya</h2>
        	</header>
        	<section>
        		<?php echo anchor(base_url(),"Absensi dan Nilai"); ?>                
        	</section>
        </article>
    </div>
    <?php } ?>
</div>
<div style="clear:both"></div>


<div style="clear:both"></div>

<?php } ?>

<script type="text/javascript">

	$(document).ready(function(){	
		var curid = <?php echo $class_settings->id; ?>;	
		function loadList(id,isnew){
			isnew = (typeof isnew === "undefined") ? false : isnew;
			var dt = $(".datatable").dataTable();

			$.ajax({
					type: "POST",			 
					url: '<?php echo base_url(); ?>kelas/get_class_archive/' + + id,
					dataType: "html",
					beforeSend: function(){					
						$(".datatable tbody").html("<tr><td></td><td><span class='loader blue' title='Processing. Please Wait'></span></td></tr>");
					},
					success: function(data){	
						dt.fnDestroy();											
						$(".datatable tbody").html(data);
						$(".datatable").dataTable( {
							"iDisplayLength": 5,
					    	"aLengthMenu": [[5, 10, 50, -1], [5, 10, 50, "All"]],
					        "aaSorting": [[ 1, "desc" ]]
					    });											
					    if(isnew){
					    	$(".datatable tbody tr").first().attr('style','background:yellow').animate({
	          						backgroundColor: "#f2f2f2",										
							}, 2500);
					    }										
					}	
			});
		}		
			
		
		$(".docarsip").live('click',function(){
			var doc_id = $(this).attr("alt");
			var access_key = $(this).find(":hidden").val();
			//getdocscribd(doc_id,access_key);
			window.open("<?php echo site_url("kelas/scribd_docview"); ?>/" + doc_id + "/" + access_key + "/<?php echo $class_settings->id; ?>",'targetWindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=508,height=538')
		});
		loadList(curid);
		
		<?php if(!is_numeric($this->session->userdata('username'))){ ?>
		$('.fileupload').remove();
		$("#uploadagent").html('<?php echo form_upload(array('style'=>'margin-left:14px','name'=>'upload','id'=>'fileupload')); ?>');
		$('#fileupload').attr('data-url','<?php echo base_url(); ?>kelas/do_upload/' + curid);
		$('#fileupload').fileupload({
						dataType: 'json',
						maxFileSize: 5000,
						acceptFileTypes: /(\.|\/)(pdf|doc?x|ppt?x|txt)$/i,
						progress: function () {				
							$(".datatable tbody").html("<tr><td></td><td><span class='loader blue' title='Processing. Please Wait'></span></td></tr>");
						},
						error: function (e, data){
							//alert(data);
							loadList(curid,true);
						},
						done: function (e, data) {		
							//alert(data.result.id)					
							loadList(data.result.id,true);							
						}
		});
		<?php } ?>
	});
</script>

<!-- Some Reference for Block -->
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.simplemodal.js"></script>
<script type='text/javascript'>
jQuery(function ($) {
var contact = {
	message: null,
	init: function () {
		$('a#ann_link').click(function (e) {		    
			e.preventDefault();
			var uid = "<?php echo $id?>"; 
			var ann_id = $(this).attr("alt");
			// load the contact form using ajax
			$.post("<?php echo base_url()?>kelas/show_announce_class",{assignment_id:uid, id : ann_id}, function(data){			
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


jQuery(function ($) {
var contact = {
	message: null,
	init: function () {
		$('a#question_link').click(function (e) {		    
			e.preventDefault();
			var uid = "<?php echo $id?>"; 
			var ann_id = $(this).attr("alt");
			// load the contact form using ajax
			$.post("<?php echo base_url()?>kelas/display_detail_question",{assignment_id:uid,id : ann_id}, function(data){			
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

