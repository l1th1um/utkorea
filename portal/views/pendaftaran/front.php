<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="title" content="" />
  <meta name="description" content="" />
<title>Pendaftaran Mahasiswa Baru | Universitas Terbuka Korea</title>

<!-- ////////////////////////////////// -->
<!-- //      Start Stylesheets       // -->
<!-- ////////////////////////////////// -->
<link href="<?php echo template_path('triveo')?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo template_path('triveo')?>css/superfish.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url()?>favicon.ico" rel="shortcut icon" type="image/x-icon" />
<!--[if IE 6]>    
	<link href="<?php echo template_path('triveo')?>css/ie6.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo template_path('triveo')?>js/DD_belatedPNG.js"></script>
	<script type="text/javascript"> 
	   DD_belatedPNG.fix('#top');
	   DD_belatedPNG.fix('img');
       DD_belatedPNG.fix('.desc');
	   DD_belatedPNG.fix('.news-spacer');            
	</script>    
<![endif]-->
<!--[if IE 7]>    
	<style type="text/css">
    .maincontent{padding-bottom:50px;}
    #search .go{margin:4px 0 0 -24px;}
    </style>
<![endif]-->
<!--[if IE 8]>    
	<style type="text/css">
    #search .go{margin:4px 0 0 -24px;}
    </style>
<![endif]-->

<!-- ////////////////////////////////// -->
<!-- //      Javascript Files        // -->
<!-- ////////////////////////////////// -->
<script type="text/javascript" src="<?php echo template_path('core')?>js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="<?php echo template_path('triveo')?>js/superfish.js"></script>
<script type="text/javascript">
// initialise plugins
jQuery(function(){
	jQuery('ul.sf-menu').superfish();
});
</script>
<script src="<?php echo template_path('triveo')?>js/jquery.cycle.all.js" type="text/javascript"></script>
<script type='text/javascript' src="<?php echo template_path('core')?>js/jquery.simplemodal.js"></script>
<link href="<?php echo template_path('core')?>css/core.css" rel="stylesheet" type="text/css"  media='screen'/>
<script type="text/javascript">
  $(function() {
  	$('#checkReg').submit(function(event){
  		event.preventDefault();
  		var no_reg = $('#noReg').val();
  		 
		if (no_reg.length == 0) {
			alert('Masukkan No Pendaftaran Anda')
		} else if ( (no_reg.length != 9) || (no_reg.substr(0,5) != "UTKOR") || ( isNaN( no_reg.substr(5,4) ) ) ) {
			alert('No Pendaftaran Anda Salah');
		} else {
			$.post("<?php echo base_url()?>pendaftaran/check_registration_status", { reg_code: no_reg},function(data) {
				if (data == false) data = "Maaf, No Pendaftaran Tidak Ditemukan";
			   $('#status_content').html(data);
			   var OSX = {
						container: null,
						init: function () {
								$("#osx-modal-content").modal({
									overlayId: 'osx-overlay',
									containerId: 'osx-container',
									closeHTML: null,
									minHeight: 80,
									opacity: 65, 
									position: ['0',],
									overlayClose: true,
									onOpen: OSX.open,
									onClose: OSX.close
								});							
						},
						open: function (d) {
							var self = this;
							self.container = d.container[0];
							d.overlay.fadeIn('slow', function () {
								$("#osx-modal-content", self.container).show();
								var title = $("#osx-modal-title", self.container);
								title.show();
								d.container.slideDown('slow', function () {
									setTimeout(function () {
										var h = $("#osx-modal-data", self.container).height()
											+ title.height()
											+ 20; // padding
										d.container.animate(
											{height: h}, 
											200,
											function () {
												$("div.close", self.container).show();
												$("#osx-modal-data", self.container).show();
											}
										);
									}, 300);
								});
							})
						},
						close: function (d) {
							var self = this; // this = SimpleModal object
							d.container.animate(
								{top:"-" + (d.container.height() + 20)},
								500,
								function () {
									self.close(); // or $.modal.close();
								}
							);
						}
					};
				
					OSX.init();
			});
			
		}
		//$('#basic-modal-content').modal();
  	});
  	
	$('.newsflash-text').cycle({
            timeout: 5000,  // milliseconds between slide transitions (0 to disable auto advance)
            fx:      'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...                        
            pause:   0,	  // true to enable "pause on hover"
            pauseOnPagerHover: 0 // true to pause when hovering over pager link
    });      
});
</script>
<script type="text/javascript" src="<?php echo template_path('triveo')?>js/jqFancyTransitions.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
    $('#slide-image-type2').jqFancyTransitions({
      width: 960, 
      height: 328, 
      strips: 40,
      delay: 5000,
      stripDelay: 70	  
    });  
  });
</script>
<script type="text/javascript" src="<?php echo template_path('triveo')?>js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo template_path('triveo')?>js/Telegrafico_400.font.js"></script>
<script type="text/javascript">
            Cufon.replace('h1') ('h2') ('h3') ('h4') ('h5');
