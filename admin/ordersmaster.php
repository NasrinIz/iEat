<?php

// OrderID
// CustomerID
// FullName
// ProvinceID
// ZipCode
// Phone
// Discount
// TotalPrice
// PaymentTypeID
// DeliveryTypeID
// OrderDateTime

?>
<?php if ($orders->Visible) { ?>
<div id="t_orders" class="box<?php if (ew_IsResponsiveLayout()) echo " table-responsive"; ?> ewGrid ewListForm  ewMasterDiv">
<table id="tbl_ordersmaster" class="table ewTable ewMasterTable ewHorizontal">
	<thead>
		<tr class="ewTableHeader">
<?php if ($orders->OrderID->Visible) { // OrderID ?>
			<th class="<?php echo $orders->OrderID->HeaderCellClass() ?>"><?php echo $orders->OrderID->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
			<th class="<?php echo $orders->CustomerID->HeaderCellClass() ?>"><?php echo $orders->CustomerID->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->FullName->Visible) { // FullName ?>
			<th class="<?php echo $orders->FullName->HeaderCellClass() ?>"><?php echo $orders->FullName->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
			<th class="<?php echo $orders->ProvinceID->HeaderCellClass() ?>"><?php echo $orders->ProvinceID->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
			<th class="<?php echo $orders->ZipCode->HeaderCellClass() ?>"><?php echo $orders->ZipCode->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->Phone->Visible) { // Phone ?>
			<th class="<?php echo $orders->Phone->HeaderCellClass() ?>"><?php echo $orders->Phone->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->Discount->Visible) { // Discount ?>
			<th class="<?php echo $orders->Discount->HeaderCellClass() ?>"><?php echo $orders->Discount->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
			<th class="<?php echo $orders->TotalPrice->HeaderCellClass() ?>"><?php echo $orders->TotalPrice->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
			<th class="<?php echo $orders->PaymentTypeID->HeaderCellClass() ?>"><?php echo $orders->PaymentTypeID->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
			<th class="<?php echo $orders->DeliveryTypeID->HeaderCellClass() ?>"><?php echo $orders->DeliveryTypeID->FldCaption() ?></th>
<?php } ?>
<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
			<th class="<?php echo $orders->OrderDateTime->HeaderCellClass() ?>"><?php echo $orders->OrderDateTime->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($orders->OrderID->Visible) { // OrderID ?>
			<td<?php echo $orders->OrderID->CellAttributes() ?>>
<span id="el_orders_OrderID">
<span<?php echo $orders->OrderID->ViewAttributes() ?>>
<?php echo $orders->OrderID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
			<td<?php echo $orders->CustomerID->CellAttributes() ?>>
<span id="el_orders_CustomerID">
<span<?php echo $orders->CustomerID->ViewAttributes() ?>>
<?php echo $orders->CustomerID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->FullName->Visible) { // FullName ?>
			<td<?php echo $orders->FullName->CellAttributes() ?>>
<span id="el_orders_FullName">
<span<?php echo $orders->FullName->ViewAttributes() ?>>
<?php echo $orders->FullName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
			<td<?php echo $orders->ProvinceID->CellAttributes() ?>>
<span id="el_orders_ProvinceID">
<span<?php echo $orders->ProvinceID->ViewAttributes() ?>>
<?php echo $orders->ProvinceID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
			<td<?php echo $orders->ZipCode->CellAttributes() ?>>
<span id="el_orders_ZipCode">
<span<?php echo $orders->ZipCode->ViewAttributes() ?>>
<?php echo $orders->ZipCode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->Phone->Visible) { // Phone ?>
			<td<?php echo $orders->Phone->CellAttributes() ?>>
<span id="el_orders_Phone">
<span<?php echo $orders->Phone->ViewAttributes() ?>>
<?php echo $orders->Phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->Discount->Visible) { // Discount ?>
			<td<?php echo $orders->Discount->CellAttributes() ?>>
<span id="el_orders_Discount">
<span<?php echo $orders->Discount->ViewAttributes() ?>>
<?php echo $orders->Discount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
			<td<?php echo $orders->TotalPrice->CellAttributes() ?>>
<span id="el_orders_TotalPrice">
<span<?php echo $orders->TotalPrice->ViewAttributes() ?>>
<?php echo $orders->TotalPrice->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
			<td<?php echo $orders->PaymentTypeID->CellAttributes() ?>>
<span id="el_orders_PaymentTypeID">
<span<?php echo $orders->PaymentTypeID->ViewAttributes() ?>>
<?php echo $orders->PaymentTypeID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
			<td<?php echo $orders->DeliveryTypeID->CellAttributes() ?>>
<span id="el_orders_DeliveryTypeID">
<span<?php echo $orders->DeliveryTypeID->ViewAttributes() ?>>
<?php echo $orders->DeliveryTypeID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
			<td<?php echo $orders->OrderDateTime->CellAttributes() ?>>
<span id="el_orders_OrderDateTime">
<span<?php echo $orders->OrderDateTime->ViewAttributes() ?>>
<?php echo $orders->OrderDateTime->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
