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


</style>
  
</head>

<body marginwidth="0" marginheight="0">
<div id="header">
  <table "width: 100%;">
    <tr >
      <td width='130px' >
      		<img src="<?php $this->config->item('absolute_path')?>assets/core/images/logo_ut.jpg" />
      </td>
      <td><h1>UNIVERSITAS TERBUKA KOREA</h1>
		  <h1>PERSATUAN PELAJAR INDONESIA DI KOREA</h1>
          <h1>KEDUTAAN BESAR REPUBLIK INDONESIA</h1>
          <h1>YEOIDO 55, YOUNGDEUNGPO-GU SEOUL</h1>
      </td>
      <td width='130px'>
      		<img src="<?php $this->config->item('absolute_path')?>assets/core/images/logo_utkorea.jpg" />
      </td>
    </tr>
  </table>
</div>

<div id="footer">
  <div class="page-number"></div>
</div>

<!-- Halaman 1 -->
<p style="padding-bottom:20px">Kepada Yth. <?php echo $row->name; ?></p>
<p>Terima kasih telah mendaftar sebagai calon mahasiswa UT Korea Semester Ganjil Tahun 2013</p>
<p>Berkas yang perlu dikirimkan adalah sebagai berikut</p>
<ol>
	<li>Formulir pendaftaran yang telah ditandatangani</li>
	<li>Satu lembar fotokopi ijazah yang telah dilegalisasi oleh pejabat yang berwenang</li>
	<li>Pas Foto 2 x 3 sebanyak 3 lembar</li>
</ol>

<p>Berkas dokumen diatas dikirimkan kepada (pilih salah satu dari dua opsi) :</p>

<p><b>1. Jika Berkas berada di Indonesia</b></p>

<div style='padding-left:10px;border:1px solid #000000;line-height: 1em'>
	<p>Universitas Terbuka UPBJJ Jakarta (a.n. Yasir UT Korea)</p>
	<p>Jl. Pemuda, Rawamangun, Komp. Universitas Negeri Jakarta, Jakarta Timur 13220</p>
	<p>Telp. 021-4701577, 4751172, 4893638 Fax. 021-4701577, 4751172</p>
</div>

<p><b>2. Jika Berkas berada di Korea</b></p>
<p>a. Untuk Wilayah Utara (Seoul dan sekitarnya)</p>

<div style='padding-left:10px;border:1px solid #000000;line-height: 1em'>
	<p>Rengganis</p>
	<p>CJ International House</p>
	<p>Room 627B Korea University, Anam-dong, Seongbuk-gu, Seoul 136-701</p>
</div>

<p>b. Untuk Wilayah Selatan (Daegu-Busan dan sekitarnya)</p>

<div style='padding-left:10px;border:1px solid #000000;line-height: 1em'>
	<p>Dian Kharismadewi</p>
	<p>School of Chemical Engineering #302</p>
	<p>Yeungnam University 214-1 Dae-dong, Gyeongsan, Gyeongbuk  712-749</p>
</div>

<p>
	Catatan :
</p>


<ol>
	<li>Pastikan anda telah memiliki back-up berkas yang akan dikirimkan, bisa berupa scan, foto atau fotokopi 
		sebelum semua dokumen dikirimkan melalui pos ke alamat diatas untuk mengantisipasi jika berkas tidak diterima oleh UT Korea</p>
	<li>Berkas harus sudah dikirimkan paling lambat pada tanggal 5 Januari 2013 (cap pos) ke alamat diatas.</li>
</li>
</ol>

<p>Terima kasih</p>
<p>UT Korea</p>
<p>Berkarya dan Berpendidikan</p>
<!-- End Halaman 1 -->
<hr>

<div style="width:100px;height:30px;margin-left:1cm;border:1px solid #000000;position:absolute;text-align: center">
	<div style="padding:8px;font-size: 12px;font-weight: bold">UTKOR<?php echo $id?></div>
</div>

<h2>FORMULIR PENDAFTARAN MAHASISWA BARU</h2>
<h2>UNIVERSITAS TERBUKA – KOREA SELATAN</h2>
<h2>TAHUN 2013<h2>


<!--	
<div style="width:3cm;height:4cm;margin-left:16cm;border:1px solid #000000;position:absolute;">
	<div style="padding-top:1.8cm;">3 x 4 cm</div>
