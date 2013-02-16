<script type='text/javascript' src='http://www.scribd.com/javascripts/scribd_api.js'></script>
<script src="<?php echo admin_tpl_path()?>js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/style.css" />

<script type="text/javascript">
  function getdocscribd(doc_id,access_key){
  	var scribd_doc = scribd.Document.getDoc(doc_id,access_key); 
  
  	scribd_doc.addParam( 'jsapi_version', 2 );  
    scribd_doc.addParam( 'height', 500 );
  	scribd_doc.write('embedded_presentation');	
  	scribd_doc.addEventListener('docReady',function(){
	  		$("#embedded_presentation").append('<a target="_blank" href="<?php echo base_url(); ?>kelas/arsip_download/' + doc_id + '/<?php echo $class_id ?>"><button class="blue" style="float:right;margin:4px;">Download</button></a>');
	  	});
  }  
  window.onload = getdocscribd('<?php echo $doc_id; ?>','<?php echo $access_key; ?>');
  
</script>
<body style="background:none">
<div style="width:490px;" id="embedded_presentation"></div>
</body>