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
                                <th>Project Name</th>
                                <th>Open Visit Date</th>
                                <th>Description</th>
                                <th>Vendors Applied</th>
                                <th>Hourly Wage</th>
                                <th>Possible Start Date</th>
                                <th>Time Estimation</th>
                                <th>Vendor Comment</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>Finish Date</th>
                                <th>Menu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->projects as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo PROJECT_DIR ?>?controller=project&action=showProjectDetail&projectId=<?php echo $value['id'] ?>"><?php echo $value['project_name'] ?></a>
                                    </td>
                                    <td>
                                        <?php echo $value['visit_date'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['description'] ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo PROJECT_DIR ?>?controller=vendor&action=showVendorDetail&vendorId=<?php echo $value['vendor_id'] ?>"><?php $vendorInfo = VendorModel::getVendorById($value['vendor_id']);
                                            echo $vendorInfo['full_name'] ?></a></td>
                                    <td><?php echo $value['vendor_hourly_wage'] ?></td>
                                    <td><?php echo $value['vendor_possible_start_date'] ?></td>
                                    <td><?php echo $value['vendor_time_estimation'] ?></td>
                                    <td><?php echo $value['vendor_comment'] ?></td>
                                    <td><?php foreach ($this->projectStatus as $keyS => $valueS) {
                                            if ($value['project_status'] == $valueS['id']) {

                                                if ($value['project_status'] == 1) {
                                                    echo '<span class="text-grey">' . $valueS['name'] . '</span>';
                                                } else if ($value['project_status'] == 2) {
                                                    echo '<span class="text-blue">' . $valueS['name'] . '</span>';
                                                } else if ($value['project_status'] == 3) {
                                                    echo '<span class="text-orange">' . $valueS['name'] . '</span>';
                                                } else {
                                                    echo '<span class="text-green">' . $valueS['name'] . '</span>';
                                                }

                                            }
                                        } ?></td>
                                    <td><?php echo $value['start_date'] ?></td>
                                    <td><?php echo $value['finish_date'] ?></td>
                                    <td>
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><i class="icon-menu7"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=project&action=deleteProject&id=<?php echo $value['id'] ?>">
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