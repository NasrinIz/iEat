<!-- Main content -->
<div class="content-wrapper">

    <!-- Main charts -->
    <div class="row">
        <div class="col-lg-7">

            <!-- Traffic sources -->
            <div class="panel panel-flat" data-intro="You can see the overview here" data-step="1">
                <div class="panel-heading">
                    <h6 class="panel-title">Overview</h6>
                    <div class="heading-elements">
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list-inline text-center">
                                <li class="no-padding-right">
                                    <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showUsersList" class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><strong><i class="icon-user"></i></strong></a>
                                </li>
                                <li class="text-left">
                                    <div class="text-semibold text-center">Users</div>
                                    <div class="text-muted"></div>
                                </li>
                            </ul>

                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="content-group" id="new-visitors"></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <ul class="list-inline text-center">
                                <li class="no-padding-right">
                                    <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showBrancheList" class="btn border-warning-400 text-warning-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><strong><i class="fa fa-project-diagram"></i></strong></a>
                                </li>
                                <li class="text-left">
                                    <div class="text-semibold text-center">Branches</div>
                                    <div class="text-muted"></div>
                                </li>
                            </ul>

                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="content-group" id="new-sessions"></div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <ul class="list-inline text-center">
                                <li class="no-padding-right">
                                    <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showOrderList" class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><strong><i class="fa fa-shopping-basket"></i></strong></a>
                                </li>
                                <li class="text-left">
                                    <div class="text-semibold text-center">Orders</div>
                                    <div class="text-muted"></div>
                                </li>
                            </ul>

                            <div class="col-lg-10 col-lg-offset-1">
                                <div class="content-group" id="total-online"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="position-relative" id="traffic-sources"></div>
            </div>
            <!-- /traffic sources -->

        </div>

        <div class="col-lg-5">

            <!-- Sales stats -->
            <div class="panel panel-flat"  data-intro="You can see the report here" data-step="2">
                <div class="panel-heading">
                    <h6 class="panel-title">Report</h6>
                    <div class="heading-elements">
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="content-group">
                                <h5 class="text-semibold no-margin"><strong><i class="icon-calendar5 position-left text-slate"></i></strong></h5>
                                <span class="text-muted text-size-small"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="content-group">
                                <h5 class="text-semibold no-margin"><strong><i class="icon-calendar52 position-left text-slate"></i></strong></h5>
                                <span class="text-muted text-size-small"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="content-group">
                                <h5 class="text-semibold no-margin"><strong><i class="icon-cash3 position-left text-slate"></i></strong></h5>
                                <span class="text-muted text-size-small"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-group-sm" id="app_sales"></div>
                <div id="monthly-sales-stats"></div>
            </div>
            <!-- /sales stats -->

        </div>
    </div>
    <!-- /main charts -->


    <!-- Dashboard content -->
    <div class="row">
        <div class="col-lg-8">


        </div>
    </div>
    <!-- /dashboard content -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->

</div>
<!-- /page container -->