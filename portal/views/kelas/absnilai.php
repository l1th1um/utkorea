<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>
<?php if($success){
	echo success_form('Data telah di simpan');
}?>
<h1>Kelas Anda :</h1> 
<i style="font-style:italic;font-size:9pt;color:#666666;">Data ini dapat diubah sewaktu - waktu untuk menyesuaikan kegiatan belajar-mengajar</i><br />
<br /><br />
<form method="POST" >
<?php if($list){ ?>
<div id="tabs">
	<?php
		$tabs = '<ul>';
		$divs = ''; 
		$curridasignment = 0;
		$first = true;
		foreach($list->result() as $row){			
			if($curridasignment!=$row->id_assignment){
				if(!$first){
					$divs .= '</tbody></table>';
					$divs .= '</div>';
				}
				$curridasignment = $row->id_assignment;
				$tabs .= '<li><a href="#tabs-'.$row->id.'">('.$row->code.') <b>'.$row->title.'</b></a></li>';
				$divs .= '<div id="tabs-'.$row->id.'">';
				$divs .= '<table class="datatable" >
							<thead>
								<tr>
									<td rowspan="2" style="vertical-align:middle;">(NIM) Student</td>
									<td colspan="8" style="text-align:center">Pertemuan</td>
									<td colspan="3" style="text-align:center">Tugas</td>
								</tr>
								<tr>';
				for($i=1;$i<=8;$i++){
					$divs .= '<td style="text-align:center">'.$i.'</td>';
				}
				$divs .= '<td style="text-align:center">I</td>';
				$divs .= '<td style="text-align:center">II</td>';
				$divs .= '<td style="text-align:center">III</td>';
				
				$divs .= '</tr></thead><tbody>';
			}			
			$divs .='<tr><td>('.$row->nim.') '.$row->name.'</td>';
			for($i=1;$i<=8;$i++){
				$divs .= '<td style="text-align:center"><input ';
				foreach(explode(",",$row->absensi) as $row2){
					if($i == $row2){
						$divs .= 'checked="checked" ';
					}
				}
				$divs .='type="checkbox" name="abs_'.$row->id_assignment.'_'.$row->nim.'[]" value="'.$i.'" /></td>';
			}
			$divs .= '<td style="text-align:center"><input value="'.$row->tugas1.'" type="text" name="tugas_'.$row->id_assignment.'_'.$row->nim.'_1" size="1" /></td>';
			$divs .= '<td style="text-align:center"><input value="'.$row->tugas2.'" type="text" name="tugas_'.$row->id_assignment.'_'.$row->nim.'_2" size="1" /></td>';
			$divs .= '<td style="text-align:center"><input value="'.$row->tugas3.'" type="text" name="tugas_'.$row->id_assignment.'_'.$row->nim.'_3" size="1" /></td>';
							
			$divs .= '</tr>';
			$first = false;
		}
			$divs .= '</tr>
						</tbody>
					</table>';
			$divs .= '</div>';
		$tabs .= '</ul>';
		echo $tabs;
		echo $divs;
	 ?>
  
</div>


<br />
<button type="submit">Simpan</button>
</form>
<?php } ?>