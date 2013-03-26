<table width="100%">
	<tr>
		<td width="120px"><label><?php echo $this->lang->line('title')?></label></td>
		<td><?php echo $row->title?></td>
	</tr>
	<tr>
		<td><label><?php echo $this->lang->line('date')?></label></td>
		<td><?php echo convertHumanDate($row->created,false) ?></td>
	</tr>
    <tr>
		<td><label>Attachment</label></td>
		<td>
            <?php
            if ($attach <> false) 
            {
                echo "<ul style='list-style-type:none;margin-left:0'>";
                foreach($attach as $val)
                {
                    echo "<li>";
                    echo img(base_url()."assets/core/images/fileicons/".$val['icon'].".png");
                    echo anchor(base_url()."attach/".$val['uuid'],$val['original_file'],"style=text-decoration:none;color:#000000;");
                    echo "</li>";    
                }
                echo "</ul>";
                 
            }
            else
            {
                echo "-";
            }
            ?>            
        </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<?php
			$news = $row->content;  
			if ($this->config->item('live_site') == 1) {
				$news = str_replace('utkorea/','',$news);
			}			
			echo $news
			?>
		</td>
	</tr>
</table>
<?php if (in_array(9,$this->session->userdata('role'))):?>
<table width="100%" style="margin-top: 40px;">
    <tr>
        <td><label><?php echo $this->lang->line('message')?></label></td>
        <td>
            <textarea name="response" id="responseTxt" 
            style="width: 500px;height:70px"><?php if ($row_student <> FALSE)echo $row_student->content;?></textarea>
        </td>
    </tr>
    <tr>
        <td>Upload</td>
        <td>
            <input name="file_tugas" class="fileupload" type="file" 
            data-url="<?php echo base_url()?>kelas/do_upload_kelas/file_tugas/tugas_mahasiswa" />
    		<input type="hidden" name="attach_uid" /> 
    		Ukuran Maks. 10MB (gif, png, jpg, jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar)
            <p style="padding-top: 5px;" id="file_tugas_cont"></p>
            <?php
                if ($attach_student <> false) {
                            echo "<ul style='list-style-type:none;margin-left:0'>";
                            foreach ($attach_student as $val)
                            {
                                $mime_icon = array(
                                        'src' => base_url().'assets/core/images/fileicons/'.$val['icon'].'.png',
                                        'style' => 'border:none;background:none'  
                                );
                                
                                $del_icon = array(
                                          'src' => admin_tpl_path().'img/icons/icon_error_small.png',
                                          'style' => 'border:none;background:none;cursor:pointer',
                                          'class' => 'del_attachment',
                                          'id' => $val['uuid']
                                );
                                echo "<li>";
                                echo "<span class='attach_cont' />";
                                echo img($mime_icon);
                                echo anchor(base_url()."attach/".$val['uuid'],$val['original_file'],"style=text-decoration:none;color:#000000;");
                                echo img($del_icon);
                                echo "</span>";
                                echo "</li>";    
                            }
                            echo "</ul>";
                        } 
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <button class="green" id="responseBtn" onclick="responseEvent()">Upload Tugas</button>
        </td>
    </tr>
</table>
<?php endif; ?>

<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.fileupload.js"></script>
<script type="text/javascript" >
	$(document).ready(function(){
		$('.fileupload').fileupload({
			dataType: 'json',
			maxFileSize: 10000,
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			progress: function () {
				var loader = $(this).attr('name') +'_loader';
				$(this).after(" <img src='<?php echo template_path('triveo')?>images/loading.gif' class='"+ loader +"' /> ");
			},
			error: function (e, data) {
				alert("Error");
			},
			done: function (e, data) {
                if (data == '0') 
                {
                    alert("Error");
                }
                else
                {
                    var cont = $(this).attr('name') +'_cont';
    				var loader = $(this).attr('name') +'_loader';
    				$('.'+ loader).hide();
    				$.each(data.result, function (index, file) {
    				    $('#' + cont).text(file.name);
    					$("input[name=attach_uid]").val(file.id);
    				});
                    
                    alert("File Sudah Berhasil Diupload");
                }
				
			}
		});	
        
         $('.del_attachment').click(function(){
            ann_id = $(this).attr("id"); 
            var r = confirm("Hapus File? ");
            
            if (r == true)
            {
                $.post("<?php echo base_url()?>kelas/del_attachment",{id : ann_id}, function(data){
	               if (data == "1") {
	                   alert('File Telah Dihapus');
                       $('.attach_cont').remove();
	               }
				});    
            }
       }); 
	});
    
    $("#responseBtn").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    
    var response = $('#responseTxt').val();
    var attachment = $('input[name=attach_uid]').val();
            
    $.post("<?php echo base_url()?>kelas/task_submit",
        {id : <?php echo $row->id  ?>,content : response,attach_uid:attachment}, function(data){
            if (data == "-1") 
            {
        	   alert("Pesan Belum Diisi");
    		}
            else if (data == "1") 
            {
        	   alert("Tugas Sudah Diupload");
    		}
            else
            {
                alert("<?php echo $this->lang->line('db_error')?>");
            }	
        });
});
</script>
    

    