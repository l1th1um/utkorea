<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<style type="text/css">

@page {
	margin: 1cm;
}

body {
  font-family: sans-serif;
  font-size : 13px;
  margin: 3cm 0 2cm 0;
  text-align: justify;  
}

#header,
#footer {
  position: fixed;
  left: 0;
  right: 0;	
}

#header {
  top: 0;
  border-bottom: 1pt solid #000000;
}

#footer {
  bottom: 0;
  border-top: 0.1pt solid #aaa;
  color: #aaa;
}

#header table,
#footer table {
	width: 100%;
	border-collapse: collapse;
	border: none;
}

#header td,
#footer td {
  padding: 0;  
}

.page-number {
  text-align: center;
}

.page-number:before {
  content: "Halaman " counter(page);
}

hr {
  page-break-after: always;
  border: 0;
}

h1 {
	text-align: center;
	font-weight:bold;
	font-size:14px;
	line-height: 0.8em;
}

h2 {
	text-align: center;
	font-weight:bold;
	font-size:13px;
}

table#regFrm tr {
	line-height:20px
}

table.kuitansi
{
	border-collapse: collapse;
	width: 100%;
	padding-top : 20px
}

table.kuitansi, table.kuitansi th, table.kuitansi td
{
	border: 1px solid #000000;
}

</style>
  
</head>

<body marginwidth="0" marginheight="0">
<div id="header">
  <table "width: 100%;">
    <tr >
      <td width='130px' >
      		<img src="<?php echo $this->config->item('absolute_path')?>assets/core/images/logo_ut.jpg" />
      </td>
      <td><h1>UNIVERSITAS TERBUKA KOREA</h1>
		  <h1>PERSATUAN PELAJAR INDONESIA DI KOREA</h1>
          <h1>KEDUTAAN BESAR REPUBLIK INDONESIA</h1>
          <h1>YEOIDO 55, YOUNGDEUNGPO-GU SEOUL</h1>
      </td>
      <td width='130px'>
      		<img src="<?php echo $this->config->item('absolute_path')?>assets/core/images/logo_utkorea.jpg" />
      </td>
    </tr>
  </table>
</div>


<!-- Halaman 1 -->
<p style="padding-bottom:30px"><h2 style='text-align: center;text-decoration: underline;font-size: 18px'>K U I T A N S I</h2></p>
<p style='text-align: center;margin-top:-15px !important'>No : <?php echo $receipt_no;?></p>
<div style='padding : 50px 20px 20px 20px'>
	
	<table>
		<tr>
			<td width="100px">NIM</td>
			<td width="20px">:</td>
			<td><?php echo $nim?></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td><?php echo $name?></td>
		</tr>
		<tr>
			<td>Jurusan</td>
			<td>:</td>
			<td><?php echo $major?></td>
		</tr>
		<tr>
			<td>Semester</td>
			<td>:</td>
			<td> <?php echo $semester?> </td>
		</tr>
	</table>
	
	<table class="kuitansi" >
		<thead>
			<tr>
				<th>No</th>
				<th>Jenis Biaya</th>
				<th>Sub Total</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$i = 1;
				$total = 0;
				
				foreach ($payment as $value) {
			?>
					<tr>
						<td style="text-align: center"><?php echo $i;?></td>
						<td><?php echo $value['type']?></td>
						<td style='text-align: right'><?php echo number_format($value['amount'])?></td>
					</tr>
			<?php
					$i++;
					$total = $total + $value['amount'];
				}
			?>
			
			<tr>
				<td style="text-align: center" colspan="2"><b>Total</b></td>
				<td style='text-align: right'><?php echo number_format($total)?></td>
			</tr>
		</tbody>
	</table>
	
	<div style="margin-left:500px;padding-top:50px">
		<p>Seoul, <?php echo $current_date; ?></p>
		<p>Bendahara UT Korea</p> 
	</div>
</div>
<!-- End Halaman 1 -->
<hr>
</body></html>