</script>  
</head>
<body>
	<div id="outer-container">
    	<div id="inner-container">
        	<!-- BEGIN HEADER -->
        	<div id="header">
                <div id="top">
                    <div id="nav-menu">
                        <ul class="sf-menu">
                            <li class="current"><a href="<?php echo base_url()."pendaftaran"?>">Home</a></li>
                            <li><a href="<?php echo base_url()."pendaftaran/registrasi"?>">Pendaftaran</a></li>
                            <li><a href="<?php echo base_url()."pendaftaran/pembayaran"?>">Konfirmasi Pembayaran</a></li>                            
                        </ul>
                    </div>
                    <div id="search-box">
                        <form id="search" action="#" method="get">
                                <fieldset class="search-fieldset">
                                <input type="text" id="s" value="" />
                                <input type="submit" class="go" value="" />
                                </fieldset>      						
                        </form>
                    </div>
                    <div id="logo">
                    	<a href="index.html"><img src="<?php echo template_path('triveo')?>images/logo_utkorea.png" alt="" /></a>
                    </div>
                    
                    <!-- BEGIN SLIDESHOW -->
                    <div id="slideshow-container">
                    	<div id="slideshow-inner">
                        	<ul id="slide-image-type2">
                                <li class="slide-image"><img src="<?php echo template_path('triveo')?>images/utkorea.jpg" alt="" class="type1-slide" /></li>
                                <li class="slide-image"><img src="<?php echo template_path('triveo')?>images/mahasiswa.jpg" alt="" class="type1-slide" /></li>
                            </ul>                            
                      </div>                        
                    </div>
                    <!-- END OF SLIDESHOW -->
                    
                </div>
            </div>
            <!-- END OF HEADER -->
            
            <!-- BEGIN CONTENT -->
            <div id="content">
            	<div class="three-column">
                	<div class="front-icon"><img src="<?php echo template_path('triveo')?>images/front-icon1.jpg" alt="" /></div>
                    <h3>Bergabung Bersama Kami</h3>
                    <p>Tambah Teman, Tambah Ilmu</p>
                    <p>Nanti Diisi sesuatu di sini yah kakak-kakak.</p>
                    <a href="#"><img src="<?php echo template_path('triveo')?>images/read-more.jpg" alt="" /></a>
                </div>
                <div class="front-spacer">&nbsp;</div>
                <div class="three-column">
                	<div class="front-icon"><img src="<?php echo template_path('triveo')?>images/front-icon2.jpg" alt="" /></div>
                    <h3>Cek No Pendaftaran</h3>
                    <p> &nbsp; </p>
                    <p>Masukkan No Pendaftaran Anda</p>
                    <p>
                    	<form method="POST" name="checkReg" id="checkReg" action="" />
                    		<input type='text' name='noReg' id='noReg' style='border: 2px solid #A4ADB0;width:14em;height:2em;background-color: #AFB8BB;color:#5A6669;font-size: 12px;' />
                    		<input class="input-submit" type="submit" name="sendContactEmail" value="">
                    	</form>
                    </p>
                    
                </div>
                <div class="front-spacer">&nbsp;</div>
                <div class="three-column">
                	<div class="front-icon"><img src="<?php echo template_path('triveo')?>images/front-icon3.jpg" alt="" /></div>
                    <h3>Kesan Mahasiswa</h3>
                    <p>Apa Kata Mahasiswa</p>
                    <blockquote>
                    <p>Belajarnya asik, tutornya mantap2. Apalagi Team IT-nya, ganteng-ganteng</p>
                    </blockquote>
                    <p><strong>Ceu Lilis - Ansan</strong></p>
                </div>
                
                <!-- Begin of Newsflash -->
                <div id="newsflash">
                	<img src="<?php echo template_path('triveo')?>images/news-icon.jpg" alt="" class="news-icon" />
                    <div class="newsflash-title"><h4>Newsflash</h4></div>
                    <div class="news-spacer">&nbsp;</div>
                    <div class="newsflash-text">
                    	<div>Pendaftaran Mahasiswa Baru Dibuka Pada Tanggal xx Desember 2012. Jangan Ketinggalan Jangan Ketinggalan Jangan Ketinggalan</div>
                        <div>Pendaftaran Mahasiswa Baru Ditutup Pada Tanggal xx Januari 2013. Jangan Ketinggalan Jangan Ketinggalan Jangan Ketinggalan</div>
                        <div>Pengumuman Mahasiswa Baru Pada Tanggal xx Januari 2013. Jangan Ketinggalan Jangan Ketinggalan Jangan Ketinggalan</div>
                    </div>                
                </div>
                <!-- End Newsflash -->
                
                <div class="maincontent">
                <h3>Butuh Bantuan ?</h3>
                <p>Pertanyaan dapat dikirimkan ke humas@utkorea.org</p>                
                </div>
                <!-- 
                <div id="sidebox">
                	<div class="featured">
                    	<div><a href="#"><img src="<?php echo template_path('triveo')?>images/featured1.jpg" alt="" /></a></div>
                    </div>
                </div>-->         
            </div>
            <!-- END CONTENT -->
            
	<div id="osx-modal-content">
		<div id="osx-modal-title">Status Pendaftaran</div>
		<div class="close"><a href="#" class="simplemodal-close">x</a></div>
		<div id="osx-modal-data">
			<p id='status_content'></p>
			<p><button class="simplemodal-close">Close</button> <span>( Atau Tekan Enter)</span></p>
		</div>
	</div>
                       
        </div>
        <!-- BEGIN OF FOOTER -->
            <div id="container-bottom">
                <div id="footer">
                    <div class="left-footer">
                    <img src="<?php echo template_path('triveo')?>images/logo_utkorea_footer.png" alt="" class="footer-logo" />
                    </div>
                    <div class="right-footer">
                        <div class="social-network">                        	
                        	<div class="social-icon"><a href="#"><img src="<?php echo template_path('triveo')?>images/facebook.jpg" alt=""/></a></div>
                            <div class="follow"><a href="http://www.facebook.com/groups/utkorea/"><strong>Become a fan</strong></a> on Facebook</div>
                        </div>
                        <div class="copyright">
                        Copyright � 2012 Universitas Terbuka Korea. All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        <!-- END FOOTER -->
    </div>
</body>
</html>