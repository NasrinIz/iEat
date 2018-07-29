<div class="background">
    <div class="page-container">
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
                                          action="<?php echo PROJECT_DIR ?>?controller=user&action=completeProfile">
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <h2 class="fs-title">Profile Details</h2>
                                            <h3 class="fs-subtitle"></h3>
                                            <div id="personalDetail">
                                                <label class="font-weight-bold">Full Name</label>
                                                <input type="text" name="name"
                                                                            placeholder="Full Name"
                                                                            class="menu_field profileInput" value="<?php echo !empty($this->userInformation['name']) ? $this->userInformation['name'] : "" ?>"/>
                                                <label class="font-weight-bold">Phone</label>
                                                <input type="text" name="phone" placeholder="Phone"
                                                       class="menu_field profileInput"
                                                       value="<?php echo !empty($this->userInformation['phone']) ? $this->userInformation['phone'] : "" ?>"/>
                                                <label class="font-weight-bold">Address</label>
                                                <textarea name="address" placeholder="Address"
                                                          class="menu_field profileTextArea"><?php echo !empty($this->userInformation['address']) ? $this->userInformation['address'] : "" ?></textarea>
                                            </div>
                                            <input type="hidden" name="id"
                                                   value="<?php echo $this->userInformation['id'] ?>"/>
                                            <input type="submit" name="submit" class="submit action-button"
                                                   value="Submit"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end container fluid -->
</div>
<!-- /HomePage -->