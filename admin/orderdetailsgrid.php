<?php include_once "employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($orderdetails_grid)) $orderdetails_grid = new corderdetails_grid();

// Page init
$orderdetails_grid->Page_Init();

// Page main
$orderdetails_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orderdetails_grid->Page_Render();
?>
<?php if ($orderdetails->Export == "") { ?>
<script type="text/javascript">

// Form object
var forderdetailsgrid = new ew_Form("forderdetailsgrid", "grid");
forderdetailsgrid.FormKeyCountName = '<?php echo $orderdetails_grid->FormKeyCountName ?>';

// Validate form
forderdetailsgrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_Quantity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orderdetails->Quantity->FldCaption(), $orderdetails->Quantity->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Quantity");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orderdetails->Quantity->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_MenuID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orderdetails->MenuID->FldCaption(), $orderdetails->MenuID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_SubMenu");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orderdetails->SubMenu->FldCaption(), $orderdetails->SubMenu->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orderdetails->Price->FldCaption(), $orderdetails->Price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orderdetails->Price->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
forderdetailsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Quantity", false)) return false;
	if (ew_ValueChanged(fobj, infix, "MenuID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "SubMenu", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Price", false)) return false;
	return true;
}

// Form_CustomValidate event
forderdetailsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
forderdetailsgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
forderdetailsgrid.Lists["x_MenuID"] = {"LinkField":"x_MenuID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":["x_SubMenu"],"FilterFields":[],"Options":[],"Template":"","LinkTable":"menus"};
forderdetailsgrid.Lists["x_MenuID"].Data = "<?php echo $orderdetails_grid->MenuID->LookupFilterQuery(FALSE, "grid") ?>";
forderdetailsgrid.Lists["x_SubMenu"] = {"LinkField":"x_SubMenuID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":["x_MenuID"],"ChildFields":[],"FilterFields":["x_MenuID"],"Options":[],"Template":"","LinkTable":"sub_menus"};
forderdetailsgrid.Lists["x_SubMenu"].Data = "<?php echo $orderdetails_grid->SubMenu->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($orderdetails->CurrentAction == "gridadd") {
	if ($orderdetails->CurrentMode == "copy") {
		$bSelectLimit = $orderdetails_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$orderdetails_grid->TotalRecs = $orderdetails->ListRecordCount();
			$orderdetails_grid->Recordset = $orderdetails_grid->LoadRecordset($orderdetails_grid->StartRec-1, $orderdetails_grid->DisplayRecs);
		} else {
			if ($orderdetails_grid->Recordset = $orderdetails_grid->LoadRecordset())
				$orderdetails_grid->TotalRecs = $orderdetails_grid->Recordset->RecordCount();
		}
		$orderdetails_grid->StartRec = 1;
		$orderdetails_grid->DisplayRecs = $orderdetails_grid->TotalRecs;
	} else {
		$orderdetails->CurrentFilter = "0=1";
		$orderdetails_grid->StartRec = 1;
		$orderdetails_grid->DisplayRecs = $orderdetails->GridAddRowCount;
	}
	$orderdetails_grid->TotalRecs = $orderdetails_grid->DisplayRecs;
	$orderdetails_grid->StopRec = $orderdetails_grid->DisplayRecs;
} else {
	$bSelectLimit = $orderdetails_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($orderdetails_grid->TotalRecs <= 0)
			$orderdetails_grid->TotalRecs = $orderdetails->ListRecordCount();
	} else {
		if (!$orderdetails_grid->Recordset && ($orderdetails_grid->Recordset = $orderdetails_grid->LoadRecordset()))
			$orderdetails_grid->TotalRecs = $orderdetails_grid->Recordset->RecordCount();
	}
	$orderdetails_grid->StartRec = 1;
	$orderdetails_grid->DisplayRecs = $orderdetails_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$orderdetails_grid->Recordset = $orderdetails_grid->LoadRecordset($orderdetails_grid->StartRec-1, $orderdetails_grid->DisplayRecs);

	// Set no record found message
	if ($orderdetails->CurrentAction == "" && $orderdetails_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$orderdetails_grid->setWarningMessage(ew_DeniedMsg());
		if ($orderdetails_grid->SearchWhere == "0=101")
			$orderdetails_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$orderdetails_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$orderdetails_grid->RenderOtherOptions();
?>
<?php $orderdetails_grid->ShowPageHeader(); ?>
<?php
$orderdetails_grid->ShowMessage();
?>
<?php if ($orderdetails_grid->TotalRecs > 0 || $orderdetails->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($orderdetails_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> orderdetails">
<div id="forderdetailsgrid" class="ewForm ewListForm form-inline">
<?php if ($orderdetails_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($orderdetails_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_orderdetails" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_orderdetailsgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$orderdetails_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$orderdetails_grid->RenderListOptions();

// Render list options (header, left)
$orderdetails_grid->ListOptions->Render("header", "left");
?>
<?php if ($orderdetails->Quantity->Visible) { // Quantity ?>
	<?php if ($orderdetails->SortUrl($orderdetails->Quantity) == "") { ?>
		<th data-name="Quantity" class="<?php echo $orderdetails->Quantity->HeaderCellClass() ?>"><div id="elh_orderdetails_Quantity" class="orderdetails_Quantity"><div class="ewTableHeaderCaption"><?php echo $orderdetails->Quantity->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Quantity" class="<?php echo $orderdetails->Quantity->HeaderCellClass() ?>"><div><div id="elh_orderdetails_Quantity" class="orderdetails_Quantity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orderdetails->Quantity->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orderdetails->Quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orderdetails->Quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orderdetails->MenuID->Visible) { // MenuID ?>
	<?php if ($orderdetails->SortUrl($orderdetails->MenuID) == "") { ?>
		<th data-name="MenuID" class="<?php echo $orderdetails->MenuID->HeaderCellClass() ?>"><div id="elh_orderdetails_MenuID" class="orderdetails_MenuID"><div class="ewTableHeaderCaption"><?php echo $orderdetails->MenuID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MenuID" class="<?php echo $orderdetails->MenuID->HeaderCellClass() ?>"><div><div id="elh_orderdetails_MenuID" class="orderdetails_MenuID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orderdetails->MenuID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orderdetails->MenuID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orderdetails->MenuID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orderdetails->SubMenu->Visible) { // SubMenu ?>
	<?php if ($orderdetails->SortUrl($orderdetails->SubMenu) == "") { ?>
		<th data-name="SubMenu" class="<?php echo $orderdetails->SubMenu->HeaderCellClass() ?>"><div id="elh_orderdetails_SubMenu" class="orderdetails_SubMenu"><div class="ewTableHeaderCaption"><?php echo $orderdetails->SubMenu->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="SubMenu" class="<?php echo $orderdetails->SubMenu->HeaderCellClass() ?>"><div><div id="elh_orderdetails_SubMenu" class="orderdetails_SubMenu">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orderdetails->SubMenu->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orderdetails->SubMenu->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orderdetails->SubMenu->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orderdetails->Price->Visible) { // Price ?>
	<?php if ($orderdetails->SortUrl($orderdetails->Price) == "") { ?>
		<th data-name="Price" class="<?php echo $orderdetails->Price->HeaderCellClass() ?>"><div id="elh_orderdetails_Price" class="orderdetails_Price"><div class="ewTableHeaderCaption"><?php echo $orderdetails->Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Price" class="<?php echo $orderdetails->Price->HeaderCellClass() ?>"><div><div id="elh_orderdetails_Price" class="orderdetails_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orderdetails->Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orderdetails->Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orderdetails->Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$orderdetails_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$orderdetails_grid->StartRec = 1;
$orderdetails_grid->StopRec = $orderdetails_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($orderdetails_grid->FormKeyCountName) && ($orderdetails->CurrentAction == "gridadd" || $orderdetails->CurrentAction == "gridedit" || $orderdetails->CurrentAction == "F")) {
		$orderdetails_grid->KeyCount = $objForm->GetValue($orderdetails_grid->FormKeyCountName);
		$orderdetails_grid->StopRec = $orderdetails_grid->StartRec + $orderdetails_grid->KeyCount - 1;
	}
}
$orderdetails_grid->RecCnt = $orderdetails_grid->StartRec - 1;
if ($orderdetails_grid->Recordset && !$orderdetails_grid->Recordset->EOF) {
	$orderdetails_grid->Recordset->MoveFirst();
	$bSelectLimit = $orderdetails_grid->UseSelectLimit;
	if (!$bSelectLimit && $orderdetails_grid->StartRec > 1)
		$orderdetails_grid->Recordset->Move($orderdetails_grid->StartRec - 1);
} elseif (!$orderdetails->AllowAddDeleteRow && $orderdetails_grid->StopRec == 0) {
	$orderdetails_grid->StopRec = $orderdetails->GridAddRowCount;
}

// Initialize aggregate
$orderdetails->RowType = EW_ROWTYPE_AGGREGATEINIT;
$orderdetails->ResetAttrs();
$orderdetails_grid->RenderRow();
if ($orderdetails->CurrentAction == "gridadd")
	$orderdetails_grid->RowIndex = 0;
if ($orderdetails->CurrentAction == "gridedit")
	$orderdetails_grid->RowIndex = 0;
while ($orderdetails_grid->RecCnt < $orderdetails_grid->StopRec) {
	$orderdetails_grid->RecCnt++;
	if (intval($orderdetails_grid->RecCnt) >= intval($orderdetails_grid->StartRec)) {
		$orderdetails_grid->RowCnt++;
		if ($orderdetails->CurrentAction == "gridadd" || $orderdetails->CurrentAction == "gridedit" || $orderdetails->CurrentAction == "F") {
			$orderdetails_grid->RowIndex++;
			$objForm->Index = $orderdetails_grid->RowIndex;
			if ($objForm->HasValue($orderdetails_grid->FormActionName))
				$orderdetails_grid->RowAction = strval($objForm->GetValue($orderdetails_grid->FormActionName));
			elseif ($orderdetails->CurrentAction == "gridadd")
				$orderdetails_grid->RowAction = "insert";
			else
				$orderdetails_grid->RowAction = "";
		}

		// Set up key count
		$orderdetails_grid->KeyCount = $orderdetails_grid->RowIndex;

		// Init row class and style
		$orderdetails->ResetAttrs();
		$orderdetails->CssClass = "";
		if ($orderdetails->CurrentAction == "gridadd") {
			if ($orderdetails->CurrentMode == "copy") {
				$orderdetails_grid->LoadRowValues($orderdetails_grid->Recordset); // Load row values
				$orderdetails_grid->SetRecordKey($orderdetails_grid->RowOldKey, $orderdetails_grid->Recordset); // Set old record key
			} else {
				$orderdetails_grid->LoadRowValues(); // Load default values
				$orderdetails_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$orderdetails_grid->LoadRowValues($orderdetails_grid->Recordset); // Load row values
		}
		$orderdetails->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($orderdetails->CurrentAction == "gridadd") // Grid add
			$orderdetails->RowType = EW_ROWTYPE_ADD; // Render add
		if ($orderdetails->CurrentAction == "gridadd" && $orderdetails->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$orderdetails_grid->RestoreCurrentRowFormValues($orderdetails_grid->RowIndex); // Restore form values
		if ($orderdetails->CurrentAction == "gridedit") { // Grid edit
			if ($orderdetails->EventCancelled) {
				$orderdetails_grid->RestoreCurrentRowFormValues($orderdetails_grid->RowIndex); // Restore form values
			}
			if ($orderdetails_grid->RowAction == "insert")
				$orderdetails->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$orderdetails->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($orderdetails->CurrentAction == "gridedit" && ($orderdetails->RowType == EW_ROWTYPE_EDIT || $orderdetails->RowType == EW_ROWTYPE_ADD) && $orderdetails->EventCancelled) // Update failed
			$orderdetails_grid->RestoreCurrentRowFormValues($orderdetails_grid->RowIndex); // Restore form values
		if ($orderdetails->RowType == EW_ROWTYPE_EDIT) // Edit row
			$orderdetails_grid->EditRowCnt++;
		if ($orderdetails->CurrentAction == "F") // Confirm row
			$orderdetails_grid->RestoreCurrentRowFormValues($orderdetails_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$orderdetails->RowAttrs = array_merge($orderdetails->RowAttrs, array('data-rowindex'=>$orderdetails_grid->RowCnt, 'id'=>'r' . $orderdetails_grid->RowCnt . '_orderdetails', 'data-rowtype'=>$orderdetails->RowType));

		// Render row
		$orderdetails_grid->RenderRow();

		// Render list options
		$orderdetails_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($orderdetails_grid->RowAction <> "delete" && $orderdetails_grid->RowAction <> "insertdelete" && !($orderdetails_grid->RowAction == "insert" && $orderdetails->CurrentAction == "F" && $orderdetails_grid->EmptyRow())) {
?>
	<tr<?php echo $orderdetails->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orderdetails_grid->ListOptions->Render("body", "left", $orderdetails_grid->RowCnt);
?>
	<?php if ($orderdetails->Quantity->Visible) { // Quantity ?>
		<td data-name="Quantity"<?php echo $orderdetails->Quantity->CellAttributes() ?>>
<?php if ($orderdetails->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_Quantity" class="form-group orderdetails_Quantity">
<input type="text" data-table="orderdetails" data-field="x_Quantity" name="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($orderdetails->Quantity->getPlaceHolder()) ?>" value="<?php echo $orderdetails->Quantity->EditValue ?>"<?php echo $orderdetails->Quantity->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->OldValue) ?>">
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_Quantity" class="form-group orderdetails_Quantity">
<input type="text" data-table="orderdetails" data-field="x_Quantity" name="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($orderdetails->Quantity->getPlaceHolder()) ?>" value="<?php echo $orderdetails->Quantity->EditValue ?>"<?php echo $orderdetails->Quantity->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_Quantity" class="orderdetails_Quantity">
<span<?php echo $orderdetails->Quantity->ViewAttributes() ?>>
<?php echo $orderdetails->Quantity->ListViewValue() ?></span>
</span>
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="orderdetails" data-field="x_OrderDetailID" name="x<?php echo $orderdetails_grid->RowIndex ?>_OrderDetailID" id="x<?php echo $orderdetails_grid->RowIndex ?>_OrderDetailID" value="<?php echo ew_HtmlEncode($orderdetails->OrderDetailID->CurrentValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_OrderDetailID" name="o<?php echo $orderdetails_grid->RowIndex ?>_OrderDetailID" id="o<?php echo $orderdetails_grid->RowIndex ?>_OrderDetailID" value="<?php echo ew_HtmlEncode($orderdetails->OrderDetailID->OldValue) ?>">
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_EDIT || $orderdetails->CurrentMode == "edit") { ?>
<input type="hidden" data-table="orderdetails" data-field="x_OrderDetailID" name="x<?php echo $orderdetails_grid->RowIndex ?>_OrderDetailID" id="x<?php echo $orderdetails_grid->RowIndex ?>_OrderDetailID" value="<?php echo ew_HtmlEncode($orderdetails->OrderDetailID->CurrentValue) ?>">
<?php } ?>
	<?php if ($orderdetails->MenuID->Visible) { // MenuID ?>
		<td data-name="MenuID"<?php echo $orderdetails->MenuID->CellAttributes() ?>>
<?php if ($orderdetails->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_MenuID" class="form-group orderdetails_MenuID">
<?php $orderdetails->MenuID->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$orderdetails->MenuID->EditAttrs["onchange"]; ?>
<select data-table="orderdetails" data-field="x_MenuID" data-value-separator="<?php echo $orderdetails->MenuID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" name="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID"<?php echo $orderdetails->MenuID->EditAttributes() ?>>
<?php echo $orderdetails->MenuID->SelectOptionListHtml("x<?php echo $orderdetails_grid->RowIndex ?>_MenuID") ?>
</select>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->OldValue) ?>">
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_MenuID" class="form-group orderdetails_MenuID">
<?php $orderdetails->MenuID->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$orderdetails->MenuID->EditAttrs["onchange"]; ?>
<select data-table="orderdetails" data-field="x_MenuID" data-value-separator="<?php echo $orderdetails->MenuID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" name="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID"<?php echo $orderdetails->MenuID->EditAttributes() ?>>
<?php echo $orderdetails->MenuID->SelectOptionListHtml("x<?php echo $orderdetails_grid->RowIndex ?>_MenuID") ?>
</select>
</span>
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_MenuID" class="orderdetails_MenuID">
<span<?php echo $orderdetails->MenuID->ViewAttributes() ?>>
<?php echo $orderdetails->MenuID->ListViewValue() ?></span>
</span>
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orderdetails->SubMenu->Visible) { // SubMenu ?>
		<td data-name="SubMenu"<?php echo $orderdetails->SubMenu->CellAttributes() ?>>
<?php if ($orderdetails->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_SubMenu" class="form-group orderdetails_SubMenu">
<select data-table="orderdetails" data-field="x_SubMenu" data-value-separator="<?php echo $orderdetails->SubMenu->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" name="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu"<?php echo $orderdetails->SubMenu->EditAttributes() ?>>
<?php echo $orderdetails->SubMenu->SelectOptionListHtml("x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu") ?>
</select>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->OldValue) ?>">
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_SubMenu" class="form-group orderdetails_SubMenu">
<select data-table="orderdetails" data-field="x_SubMenu" data-value-separator="<?php echo $orderdetails->SubMenu->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" name="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu"<?php echo $orderdetails->SubMenu->EditAttributes() ?>>
<?php echo $orderdetails->SubMenu->SelectOptionListHtml("x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu") ?>
</select>
</span>
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_SubMenu" class="orderdetails_SubMenu">
<span<?php echo $orderdetails->SubMenu->ViewAttributes() ?>>
<?php echo $orderdetails->SubMenu->ListViewValue() ?></span>
</span>
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($orderdetails->Price->Visible) { // Price ?>
		<td data-name="Price"<?php echo $orderdetails->Price->CellAttributes() ?>>
<?php if ($orderdetails->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_Price" class="form-group orderdetails_Price">
<input type="text" data-table="orderdetails" data-field="x_Price" name="x<?php echo $orderdetails_grid->RowIndex ?>_Price" id="x<?php echo $orderdetails_grid->RowIndex ?>_Price" size="30" placeholder="<?php echo ew_HtmlEncode($orderdetails->Price->getPlaceHolder()) ?>" value="<?php echo $orderdetails->Price->EditValue ?>"<?php echo $orderdetails->Price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="o<?php echo $orderdetails_grid->RowIndex ?>_Price" id="o<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->OldValue) ?>">
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_Price" class="form-group orderdetails_Price">
<input type="text" data-table="orderdetails" data-field="x_Price" name="x<?php echo $orderdetails_grid->RowIndex ?>_Price" id="x<?php echo $orderdetails_grid->RowIndex ?>_Price" size="30" placeholder="<?php echo ew_HtmlEncode($orderdetails->Price->getPlaceHolder()) ?>" value="<?php echo $orderdetails->Price->EditValue ?>"<?php echo $orderdetails->Price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($orderdetails->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $orderdetails_grid->RowCnt ?>_orderdetails_Price" class="orderdetails_Price">
<span<?php echo $orderdetails->Price->ViewAttributes() ?>>
<?php echo $orderdetails->Price->ListViewValue() ?></span>
</span>
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="x<?php echo $orderdetails_grid->RowIndex ?>_Price" id="x<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="o<?php echo $orderdetails_grid->RowIndex ?>_Price" id="o<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_Price" id="forderdetailsgrid$x<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->FormValue) ?>">
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_Price" id="forderdetailsgrid$o<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orderdetails_grid->ListOptions->Render("body", "right", $orderdetails_grid->RowCnt);
?>
	</tr>
<?php if ($orderdetails->RowType == EW_ROWTYPE_ADD || $orderdetails->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
forderdetailsgrid.UpdateOpts(<?php echo $orderdetails_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($orderdetails->CurrentAction <> "gridadd" || $orderdetails->CurrentMode == "copy")
		if (!$orderdetails_grid->Recordset->EOF) $orderdetails_grid->Recordset->MoveNext();
}
?>
<?php
	if ($orderdetails->CurrentMode == "add" || $orderdetails->CurrentMode == "copy" || $orderdetails->CurrentMode == "edit") {
		$orderdetails_grid->RowIndex = '$rowindex$';
		$orderdetails_grid->LoadRowValues();

		// Set row properties
		$orderdetails->ResetAttrs();
		$orderdetails->RowAttrs = array_merge($orderdetails->RowAttrs, array('data-rowindex'=>$orderdetails_grid->RowIndex, 'id'=>'r0_orderdetails', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($orderdetails->RowAttrs["class"], "ewTemplate");
		$orderdetails->RowType = EW_ROWTYPE_ADD;

		// Render row
		$orderdetails_grid->RenderRow();

		// Render list options
		$orderdetails_grid->RenderListOptions();
		$orderdetails_grid->StartRowCnt = 0;
?>
	<tr<?php echo $orderdetails->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orderdetails_grid->ListOptions->Render("body", "left", $orderdetails_grid->RowIndex);
?>
	<?php if ($orderdetails->Quantity->Visible) { // Quantity ?>
		<td data-name="Quantity">
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orderdetails_Quantity" class="form-group orderdetails_Quantity">
<input type="text" data-table="orderdetails" data-field="x_Quantity" name="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" size="30" placeholder="<?php echo ew_HtmlEncode($orderdetails->Quantity->getPlaceHolder()) ?>" value="<?php echo $orderdetails->Quantity->EditValue ?>"<?php echo $orderdetails->Quantity->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orderdetails_Quantity" class="form-group orderdetails_Quantity">
<span<?php echo $orderdetails->Quantity->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orderdetails->Quantity->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="x<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orderdetails" data-field="x_Quantity" name="o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" id="o<?php echo $orderdetails_grid->RowIndex ?>_Quantity" value="<?php echo ew_HtmlEncode($orderdetails->Quantity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orderdetails->MenuID->Visible) { // MenuID ?>
		<td data-name="MenuID">
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orderdetails_MenuID" class="form-group orderdetails_MenuID">
<?php $orderdetails->MenuID->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$orderdetails->MenuID->EditAttrs["onchange"]; ?>
<select data-table="orderdetails" data-field="x_MenuID" data-value-separator="<?php echo $orderdetails->MenuID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" name="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID"<?php echo $orderdetails->MenuID->EditAttributes() ?>>
<?php echo $orderdetails->MenuID->SelectOptionListHtml("x<?php echo $orderdetails_grid->RowIndex ?>_MenuID") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orderdetails_MenuID" class="form-group orderdetails_MenuID">
<span<?php echo $orderdetails->MenuID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orderdetails->MenuID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="x<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orderdetails" data-field="x_MenuID" name="o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" id="o<?php echo $orderdetails_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($orderdetails->MenuID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orderdetails->SubMenu->Visible) { // SubMenu ?>
		<td data-name="SubMenu">
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orderdetails_SubMenu" class="form-group orderdetails_SubMenu">
<select data-table="orderdetails" data-field="x_SubMenu" data-value-separator="<?php echo $orderdetails->SubMenu->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" name="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu"<?php echo $orderdetails->SubMenu->EditAttributes() ?>>
<?php echo $orderdetails->SubMenu->SelectOptionListHtml("x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_orderdetails_SubMenu" class="form-group orderdetails_SubMenu">
<span<?php echo $orderdetails->SubMenu->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orderdetails->SubMenu->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="x<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orderdetails" data-field="x_SubMenu" name="o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" id="o<?php echo $orderdetails_grid->RowIndex ?>_SubMenu" value="<?php echo ew_HtmlEncode($orderdetails->SubMenu->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($orderdetails->Price->Visible) { // Price ?>
		<td data-name="Price">
<?php if ($orderdetails->CurrentAction <> "F") { ?>
<span id="el$rowindex$_orderdetails_Price" class="form-group orderdetails_Price">
<input type="text" data-table="orderdetails" data-field="x_Price" name="x<?php echo $orderdetails_grid->RowIndex ?>_Price" id="x<?php echo $orderdetails_grid->RowIndex ?>_Price" size="30" placeholder="<?php echo ew_HtmlEncode($orderdetails->Price->getPlaceHolder()) ?>" value="<?php echo $orderdetails->Price->EditValue ?>"<?php echo $orderdetails->Price->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_orderdetails_Price" class="form-group orderdetails_Price">
<span<?php echo $orderdetails->Price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orderdetails->Price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="x<?php echo $orderdetails_grid->RowIndex ?>_Price" id="x<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="orderdetails" data-field="x_Price" name="o<?php echo $orderdetails_grid->RowIndex ?>_Price" id="o<?php echo $orderdetails_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($orderdetails->Price->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orderdetails_grid->ListOptions->Render("body", "right", $orderdetails_grid->RowIndex);
?>
<script type="text/javascript">
forderdetailsgrid.UpdateOpts(<?php echo $orderdetails_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($orderdetails->CurrentMode == "add" || $orderdetails->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $orderdetails_grid->FormKeyCountName ?>" id="<?php echo $orderdetails_grid->FormKeyCountName ?>" value="<?php echo $orderdetails_grid->KeyCount ?>">
<?php echo $orderdetails_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($orderdetails->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $orderdetails_grid->FormKeyCountName ?>" id="<?php echo $orderdetails_grid->FormKeyCountName ?>" value="<?php echo $orderdetails_grid->KeyCount ?>">
<?php echo $orderdetails_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($orderdetails->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="forderdetailsgrid">
</div>
<?php

// Close recordset
if ($orderdetails_grid->Recordset)
	$orderdetails_grid->Recordset->Close();
?>
<?php if ($orderdetails_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($orderdetails_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($orderdetails_grid->TotalRecs == 0 && $orderdetails->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orderdetails_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($orderdetails->Export == "") { ?>
<script type="text/javascript">
forderdetailsgrid.Init();
</script>
<?php } ?>
<?php
$orderdetails_grid->Page_Terminate();
?>
