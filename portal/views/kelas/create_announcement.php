<script type="text/javascript" src="<?php echo template_path('core') ?>js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo template_path('core') ?>js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			relative_urls : false,
			file_browser_callback : MadFileBrowser
		});
		
		
	});
	
	function MadFileBrowser(field_name, url, type, win) {
		
	  tinyMCE.activeEditor.windowManager.open({
	      file : "<?php echo template_path('core') ?>js/mfm.php?field=" + field_name + "&url=" + url + "",
	      title : 'File Manager',
	      width : 640,
	      height : 450,
	      resizable : "no",
	      inline : "yes",
	      close_previous : "no"
	  }, {
	      window : win,
	      input : field_name
	  });
	  return false;
	}
</script>


<?php if (isset($message)) echo "<h3>".$message."</h3>";  else $message= '';?>
    <?php
        echo form_open_multipart(current_url(),"id='frmSms'"); 
    ?>	
    <fieldset>
        <table>
            <tr>
                <td width="120px"><label><?php echo $this->lang->line('title');?></label></td>
                <td><?php echo form_input('title','','style="width:500px"')?></td>                
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><?php echo form_textarea('content','',"style='width:98%;height:300px;' class='tinymce' ")?></td>                
            </tr>
            <tr>
                <td>Upload File</td>
                <td>
                    <input name="file_pengumuman" class="fileupload" type="file" 
                    data-url="<?php echo base_url()?>kelas/do_upload_kelas/file_pengumuman/pengumuman" />
    				<input type="hidden" name="attach_uid" /> 
    				Ukuran Maks. 10MB (gif, png, jpg, jpeg,pdf,doc,docx,xls,xlsx,ppt,pptx)
                    <p style="padding-top: 5px;" id="file_pengumuman_cont"></p>
                </td>                
            </tr>            
            <tr>
                <td colspan="3"><button type="submit"><?php echo $this->lang->line('submit');?></button></td>
            </tr>
        </table>	
	</fieldset>	
	
	</form>
    
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
                }
				
			}
		});	
	})
</script>