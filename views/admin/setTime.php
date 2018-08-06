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
                                          action="<?php echo PROJECT_DIR ?>?controller=admin&action=setTime"
                                          enctype="multipart/form-data">
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <h2 class="fs-title">Set order time</h2>
                                            <h3 class="fs-subtitle"></h3>
                                            <input type="text" name="order_time_from"
                                                   placeholder="From"
                                                   class="menu_field profileInput"
                                                   value="<?php echo $this->orderTime['order_time_from'] ?>"/>
                                            <input type="text" name="order_time_to"
                                                   placeholder="To"
                                                   class="menu_field profileInput"
                                                   value="<?php echo $this->orderTime['order_time_to'] ?>"/>
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