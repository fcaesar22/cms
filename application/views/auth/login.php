<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login | CMS</title>
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
        <link rel="stylesheet" href="<?=base_url()?>assets/css/app.min.css">
    </head>
    <body data-sa-theme="3">
        <div class="login">
            <div class="login__block active" id="l-login">
                <div class="login__block__header">
                    <img src="http://localhost/new_cms/assets/img/dens_tv.png" alt="">
                    Hi there! Please Sign in
                </div>
                <div class="login__block__body">
                    <?php if($this->session->flashdata('error')): ?>
                        <p style="color:red;"><?= $this->session->flashdata('error') ?></p>
                    <?php endif; ?>
                    <form action="<?php echo site_url('auth/login'); ?>" method="post">
                        <div class="form-group form-group--float form-group--centered">
                            <input type="text" class="form-control" name="username" placeholder="Username" required />
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group form-group--float form-group--centered">
                            <input type="password" class="form-control" name="password" placeholder="Password" required />
                            <i class="form-group__bar"></i>
                        </div>

                        <button class="btn btn--icon login__block__btn"><i class="zmdi zmdi-long-arrow-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script src="<?=base_url()?>assets/vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url()?>assets/vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?=base_url()?>assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>assets/js/app.min.js"></script>
</html>