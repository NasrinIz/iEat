<div class="background">    <div class="container-fluid">        <!--MAIN CONTENT-->        <div class="row">            <div class="col-md-12 bg-color-ddd">                <!-- HomePage -->                <div><?php echo $this->notification ?></div>                <div class="dashboard-content no-print">                    <fieldset class="bg-white">                        <table id="tableList" class="display table-responsive" style="width:100%">                            <thead>                            <tr>                                <th>Customer</th>                                <th>Customer Address</th>                                <th>Total Price</th>                                <th>Order Date</th>                                <th>Status</th>                                <th>Menu</th>                            </tr>                            </thead>                            <tbody>                            <?php foreach ($this->orderList as $key => $value) { ?>                                <tr>                                    <td>                                        <?php echo $this->userInformation['name'] ?>                                    </td>                                    <td>                                        <?php echo $this->userInformation['address'] ?>                                    </td>                                    <td>                                        <?php echo $value['total_price'] ?>                                    </td>                                    <td>                                        <?php echo $value['order_date_time'] ?>                                    </td>                                    <td>                                        <?php if ($value['status'] == 0) {                                            echo 'Waiting';                                        } else if ($value['status'] == 1) {                                            echo 'Registered';                                        } else if ($value['status'] == 2) {                                            echo 'Sent';                                        } else if ($value['status'] == 3) {                                            echo 'Delivered';                                        } else {                                            echo 'Done';                                        } ?>                                    </td>                                    <td>                                        <ul class="icons-list">                                            <li class="dropdown">                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"                                                   aria-expanded="false"><strong><i class="icon-menu7"></i></strong></a>                                                <ul class="dropdown-menu dropdown-menu-right">                                                    <li><a href="#"><strong><i class="icon-gear"></i></strong> Settings</a></li>                                                </ul>                                            </li>                                        </ul>                                    </td>                                </tr>                            <?php } ?>                            </tbody>                        </table>                        <!--  <?php /*if ($this->userInformation['user_type'] == "owner") { */ ?>                            <button type="button" class="btn bg-teal-400 btn-labeled legitRipple"><b><i                                            class="fa fa-plus"></i></b>                                <a href="<?php /*echo PROJECT_DIR */ ?>?controller=owner&action=showAddProject">Add                                    Project</a></button>                            --><?php                        /*                        } */ ?>                    </fieldset>                </div>            </div>        </div>    </div>    <!-- end container fluid --></div><!-- /HomePage --><script>    $('#tableList').DataTable({});</script>