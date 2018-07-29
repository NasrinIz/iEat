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
                                <th>Full Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Comments</th>
                                <th>Menu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->owners as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['full_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['address'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['phone'] ?>
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
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=owner&action=deleteOwner&id=<?php echo $value['owner_id'] ?>">
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