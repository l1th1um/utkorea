

<?php echo success_form("Anda telah terdaftar dalam kelas. Silahkan pilih kelas yang tersedia dari daftar berikut"); ?>
<div style="clear:both;margin-bottom:8px;"></div>

<?php
	if($list){
		$isgabung = false;	
		$tergabung = false;	
		foreach($list->result() as $row){
			foreach($gb as $row2){
				if($row2['from_assignment']==$row->realid){					
					$tergabung = true;
					break;
				}else{
					if($row2['to_assignment']==$row->realid){
						$isgabung = true;
					}
				}
			}		
			if($tergabung){ continue; }
			?>
			<a href="<?php echo base_url(); ?>kelas/course/<?php echo $row->asgnmtid; ?>">
			<article class="quarter-block nested clearrm classli" style="min-height:180px;max-height:300px;margin:4px;">
				<header><h2><?php echo $row->code; ?></h2></header>
				<section>
					<p><b style="font-weight:bold;"><?php echo $row->title; ?></b><br />
					   Tutor : <?php echo $row->name; ?><br />
					   Lokasi : <?php 
					   if($isgabung){
					   		echo 'Utara dan Selatan';
					   }else{
					   		echo $row->region;
					   }?>
					</p>
				</section>
			</article>
			</a>
<?php
		}
	}
?>
<div style="clear:both"></div>
