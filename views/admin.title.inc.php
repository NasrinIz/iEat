<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="iEat"/>
    <meta name="keywords" content="iEat"/>
    <meta name="author" content="iEat"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
          integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
          type="text/css">
    <link href="<?php echo PROJECT_DIR ?>/views/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo PROJECT_DIR ?>views/assets/css/introjs.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/effects.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/components.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/core.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/responsive.css">

    <script src="<?php echo PROJECT_DIR ?>views/assets/js/modernizr.custom.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"
            integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
            crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"></script>

    <script src="<?php echo PROJECT_DIR ?>views/assets/js/intro.min.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/en-ca.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo PROJECT_DIR ?>views/assets/js/nicescroll.min.js"></script>
    <script src="<?php echo PROJECT_DIR ?>views/assets/js/jquery.filterizr.min.js"></script>
    <script src="<?php echo PROJECT_DIR ?>views/assets/js/app.js"></script>
    <script src="<?php echo PROJECT_DIR ?>views/assets/js/dashboard.js"></script>

</head>
<body class="navbar-bottom admin-bg">

<!-- Main navbar -->
<div class="navbar navbar-inverse bg-warning-600">
    <div class="navbar-header">
        <ul class="nav navbar-nav visible-xs-block">
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
        <li class="float-left margin-right" style="list-style: none; color: #fff !important;"><a href="#" onclick="startIntroJs()"> <i
                        class="icon-question3"></i> Help</a></li>
    </div>
</div>
<!-- /main navbar -->
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
        <div class="sidebar sidebar-main sidebar-default">
            <div class="sidebar-content">

                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="sidebar-user-material">
                        <div class="category-content">
                            <div class="sidebar-user-material-content">
                                <a href="#"><img src="#" class="img-circle img-responsive" alt=""></a>
                                <h6><?php echo $this->userInformation['username'] ?></h6>
                                <span class="text-size-small"></span>
                            </div>

                            <div class="sidebar-user-material-menu">
                                <a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
                            </div>
                        </div>

                        <div class="navigation-wrapper collapse" id="user-nav">
                            <ul class="navigation">
                                <li><a href="#"><i class="icon-user-plus"></i> <span>My profile</span></a></li>
                                <li><a href="#"><i class="icon-comment-discussion"></i> <span><span
                                                    class="badge bg-teal-400 pull-right">58</span> Messages</span></a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="icon-cog5"></i> <span>Account settings</span></a></li>
                                <li><a href="<?php echo PROJECT_DIR ?>?controller=login&action=logOut"><i class="icon-switch2"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">

                            <!-- Main -->
                            <li class="navigation-header"><span>Main</span> <i class="icon-menu" title="Main pages"></i>
                            </li>
                            <li class="active"><a
                                        href="<?php echo PROJECT_DIR ?>?controller=user&action=showHomePage"><i
                                            class="icon-home"></i> <span>HomePage</span></a></li>
                            <li class="active"><a
                                        href="<?php echo PROJECT_DIR ?>?controller=admin&action=showDashboard"><i
                                            class="icon-home4"></i> <span>Dashboard</span></a></li>
                            <li>
                                <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showMenuList"><i class="icon-stack"></i> <span>Customize Menu</span></a>
                                <ul>
                                    <li><a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showAddMenuItem"><i class="icon-plus2"></i> Add Item</a></li>
                                    <li><a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showMenuList"><i class="icon-list2"></i> Menu List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showAdvertisementList"><i class="icon-stack"></i> <span>Advertisement</span></a>
                                <ul>
                                    <li><a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showAddAdvertisement"><i class="icon-plus2"></i> Add Advertisement</a></li>
                                    <li><a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showAdvertisementList"><i class="icon-list2"></i> Advertisement List</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showOrderList"><i class="icon-list"></i> <span>Order List</span></a>
                            </li>
                            <li>
                                <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showSetTime"><i class="icon-database-time2"></i> <span>Set Order Time</span></a>
                            </li>
                            <!-- /main -->
                        </ul>
                    </div>
                </div>
                <!-- /main navigation -->
            </div>
        </div>
        <!-- /main sidebar -->
