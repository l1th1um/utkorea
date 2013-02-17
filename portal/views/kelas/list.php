<style>
	.classli:hover{
		border:1px solid red;
	}	
</style>

<?php echo success_form("Anda telah terdaftar dalam kelas. Silahkan pilih kelas yang tersedia dari daftar berikut"); ?>
<div style="clear:both;margin-bottom:8px;"></div>

<?php
	if($list){
		foreach($list->result() as $row){
			?>
			<a href="<?php echo base_url(); ?>kelas/course/<?php echo $row->asgnmtid; ?>">
			<article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:200px;margin:4px;">
				<header><h2><?php echo $row->code; ?></h2></header>
				<section>
					<p><b style="font-weight:bold;"><?php echo $row->title; ?></b><br />
					   Tutor : <?php echo $row->name; ?><br />
					   Lokasi : <?php echo ($row->region)?'Utara':'Selatan'; ?>
					</p>
				</section>
			</article>
			</a>
<?php
		}
	}
?>
<div style="clear:both"></div>
