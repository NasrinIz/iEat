<div>
    <div class="container-fluid">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print">
                    <fieldset class="bg-white">
                        <table id="adTableList" class="display table-responsive" style="width:100%">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Image</th>
                                <th>Menu</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->advertisements as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['title'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['content'] ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo PROJECT_DIR ?>uploads/advertisements/<?php echo $value['id'] ?>/<?php echo $value['img'] ?>" target="_blank">
                                            <?php echo $value['img'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><strong><i class="icon-menu7"></i></strong></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showEditAd&id=<?php echo $value['id'] ?>">
                                                            Edit <strong><i class="icon-pencil"></i></strong></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=deleteAd&id=<?php echo $value['id'] ?>">
                                                            Delete <strong><i class="icon-trash"></i></strong></a>
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
    $('#adTableList').DataTable({});
</script>