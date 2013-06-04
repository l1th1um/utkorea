<header>
	<h2>Hasil Survey Kelas</h2>
</header>

<strong>Tutor</strong> 	   : <?php echo $class->name; ?><br />
<strong>Class Name</strong> : <?php echo $class->title; ?><br />
<strong>Daerah</strong> : <?php echo $class->region; ?><br />



<div class="widget <?php echo ($overall>=2.5)?'increase':'decrease'; ?>" id="new-tasks">							
		<p><strong><?php echo substr($overall,0,4); ?></strong>Nilai Overall</p>
</div>

<fieldset>
		<table>
			<tr>
				<td rowspan="2">No.</td>
				<td rowspan="2">Aspek yang diamati</td>
				<td colspan="4" ><center>Rata - rata Mutu*</center></td>
			</tr>
			<tr>				
				<td colspan="4"></td>
			</tr>			
			<?php
			$i = 1;$a = 1;$skip=0;
			foreach($surveyques as $key=>$row){ ?>
			<tr>				
				<td><?php if($row[1]!==true){
					echo $row[1];
					$i = 0;
					$skip++;
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
				<td colspan="4"><?php echo substr($total[$key-$skip]/$numresponden,0,4); ?></td>
				<?php }else{ ?>
				<td></td><td></td><td></td><td></td>	
				<?php } ?> 							
			</tr>		
			<?php
			$a++;
			$i++;			
			 }?>			
		</table>
</fieldset>

<article class="full-block nested">
	<header>
		<h2>Comments</h2>
	</header>	
	<?php foreach($comment as $row2){ ?>
		<div class="notification note">		
				<p><?php echo $row2; ?></p>
		</div>
	<?php } ?>
</article>

