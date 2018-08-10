<!DOCTYPE html>
<html lang="en">
<head>
    <title>iEat</title>
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
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/effects.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/components.css">
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo PROJECT_DIR ?>views/assets/css/core.css">
    <link rel="stylesheet" href="<?php echo PROJECT_DIR ?>views/assets/OwlCarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo PROJECT_DIR ?>views/assets/OwlCarousel/owl.theme.default.min.css">
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

    <script src="<?php echo PROJECT_DIR ?>views/assets/OwlCarousel/owl.carousel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/en-ca.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo PROJECT_DIR ?>views/assets/js/nicescroll.min.js"></script>
    <script src="<?php echo PROJECT_DIR ?>views/assets/js/jquery.filterizr.min.js"></script>
    <script src="<?php echo PROJECT_DIR ?>views/assets/js/app.js"></script>

</head>
<!-- Main navbar -->
<nav>
    <a href="#" class="menu-trigger"><i class="fa fa-bars"></i></a>
    <ul>
        <li><a href="<?php echo PROJECT_DIR ?>?controller=user&action=showHomePage"><i class="fa fa-home"></i> Home</a>
        </li>


        <li><a href="<?php echo PROJECT_DIR ?>?controller=user&action=showMenuPage"><i class="icon-stack"></i>
                Menu</a></li>

        <li><a href="<?php echo PROJECT_DIR ?>?controller=user&action=showCart"><i class="fa fa-shopping-cart"></i>
                Cart</a></li>
        <?php
        if ($_SESSION['logged_in'] != 1) {
            ?>
            <li class="float-right"><a href="<?php echo PROJECT_DIR ?>?controller=login&action=showLoginRegister"> <i
                            class="fa fa-sign-in"></i> Login
                    /
                    Register</a></li>
        <?php } else { ?>
            <li class="float-right">
                <div class="nav toggle">
                    <div class="btn-group">
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"
                                style="background: transparent; color:#fff; text-transform: none;">
                            <?php echo $_SESSION['email'] ?>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php if ($this->userInformation['is_admin'] == 1 && $_SESSION['logged_in'] == 1) { ?>
                                <li>
                                    <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showDashboard"><i
                                                class="fa fa-user-circle"></i> Dashboard</a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a href="<?php echo PROJECT_DIR ?>?controller=user&action=showProfile"><i
                                                class="fa fa-user-circle"></i> Your
                                        Profile</a>
                                </li>
                            <?php } ?>
                            <li><a href="<?php echo PROJECT_DIR ?>?controller=user&action=showOrderList"> <i
                                            class="icon-stack"></i>Order List</a></li>
                            <li><a href="<?php echo PROJECT_DIR ?>?controller=login&action=logOut"> <i
                                            class="fa fa-sign-out-alt"></i>Log Out</a></li>

                        </ul>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</nav>
<!-- /Main navbar -->
<body class="no-padding">
