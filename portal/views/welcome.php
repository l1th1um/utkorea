Selamat Datang, <?php echo user_detail('name',$this->session->userdata('username'))?>

<div style='padding-top:20px'>
	<?php
		if ($news == false) {
	?>
			<h1 style="text-align: center;font-size: 20px">
				Maaf Tidak Ada Pengumuman				
			</h1>
	<?php	
		}  else {
	?>
	<?php
		}
	?>
</div>