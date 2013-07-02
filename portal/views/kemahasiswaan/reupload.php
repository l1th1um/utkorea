<header>
	<h2>Reupload Ijasah/Foto</h2>
</header>
<header>
	<div style="float:left;padding:8px;border-right:1px solid #666666;"><a href="<?php echo base_url('kemahasiswaan/mahasiswa_baru'); ?>">Tabel Mahasiswa Baru</a></div>
	<div style="float:left;padding:8px;"><a href="<?php echo base_url('kemahasiswaan/reupload/maba'); ?>">Re-upload Ijasah/Foto</a></div>
 </header>	
<?php if($message!=''){ ?>
	<?php echo info_form($message); ?>
<?php } ?> 
<?php echo form_open_multipart('kemahasiswaan/reupload/maba',array('id=>frmReupload')); ?>
<fieldset>
	<label for="reg_code">Nomor Pendaftaran</label>
	<input type="text" name="reg_code" />
	<br /><br />
	<label for="jenis">Jenis</label>
	<input name="jenis" type="radio" value="ijasah_image" checked="checked"/>&nbsp;Ijasah&nbsp;
	<input name="jenis" type="radio" value="photo_image" />&nbsp;Foto&nbsp;
	<br /><br />
	<label for="filename">File</label>
	<input type="file" name="filename" />
	<br /><br />
	<button>submit</button>
	<br />
</fieldset>
</form>