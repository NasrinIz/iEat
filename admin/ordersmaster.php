<?php

// order_id
// customer_id
// full_name
// province_id
// zip_code
// phone
// discount
// total_price
// payment_type_id
// delivery_type_id
// order_date_time

?>
<?php if ($orders->Visible) { ?>
<div id="t_orders" class="box<?php if (ew_IsResponsiveLayout()) echo " table-responsive"; ?> ewGrid ewListForm  ewMasterDiv">
<table id="tbl_ordersmaster" class="table ewTable ewMasterTable ewHorizontal">
	<thead>
		<tr class="ewTableHeader">
<?php if ($orders->order_id->Visible) { // order_id ?>
			<th class="<?php echo $orders->order_id->HeaderCellClass() ?>"><?php echo $orders->order_id->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->customer_id->Visible) { // customer_id ?>
			<th class="<?php echo $orders->customer_id->HeaderCellClass() ?>"><?php echo $orders->customer_id->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->full_name->Visible) { // full_name ?>
			<th class="<?php echo $orders->full_name->HeaderCellClass() ?>"><?php echo $orders->full_name->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->province_id->Visible) { // province_id ?>
			<th class="<?php echo $orders->province_id->HeaderCellClass() ?>"><?php echo $orders->province_id->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->zip_code->Visible) { // zip_code ?>
			<th class="<?php echo $orders->zip_code->HeaderCellClass() ?>"><?php echo $orders->zip_code->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->phone->Visible) { // phone ?>
			<th class="<?php echo $orders->phone->HeaderCellClass() ?>"><?php echo $orders->phone->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->discount->Visible) { // discount ?>
			<th class="<?php echo $orders->discount->HeaderCellClass() ?>"><?php echo $orders->discount->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->total_price->Visible) { // total_price ?>
			<th class="<?php echo $orders->total_price->HeaderCellClass() ?>"><?php echo $orders->total_price->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
			<th class="<?php echo $orders->payment_type_id->HeaderCellClass() ?>"><?php echo $orders->payment_type_id->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
			<th class="<?php echo $orders->delivery_type_id->HeaderCellClass() ?>"><?php echo $orders->delivery_type_id->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
			<th class="<?php echo $orders->order_date_time->HeaderCellClass() ?>"><?php echo $orders->order_date_time->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($orders->order_id->Visible) { // order_id ?>
			<td<?php echo $orders->order_id->CellAttributes() ?>>
<span id="el_orders_order_id">
<span<?php echo $orders->order_id->ViewAttributes() ?>>
<?php echo $orders->order_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->customer_id->Visible) { // customer_id ?>
			<td<?php echo $orders->customer_id->CellAttributes() ?>>
<span id="el_orders_customer_id">
<span<?php echo $orders->customer_id->ViewAttributes() ?>>
<?php echo $orders->customer_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->full_name->Visible) { // full_name ?>
			<td<?php echo $orders->full_name->CellAttributes() ?>>
<span id="el_orders_full_name">
<span<?php echo $orders->full_name->ViewAttributes() ?>>
<?php echo $orders->full_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->province_id->Visible) { // province_id ?>
			<td<?php echo $orders->province_id->CellAttributes() ?>>
<span id="el_orders_province_id">
<span<?php echo $orders->province_id->ViewAttributes() ?>>
<?php echo $orders->province_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->zip_code->Visible) { // zip_code ?>
			<td<?php echo $orders->zip_code->CellAttributes() ?>>
<span id="el_orders_zip_code">
<span<?php echo $orders->zip_code->ViewAttributes() ?>>
<?php echo $orders->zip_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->phone->Visible) { // phone ?>
			<td<?php echo $orders->phone->CellAttributes() ?>>
<span id="el_orders_phone">
<span<?php echo $orders->phone->ViewAttributes() ?>>
<?php echo $orders->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->discount->Visible) { // discount ?>
			<td<?php echo $orders->discount->CellAttributes() ?>>
<span id="el_orders_discount">
<span<?php echo $orders->discount->ViewAttributes() ?>>
<?php echo $orders->discount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->total_price->Visible) { // total_price ?>
			<td<?php echo $orders->total_price->CellAttributes() ?>>
<span id="el_orders_total_price">
<span<?php echo $orders->total_price->ViewAttributes() ?>>
<?php echo $orders->total_price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
			<td<?php echo $orders->payment_type_id->CellAttributes() ?>>
<span id="el_orders_payment_type_id">
<span<?php echo $orders->payment_type_id->ViewAttributes() ?>>
<?php echo $orders->payment_type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
			<td<?php echo $orders->delivery_type_id->CellAttributes() ?>>
<span id="el_orders_delivery_type_id">
<span<?php echo $orders->delivery_type_id->ViewAttributes() ?>>
<?php echo $orders->delivery_type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
			<td<?php echo $orders->order_date_time->CellAttributes() ?>>
<span id="el_orders_order_date_time">
<span<?php echo $orders->order_date_time->ViewAttributes() ?>>
<?php echo $orders->order_date_time->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
