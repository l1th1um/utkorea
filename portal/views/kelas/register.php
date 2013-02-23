


<h1>Kelas Tersedia :</h1> 
<i style="font-style:italic;font-size:9pt;color:#666666;">Pengaturan ini hanya dapat dilakukan sekali pada tiap awal semester, harap perhatikan kelas yang akan anda ambil</i><br />
<a href="https://docs.google.com/file/d/1i48wvaX2KaHFpZr__0up0hgdyrKv9bHTPARn-tytS2AZv619ldKJ3oPQFpWC/edit?usp=sharing">Klik disini untuk petunjuk</a>

<div style="clear:both;margin-bottom:8px;"></div>
<form method="POST" >
<?php
	if($classes){
		$tergabung = false;	
		foreach($classes->result() as $row){
			$thisid = $row->asgmntid;
			foreach($gb as $row2){
				if($row2['from_assignment']==$thisid){					
					$tergabung = true;
					$thisid = $row2['to_assignment'];
					break;
				}
			}					
			?>
			<article class="quarter-block nested clearrm" style="min-height:180px;max-height:300px;margin-right:6px">
				<header><h2><?php echo $row->code; ?></h2>
					<?php if($semester>6) { ?><span style="float:right;"><input type="checkbox" checked="checked" class="check" name="classid[]" id="check<?php echo $row->asgmntid; ?>" value="<?php echo $row->asgmntid; ?>" /><label for="check<?php echo $row->asgmntid; ?>">Pilih Kelas</label></span><?php }else{ ?>
					<input type="hidden" name="classid[]" value="<?php echo $thisid; ?>"	 /><?php } ?>
				</header>
				<section>
					<p><b style="font-weight:bold;"><?php echo $row->title; ?></b><br />
					   Tutor : <?php echo $row->name; ?><br />
					   Lokasi : <?php echo $row->region; ?>
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

