<script type="text/javascript">
$("#responseBtn").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    
    var response = $('#responseTxt').val();
            
    $.post("<?php echo base_url()?>kelas/question_response",
        {id : <?php echo $question_id  ?>,response : response}, function(data){
            if (data == "1") 
            {
    		    var text = "<tr><td>&nbsp;</td><td>";
                text += "<p style='font-size:10px;padding-bottom:20px;color : #4f6b72'>";
                text += "<i>Dari : <?php echo user_detail('name',$this->session->userdata('username'));?></i></p>";
                text += "<p style='color : #4f6b72'>" + response + "</p></td></tr>";
                
                $(text).appendTo("table[id=simplemodal-data]");
                
                $('#responseTxt').val("");
		}
    
        else
        {
            alert("<?php echo $this->lang->line('db_error')?>");
        }	
        });
});
  
</script>   
<table style="width:100%" >
	<tr>
		<td style="width:120px"><label><?php echo $this->lang->line('from')?></label></td>
		<td><?php echo user_detail('name',$row->user_id);?></td>
	</tr>
    <tr>
		<td><label><?php echo $this->lang->line('title')?></label></td>
		<td><?php echo $row->title?> ( <?php echo convertHumanDate($row->created,false) ?> )</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<?php
			$news = $row->content;  
			if ($this->config->item('live_site') == 1) {
				$news = str_replace('utkorea/','',$news);
			} echo $news            
			?>
		</td>
	</tr>
    
    <?php
    if ($response != false)
    {
        foreach ($response as $val)
        {
    ?>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <p style='font-size:10px;padding-bottom:20px;color : #4f6b72'>
                        <i>Dari : <?php echo user_detail('name',$val->user_id);?></i>
                    </p>
                    <p style='color : #4f6b72'>
                        <?php echo $val->response; ?>
                    </p>
                </td>
            </tr>
    <?php
        }
    }
    ?>
</table>
<form action="" method="POST" name="responseFrm" id="responseFrm">
<div style="float: right;">
    <textarea name="response" id="responseTxt" style="width: 500px;height:70px"></textarea>
    <p style="text-align: right;">
        <button class="green" id="responseBtn" onclick="responseEvent()">Response</button>
    </p>
</div>
</form>