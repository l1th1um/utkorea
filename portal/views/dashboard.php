<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->

<head>
	<meta charset="UTF-8">
	<!--[if IE 8 ]><meta http-equiv="X-UA-Compatible" content="IE=7"><![endif]-->
	<title>Portal Universitas Terbuka Korea Selatan</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<script src="<?php echo admin_tpl_path()?>js/jquery-1.8.2.min.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/jqueryui/js/jquery-ui-1.9.1.custom.min.js"></script>
    <script src="<?php echo admin_tpl_path()?>js/jquery/jquery.datatables.js"></script>
	<!-- CSS Styles -->
	<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/style.css" />
	<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery.tipsy.css" />
	<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery.wysiwyg.css" />
	<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery.datatables.css" />
<!--	<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery.facebox.css" />-->
    <link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery.facebox.css" />
    <link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/jquery-ui-1.8.19.custom.css" />
	<link rel="stylesheet" href="<?php echo admin_tpl_path()?>css/ui.spinner.css" />
    <noscript>
    	<h1 style="text-align: center;color:#000000;font-size: 24px">Javascript Harus Diaktifkan</h1>
    </noscript>
	<script src="<?php echo admin_tpl_path()?>js/libs/modernizr-1.7.min.js"></script>
</head>
<body>
	<!-- Aside Block -->
	<section role="navigation">
		<!-- Header with logo and headline -->
		<header>
			<a href="<?php echo base_url();?>" title="Back to Homepage"></a>			
		</header>
		
		<!-- User Info -->
		<section id="user-info">
			<img src="<?php echo admin_tpl_path()?>img/sample_user.png" alt="Sample User Avatar">
			<div>
				<a href="#" title="Account Settings and Profile Page">
					<?php echo user_detail('name',$this->session->userdata('username'))?>
				</a>
				<p>
					<em>
						<?php echo get_role($this->session->userdata('role'));?>
						<?php 
                        if ( (in_array(8,$this->session->userdata('role'))) || (in_array(9,$this->session->userdata('role')) )) 
                            echo get_major($this->session->userdata('major')); ?>
					</em>
				</p>
				<ul>					
					<li><a class="button-link" href="<?php echo base_url()."logout" ?>" title="Logout!" rel="tooltip">logout</a></li>
				</ul>
			</div>
		</section>
		<!-- /User Info -->
		
		<!-- Main Navigation -->
		<?php echo generate_menu($this->session->userdata('role'));?>
		<!-- /Main Navigation -->
		
		<!-- Sidebar -->
		<!--
		<section class="sidebar nested">
			<h2>Pengumuman</h2>
			<p>Tidak Ada Pengumuman.</p>			
		</section>
		-->
		<!-- /Sidebar -->
		
	
	</section>
	<!-- /Aside Block -->
	
	<!-- Main Content -->
	<section role="main" >		
		
		<!-- Breadcumbs -->
        	<div style="padding:25px 25px 0 25px"><?php echo create_breadcrumb(); ?>	</div>
		<!-- /Breadcumbs -->
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix" style="margin:25px" >
			
            <!-- Article Header -->
			<header>
				<h2><?php echo get_page_title(); ?></h2>
				
			</header>
			<!-- /Article Header -->
            
		    <?php if (isset($page)) echo $page;  else $page= '';?>
		    <div style="height:20px;">&nbsp;</div>
			<!-- Article Footer -->
			
			<footer style="text-align:center;position:fixed;bottom:0;left:47%;">
				<p>Copyright &copy; 2012 Universitas Terbuka Korea Selatan. All Rights Reserved</p>
			</footer>
			
			<!-- /Article Footer -->
			
		</article>
		<!-- /Full Content Block -->

		<div class="clearfix"></div> <!-- We're really sorry for this, but because of IE7 we still need separated div with clearfix -->
		
	</section>
	<!-- /Main Content -->

	<!-- JS Libs at the end for faster loading -->
    <!--
	<script src="../../../ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> 
	<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo admin_tpl_path()?>js/jquery/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
    -->
	<script src="<?php echo admin_tpl_path()?>js/libs/selectivizr.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/jquery/jquery.facebox.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/jquery/jquery.tipsy.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/jquery/jquery.wysiwyg.js"></script>	
    
	
    <script src="<?php echo admin_tpl_path()?>js/jquery/jquery.validate.min.js"></script>	
	<script src="<?php echo admin_tpl_path()?>js/jquery/ui.spinner.min.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/script.js"></script>

</body>

</html>