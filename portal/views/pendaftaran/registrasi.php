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
<!--  <link href="<?php echo template_path('triveo')?>css/fancybox.css" rel="stylesheet" type="text/css" media="screen" /> -->
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
    #content-inner{padding-top:45px;}
    #search .go{margin:4px 0 0 -24px;}
    </style>
<![endif]-->
<!--[if IE 8]>    
	<style type="text/css">
    #search .go{margin:4px 0 0 -24px;}
    </style>
<![endif]-->
<style type='text/css' media='screen,projection'>
<!--
fieldset { border:0;margin:0;padding:0; }
label {  padding-right:15px; float:left; width:70px;}
input.text{ width:290px;font:12px/12px 'courier new',courier,monospace;color:#333;padding:3px;margin:1px 0; }
-->
</style> 
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
<script type="text/javascript" src="<?php echo template_path('triveo')?>js/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo template_path('triveo')?>js/Telegrafico_400.font.js"></script>
<script type="text/javascript">
            Cufon.replace('h1') ('h2') ('h3') ('h4') ('h5');
</script>  
</head>
<body>
	<div id="outer-container2">
    	<div id="inner-container2">
        	<!-- BEGIN HEADER -->
        	<div id="header-inner">
                <div id="top">
                  <div id="nav-menu">
                        <ul class="sf-menu">
                            <li class="current"><a href="<?php echo base_url()."pendaftaran"?>">Home</a></li>
                            <li><a href="<?php echo base_url()."pendaftaran/registrasi"?>">Pendaftaran</a></li>
                            <!--  
                            <li><a href="services.html">Services</a>
                            	<ul class="subnav">
                                    <li><a href="index2.html">Home Alternate</a></li>
                                    <li><a href="fullwidth.html">Fullwidth Page</a></li>
                            	</ul>
                            </li>                          
                            <li><a href="portfolio.html">Portfolio</a></li>
                            <li><a href="contact.html">Contact</a></li>-->
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
                </div>
                <div id="sitemap">
                	<strong>You are here</strong> : <a href="index.html">Home</a> &raquo; Fullwidth
                </div>
            </div>
            <!-- END OF HEADER -->
            
            <!-- BEGIN CONTENT -->
            <div id="content-inner">          
                <div class="maincontent-fullwidth">
                <?php echo $page?>
                
                </div>                         
            </div>
            <!-- END CONTENT --> 
                       
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
                        Copyright © 2012 Universitas Terbuka Korea. All rights reserved
                        </div>
                    </div>
                </div>
            </div>
        <!-- END FOOTER -->
    </div>
</body>
</html>