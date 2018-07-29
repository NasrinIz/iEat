<div>
    <div class="container-fluid">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print">
                    <fieldset class="bg-white">
                        <table id="ownerProjectList" class="display table-responsive" style="width:100%">
                            <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Job Description</th>
                                <th>Comments</th>
                                <th>Menu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->vendors as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['company_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['full_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['email'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['phone'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['address'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['job_description'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['comments'] ?>
                                    </td>
                                    <td>
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><i class="icon-menu7"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=vendor&action=deleteVendor&id=<?php echo $value['vendor_id'] ?>">
                                                            Delete<i class="icon-trash"></i></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php if ($this->userInformation['user_type'] == "owner") { ?>
                            <button type="button" class="btn bg-teal-400 btn-labeled legitRipple"><b><i
                                        class="fa fa-plus"></i></b>
                                <a href="<?php echo PROJECT_DIR ?>?controller=owner&action=showAddProject">Add
                                    Project</a></button>
                            <?php
                        } ?>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <!-- end container fluid -->
</div>
<!-- /HomePage -->

<script>
    $('#ownerProjectList').DataTable({});
</script>