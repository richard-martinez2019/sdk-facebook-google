<!DOCTYPE html>
<html lang="es-cl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex/nofollow" />

    <title>Dashboard CMS :: WebySEO</title>
    <meta content="" name="description" />   
    

    <!-- App favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Summernote css -->
    <link href="/css/vendor/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <!-- SimpleMDE css -->
    <link href="/css/vendor/simplemde.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/css/app.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        .card .header-title { font-size: .8rem; }
        .left-side-menu {
            background: rgb(249,44,139);
            background: -moz-linear-gradient(159deg, rgba(249,44,139,1) 0%, rgba(135,50,222,1) 54%, rgba(0,212,255,0.01) 100%);
            background: -webkit-linear-gradient(159deg, rgba(249,44,139,1) 0%, rgba(135,50,222,1) 54%, rgba(0,212,255,0.01) 100%);
            background: linear-gradient(159deg, rgba(249,44,139,1) 0%, rgba(135,50,222,1) 54%, rgba(0,212,255,0.01) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#f92c8b",endColorstr="#00d4ff",GradientType=1);
        }
        .btn-primary {
            background: rgb(249,44,139);
            border-color: rgb(249,44,139);
            -webkit-box-shadow: 0 2px 6px 0 rgba(249,44,139,.5);
            box-shadow: 0 2px 6px 0 rgba(249,44,139,.5);
        }
        .page-title, .header-title {
            color: rgb(135,50,222) !important;
        }
        .bg-colorido {
           background: rgb(249,44,139);
           background: -webkit-linear-gradient(left, rgba(249,44,139,1) 0%, rgba(132,50,222,1) 100%, rgba(0,212,255,1) 100%);
           background: -o-linear-gradient(left, rgba(249,44,139,1) 0%, rgba(132,50,222,1) 100%, rgba(0,212,255,1) 100%);
           background: linear-gradient(to right, rgba(249,44,139,1) 0%, rgba(132,50,222,1) 100%, rgba(0,212,255,1) 100%);
        }
    </style>

</head>

<body class="<?php if(isset($css_body)): echo ' '.$css_body; endif; ?>">
    
    <?php if( isset($login) && $login == true ): ?>
    <?php else: ?>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">

            <div class="slimscroll-menu" id="left-side-menu-container">

                <!-- LOGO -->
                <a href="/" class="logo text-center">
                    <span class="logo-lg">
                        <img src="https://clickrepuestos.cl/pro/img/logo-webyseo-blanco.svg" alt="" height="36">
                    </span>
                    <span class="logo-sm">
                        <img src="https://clickrepuestos.cl/pro/img/logo-webyseo-blanco.svg" alt="" height="36">
                    </span>
                </a>

                <!--- Sidemenu -->
                <?php include 'inc/_menu.php'; ?>

                <!-- End Sidebar -->
                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Topbar Start -->
                <?php include 'inc/_barra_top.php'; ?>
                <!-- end Topbar -->

    <?php endif; 