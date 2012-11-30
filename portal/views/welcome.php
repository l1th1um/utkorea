Selamat Datang, <?php echo user_detail('name',$this->session->userdata('username'))?>

<div style='padding-top:20px'>
	<?php
		if ($news == false && empty($message)) {
	?>
			<h2 style="text-align: center;font-size: 20px">
				<?php echo $this->lang->line('no_announcement')?>			
			</h2>
	<?php	
		}  else {
			echo $news;	
			
		if(!empty($message)){
			echo '<table>
				  <thead>
					<td>Dari</td><td>Pesan</td><td>Timestamp</td>
				  </thead>';
			foreach($message->result() as $row){
				echo '<tr><td>'.$row->from.'</td><td>'.highlight_notif(html_entity_decode($row->message)).'</td><td>'.$row->timestamp.'</td></tr>';
			}	
			echo '</table>';
		}
	?>
	<?php
		}
	?>
</div>
