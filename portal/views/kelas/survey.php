<?php if(isset($message)){ echo $message; }else{
echo validation_errors('<div class="error">', '</div>'); ?>

<?php echo info_form('Semua Pertanyaan dan Catatan harus diisi'); ?>
<header>
	<h2>FORM EVALUASI TUTOR UT KOREA</h2>
	<nav>
		<ul class="tab-switch">
			<li>Tutor : <b><?php echo $tutor; ?></b>, <?php echo $title; ?> (Semester <?php echo $semester; ?>)</li>			
		</ul>
	</nav>
</header>

<form method="POST" style="margin-bottom:20px">
	<fieldset>
		<table>
			<tr>
				<td rowspan="2">No.</td>
				<td rowspan="2">Aspek yang diamati</td>
				<td colspan="4" ><center>Mutu*</center></td>
			</tr>
			<tr>				
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
			</tr>			
			<?php
			$i = 1;$a = 1;
			foreach($surveyques as $row){ ?>
			<tr>				
				<td><?php if($row[1]!==true){
					echo $row[1];
					$i = 0;
				}else{					
					echo $i;
				}?></td>
				<td><?php
				if($i!=0){
					echo $row[0];
				}else{
					echo '<b style="font-weight:bold;">'.$row[0].'</b>';	
				} ?></td>
				<?php if($i!=0){ ?>
				<td><input type="radio" name="ch<?php echo $a; ?>" value="1" /></td>
				<td><input type="radio" name="ch<?php echo $a; ?>" value="2" /></td>
				<td><input type="radio" name="ch<?php echo $a; ?>" value="3" /></td>
				<td><input type="radio" name="ch<?php echo $a; ?>" value="4" /></td>
				<?php }else{ ?>
				<td></td><td></td><td></td><td></td>				
				<?php } ?>				
			</tr>		
			<?php
			$a++;
			$i++;			
			 }?>			
		</table>
		<br />
		<label>Catatan untuk tutor/kelas</label>
		<textarea name="comment" cols="150" rows="10"></textarea>
	</fieldset>
	*)1 = kurang  |  2 = cukup   |    3  = baik   |    4 = baik sekali
	<br/>
	<button style="float:right">Simpan</button>
</form>
<?php } ?>