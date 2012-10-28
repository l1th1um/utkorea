<?php
	if($res->num_rows()>0){ ?>
	<select name="who" multiple="multiple" size="20">
	<?php	foreach ($res->result() as $row)
	   { ?>
		<option value="<?php echo $row->phone; ?>"><?php echo $row->name; ?></option>		
	   <?php } ?>
	 </select>  
	<?php    
	}
?>