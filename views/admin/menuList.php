<div>
    <div class="container-fluid">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print">
                    <fieldset class="bg-white">
                        <table id="tableList" class="display table-responsive" style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Content</th>
                                <th>Calories</th>
                                <th>Amount</th>
                                <th>Image</th>
                                <th>Menu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->menuList as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['content'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['calories'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['amount'] ?>
                                    </td>
                                    <td>
                                        <a target="_blank"
                                           href="<?php echo PROJECT_DIR ?>uploads/menus/<?php echo $value['id'] ?>/<?php echo $value['img'] ?>">
                                           img
                                        </a>
                                    </td>
                                    <td>
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><strong><i class="icon-menu7"></i></strong></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showEditMenuItem&id=<?php echo $value['id'] ?>">
                                                             Edit<strong> <i class="icon-pencil"></i></strong></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=deleteMenuItem&id=<?php echo $value['id'] ?>">
                                                             Delete<strong> <i class="icon-trash"></i></strong></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <br/>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <!-- end container fluid -->
</div>
<!-- /HomePage -->

<script>
    $('#tableList').DataTable({});
</script>