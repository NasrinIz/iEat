<div class="background">
    <div class="page-container">
        <!--MAIN CONTENT-->
        <!-- HomePage -->
        <div><?php echo $this->notification ?></div>
        <div class="dashboard-content no-print customForm">
            <input type="text" class="menu_field profileInput " name="search" placeholder="Search..."
                   data-search>
            <div class="row">
                <div class="filtr-container customForm">
                    <?php foreach ($this->menuList as $key => $value) { ?>
                        <div class="col-md-4 filtr-item" data-category="1"
                             data-sort="<?php echo $value['name'] ?>">
                            <figure class="customCard">
                                <div class="image">
                                    <img src="<?php echo PROJECT_DIR ?>uploads/menus/<?php echo $value['id'] ?>/<?php echo $value['picture'] ?>"
                                         alt="Card image cap">
                                </div>
                                <figcaption>
                                    <h5><?php echo $value['title'] ?></h5>
                                    <p><?php echo $value['content'] ?></p>
                                    <div class="rectangle">
                                      <strong><i class="icon-stack"></i></strong>
                                    </div>
                                  <button type="submit" class="submit action-button"><a
                                            href="<?php echo PROJECT_DIR ?>?controller=user&action=showMenuDetail&menuId=<?php echo $value['id'] ?>">
                                            Details</a></button>
                                </figcaption>
                            </figure>
                            <br/>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end container fluid -->
</div>
<!-- /HomePage -->

<script>
    let filterizd = $('.filtr-container').filterizr({
        //options object
    });
    filterizd.filterizr('setOptions', {layout: 'packed'});
</script>