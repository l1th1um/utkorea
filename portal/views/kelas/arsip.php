<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.fileupload.js"></script>
<script type='text/javascript' src='http://www.scribd.com/javascripts/scribd_api.js'></script>
<script type="text/javascript">
$(document).ready(function(){	
	var curid = '';
	function getdocscribd(doc_id,access_key){
	  	var scribd_doc = scribd.Document.getDoc(doc_id,access_key); 
	  
	  	scribd_doc.addParam( 'jsapi_version', 2 );  
	  	scribd_doc.write('embedded_presentation');	
	  	scribd_doc.addEventListener('docReady',function(){
	  		$("#embedded_presentation").append('<a target="_blank" href="<?php echo base_url(); ?>kelas/arsip_download/' + doc_id + '/' + curid + '"><button class="blue" style="float:right;margin:4px;">Download</button></a><button alt="' + doc_id + '" id="delete" style="float:right;margin:4px;">Hapus dari Arsip</button>');
	  	});
	}
	function loadList(id,isnew){
		isnew = (typeof isnew === "undefined") ? false : isnew;
		var dt = $(".datatable").dataTable();
		$.ajax({
				type: "POST",			 
				url: '<?php echo base_url(); ?>kelas/get_class_archive/' + id,
				dataType: "html",
				beforeSend: function(){					
					$(".datatable tbody").html("<tr><td></td><td><span class='loader blue' title='Processing. Please Wait'></span></td></tr>");
				},
				success: function(data){	
					dt.fnDestroy();											
					$(".datatable tbody").html(data);
					$(".datatable").dataTable( {
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
	$("#delete").live('click',function(){
		var doc_id = $(this).attr('alt');
		$( "#dialog-confirm" ).dialog({
	      resizable: false,
	      height:140,
	      modal: true,
	      buttons: {
	        "Delete": function() {
	          	$.ajax({
						type: "POST",			 
						url: '<?php echo base_url(); ?>kelas/arsip_delete/' + doc_id + '/' + curid,
						dataType: "html",
						beforeSend: function(){		
							$("#embedded_presentation").html("");			
							$(".datatable tbody").html("<tr><td></td><td><span class='loader blue' title='Processing. Please Wait'></span></td></tr>");
						},
						success: function(data){	
							loadList(curid);																
						}	
				});
				$( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
	});
	$(".docarsip").live('click',function(){
			var doc_id = $(this).attr("alt");
			var access_key = $(this).find(":hidden").val();
			getdocscribd(doc_id,access_key);
		});
	$(".trglist").click(function(){
		$("#embedded_presentation").html("");
		var id = $(this).attr("alt");
		curid = id;
		var title = $(this).html();
		$("#listcontainer").show();
		$("#title").html(title);
		$("#title br").remove();
		$('.fileupload').remove();
		$("#uploadagent").html('<?php echo form_upload(array('style'=>'margin-left:14px','name'=>'upload','class'=>'fileupload')); ?>');
		$('.fileupload').attr('data-url','<?php echo base_url(); ?>kelas/do_upload/' + id);
		
		loadList(id);	
		
		
		$('.fileupload').fileupload({
						dataType: 'json',
						maxFileSize: 5000,
						acceptFileTypes: /(\.|\/)(pdf|doc?x|ppt?x|txt)$/i,
						progress: function () {				
							$(".datatable tbody").html("<tr><td></td><td><span class='loader blue' title='Processing. Please Wait'></span></td></tr>");
						},
						error: function (e, data) {
							alert(data);
						},
						done: function (e, data) {							
							loadList(data.result.id,true);							
						}
		});	
	});
		
	
});
</script>
<div class="sidetabs">
	<nav class="sidetab-switch">
		<ul>
			<?php foreach($list->result() as $row){
				echo '<li><a class="trglist" href="#" alt="'.$row->id.'">('.$row->code.')<br />'.$row->title.'</a></li>';
			}?>
		</ul>
	</nav>
	<div class="sidetab default-sidetab">
		<article id="listcontainer" class="half-block" style="display:none;float:left;">
			<header>
				<h2 id="title"></h2>				
			</header>
			<label for="upload">Upload File untuk Kelas ini</label>	
			<span id="uploadagent"></span>
			<span style="font-size:8pt">Format : .doc .docx .ppt .pptx .pdf</span>
			<hr />		
			<table class="datatable">
		  		<thead>
		  			<tr>
		  				<th>Name</th>
		  				<th>Upload Date</th>
		  			</tr>
		  		</thead>
		  		<tbody></tbody>
		  	</table>
		</article>
		<div id="embedded_presentation" class="half-block" style="float:left;width:387px">
			
		</div>
	</div>
</div>
<div id="dialog-confirm" title="Hapus File Ini?" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>File ini akan di hapus permanent. Anda yakin?</p>
</div>

	