<script type='text/javascript' src='http://www.scribd.com/javascripts/scribd_api.js'></script>
<script src="<?php echo admin_tpl_path()?>js/jquery-1.8.2.min.js"></script>
<script src="<?php echo admin_tpl_path()?>js/jqueryui/js/jquery-ui-1.9.1.custom.min.js"></script>

<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery-ui-1.8.19.custom.css" />
<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/style.css" />

<script type="text/javascript">
$(document).ready(function(){	
  function getdocscribd(doc_id,access_key){
  	var scribd_doc = scribd.Document.getDoc(doc_id,access_key); 
  
  	scribd_doc.addParam( 'jsapi_version', 2 );  
    scribd_doc.addParam( 'height', 500 );
  	scribd_doc.write('embedded_presentation');	
  	scribd_doc.addEventListener('docReady',function(){
	  		$("#embedded_presentation").append('<a target="_blank" href="<?php echo base_url(); ?>kelas/arsip_download/' + doc_id + '/<?php echo $class_id ?>"><button class="blue" style="float:right;margin:4px;">Download</button></a><?php if(!is_numeric($this->session->userdata('username'))){ ?><button alt="' + doc_id + '" id="delete" style="float:right;margin:4px;">Hapus dari Arsip</button><?php } ?>');
	  	});
  }  
  window.onload = getdocscribd('<?php echo $doc_id; ?>','<?php echo $access_key; ?>');
  
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
							url: '<?php echo base_url(); ?>kelas/arsip_delete/<?php echo $doc_id; ?>/<?php echo $class_id ?>',
							dataType: "html",
							beforeSend: function(){		
								$("#embedded_presentation").html("");			
								$(".datatable tbody").html("<tr><td></td><td><span class='loader blue' title='Processing. Please Wait'></span></td></tr>");
							},
							success: function(data){	
								opener.location.reload();  								
  								window.close();																
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
 }); 
</script>
<body style="background:none">
<div style="width:490px;" id="embedded_presentation"></div>
<div id="dialog-confirm" title="Hapus File Ini?" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>File ini akan di hapus permanent. Anda yakin?</p>
</div>
</body>