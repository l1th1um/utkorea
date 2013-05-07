<header>
	<h2>Nilai : <?php echo $myclass->title; ?></h2>
</header>

<table>
	<tr>
		<td>Tugas TA (1)</td>
		<td><?php echo $myclass->tugas1; ?></td>		
	</tr>
	<tr>
		<td>Tugas TA (2)</td>
		<td><?php echo $myclass->tugas2; ?></td>		
	</tr>	
	<tr>
		<td>Tugas TA (3)</td>
		<td><?php echo $myclass->tugas3; ?></td>		
	</tr>	
	<tr>
		<td>Tugas TA</td>
		<td><?php echo (($myclass->tugas1 + $myclass->tugas2 + $myclass->tugas3)/3); ?></td>		
	</tr>	
	<tr>
		<td>Partisipasi</td>
		<td><?php echo $myclass->partisipasi; ?></td>		
	</tr>
	<tr>
		<td><b style="font-weight:Bold;">Total</b></td>
		<td><?php echo (0.7*(($myclass->tugas1 + $myclass->tugas2 + $myclass->tugas3)/3)+0.3*$myclass->partisipasi); ?></td>		
	</tr>				
</table>	

<?php echo success_form('Pertanyaan mengenai nilai harap berkomunikasi langsung dengan tutor terkait'); ?>

