<?php include_once "employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($order_details_grid)) $order_details_grid = new corder_details_grid();

// Page init
$order_details_grid->Page_Init();

// Page main
$order_details_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$order_details_grid->Page_Render();
?>
<?php if ($order_details->Export == "") { ?>
<script type="text/javascript">

// Form object
var forder_detailsgrid = new ew_Form("forder_detailsgrid", "grid");
forder_detailsgrid.FormKeyCountName = '<?php echo $order_details_grid->FormKeyCountName ?>';

// Validate form
forder_detailsgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_quantity");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $order_details->quantity->FldCaption(), $order_details->quantity->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_quantity");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($order_details->quantity->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_menu_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $order_details->menu_id->FldCaption(), $order_details->menu_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_sub_menu_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $order_details->sub_menu_id->FldCaption(), $order_details->sub_menu_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $order_details->price->FldCaption(), $order_details->price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($order_details->price->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
forder_detailsgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "quantity", false)) return false;
	if (ew_ValueChanged(fobj, infix, "menu_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "sub_menu_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "price", false)) return false;
	return true;
}

// Form_CustomValidate event
forder_detailsgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
forder_detailsgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
forder_detailsgrid.Lists["x_menu_id"] = {"LinkField":"x_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"menus"};
forder_detailsgrid.Lists["x_menu_id"].Data = "<?php echo $order_details_grid->menu_id->LookupFilterQuery(FALSE, "grid") ?>";
forder_detailsgrid.Lists["x_sub_menu_id"] = {"LinkField":"x_sub_menu_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"sub_menus"};
forder_detailsgrid.Lists["x_sub_menu_id"].Data = "<?php echo $order_details_grid->sub_menu_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($order_details->CurrentAction == "gridadd") {
	if ($order_details->CurrentMode == "copy") {
		$bSelectLimit = $order_details_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$order_details_grid->TotalRecs = $order_details->ListRecordCount();
			$order_details_grid->Recordset = $order_details_grid->LoadRecordset($order_details_grid->StartRec-1, $order_details_grid->DisplayRecs);
		} else {
			if ($order_details_grid->Recordset = $order_details_grid->LoadRecordset())
				$order_details_grid->TotalRecs = $order_details_grid->Recordset->RecordCount();
		}
		$order_details_grid->StartRec = 1;
		$order_details_grid->DisplayRecs = $order_details_grid->TotalRecs;
	} else {
		$order_details->CurrentFilter = "0=1";
		$order_details_grid->StartRec = 1;
		$order_details_grid->DisplayRecs = $order_details->GridAddRowCount;
	}
	$order_details_grid->TotalRecs = $order_details_grid->DisplayRecs;
	$order_details_grid->StopRec = $order_details_grid->DisplayRecs;
} else {
	$bSelectLimit = $order_details_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($order_details_grid->TotalRecs <= 0)
			$order_details_grid->TotalRecs = $order_details->ListRecordCount();
	} else {
		if (!$order_details_grid->Recordset && ($order_details_grid->Recordset = $order_details_grid->LoadRecordset()))
			$order_details_grid->TotalRecs = $order_details_grid->Recordset->RecordCount();
	}
	$order_details_grid->StartRec = 1;
	$order_details_grid->DisplayRecs = $order_details_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$order_details_grid->Recordset = $order_details_grid->LoadRecordset($order_details_grid->StartRec-1, $order_details_grid->DisplayRecs);

	// Set no record found message
	if ($order_details->CurrentAction == "" && $order_details_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$order_details_grid->setWarningMessage(ew_DeniedMsg());
		if ($order_details_grid->SearchWhere == "0=101")
			$order_details_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$order_details_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$order_details_grid->RenderOtherOptions();
?>
<?php $order_details_grid->ShowPageHeader(); ?>
<?php
$order_details_grid->ShowMessage();
?>
<?php if ($order_details_grid->TotalRecs > 0 || $order_details->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($order_details_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> order_details">
<div id="forder_detailsgrid" class="ewForm ewListForm form-inline">
<?php if ($order_details_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($order_details_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_order_details" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_order_detailsgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$order_details_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$order_details_grid->RenderListOptions();

// Render list options (header, left)
$order_details_grid->ListOptions->Render("header", "left");
?>
<?php if ($order_details->quantity->Visible) { // quantity ?>
	<?php if ($order_details->SortUrl($order_details->quantity) == "") { ?>
		<th data-name="quantity" class="<?php echo $order_details->quantity->HeaderCellClass() ?>"><div id="elh_order_details_quantity" class="order_details_quantity"><div class="ewTableHeaderCaption"><?php echo $order_details->quantity->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="quantity" class="<?php echo $order_details->quantity->HeaderCellClass() ?>"><div><div id="elh_order_details_quantity" class="order_details_quantity">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $order_details->quantity->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($order_details->quantity->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($order_details->quantity->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($order_details->menu_id->Visible) { // menu_id ?>
	<?php if ($order_details->SortUrl($order_details->menu_id) == "") { ?>
		<th data-name="menu_id" class="<?php echo $order_details->menu_id->HeaderCellClass() ?>"><div id="elh_order_details_menu_id" class="order_details_menu_id"><div class="ewTableHeaderCaption"><?php echo $order_details->menu_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="menu_id" class="<?php echo $order_details->menu_id->HeaderCellClass() ?>"><div><div id="elh_order_details_menu_id" class="order_details_menu_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $order_details->menu_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($order_details->menu_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($order_details->menu_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($order_details->sub_menu_id->Visible) { // sub_menu_id ?>
	<?php if ($order_details->SortUrl($order_details->sub_menu_id) == "") { ?>
		<th data-name="sub_menu_id" class="<?php echo $order_details->sub_menu_id->HeaderCellClass() ?>"><div id="elh_order_details_sub_menu_id" class="order_details_sub_menu_id"><div class="ewTableHeaderCaption"><?php echo $order_details->sub_menu_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="sub_menu_id" class="<?php echo $order_details->sub_menu_id->HeaderCellClass() ?>"><div><div id="elh_order_details_sub_menu_id" class="order_details_sub_menu_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $order_details->sub_menu_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($order_details->sub_menu_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($order_details->sub_menu_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($order_details->price->Visible) { // price ?>
	<?php if ($order_details->SortUrl($order_details->price) == "") { ?>
		<th data-name="price" class="<?php echo $order_details->price->HeaderCellClass() ?>"><div id="elh_order_details_price" class="order_details_price"><div class="ewTableHeaderCaption"><?php echo $order_details->price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="price" class="<?php echo $order_details->price->HeaderCellClass() ?>"><div><div id="elh_order_details_price" class="order_details_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $order_details->price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($order_details->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($order_details->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$order_details_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$order_details_grid->StartRec = 1;
$order_details_grid->StopRec = $order_details_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($order_details_grid->FormKeyCountName) && ($order_details->CurrentAction == "gridadd" || $order_details->CurrentAction == "gridedit" || $order_details->CurrentAction == "F")) {
		$order_details_grid->KeyCount = $objForm->GetValue($order_details_grid->FormKeyCountName);
		$order_details_grid->StopRec = $order_details_grid->StartRec + $order_details_grid->KeyCount - 1;
	}
}
$order_details_grid->RecCnt = $order_details_grid->StartRec - 1;
if ($order_details_grid->Recordset && !$order_details_grid->Recordset->EOF) {
	$order_details_grid->Recordset->MoveFirst();
	$bSelectLimit = $order_details_grid->UseSelectLimit;
	if (!$bSelectLimit && $order_details_grid->StartRec > 1)
		$order_details_grid->Recordset->Move($order_details_grid->StartRec - 1);
} elseif (!$order_details->AllowAddDeleteRow && $order_details_grid->StopRec == 0) {
	$order_details_grid->StopRec = $order_details->GridAddRowCount;
}

// Initialize aggregate
$order_details->RowType = EW_ROWTYPE_AGGREGATEINIT;
$order_details->ResetAttrs();
$order_details_grid->RenderRow();
if ($order_details->CurrentAction == "gridadd")
	$order_details_grid->RowIndex = 0;
if ($order_details->CurrentAction == "gridedit")
	$order_details_grid->RowIndex = 0;
while ($order_details_grid->RecCnt < $order_details_grid->StopRec) {
	$order_details_grid->RecCnt++;
	if (intval($order_details_grid->RecCnt) >= intval($order_details_grid->StartRec)) {
		$order_details_grid->RowCnt++;
		if ($order_details->CurrentAction == "gridadd" || $order_details->CurrentAction == "gridedit" || $order_details->CurrentAction == "F") {
			$order_details_grid->RowIndex++;
			$objForm->Index = $order_details_grid->RowIndex;
			if ($objForm->HasValue($order_details_grid->FormActionName))
				$order_details_grid->RowAction = strval($objForm->GetValue($order_details_grid->FormActionName));
			elseif ($order_details->CurrentAction == "gridadd")
				$order_details_grid->RowAction = "insert";
			else
				$order_details_grid->RowAction = "";
		}

		// Set up key count
		$order_details_grid->KeyCount = $order_details_grid->RowIndex;

		// Init row class and style
		$order_details->ResetAttrs();
		$order_details->CssClass = "";
		if ($order_details->CurrentAction == "gridadd") {
			if ($order_details->CurrentMode == "copy") {
				$order_details_grid->LoadRowValues($order_details_grid->Recordset); // Load row values
				$order_details_grid->SetRecordKey($order_details_grid->RowOldKey, $order_details_grid->Recordset); // Set old record key
			} else {
				$order_details_grid->LoadRowValues(); // Load default values
				$order_details_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$order_details_grid->LoadRowValues($order_details_grid->Recordset); // Load row values
		}
		$order_details->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($order_details->CurrentAction == "gridadd") // Grid add
			$order_details->RowType = EW_ROWTYPE_ADD; // Render add
		if ($order_details->CurrentAction == "gridadd" && $order_details->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$order_details_grid->RestoreCurrentRowFormValues($order_details_grid->RowIndex); // Restore form values
		if ($order_details->CurrentAction == "gridedit") { // Grid edit
			if ($order_details->EventCancelled) {
				$order_details_grid->RestoreCurrentRowFormValues($order_details_grid->RowIndex); // Restore form values
			}
			if ($order_details_grid->RowAction == "insert")
				$order_details->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$order_details->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($order_details->CurrentAction == "gridedit" && ($order_details->RowType == EW_ROWTYPE_EDIT || $order_details->RowType == EW_ROWTYPE_ADD) && $order_details->EventCancelled) // Update failed
			$order_details_grid->RestoreCurrentRowFormValues($order_details_grid->RowIndex); // Restore form values
		if ($order_details->RowType == EW_ROWTYPE_EDIT) // Edit row
			$order_details_grid->EditRowCnt++;
		if ($order_details->CurrentAction == "F") // Confirm row
			$order_details_grid->RestoreCurrentRowFormValues($order_details_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$order_details->RowAttrs = array_merge($order_details->RowAttrs, array('data-rowindex'=>$order_details_grid->RowCnt, 'id'=>'r' . $order_details_grid->RowCnt . '_order_details', 'data-rowtype'=>$order_details->RowType));

		// Render row
		$order_details_grid->RenderRow();

		// Render list options
		$order_details_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($order_details_grid->RowAction <> "delete" && $order_details_grid->RowAction <> "insertdelete" && !($order_details_grid->RowAction == "insert" && $order_details->CurrentAction == "F" && $order_details_grid->EmptyRow())) {
?>
	<tr<?php echo $order_details->RowAttributes() ?>>
<?php

// Render list options (body, left)
$order_details_grid->ListOptions->Render("body", "left", $order_details_grid->RowCnt);
?>
	<?php if ($order_details->quantity->Visible) { // quantity ?>
		<td data-name="quantity"<?php echo $order_details->quantity->CellAttributes() ?>>
<?php if ($order_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_quantity" class="form-group order_details_quantity">
<input type="text" data-table="order_details" data-field="x_quantity" name="x<?php echo $order_details_grid->RowIndex ?>_quantity" id="x<?php echo $order_details_grid->RowIndex ?>_quantity" size="30" placeholder="<?php echo ew_HtmlEncode($order_details->quantity->getPlaceHolder()) ?>" value="<?php echo $order_details->quantity->EditValue ?>"<?php echo $order_details->quantity->EditAttributes() ?>>
</span>
<input type="hidden" data-table="order_details" data-field="x_quantity" name="o<?php echo $order_details_grid->RowIndex ?>_quantity" id="o<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->OldValue) ?>">
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_quantity" class="form-group order_details_quantity">
<input type="text" data-table="order_details" data-field="x_quantity" name="x<?php echo $order_details_grid->RowIndex ?>_quantity" id="x<?php echo $order_details_grid->RowIndex ?>_quantity" size="30" placeholder="<?php echo ew_HtmlEncode($order_details->quantity->getPlaceHolder()) ?>" value="<?php echo $order_details->quantity->EditValue ?>"<?php echo $order_details->quantity->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_quantity" class="order_details_quantity">
<span<?php echo $order_details->quantity->ViewAttributes() ?>>
<?php echo $order_details->quantity->ListViewValue() ?></span>
</span>
<?php if ($order_details->CurrentAction <> "F") { ?>
<input type="hidden" data-table="order_details" data-field="x_quantity" name="x<?php echo $order_details_grid->RowIndex ?>_quantity" id="x<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_quantity" name="o<?php echo $order_details_grid->RowIndex ?>_quantity" id="o<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="order_details" data-field="x_quantity" name="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_quantity" id="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_quantity" name="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_quantity" id="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="order_details" data-field="x_order_detail_id" name="x<?php echo $order_details_grid->RowIndex ?>_order_detail_id" id="x<?php echo $order_details_grid->RowIndex ?>_order_detail_id" value="<?php echo ew_HtmlEncode($order_details->order_detail_id->CurrentValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_order_detail_id" name="o<?php echo $order_details_grid->RowIndex ?>_order_detail_id" id="o<?php echo $order_details_grid->RowIndex ?>_order_detail_id" value="<?php echo ew_HtmlEncode($order_details->order_detail_id->OldValue) ?>">
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_EDIT || $order_details->CurrentMode == "edit") { ?>
<input type="hidden" data-table="order_details" data-field="x_order_detail_id" name="x<?php echo $order_details_grid->RowIndex ?>_order_detail_id" id="x<?php echo $order_details_grid->RowIndex ?>_order_detail_id" value="<?php echo ew_HtmlEncode($order_details->order_detail_id->CurrentValue) ?>">
<?php } ?>
	<?php if ($order_details->menu_id->Visible) { // menu_id ?>
		<td data-name="menu_id"<?php echo $order_details->menu_id->CellAttributes() ?>>
<?php if ($order_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_menu_id" class="form-group order_details_menu_id">
<select data-table="order_details" data-field="x_menu_id" data-value-separator="<?php echo $order_details->menu_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $order_details_grid->RowIndex ?>_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_menu_id"<?php echo $order_details->menu_id->EditAttributes() ?>>
<?php echo $order_details->menu_id->SelectOptionListHtml("x<?php echo $order_details_grid->RowIndex ?>_menu_id") ?>
</select>
</span>
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="o<?php echo $order_details_grid->RowIndex ?>_menu_id" id="o<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->OldValue) ?>">
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_menu_id" class="form-group order_details_menu_id">
<select data-table="order_details" data-field="x_menu_id" data-value-separator="<?php echo $order_details->menu_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $order_details_grid->RowIndex ?>_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_menu_id"<?php echo $order_details->menu_id->EditAttributes() ?>>
<?php echo $order_details->menu_id->SelectOptionListHtml("x<?php echo $order_details_grid->RowIndex ?>_menu_id") ?>
</select>
</span>
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_menu_id" class="order_details_menu_id">
<span<?php echo $order_details->menu_id->ViewAttributes() ?>>
<?php echo $order_details->menu_id->ListViewValue() ?></span>
</span>
<?php if ($order_details->CurrentAction <> "F") { ?>
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_menu_id" id="x<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="o<?php echo $order_details_grid->RowIndex ?>_menu_id" id="o<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_menu_id" id="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_menu_id" id="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($order_details->sub_menu_id->Visible) { // sub_menu_id ?>
		<td data-name="sub_menu_id"<?php echo $order_details->sub_menu_id->CellAttributes() ?>>
<?php if ($order_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_sub_menu_id" class="form-group order_details_sub_menu_id">
<select data-table="order_details" data-field="x_sub_menu_id" data-value-separator="<?php echo $order_details->sub_menu_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id"<?php echo $order_details->sub_menu_id->EditAttributes() ?>>
<?php echo $order_details->sub_menu_id->SelectOptionListHtml("x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id") ?>
</select>
</span>
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->OldValue) ?>">
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_sub_menu_id" class="form-group order_details_sub_menu_id">
<select data-table="order_details" data-field="x_sub_menu_id" data-value-separator="<?php echo $order_details->sub_menu_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id"<?php echo $order_details->sub_menu_id->EditAttributes() ?>>
<?php echo $order_details->sub_menu_id->SelectOptionListHtml("x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id") ?>
</select>
</span>
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_sub_menu_id" class="order_details_sub_menu_id">
<span<?php echo $order_details->sub_menu_id->ViewAttributes() ?>>
<?php echo $order_details->sub_menu_id->ListViewValue() ?></span>
</span>
<?php if ($order_details->CurrentAction <> "F") { ?>
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($order_details->price->Visible) { // price ?>
		<td data-name="price"<?php echo $order_details->price->CellAttributes() ?>>
<?php if ($order_details->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_price" class="form-group order_details_price">
<input type="text" data-table="order_details" data-field="x_price" name="x<?php echo $order_details_grid->RowIndex ?>_price" id="x<?php echo $order_details_grid->RowIndex ?>_price" size="30" placeholder="<?php echo ew_HtmlEncode($order_details->price->getPlaceHolder()) ?>" value="<?php echo $order_details->price->EditValue ?>"<?php echo $order_details->price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="order_details" data-field="x_price" name="o<?php echo $order_details_grid->RowIndex ?>_price" id="o<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->OldValue) ?>">
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_price" class="form-group order_details_price">
<input type="text" data-table="order_details" data-field="x_price" name="x<?php echo $order_details_grid->RowIndex ?>_price" id="x<?php echo $order_details_grid->RowIndex ?>_price" size="30" placeholder="<?php echo ew_HtmlEncode($order_details->price->getPlaceHolder()) ?>" value="<?php echo $order_details->price->EditValue ?>"<?php echo $order_details->price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($order_details->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $order_details_grid->RowCnt ?>_order_details_price" class="order_details_price">
<span<?php echo $order_details->price->ViewAttributes() ?>>
<?php echo $order_details->price->ListViewValue() ?></span>
</span>
<?php if ($order_details->CurrentAction <> "F") { ?>
<input type="hidden" data-table="order_details" data-field="x_price" name="x<?php echo $order_details_grid->RowIndex ?>_price" id="x<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_price" name="o<?php echo $order_details_grid->RowIndex ?>_price" id="o<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="order_details" data-field="x_price" name="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_price" id="forder_detailsgrid$x<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->FormValue) ?>">
<input type="hidden" data-table="order_details" data-field="x_price" name="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_price" id="forder_detailsgrid$o<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$order_details_grid->ListOptions->Render("body", "right", $order_details_grid->RowCnt);
?>
	</tr>
<?php if ($order_details->RowType == EW_ROWTYPE_ADD || $order_details->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
forder_detailsgrid.UpdateOpts(<?php echo $order_details_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($order_details->CurrentAction <> "gridadd" || $order_details->CurrentMode == "copy")
		if (!$order_details_grid->Recordset->EOF) $order_details_grid->Recordset->MoveNext();
}
?>
<?php
	if ($order_details->CurrentMode == "add" || $order_details->CurrentMode == "copy" || $order_details->CurrentMode == "edit") {
		$order_details_grid->RowIndex = '$rowindex$';
		$order_details_grid->LoadRowValues();

		// Set row properties
		$order_details->ResetAttrs();
		$order_details->RowAttrs = array_merge($order_details->RowAttrs, array('data-rowindex'=>$order_details_grid->RowIndex, 'id'=>'r0_order_details', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($order_details->RowAttrs["class"], "ewTemplate");
		$order_details->RowType = EW_ROWTYPE_ADD;

		// Render row
		$order_details_grid->RenderRow();

		// Render list options
		$order_details_grid->RenderListOptions();
		$order_details_grid->StartRowCnt = 0;
?>
	<tr<?php echo $order_details->RowAttributes() ?>>
<?php

// Render list options (body, left)
$order_details_grid->ListOptions->Render("body", "left", $order_details_grid->RowIndex);
?>
	<?php if ($order_details->quantity->Visible) { // quantity ?>
		<td data-name="quantity">
<?php if ($order_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_order_details_quantity" class="form-group order_details_quantity">
<input type="text" data-table="order_details" data-field="x_quantity" name="x<?php echo $order_details_grid->RowIndex ?>_quantity" id="x<?php echo $order_details_grid->RowIndex ?>_quantity" size="30" placeholder="<?php echo ew_HtmlEncode($order_details->quantity->getPlaceHolder()) ?>" value="<?php echo $order_details->quantity->EditValue ?>"<?php echo $order_details->quantity->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_quantity" class="form-group order_details_quantity">
<span<?php echo $order_details->quantity->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $order_details->quantity->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_quantity" name="x<?php echo $order_details_grid->RowIndex ?>_quantity" id="x<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_quantity" name="o<?php echo $order_details_grid->RowIndex ?>_quantity" id="o<?php echo $order_details_grid->RowIndex ?>_quantity" value="<?php echo ew_HtmlEncode($order_details->quantity->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($order_details->menu_id->Visible) { // menu_id ?>
		<td data-name="menu_id">
<?php if ($order_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_order_details_menu_id" class="form-group order_details_menu_id">
<select data-table="order_details" data-field="x_menu_id" data-value-separator="<?php echo $order_details->menu_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $order_details_grid->RowIndex ?>_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_menu_id"<?php echo $order_details->menu_id->EditAttributes() ?>>
<?php echo $order_details->menu_id->SelectOptionListHtml("x<?php echo $order_details_grid->RowIndex ?>_menu_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_menu_id" class="form-group order_details_menu_id">
<span<?php echo $order_details->menu_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $order_details->menu_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_menu_id" id="x<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_menu_id" name="o<?php echo $order_details_grid->RowIndex ?>_menu_id" id="o<?php echo $order_details_grid->RowIndex ?>_menu_id" value="<?php echo ew_HtmlEncode($order_details->menu_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($order_details->sub_menu_id->Visible) { // sub_menu_id ?>
		<td data-name="sub_menu_id">
<?php if ($order_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_order_details_sub_menu_id" class="form-group order_details_sub_menu_id">
<select data-table="order_details" data-field="x_sub_menu_id" data-value-separator="<?php echo $order_details->sub_menu_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id"<?php echo $order_details->sub_menu_id->EditAttributes() ?>>
<?php echo $order_details->sub_menu_id->SelectOptionListHtml("x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_sub_menu_id" class="form-group order_details_sub_menu_id">
<span<?php echo $order_details->sub_menu_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $order_details->sub_menu_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="x<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_sub_menu_id" name="o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" id="o<?php echo $order_details_grid->RowIndex ?>_sub_menu_id" value="<?php echo ew_HtmlEncode($order_details->sub_menu_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($order_details->price->Visible) { // price ?>
		<td data-name="price">
<?php if ($order_details->CurrentAction <> "F") { ?>
<span id="el$rowindex$_order_details_price" class="form-group order_details_price">
<input type="text" data-table="order_details" data-field="x_price" name="x<?php echo $order_details_grid->RowIndex ?>_price" id="x<?php echo $order_details_grid->RowIndex ?>_price" size="30" placeholder="<?php echo ew_HtmlEncode($order_details->price->getPlaceHolder()) ?>" value="<?php echo $order_details->price->EditValue ?>"<?php echo $order_details->price->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_order_details_price" class="form-group order_details_price">
<span<?php echo $order_details->price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $order_details->price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="order_details" data-field="x_price" name="x<?php echo $order_details_grid->RowIndex ?>_price" id="x<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="order_details" data-field="x_price" name="o<?php echo $order_details_grid->RowIndex ?>_price" id="o<?php echo $order_details_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($order_details->price->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$order_details_grid->ListOptions->Render("body", "right", $order_details_grid->RowIndex);
?>
<script type="text/javascript">
forder_detailsgrid.UpdateOpts(<?php echo $order_details_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($order_details->CurrentMode == "add" || $order_details->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $order_details_grid->FormKeyCountName ?>" id="<?php echo $order_details_grid->FormKeyCountName ?>" value="<?php echo $order_details_grid->KeyCount ?>">
<?php echo $order_details_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($order_details->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $order_details_grid->FormKeyCountName ?>" id="<?php echo $order_details_grid->FormKeyCountName ?>" value="<?php echo $order_details_grid->KeyCount ?>">
<?php echo $order_details_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($order_details->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="forder_detailsgrid">
</div>
<?php

// Close recordset
if ($order_details_grid->Recordset)
	$order_details_grid->Recordset->Close();
?>
<?php if ($order_details_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($order_details_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($order_details_grid->TotalRecs == 0 && $order_details->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($order_details_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($order_details->Export == "") { ?>
<script type="text/javascript">
forder_detailsgrid.Init();
</script>
<?php } ?>
<?php
$order_details_grid->Page_Terminate();
?>
