<?php
/* 
if($pengumuman->num_rows()>0){
	foreach($pengumuman->result() as $row){
		echo info_form($row->content);
	}
 
}*/
?>

<?php if($class_settings){ ?>
<script type='text/javascript' src='http://www.scribd.com/javascripts/scribd_api.js'></script>

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
			getdocscribd(<?php echo $file['result'.$totalc]['doc_id']; ?>, '<?php echo $file['result'.$totalc]['access_key']; ?>' );
		<?php }else{
			echo '$("#embedded_presentation").html("Scribd Service Currently not available");';
		} ?> 
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
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($file){ 
			$totalc = (count($file)>1)?' '.count($file):'';
			?>
			getdocscribd(<?php echo $file['result'.$totalc]['doc_id']; ?>, '<?php echo $file['result'.$totalc]['access_key']; ?>' );
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
			getdocscribd(<?php echo $file['result'.$totalc]['doc_id']; ?>, '<?php echo $file['result'.$totalc]['access_key']; ?>' );
		<?php }else{
			echo '$("#embedded_presentation").html("Scribd Service Currently not available");';
		} ?> 
		$("#video").append('<iframe src="http://embed.bambuser.com/channel/<?php echo $class_settings->bambuserch; ?>?chat=1" width="360" height="270" frameborder="0"></iframe>');		
	});
</script>
<?php } ?>

<header>
		<h2><?php echo $class_settings->title; ?></h2>
		<nav>
			<ul class="tab-switch">
				<li><a id="arsip" href="#">Arsip File</a></li>				
			</ul>
		</nav>
	</header>
    
<div style="height:auto;width:100%;position: inherit;">
    <div id="video" style="width:48%;float:left"></div>
    <div id="chat" style="width:48%;;float:left;padding-left:10px"></div>    
</div>
<div style="clear:both"></div>

<!--
<div style="width: 100%;">        
    <div style="width:20%;float:left;">
        This if For Material Content
    </div>
    <div style="width:70%float:left;padding-left:30px" id="embedded_presentation"></div>
</div>
-->
<!--
<article class="half-block" style="width:495px;padding:4px;float:right;">
	<header>
		<h2>
            <?php echo $class_settings->title; ?>
        </h2>
		<nav>
			<ul class="tab-switch">
				<li><a id="arsip" href="#">Arsip File</a></li>				
			</ul>
		</nav>
	</header>	
	<div style="width:490px;" id="embedded_presentation"></div>
</article>
-->

<div style="clear:both"></div>

<div style="height:auto;width:100%;position: inherit;padding-top:10px">
    <div style="width: 48%;float:left;">
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Materi Kuliah</h2>
        	</header>
        	<section>
        		Content Will Be Here
        	</section>
        </article>
    </div>
    <div style="width: 48%;float:left;padding-left:10px" >
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Pengumuman</h2>
        	</header>
        	<section>
        		Content Will Be Here
        	</section>
        </article>
    </div>
</div>
<div style="clear:both"></div>

<div style="height:auto;width:100%;position: inherit;padding-top:10px">
    <div style="width: 48%;float:left;">
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Pertanyaan</h2>
        	</header>
        	<section>
        		Content Will Be Here
        	</section>
        </article>
    </div>
    <div style="width: 48%;float:left;padding-left:10px" >
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Tugas</h2>
        	</header>
        	<section>
        		Content Will Be Here
        	</section>
        </article>
    </div>
</div>
<div style="clear:both"></div>


<div style="height:auto;width:100%;position: inherit;padding-top:10px">
    <div style="width: 48%;float:left;">
        <article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;width:100%">
        	<header>
        		<h2>Absensi</h2>
        	</header>
        	<section>
        		Content Will Be Here
        	</section>
        </article>
    </div>    
</div>
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
