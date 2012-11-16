Daftar Ulang
<?php
	if (!empty($empty_val)) {
		echo error_form("Sebelum Daftar Ulang Mohon Melengkapi Data Berikut"). "\n <ul>";
		
		foreach($empty_val as $row) {
			echo "<li>".$this->lang->line($row)."</li>";
		}
		
		echo"</ul>";
	} 	
?>