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
	
	<script src="<?php echo admin_tpl_path()?>js/jquery/jquery-1.8.0.min.js"></script>
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
				<a href="#" title="Account Settings and Profile Page"><?php echo user_detail('name',$this->session->userdata('username'))?></a>
				<em>Humas</em>
				<ul>					
					<li><a class="button-link" href="<?php echo base_url()."logout" ?>" title="And this is Sparta!" rel="tooltip">logout</a></li>
				</ul>
			</div>
		</section>
		<!-- /User Info -->
		
		<!-- Main Navigation -->
		<nav id="main-nav">
			<ul>
				<li><a href="index.html" title="" class="dashboard no-submenu">Dashboard</a></li> <!-- Use class .no-submenu to open link instead of a sub menu-->
				<!-- Use class .current to open submenu on page load -->
				<!--
				<li class="current">
					<a href="#" title="" class="projects">Berita</a><span title="You have 3 new tasks">3</span>
					<ul>
						<li><a href="<?php echo base_url()?>" title="" class="pnc_link">Intake Form</a></li>
                        <li><a href="<?php echo base_url()?>lists" title="" class="pnc_link">Patient List</a></li>					
					</ul>
				</li>			
				-->
                <li class="current">
					<a href="#" title="" class="projects">Communication</a><span title="You have 3 new tasks">3</span>
					<ul>
						<li><a href="<?php echo base_url()?>sms" title="" class="pnc_link">SMS</a></li>
						<li><a href="<?php echo base_url()?>sms/history" title="" class="pnc_link">History SMS</a></li>
                    </ul>
				</li>
				<li><a href="#" title="" class="settings">Settings</a></li>
			</ul>
		</nav>
		<!-- /Main Navigation -->
		
		<!-- Sidebar -->
		<section class="sidebar nested"> <!-- Use class .nested for diferent style -->
			<h2>Announcement</h2>
			<p>Annoucement Will Be Here.</p>			
		</section>
		<!-- /Sidebar -->
		
	
	</section>
	<!-- /Aside Block -->
	
	<!-- Main Content -->
	<section role="main">
	
		
		
		<!-- Breadcumbs -->
        
		<ul id="breadcrumbs">
			<li><a href="<?php echo base_url()?>" title="Back to Homepage">Back to Home</a></li>
            <li><a href="#">Communication</a></li>			
			<li>Current Page</li>
		</ul>
        
		<!-- /Breadcumbs -->
		
		<!-- Full Content Block -->
		<!-- Note that only 1st article need clearfix class for clearing -->
		<article class="full-block clearfix">
            <!-- Article Header -->
			<header>
				<h2>Send SMS</h2>
				
			</header>
			<!-- /Article Header -->
            
		    <?php if (isset($page)) echo $page;  else $page= '';?>
			<!-- Article Footer -->
			<footer style="text-align: center;">
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
    <script src="<?php echo admin_tpl_path()?>js/jquery/jquery.ui.core.min.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/jquery/jquery.ui.widget.min.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/jquery/jquery.ui.datepicker.min.js"></script>
    <script src="<?php echo admin_tpl_path()?>js/jquery/jquery.validate.min.js"></script>	
	<script src="<?php echo admin_tpl_path()?>js/jquery/ui.spinner.min.js"></script>
	<script src="<?php echo admin_tpl_path()?>js/script.js"></script>

</body>

</html>