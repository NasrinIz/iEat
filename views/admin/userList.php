<div>
    <div class="container-fluid">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print">
                    <fieldset class="bg-white">
                        <table id="usersListTable" class="display table-responsive" style="width:100%">
                            <thead>
                            <tr>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Company Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Comments</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php foreach ($this->users as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['username'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['full_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['company_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['phone'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['address'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['comments'] ?>
                                    </td>
                                    <td>
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><strong><i class="icon-menu7"></i></strong></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <!--  <li>
                                                        <a href="<?php /*echo PROJECT_DIR */ ?>?controller=user&action=editUser&id=<?php /*echo $value['id'] */ ?>">
                                                            Edit <i class="icon-pencil"></i>
                                                        </a>
                                                    </li>-->
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=user&action=deleteUser&id=<?php echo $value['id'] ?>">
                                                            Delete<strong><i class="icon-trash"></i></strong></a>
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
    $('#usersListTable').DataTable({});
</script>