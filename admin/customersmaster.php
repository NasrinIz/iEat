<?php

// full_name
// phone
// mobile
// reward
// user_name
// user_pass
// activity_status

?>
<?php if ($customers->Visible) { ?>
<div id="t_customers" class="box<?php if (ew_IsResponsiveLayout()) echo " table-responsive"; ?> ewGrid ewListForm  ewMasterDiv">
<table id="tbl_customersmaster" class="table ewTable ewMasterTable ewHorizontal">
	<thead>
		<tr class="ewTableHeader">
<?php if ($customers->full_name->Visible) { // full_name ?>
			<th class="<?php echo $customers->full_name->HeaderCellClass() ?>"><?php echo $customers->full_name->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->phone->Visible) { // phone ?>
			<th class="<?php echo $customers->phone->HeaderCellClass() ?>"><?php echo $customers->phone->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->mobile->Visible) { // mobile ?>
			<th class="<?php echo $customers->mobile->HeaderCellClass() ?>"><?php echo $customers->mobile->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->reward->Visible) { // reward ?>
			<th class="<?php echo $customers->reward->HeaderCellClass() ?>"><?php echo $customers->reward->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->user_name->Visible) { // user_name ?>
			<th class="<?php echo $customers->user_name->HeaderCellClass() ?>"><?php echo $customers->user_name->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->user_pass->Visible) { // user_pass ?>
			<th class="<?php echo $customers->user_pass->HeaderCellClass() ?>"><?php echo $customers->user_pass->FldCaption() ?></th>
<?php } ?>
<?php if ($customers->activity_status->Visible) { // activity_status ?>
			<th class="<?php echo $customers->activity_status->HeaderCellClass() ?>"><?php echo $customers->activity_status->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($customers->full_name->Visible) { // full_name ?>
			<td<?php echo $customers->full_name->CellAttributes() ?>>
<span id="el_customers_full_name">
<span<?php echo $customers->full_name->ViewAttributes() ?>>
<?php echo $customers->full_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->phone->Visible) { // phone ?>
			<td<?php echo $customers->phone->CellAttributes() ?>>
<span id="el_customers_phone">
<span<?php echo $customers->phone->ViewAttributes() ?>>
<?php echo $customers->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->mobile->Visible) { // mobile ?>
			<td<?php echo $customers->mobile->CellAttributes() ?>>
<span id="el_customers_mobile">
<span<?php echo $customers->mobile->ViewAttributes() ?>>
<?php echo $customers->mobile->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->reward->Visible) { // reward ?>
			<td<?php echo $customers->reward->CellAttributes() ?>>
<span id="el_customers_reward">
<span<?php echo $customers->reward->ViewAttributes() ?>>
<?php echo $customers->reward->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->user_name->Visible) { // user_name ?>
			<td<?php echo $customers->user_name->CellAttributes() ?>>
<span id="el_customers_user_name">
<span<?php echo $customers->user_name->ViewAttributes() ?>>
<?php echo $customers->user_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->user_pass->Visible) { // user_pass ?>
			<td<?php echo $customers->user_pass->CellAttributes() ?>>
<span id="el_customers_user_pass">
<span<?php echo $customers->user_pass->ViewAttributes() ?>>
<?php echo $customers->user_pass->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($customers->activity_status->Visible) { // activity_status ?>
			<td<?php echo $customers->activity_status->CellAttributes() ?>>
<span id="el_customers_activity_status">
<span<?php echo $customers->activity_status->ViewAttributes() ?>>
<?php echo $customers->activity_status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
