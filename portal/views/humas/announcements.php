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
	<form method="post" action="<?php echo current_url();?>" id="frmSms">
    <fieldset>
        <table>
            <tr>
                <td width="120px"><label><?php echo $this->lang->line('title');?></label></td>
                <td><?php echo form_input('title',set_value('title'),'style="width:500px"')?></td>                
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><?php echo form_textarea('news','',"style='width:98%;height:600px;' class='tinymce' ")?></td>                
            </tr>
            <tr>
                <td width="120px"><label><?php echo $this->lang->line('publish');?></label></td>
                <td><?php echo form_radio('publish','1',true); ?> Ya
                	<?php echo form_radio('publish','0'); ?> Tidak
                </td>                
            </tr>
            <tr>
                <td colspan="3"><button type="submit"><?php echo $this->lang->line('send_to');?></button></td>
            </tr>
        </table>	
	</fieldset>	
	
	</form>