<?php if($success){
	echo success_form("Laporan Reimburse anda telah disimpan. Silahkan tunggu proses dari bendahara");
}?>
<div id="accordion">
	 <h3 style="padding:6px;font-size:12pt;padding-left:26px;">Form Reimburse</h3>
  	 <div>
		<?php echo form_open(current_url(), array('id'=>'frmTransport')); ?>
		Silahkan isi form ini berlandaskan asas kejujuran dan kepercayaan :-)
		<fieldset>
			<table>
				<tr>
					<td colspan="2">
						<input type="checkbox" id="simprev" name="simprev" value="1" />&nbsp;Sama dengan laporan sebelumnya
					</td>
				</tr>
				<tr>
					<td  width="150px"><label>Tanggal TTM</label></td>
					<td>
						<input type="text" name="tanggalttm" />
					</td>                
				</tr>
				<tr>
					<td  width="150px"><label>Total Pengeluaran</label></td>
					<td><input type="text" name="total" /></td>                
				</tr>
				<tr>
					<td><label>Deskripsi Perjalanan</label></td>
					<td><textarea rows="5" cols="80" name="deskripsi"></textarea>
						<br />
						<span style="font-size:8pt;">Utarakan moda transportasi, biaya dan sebagainya</span>
					</td>                
				</tr>		
				<tr>
					<td><label>Pilihan waktu pembayaran</label></td>
					<td><input name="waktudibayar" type="radio" value="m" checked="checked"/>&nbsp;Minggu ini&nbsp;<input name="waktudibayar" type="radio" value="s" />&nbsp;Akhir Semester</td>
				</tr>
				<tr>
					<td colspan="3"><button type="submit">
					<?php echo $this->lang->line('submit');?>
					</button></td>
				</tr>		
			</table>				
		</fieldset>	
		
		</form>
	</div>
</div>
<br />
<h3>Status Reimburse</h3>
<table>
	<thead>
		<td>Tanggal TTM</td>
		<td>Total Pembayaran</td>
		<td>Waktu di bayarkan</td>
		<td>Status</td>		
	</thead>
	<?php if($transport){
		foreach($transport->result() as $row){ ?>
			<tr>
				<td><?php echo substr($row->tanggalttm,0,10); ?></td>
				<td><?php echo $row->total; ?></td>
				<td><?php echo ($row->waktudibayar=='m')?'Per Minggu':'Akhir Semester'; ?></td>
				<td><?php echo ($row->is_verified==1)?'<span style="color:green;">Lunas</span>':'<span style="color:orange;">Pending</span>'; ?></td>
			</tr>
	<?php }
	}else{ echo '<tr><td colspan="4"><center>Belum ada data reimburse transport</center></td></tr>';}?>
</table>
<script type="text/javascript" >
$(document).ready(function(){		
		$( "input[name=tanggalttm]" ).datepicker({
		changeMonth: true,
		changeYear: true,		
		dateFormat: "yy-mm-dd"

		});
		$( "#accordion" ).accordion({
	      collapsible: true,
	      active: false
	    });
	    $("#simprev").change(function(){
	    	if(this.checked) {
        		$.ajax({
					  type: "POST",					 
					  url: "<?php echo site_url("bendahara/get_last_transport"); ?>",						  
					  dataType: "json",					  
					  success: function(data){
					  		if(data.message!=''){
					  			alert(data.message);					  			
					  		}
							if(data.tanggalttm!=null){
								$("#frmTransport input[name=tanggalttm]").val(data.tanggalttm.substr(0,10));
							}
							if(data.deskripsi!=null){
								$("#frmTransport textarea[name=deskripsi]").val(data.deskripsi);
							}
							if(data.total!=null){
								$("#frmTransport input[name=total]").val(data.total);
							}
							if(data.waktudibayar!=null){
								$("#frmTransport input[value=" + data.waktudibayar + "]").attr("checked","checked");
							}
					  }
					});
    		}else{
    			$('#frmTransport').each(function(){
				        this.reset();
				});
    		}
	    });
});
</script>
