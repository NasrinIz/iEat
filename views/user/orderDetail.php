<div class="moreSpaceBackground">
    <div class="container-fluid">
        <!--MAIN CONTENT-->
        <div class="row">
            <div class="col-md-12 bg-color-ddd">
                <!-- HomePage -->
                <div><?php echo $this->notification ?></div>
                <div class="dashboard-content no-print custom-opacity">
                    <fieldset class="bg-white">
                        <table id="tableList" class="display table-responsive" style="width:100%">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Count</th>
                                <th>Amount</th>
                                <th>Comment</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->orderDetail as $key => $value) { ?>
                                <tr>
                                    <td>
                                        <?php echo $value['name'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['count'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['amount'] ?>
                                    </td>
                                    <td>
                                        <?php echo $value['comment'] ?>
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
    $('#tableList').DataTable({});
</script>