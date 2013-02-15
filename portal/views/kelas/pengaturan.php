<?php if($is_class){ ?>
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
</script>
<?php if($success){
	echo success_form('Pengaturan Anda telah disimpan');
}?>
<h1>Kelas Anda :</h1> 
<i style="font-style:italic;font-size:9pt;color:#666666;">Pengaturan ini dapat diubah sewaktu - waktu untuk menyesuaikan kegiatan belajar-mengajar</i><br />
<a href="">Klik disini untuk petunjuk</a>
<br /><br />
<form method="POST" >
<?php if($classes){ ?>
<div id="tabs">
	<?php
		$tabs = '<ul>';
		$divs = ''; 
		foreach($classes->result() as $row){
			$tabs .= '<li><a href="#tabs-'.$row->id.'">('.$row->code.') <b>'.$row->title.'</b></a></li>';
			$divs .= '<div id="tabs-'.$row->id.'">';
			$divs .= '<h1>Pengaturan Live Stream</h1>
    <div style="float:left;padding:4px;margin:6px;border-right:1px solid #cccccc;">
		<input';
	if($row->chopt=='ustream'){$divs.=' checked="checked" ';}
	$divs .=' type="radio" name="radio'.$row->id.'" value="ustream" style="float:left;margin:4px;" /><a target="_blank" href="http://ustream.tv"><img title="USTREAM TV" src="'.template_path('core').'/images/ustream.png" /></a><br />
		Channel : <input type="text" name="ustreamch'.$row->id.'" size="13" value="'.$row->ustreamch.'" />
	</div>
	<div style="float:left;padding:4px;margin:6px;border-right:1px solid #cccccc;">
		<input';
	if($row->chopt=='justin'){$divs.=' checked="checked" ';}
	$divs .=' type="radio" name="radio'.$row->id.'" value="justin" style="float:left;margin:4px;" /><a target="_blank" href="http://justin.tv"><img title="JUSTIN TV" src="'.template_path('core').'/images/justintv.png" /></a><br />
		Channel : <input type="text" name="justinch'.$row->id.'" size="13" value="'.$row->justinch.'" />
	</div>
	<div style="float:left;padding:4px;margin:6px;border-right:1px solid #cccccc;">
		<input';
	if($row->chopt=='bambuser'){$divs.=' checked="checked" ';}
	$divs .=' type="radio" name="radio'.$row->id.'" value="bambuser" style="float:left;margin:4px;" /><a target="_blank" href="http://bambuser.com"><img title="BAMBUSER" src="'.template_path('core').'/images/bambuser.png" /></a><br />
		Channel : <input type="text" name="bambuserch'.$row->id.'" size="13" value="'.$row->bambuserch.'" />
	</div>
	<div style="float:left;padding:4px;margin:6px;border-right:1px solid #cccccc;">
		<input';
	if($row->chopt=='ls'){$divs.=' checked="checked" ';}
	$divs .=' type="radio" disabled="disabled" name="radio'.$row->id.'" value="ls" style="float:left;margin:4px;" /><a target="_blank" href="http://livestream.com"><img title="LIVESTREAM" src="'.template_path('core').'/images/livestream.png" /></a><br />
		Channel : <input disabled="disabled" type="text" name="lsch'.$row->id.'" size="13" value="'.$row->lsch.'" />
	</div>
	<div style="clear:both"></div>
	<hr />
	<h1>Status</h1>
	<input';
	if($row->status){$divs.=' checked="checked" ';}
	$divs .=' type="radio" name="status'.$row->id.'" value="1" />&nbsp;Mengajar&nbsp;<input';
	if(!$row->status){$divs.=' checked="checked" ';}
	$divs .=' type="radio" name="status'.$row->id.'" value="0" />&nbsp;Cuti&nbsp;
	<br />
	Link Video Pengganti : <input type="text" name="linkvid'.$row->id.'" value="'.$row->linkvid.'" />';
			$divs .= '</div>';
		}
		$tabs .= '</ul>';
		echo $tabs;
		echo $divs;
	 ?>
  
</div>
<br />
<button type="submit">Simpan</button>
</form>
<?php } 
} else {
    echo $message;
}?>