<div class="container-fluid">
    <form class="customForm" method="post"
          action="<?php echo PROJECT_DIR ?>?controller=user&action=placeOrder">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">Bill</h6>
         <!--   <div class="heading-elements">
                <button type="button" class="btn btn-default btn-xs heading-btn legitRipple"><i
                            class="icon-file-check position-left"></i> Save
                </button>
                <button type="button" class="btn btn-default btn-xs heading-btn legitRipple"><i
                            class="icon-printer position-left"></i> Print
                </button>
            </div>-->
            <a class="heading-elements-toggle"><i class="icon-more"></i></a></div>

        <div id="invoice-editable" contenteditable="true" class="cke_contents_ltr"
             tabindex="0" spellcheck="false" role="textbox" aria-describedby="cke_66" style="position: relative;">
            <div class="panel-body no-padding-bottom">
                <div class="row">
                    <div class="col-sm-6 content-group"><img data-cke-saved-src="assets/images/logo_demo.png"
                                                             src="assets/images/logo_demo.png"
                                                             class="content-group mt-10"
                                                             alt="" style="width: 120px;">
                        <ul class="list-condensed list-unstyled">
                           Subway Montreal- Concordia Branch
                        </ul>
                    </div>
                    <div class="col-sm-6 content-group">
                        <div class="invoice-details"><h5 class="text-uppercase text-semibold"></h5>
                            <ul class="list-condensed list-unstyled">
                                <li>Date: <span class="text-semibold"><?php echo date('d-m-y')?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-9 content-group"><span class="text-muted">Invoice To:</span>
                        <ul class="list-condensed list-unstyled">
                        <li> <?php echo $this->userInformation['name']?></li>
                        <li> <?php echo $this->userInformation['address']?></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-3 content-group"><span class="text-muted">Payment Details:</span>
                        <ul class="list-condensed list-unstyled invoice-payment-details">
                            <li><h5>Total Due: <span class="text-right text-semibold"></span></h5></li>
                            <?php
                            $sum = 0;
                            foreach ($this->cartInfo as $key=>$value){
                               $sum = $value['amount'] + $sum;
                            }
                            echo $sum;
                            ?>
                        <li></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-lg cke_show_border">
                    <thead>
                    <tr>
                        <th>Description</th>
                        <th class="col-sm-1">Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($this->cartInfo as $key=>$value){?>
                        <tr>
                            <td></td>
                            <td><?php echo  $value['comment']?></td>
                        </tr>
                  <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <input type="hidden" name="full_name" value="<?php echo $this->userInformation['name']?>"/>
        <input type="hidden" name="address" value="<?php echo $this->userInformation['address']?>"/>
        <input type="hidden" name="phone" value="<?php echo $this->userInformation['phone']?>"/>
        <input type="hidden" name="total_price" value="<?php echo $sum?>"/>
        <input type="hidden" name="order_date_time" value="<?php echo date("d-m-y h:m")?>"/>
        <input type="hidden" name="customerId" value="<?php echo $this->userInformation['id']?>"/>
    <button type="submit" class="btn bg-warning-400 btn-labeled legitRipple"><b><i
                    class="fa fa-plus"></i></b> Place Order</button>
    </form>