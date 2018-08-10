<div>
    <div class="container">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <input type="hidden" value="<?php echo $this->userInformation['id'] ?>"/>
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <form class="customForm" method="post"
                                          action="<?php echo PROJECT_DIR ?>?controller=admin&action=addMenuItem" enctype="multipart/form-data">
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <h2 class="fs-title">Menu Item</h2>
                                            <h3 class="fs-subtitle"></h3>
                                            <input type="text" name="name"
                                                   placeholder="Name"
                                                   class="menu_field profileInput"/>
                                            <textarea name="content" placeholder="Description"
                                                      class="menu_field profileTextArea"></textarea>
                                            <input type="text" name="calories"
                                                   placeholder="Calories"
                                                   class="menu_field profileInput"/>
                                            <input type="text" name="amount"
                                                   placeholder="Amount"
                                                   class="menu_field profileInput"/>
                                            <label class="text-bold">Item Picture</label>
                                            <input type="file" class="menu_field profileInput" name="img01" id="img01">
                                            <input type="submit" name="submit" class="submit action-button"
                                                   value="Add"/>
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