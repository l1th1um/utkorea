<?php if($class_settings){ ?>
<script type='text/javascript' src='http://www.scribd.com/javascripts/scribd_api.js'></script>

<script type="text/javascript">
  function getdocscribd(doc_id,access_key){
  	var scribd_doc = scribd.Document.getDoc(doc_id,access_key); 
  
  	scribd_doc.addParam( 'jsapi_version', 2 );  
  	scribd_doc.write('embedded_presentation');	
  }  
</script>


<?php if($class_settings->chopt=='ustream') { ?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($file){ ?>
			getdocscribd(<?php echo $file['result '.count($file)]['doc_id']; ?>, '<?php echo $file['result '.count($file)]['access_key']; ?>' );
		<?php } ?> 
		$.ajax({
			type: "POST",			 
			url: "http://api.ustream.tv/json/channel/<?php echo $class_settings->ustreamch; ?>/getCustomEmbedTag?key=<?php echo $this->config->item('ustream_key'); ?>&params=autoplay:false;mute:false;height:270;width:360",
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
				$("#chat").find("embed").attr("width","360");
												
			}	
		});
	});
</script>
<?php }else if($class_settings->chopt=='justin'){ ?>
	
<?php } ?>


<div style="height:500;width:418px;float:right">
	<article id="video" class="half-block nested clearfix" style="width:360px;padding:6px;text-align:center" >		
	</article>
	<article id="chat" class="half-block clearfix" style="width:360px;padding:6px;" >		
	</article>
</div>

<article class="half-block" style="width:566px;padding:4px;float:right;">
	<header>
		<h2><?php echo $class_settings->title; ?></h2>
		<nav>
			<ul class="tab-switch">
				<li><a id="arsip" href="#">Arsip File</a></li>				
			</ul>
		</nav>
	</header>	
	<div style="width:566px;" id="embedded_presentation"></div>
</article>
<div style="clear:both"></div>
<?php } ?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#arsip").click(function(){
			$.ajax({
				type: "POST",			 
				url: '<?php echo base_url(); ?>kelas/get_class_archive/<?php echo $class_settings->id; ?>',
				dataType: "html",
				success: function(data){
					$(".datatable tbody").html(data);				
					$( "#dialog-message" ).dialog({
				      modal: true,
				      width: 600
				    });				
				}	
			});	
		});
		$(".docarsip").live('click',function(){
			var doc_id = $(this).attr("alt");
			var access_key = $(this).find(":hidden").val();
			getdocscribd(doc_id,access_key);
		});
		
	});
</script>
<div id="dialog-message" title="Arsip File" style="display:none">
  <table class="datatable">
  		<thead>
  			<tr>
  				<th>Name</th>
  				<th>Upload Date</th>
  			</tr>
  		</thead>
  		<tbody></tbody>
  </table>
</div>
