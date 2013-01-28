

<script type="text/javascript">
	$(document).ready(function(){
		$( ".check" ).button();
		$("#ann_click").click(function(e){
			e.preventDefault();
			
			$("#ann_click_res").dialog({
				modal:true,
				position: { my: "center top", at: "center top", of: "body" },
				resizable: false,
				width:600,
				height:650
			});
		});
	});
</script>

<h1>Kelas Tersedia :</h1> 
<i style="font-style:italic;font-size:9pt;color:#666666;">Pengaturan ini hanya dapat dilakukan sekali pada tiap awal semester, harap perhatikan kelas yang akan anda ambil</i><br />
<a id="ann_click" href="#">Klik disini untuk petunjuk</a>
<div id="ann_click_res" style="width:550px;display:none">
	<img src="<?php echo template_path('core').'images/regsiterclasscmp.jpg'; ?>" width="550" />
</div>
<div style="clear:both;margin-bottom:8px;"></div>
<form method="POST" >
<?php
	if($classes){
		foreach($classes->result() as $row){
			?>
			<article class="quarter-block nested clearrm" style="height:140px;margin-right:6px">
				<header><h2><?php echo $row->code; ?></h2>
					<?php if($semester>6) { ?><span style="float:right;"><input type="checkbox" checked="checked" class="check" name="classid[]" id="check<?php echo $row->asgmntid; ?>" value="<?php echo $row->asgmntid; ?>" /><label for="check<?php echo $row->asgmntid; ?>">Pilih Kelas</label></span><?php }else{ ?>
					<input type="hidden" name="classid[]" value="<?php echo $row->asgmntid; ?>"	 /><?php } ?>
				</header>
				<section>
					<p><b style="font-weight:bold;"><?php echo $row->title; ?></b><br />
					   Tutor : <?php echo $row->name; ?><br />
					   Lokasi : <?php echo ($row->region)?'Utara':'Selata'; ?>
					</p>
				</section>
			</article>
			
<?php
		}
	}
?>
<div style="clear:both"></div>
<hr />
	<button type="submit">
					<?php echo $this->lang->line('submit');?>
				</button>
</form>

