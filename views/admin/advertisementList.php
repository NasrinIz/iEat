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
                                <th>Name</th>
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
                                        <?php echo $value['img'] ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo PROJECT_DIR ?>?controller=vendor&action=showVendorDetail&vendorId=<?php echo $value['vendor_id'] ?>"><?php $vendorInfo = VendorModel::getVendorById($value['vendor_id']);
                                            echo $vendorInfo['full_name'] ?></a></td>
                                    <td>
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                   aria-expanded="false"><i class="icon-menu7"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=deleteAd&id=<?php echo $value['id'] ?>">
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
                        <button type="button" class="btn bg-teal-400 btn-labeled legitRipple"><b><i
                                        class="fa fa-plus"></i></b>
                            <a href="<?php echo PROJECT_DIR ?>?controller=admin&action=showAddAdvertisement">Add
                                Advertisement</a>
                        </button>
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