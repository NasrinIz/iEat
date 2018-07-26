<?php

// FullName
// Phone
// Mobile
// Reward
// UserName
// UserPass
// ActivityStatus

?>
<?php if ($customers->Visible) { ?>
<div id="t_customers" class="box<?php if (ew_IsResponsiveLayout()) echo " table-responsive"; ?> ewGrid ewListForm  ewMasterDiv">
<table id="tbl_customersmaster" class="table ewTable ewMasterTable ewHorizontal">
	<thead>
		<tr class="ewTableHeader">
<?php if ($customers->FullName->Visible) { // FullName ?>
			<th class="<?php echo $customers->FullName->HeaderCellClass() ?>"><?php echo $customers->FullName->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->Phone->Visible) { // Phone ?>
			<th class="<?php echo $customers->Phone->HeaderCellClass() ?>"><?php echo $customers->Phone->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->Mobile->Visible) { // Mobile ?>
			<th class="<?php echo $customers->Mobile->HeaderCellClass() ?>"><?php echo $customers->Mobile->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->Reward->Visible) { // Reward ?>
			<th class="<?php echo $customers->Reward->HeaderCellClass() ?>"><?php echo $customers->Reward->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->UserName->Visible) { // UserName ?>
			<th class="<?php echo $customers->UserName->HeaderCellClass() ?>"><?php echo $customers->UserName->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->UserPass->Visible) { // UserPass ?>
			<th class="<?php echo $customers->UserPass->HeaderCellClass() ?>"><?php echo $customers->UserPass->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->ActivityStatus->Visible) { // ActivityStatus ?>
			<th class="<?php echo $customers->ActivityStatus->HeaderCellClass() ?>"><?php echo $customers->ActivityStatus->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($customers->FullName->Visible) { // FullName ?>
			<td<?php echo $customers->FullName->CellAttributes() ?>>
<span id="el_customers_FullName">
<span<?php echo $customers->FullName->ViewAttributes() ?>>
<?php echo $customers->FullName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->Phone->Visible) { // Phone ?>
			<td<?php echo $customers->Phone->CellAttributes() ?>>
<span id="el_customers_Phone">
<span<?php echo $customers->Phone->ViewAttributes() ?>>
<?php echo $customers->Phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->Mobile->Visible) { // Mobile ?>
			<td<?php echo $customers->Mobile->CellAttributes() ?>>
<span id="el_customers_Mobile">
<span<?php echo $customers->Mobile->ViewAttributes() ?>>
<?php echo $customers->Mobile->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->Reward->Visible) { // Reward ?>
			<td<?php echo $customers->Reward->CellAttributes() ?>>
<span id="el_customers_Reward">
<span<?php echo $customers->Reward->ViewAttributes() ?>>
<?php echo $customers->Reward->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->UserName->Visible) { // UserName ?>
			<td<?php echo $customers->UserName->CellAttributes() ?>>
<span id="el_customers_UserName">
<span<?php echo $customers->UserName->ViewAttributes() ?>>
<?php echo $customers->UserName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->UserPass->Visible) { // UserPass ?>
			<td<?php echo $customers->UserPass->CellAttributes() ?>>
<span id="el_customers_UserPass">
<span<?php echo $customers->UserPass->ViewAttributes() ?>>
<?php echo $customers->UserPass->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->ActivityStatus->Visible) { // ActivityStatus ?>
			<td<?php echo $customers->ActivityStatus->CellAttributes() ?>>
<span id="el_customers_ActivityStatus">
<span<?php echo $customers->ActivityStatus->ViewAttributes() ?>>
<?php echo $customers->ActivityStatus->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