</div>-->
<table style="width:80%;padding-top:40px" align="center"  id="regFrm">
	<tr>
		<td width="200px"><?php echo $this->lang->line('name');?></td>
		<td width="20px">:</td>
		<td><?php echo $row->name; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('no_passport');?></td>
		<td>:</td>
		<td><?php echo $row->passport; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('gender');?></td>
		<td>:</td>
		<td>
			<?php if ($row->gender == 'L') echo "<span>L / <del>P</del></span>";
				  else echo "<span><del>L</del> / P</span>"; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('place_time_birth');?></td>
		<td>:</td>
		<td><?php echo $row->place_of_birth; ?>, <?php echo convertHumanDate($row->birth_date); ?></td>
	</tr>
	<tr>
		<td valign="top"><?php echo $this->lang->line('address_id');?></td>
		<td valign="top">:</td>
		<td><?php echo $row->address_id; ?></td>
	</tr>
	<tr>
		<td valign="top"><?php echo $this->lang->line('address_kr');?></td>
		<td valign="top">:</td>
		<td><?php 
		if (strlen($row->address_kr) != strlen(utf8_decode($row->address_kr))) {
			echo "<p style='font-family : batang'>".$row->address_kr."</p>";
		} else {
			echo $row->address_kr;	
		}
		 
		?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('phone');?></td>
		<td>:</td>
		<td>+<?php echo $row->phone; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('email');?></td>
		<td>:</td>
		<td><?php echo $row->email; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('religion');?></td>
		<td>:</td>
		<td><?php
			$religion =$this->lang->line('religion_list');  
			echo $religion[$row->religion]; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('marital_status');?></td>
		<td>:</td>
		<td><?php
			$marital =$this->lang->line('marital_status_list');  
			echo $marital[$row->marital_status]; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('employment_status');?></td>
		<td>:</td>
		<td><?php
			$employment =$this->lang->line('employment_list');  
			echo $employment[$row->employment]; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('last_education');?></td>
		<td>:</td>
		<td><?php
			$last_education =$this->lang->line('education_list');  
			echo $last_education[$row->last_education]; ?>
		</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('major_code');?></td>
		<td>:</td>
		<td><?php echo $row->last_education_major; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('year_graduate');?></td>
		<td>:</td>
		<td><?php echo $row->year_graduate; ?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('is_teaching');?></td>
		<td>:</td>
		<td>
			<?php 
			if ($row->teach == '1') {
				echo "<span>Ya / <del>Tidak</del></span>";
				if ($row->teach_at == 1) echo"<span>TK/ <del>SD/ SLTP/ SLTA/ PT / Non Formal</del></span>";
				else if ($row->teach_at == 2) $teach_at = "<span><del>TK/</del> SD/ <del>SLTP/ SLTA/ PT / Non Formal</del></span>";
				else if ($row->teach_at == 3) $teach_at = "<span><del>TK/ SD/</del> SLTP/ <del>SLTA/ PT / Non Formal</del></span>";
				else if ($row->teach_at == 4) $teach_at = "<span><del>TK/ SD/ SLTP/ </del>SLTA/ <del>PT / Non Formal</del></span>";
				else if ($row->teach_at == 5) $teach_at = "<span><del>TK/ SD/ SLTP/ SLTA</del>/ PT <del>/ Non Formal</del></span>";
				else if ($row->teach_at == 6) $teach_at = "<span><del>TK/ SD/ SLTP/ SLTA/ PT </del>/ Non Formal</span>";
				$teach_major = $row->teach_major; 
			} else {
				echo "<span><del>Ya</del> / Tidak</span>"; 
				$teach_at = "TK/ SD/ SLTP/ SLTA/ PT / Non Formal";
				$teach_major = "";
			}
			?>
		</td>
	</tr>
	<tr>
		<td>Jika Ya, Mengajar Pada</td>
		<td>:</td>
		<td>
			<?php echo $teach_at; ?>
		</td>
	</tr>
	<tr>
		<td>Mengajar Bidang Studi</td>
		<td>:</td>
		<td>
			<?php echo $teach_major; ?>
		</td>
	</tr>
	<tr>
		<td>Nama Ibu Kandung</td>
		<td>:</td>
		<td>
			<?php echo $row->mother_name; ?>
		</td>
	</tr>
	<tr>
		<td>Jurusan Yang Dipilih</td>
		<td>:</td>
		<td>
			<?php echo get_major($row->major); ?>
		</td>
	</tr>
	<tr>
		<td>Lokasi Perkuliahan</td>
		<td>:</td>
		<td>
			<?php echo get_region($row->region); ?>
		</td>
	</tr>
	<tr valign="bottom" height="150px">
		<td colspan="3">Dengan ini saya menyatakan bahwa semua data diatas adalah benar.</td>
	</tr>
	<tr style="line-height:100px;" valign="bottom">
		<td colspan="3">(<span><u><?php echo $row->name;?></u></span>)</td>		
	</tr>	
</table>
</hr>

</body></html>