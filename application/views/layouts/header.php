<!DOCTYPE html>
	<html lang="en">
	<head>
		<title><?php echo isset($title) ? $title : 'Dashboard'; ?> | CMS</title>
		<meta charset="utf-8">
	    <meta name="description" content="AID is Content Management System Dens.TV">
	    <meta name="keywords" content="HTML,CSS,XML,PHP,JavaScript">
	    <meta name="author" content="facav">
	    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	     
	    <!-- Google / Search Engine Tags -->
	    <meta itemprop="name" content="AID">
	    <meta itemprop="description" content="AID is Content Management System Dens.TV">
	    <meta itemprop="image" content="<?=base_url()?>assets/img/dens_tv.png">
	     
	    <!-- Facebook Meta Tags -->
	    <meta property="og:url" content="http://aid.digdaya.co.id">
	    <meta property="og:type" content="website">
	    <meta property="og:title" content="AID">
	    <meta property="og:description" content="AID is Content Management System Dens.TV">
	    <meta property="og:image" content="<?=base_url()?>assets/img/dens_tv.png">
	     
	    <!-- Twitter Meta Tags -->
	    <meta name="twitter:card" content="summary_large_image">
	    <meta name="twitter:title" content="AID">
	    <meta name="twitter:description" content="AID is Content Management System Dens.TV">
	    <meta name="twitter:image" content="<?=base_url()?>assets/img/dens_tv.png">

		<link rel="shortcut icon" href="<?=base_url()?>assets/img/dens_tv.png">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/animate.css/animate.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/image-picker/image-picker.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/select2/dist/css/select2.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/fontawesome5102/css/all.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/fontawesome/dist/css/fontawesome-iconpicker.min.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/video-js/video-js.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/video-js/theme/forest/index.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/css/jquery.minicolors.css">
	    <link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">

	    <style type="text/css">
	        .top-nav>li>a:not(.header__nav__text)>.zmdi {font-size: 1.5rem;}
	    </style>
	</head>
	<body data-sa-theme="3">
		<main class="main">
	  		<div class="page-loader">
	    		<div class="page-loader__spinner">
	      			<svg viewBox="25 25 50 50">
	        			<circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
	      			</svg>
	    		</div>
	  		</div>
	  		<header class="header">
	    		<div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
	      			<i class="zmdi zmdi-menu"></i>
	    		</div>
	    		<div class="logo hidden-sm-down">
	      			<a href="<?php echo site_url('dashboard'); ?>">
	      				<img src="<?=base_url()?>assets/img/logo.png" alt="">
	      			</a>
	    		</div>
	    		<ul class="top-nav">
                    <li>
                        <div id="MyClockDisplay" class="clock hidden-md-down" onload="showTime()"></div>
                    </li>
                    <li class="dropdown hidden-xs-down">
                        <a class="btn btn-light" href="<?php echo base_url('Auth/logout'); ?>"><i class="zmdi zmdi-power zmdi-hc-fw"></i></a>
                    </li>
                </ul>
	  		</header>

	  	<script src="<?=base_url()?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/image-picker/image-picker.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
        <script src="<?=base_url()?>assets/vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
        <script src="<?=base_url()?>assets/fontawesome/dist/js/fontawesome-iconpicker.min.js"></script>
        <script src="<?=base_url()?>assets/js/datatables.js"></script>
        <script src="<?=base_url()?>assets/js/jquery-ui.min.js"></script>
        <script src="<?=base_url()?>assets/video-js/ie8/1.1.2/videojs-ie8.min.js"></script>
        <script src="<?=base_url()?>assets/video-js/video.js">"></script>
        <script src="<?=base_url()?>assets/js/jquery.minicolors.min.js"></script>
        <script src="<?=base_url()?>assets/js/app.min.js"></script>
        <script type="text/javascript">
          	$(document).ready(function(){
                showTime()
            })

            function showTime(){
                var date = new Date();
                var h = date.getHours(); // 0 - 23
                var m = date.getMinutes(); // 0 - 59
                var s = date.getSeconds(); // 0 - 59
                var session = "AM";
                
                if(h == 0)
                {
                    h = 12;
                }
                
                if(h > 12)
                {
                    h = h - 12;
                    session = "PM";
                }
                
                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;
                
                var time = h + ":" + m + ":" + s + " " + session;
                document.getElementById("MyClockDisplay").innerText = time;
                document.getElementById("MyClockDisplay").textContent = time;
                setTimeout(showTime, 1000);
            }
        </script>