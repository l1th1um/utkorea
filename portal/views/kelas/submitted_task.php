<div style="clear: both;"></div>
<?php if (isset($message)) echo "<h3>".$message."</h3>";  else $message= '';?>
<h3><?php $this->lang->line('task')?></h3>
<?php
    if ($list == false) {
        echo $this->lang->line('no_task_submitted');
    }
    else 
    {
?>
<h2 style=";font-size: 14px;padding:10px 0">
	<?php echo $this->lang->line('task')." : ".$task->title?>      			
</h2>
<table>
	<thead>
		<tr>
			<th style='width:50px;'>No</th>
            <th style='width:100px;'>NIM</th>
			<th style='width:150px;'>Nama</th>
            <th>Content</th>
            <th style='width:200px;'>File</th>
            <th style='width:150px;'>Tanggal Submit</th>
		</tr>
	</thead>
    <tbody>
        <?php
            $i = 1;
            foreach($list as $val)
            {
                echo "<tr>";
                echo "<td>".$i."</td>";
                echo "<td>".$val['nim']."</td>";
                echo "<td>".user_detail('name',$val['nim'])."</td>";
                echo "<td>".$val['content']."</td>";
                echo "<td>";
                if ($val['attachment'] <> false)
                {
                    echo "<ul>";
                    
                    foreach ($val['attachment'] as $val2) {
                        $mime_icon = array(
                                'src' => base_url().'assets/core/images/fileicons/'.$val2['icon'].'.png',
                                'style' => 'border:none;background:none'  
                        );
                    
                        echo "<li>";
                        echo img($mime_icon);
                        echo anchor(base_url()."attach/".$val2['uuid'],$val2['original_file'],"style=text-decoration:none;color:#000000;");
                        echo "</li>";
                    }
                    echo "</ul>";    
                }                
                echo "</td>";
                echo "<td>".convertHumanDate($val['created'])."</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>
<?php
}
?>