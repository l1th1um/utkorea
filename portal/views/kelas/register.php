

<script type="text/javascript">
	$(document).ready(function(){
		$( ".check" ).button();
	});
</script>

<h1>Kelas Tersedia :</h1> 
<i style="font-style:italic;font-size:9pt;color:#666666;">Pengaturan ini hanya dapat dilakukan sekali pada tiap awal semester, harap perhatikan kelas yang akan anda ambil</i><br />
<a href="">Klik disini untuk petunjuk</a>
<div style="clear:both;margin-bottom:8px;"></div>
<form method="POST" >
<?php
	if($classes){
		foreach($classes->result() as $row){
			?>
			<article class="quarter-block nested clearrm" style="height:140px">
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