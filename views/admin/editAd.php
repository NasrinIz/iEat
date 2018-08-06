<div>
    <div class="container">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form class="customForm" method="post"
                                          action="<?php echo PROJECT_DIR ?>?controller=admin&action=editAd" enctype="multipart/form-data">
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <h2 class="fs-title">Advertisement</h2>
                                            <h3 class="fs-subtitle"></h3>
                                            <input type="text" name="title"
                                                   placeholder="Title"
                                                   class="menu_field profileInput" value="<?php echo $this->adDetail['title']?>"/>
                                            <textarea name="content" placeholder="Content"
                                                      class="menu_field profileTextArea"><?php echo $this->adDetail['content']?></textarea>
                                            <input type="hidden" name="id" value="<?php echo $this->adDetail['id']?>"/>
                                        <!--    <label class="text-bold">Advertisement Picture</label>
                                            <input type="file" class="menu_field profileInput" name="img01" id="img01">-->
                                            <input type="submit" name="submit" class="submit action-button"
                                                   value="Update"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end container fluid -->
</div>
<!-- /HomePage -->

<script>
    $('#openVisitDate').datetimepicker({
        format: 'DD-MM-YYYY'
    });
</script>