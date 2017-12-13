<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>SAME Estates Manager&reg; | <?php echo $title; ?></title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />

        <!-- Datepicker CSS -->
        <link rel="stylesheet" href="<?php echo base_url("assets/css/datepicker.css"); ?>" />

        <!-- Daterangepicker CSS -->
        <link rel="stylesheet" href="<?php echo base_url("assets/css/daterangepicker.css"); ?>" />

        <!-- Select 2 CSS -->
        <link rel="stylesheet" href="<?php echo base_url("assets/css/select2.min.css"); ?>" />

        <!-- Data table CSS -->
        <!-- Data table CSS>
        <link rel="stylesheet" href="<?php echo base_url("assets/css/dataTables.bootstrap.css"); ?>" / -->
        <link rel="stylesheet" href="<?php echo base_url("assets/DataTables/datatables.min.css"); ?>" />
        <!--link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/DataTables/DataTables-1.10.16/css/dataTables.bootstrap.min.css"); ?>"/-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/DataTables/Buttons-1.4.2/css/buttons.bootstrap.min.css"); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/DataTables/FixedHeader-3.1.3/css/fixedHeader.bootstrap.min.css"); ?>"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/DataTables/Scroller-1.4.3/css/scroller.bootstrap.min.css"); ?>"/>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url("assets/css/AdminLTE.min.css"); ?>">

        <!-- Morris Charts CSS -->
        <link href="<?php echo base_url("assets/css/morris.css"); ?>" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo base_url("assets/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="<?php echo base_url("assets/css/skin-purple-light.min.css"); ?>" type="text/css">
        <!-- iCheck -->

        <link rel="stylesheet" href="<?php echo base_url("assets/iCheck/square/blue.css"); ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.2.1.min.js"); ?>"></script>
        <style>
            textarea {
                resize: vertical; /* user can resize vertically, but width is fixed */
            }
            body {
                background-color: #f6f6f6;
            }
        </style>
    </head>

    <body class="hold-transition skin-red-light sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini" title="SAME Estates Manager&reg;"><b>SEM&reg;</b></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg" title="SAME Estates Manager&reg;"><b>SAME EM&reg;</b></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                   <!--  <img src="<?php echo base_url("assets/images/profiles/{$_SESSION['username']}-160x160.jpg"); ?>" class="user-image" alt="User Image">
                                    hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">
                                        <?php
                                        if (isset($_SESSION['user_id'])) {
                                            echo $_SESSION['username'];
                                        }
                                        ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <p>
                                            <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>
                                            <small>Member since <?php echo mdate('%M. %Y', $_SESSION['reg_date']); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <?php if (isset($_SESSION['user_id'])) {
                                            ?>
                                            <div class="pull-left">
                                                <a href="<?php echo site_url("user/view/" . $_SESSION['user_id']); ?>" class="btn btn-default btn-flat"> User Profile</a>
                                            </div>
                                            <div class="pull-right">
                                                <a href="<?php echo site_url("user/logout/"); ?>" class="btn btn-default btn-flat"> Sign out</a>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="pull-right">
                                                <a href="<?php echo site_url("user/login/"); ?>" class="btn btn-default btn-flat"> Sign in</a>
                                            </div>
                                        <?php } ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) 
                    <div class="user-panel">-->
                    <!--<div class="pull-left image">
                       <img src="<?php echo base_url("assets/images/profiles/{$_SESSION['username']}-160x160.jpg"); ?>" class="img-circle" alt="User Image"/>
                    </div>
                    <div class="pull-left info">
                      <p><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?></p>-->
                    <!-- Status 
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                  </div>
                </div>-->

                    <!-- search form (Optional)
                    <form action="#" method="get" class="sidebar-form">
                      <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                      </div>
                    </form> -->
                    <!-- /.search form -->

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">Menu</li>
                        <!-- Optionally, you can add icons to the links -->
                        <!-- If ordinary staff have logged in -->
                        <!-- ?php if($_SESSION['role']==2){?-->
                        <li>
                            <a href="#">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url("tenant"); ?>">
                                <i class="fa fa-hotel"></i> <span>Tenants</span>
                            </a>
                            <!--ul class="treeview-menu"> <i class="fa fa-angle-left pull-right"></i>
                              <li><a href="<?php echo site_url("tenant/create"); ?>"><i class="fa fa-edit"></i> New</a></li>
                              <li><a href="<?php echo site_url("tenancy"); ?>"><i class="fa fa-binoculars"></i> View</a></li>
                              <li><a href="<?php echo site_url("tenant"); ?>"><i class="fa fa-hotel"></i> Other  tenants</a></li>
                            </ul-->
                        </li>
                        <li class="treeview">
                            <a href="<?php echo site_url("payment"); ?>">
                                <i class="fa fa-credit-card"></i> <span>Payments</span>
                            </a>
                            <!--ul class="treeview-menu">
                              <li><a href="<?php echo site_url("payment/create"); ?>"><i class="fa fa-edit"></i> New</a></li>
                              <li><a href="<?php echo site_url("payment"); ?>"><i class="fa fa-binoculars"></i> View</a></li>
                            </ul-->
                        </li>
                        <!-- If the estates owner/admininistrator is logged in -->
                        <?php if ($_SESSION['role'] == 4 || $_SESSION['role'] == 3) { ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-user"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="<?php echo site_url("user/create"); ?>"><i class="fa fa-edit"></i> New</a></li>
                                    <li><a href="<?php echo site_url("user"); ?>"><i class="fa fa-binoculars"></i> View</a></li>
                                </ul>
                            </li>

                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-gear"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-money"></i> <span>Accounts</span> <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
                                            <li><a href="<?php echo site_url("account/create"); ?>"><i class="fa fa-edit"></i> New</a></li>
                                            <li><a href="<?php echo site_url("account"); ?>"><i class="fa fa-binoculars"></i> View</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url("estate"); ?>">
                                            <i class="fa fa-institution"></i> <span>Estates</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url("house"); ?>">
                                            <i class="fa fa-home"></i> <span>Houses</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul><!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">		
                    <h1>
                        <?php echo $title; ?>
                        <small><?php echo $sub_title; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active"><?php echo $title; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
