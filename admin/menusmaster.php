<?php

// Name
// Picture

?>
<?php if ($menus->Visible) { ?>
<div id="t_menus" class="box<?php if (ew_IsResponsiveLayout()) echo " table-responsive"; ?> ewGrid ewListForm  ewMasterDiv">
<table id="tbl_menusmaster" class="table ewTable ewMasterTable ewHorizontal">
	<thead>
		<tr class="ewTableHeader">
<?php if ($menus->Name->Visible) { // Name ?>
			<th class="<?php echo $menus->Name->HeaderCellClass() ?>"><?php echo $menus->Name->FldCaption() ?></th>
<?php } ?>
<?php if ($menus->Picture->Visible) { // Picture ?>
			<th class="<?php echo $menus->Picture->HeaderCellClass() ?>"><?php echo $menus->Picture->FldCaption() ?></th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php if ($menus->Name->Visible) { // Name ?>
			<td<?php echo $menus->Name->CellAttributes() ?>>
<span id="el_menus_Name">
<span<?php echo $menus->Name->ViewAttributes() ?>>
<?php echo $menus->Name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($menus->Picture->Visible) { // Picture ?>
			<td<?php echo $menus->Picture->CellAttributes() ?>>
<span id="el_menus_Picture">
<span>
<?php echo ew_GetFileViewTag($menus->Picture, $menus->Picture->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
		</tr>
	</tbody>
</table>
</div>
<?php } ?>
