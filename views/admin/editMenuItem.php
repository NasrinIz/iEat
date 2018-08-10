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
                                          action="<?php echo PROJECT_DIR ?>?controller=admin&action=editMenuItem" enctype="multipart/form-data">
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <h2 class="fs-title">Menu Item</h2>
                                            <h3 class="fs-subtitle"></h3>
                                            <input type="text" name="name"
                                                   placeholder="Name"
                                                   class="menu_field profileInput" value="<?php echo $this->menuItem['name']?>"/>
                                            <textarea name="content" placeholder="Description"
                                                      class="menu_field profileTextArea"><?php echo $this->menuItem['content']?></textarea>
                                            <input type="text" name="calories"
                                                   placeholder="Calories"
                                                   class="menu_field profileInput" value="<?php echo $this->menuItem['calories']?>"/>
                                            <input type="text" name="amount"
                                                   placeholder="Amount"
                                                   class="menu_field profileInput" value="<?php echo $this->menuItem['amount']?>"/>
                                            <input type="hidden" name="id" value="<?php echo $this->menuItem['id']?>"/>
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
