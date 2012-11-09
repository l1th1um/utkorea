<?php 
	$sub_container = "<div style='width:33%;float:left'> \n <table style='width:100%;'>\n
					<thead><tr><th>Kode</th><th>Jurusan</th></tr></thead><tbody>";
	$container = "<div style='width:98%;'> \n".$sub_container;
	
	$end_sub_container = "</tbody></table></div>";
	$end_container = $end_sub_container."</div><div style='clear:both;padding-bottom:10px'></div>";
?>
<?php 
	echo $container;
?>
<?php
	$i = 1;
	$total = count($list);
	foreach ($list as $val) {
		echo "<tr>
				<td>
					<a href='javascript://' class='edu_id' id='$val->edu_id' style='text-decoration:none;color:#6E7A7F'>$val->edu_id</a>
				</td>
				<td>
					<a href='javascript://' class='edu_id' id='$val->edu_id' style='text-decoration:none;color:#6E7A7F'>$val->major</a>
				</td>
				</tr>";
		
		if ($i == $total) {
			echo $end_container;
		} else if ($i % 90 == 0) {
			echo $end_container.$container;
		} else if ($i % 30 == 0) {
			echo $end_sub_container.$sub_container;
		}
		
		$i++;
	}
?>
<?php 
	echo $end_container;
?>
