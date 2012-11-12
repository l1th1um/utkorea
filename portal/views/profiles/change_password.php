	<?php if (isset($message)) echo $message;  else $message= '';?>
	<form method="post" action="<?php echo current_url();?>" id="frmChangePwd">
    <fieldset>
        <table>
            <tr>
                <td  width="150px"><label><?php echo $this->lang->line('old_password');?></label></td>
                <td><input type="password" name="password" /></td>                
            </tr>
            <tr>
                <td><label><?php echo $this->lang->line('new_password');?></label></td>
                <td><input type="password" name="new_password" /></td>                
            </tr>
            <tr>
                <td><label><?php echo $this->lang->line('new_password_verify');?></label></td>
                <td><input type="password" name="new_password2" /></td>                
            </tr>
            <tr>
                <td colspan="3"><button type="submit">
                <?php echo $this->lang->line('send_to');?>
                </button></td>
            </tr>
        </table>	
	</fieldset>	
	
	</form>