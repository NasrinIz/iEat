<?php include_once "employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($addresses_grid)) $addresses_grid = new caddresses_grid();

// Page init
$addresses_grid->Page_Init();

// Page main
$addresses_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$addresses_grid->Page_Render();
?>
<?php if ($addresses->Export == "") { ?>
<script type="text/javascript">

// Form object
var faddressesgrid = new ew_Form("faddressesgrid", "grid");
faddressesgrid.FormKeyCountName = '<?php echo $addresses_grid->FormKeyCountName ?>';

// Validate form
faddressesgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_CustomerID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $addresses->CustomerID->FldCaption(), $addresses->CustomerID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ProvinceID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $addresses->ProvinceID->FldCaption(), $addresses->ProvinceID->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
faddressesgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "CustomerID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "ProvinceID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "POBox", false)) return false;
	return true;
}

// Form_CustomValidate event
faddressesgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
faddressesgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
faddressesgrid.Lists["x_CustomerID"] = {"LinkField":"x_CustomerID","Ajax":true,"AutoFill":false,"DisplayFields":["x_FullName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
faddressesgrid.Lists["x_CustomerID"].Data = "<?php echo $addresses_grid->CustomerID->LookupFilterQuery(FALSE, "grid") ?>";
faddressesgrid.Lists["x_ProvinceID"] = {"LinkField":"x_ProvinceID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
faddressesgrid.Lists["x_ProvinceID"].Data = "<?php echo $addresses_grid->ProvinceID->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($addresses->CurrentAction == "gridadd") {
	if ($addresses->CurrentMode == "copy") {
		$bSelectLimit = $addresses_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$addresses_grid->TotalRecs = $addresses->ListRecordCount();
			$addresses_grid->Recordset = $addresses_grid->LoadRecordset($addresses_grid->StartRec-1, $addresses_grid->DisplayRecs);
		} else {
			if ($addresses_grid->Recordset = $addresses_grid->LoadRecordset())
				$addresses_grid->TotalRecs = $addresses_grid->Recordset->RecordCount();
		}
		$addresses_grid->StartRec = 1;
		$addresses_grid->DisplayRecs = $addresses_grid->TotalRecs;
	} else {
		$addresses->CurrentFilter = "0=1";
		$addresses_grid->StartRec = 1;
		$addresses_grid->DisplayRecs = $addresses->GridAddRowCount;
	}
	$addresses_grid->TotalRecs = $addresses_grid->DisplayRecs;
	$addresses_grid->StopRec = $addresses_grid->DisplayRecs;
} else {
	$bSelectLimit = $addresses_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($addresses_grid->TotalRecs <= 0)
			$addresses_grid->TotalRecs = $addresses->ListRecordCount();
	} else {
		if (!$addresses_grid->Recordset && ($addresses_grid->Recordset = $addresses_grid->LoadRecordset()))
			$addresses_grid->TotalRecs = $addresses_grid->Recordset->RecordCount();
	}
	$addresses_grid->StartRec = 1;
	$addresses_grid->DisplayRecs = $addresses_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$addresses_grid->Recordset = $addresses_grid->LoadRecordset($addresses_grid->StartRec-1, $addresses_grid->DisplayRecs);

	// Set no record found message
	if ($addresses->CurrentAction == "" && $addresses_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$addresses_grid->setWarningMessage(ew_DeniedMsg());
		if ($addresses_grid->SearchWhere == "0=101")
			$addresses_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$addresses_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$addresses_grid->RenderOtherOptions();
?>
<?php $addresses_grid->ShowPageHeader(); ?>
<?php
$addresses_grid->ShowMessage();
?>
<?php if ($addresses_grid->TotalRecs > 0 || $addresses->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($addresses_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> addresses">
<div id="faddressesgrid" class="ewForm ewListForm form-inline">
<?php if ($addresses_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($addresses_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_addresses" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_addressesgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$addresses_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$addresses_grid->RenderListOptions();

// Render list options (header, left)
$addresses_grid->ListOptions->Render("header", "left");
?>
<?php if ($addresses->CustomerID->Visible) { // CustomerID ?>
	<?php if ($addresses->SortUrl($addresses->CustomerID) == "") { ?>
		<th data-name="CustomerID" class="<?php echo $addresses->CustomerID->HeaderCellClass() ?>"><div id="elh_addresses_CustomerID" class="addresses_CustomerID"><div class="ewTableHeaderCaption"><?php echo $addresses->CustomerID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CustomerID" class="<?php echo $addresses->CustomerID->HeaderCellClass() ?>"><div><div id="elh_addresses_CustomerID" class="addresses_CustomerID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addresses->CustomerID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addresses->CustomerID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addresses->CustomerID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($addresses->ProvinceID->Visible) { // ProvinceID ?>
	<?php if ($addresses->SortUrl($addresses->ProvinceID) == "") { ?>
		<th data-name="ProvinceID" class="<?php echo $addresses->ProvinceID->HeaderCellClass() ?>"><div id="elh_addresses_ProvinceID" class="addresses_ProvinceID"><div class="ewTableHeaderCaption"><?php echo $addresses->ProvinceID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ProvinceID" class="<?php echo $addresses->ProvinceID->HeaderCellClass() ?>"><div><div id="elh_addresses_ProvinceID" class="addresses_ProvinceID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addresses->ProvinceID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addresses->ProvinceID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addresses->ProvinceID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($addresses->POBox->Visible) { // POBox ?>
	<?php if ($addresses->SortUrl($addresses->POBox) == "") { ?>
		<th data-name="POBox" class="<?php echo $addresses->POBox->HeaderCellClass() ?>"><div id="elh_addresses_POBox" class="addresses_POBox"><div class="ewTableHeaderCaption"><?php echo $addresses->POBox->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="POBox" class="<?php echo $addresses->POBox->HeaderCellClass() ?>"><div><div id="elh_addresses_POBox" class="addresses_POBox">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $addresses->POBox->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($addresses->POBox->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($addresses->POBox->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$addresses_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$addresses_grid->StartRec = 1;
$addresses_grid->StopRec = $addresses_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($addresses_grid->FormKeyCountName) && ($addresses->CurrentAction == "gridadd" || $addresses->CurrentAction == "gridedit" || $addresses->CurrentAction == "F")) {
		$addresses_grid->KeyCount = $objForm->GetValue($addresses_grid->FormKeyCountName);
		$addresses_grid->StopRec = $addresses_grid->StartRec + $addresses_grid->KeyCount - 1;
	}
}
$addresses_grid->RecCnt = $addresses_grid->StartRec - 1;
if ($addresses_grid->Recordset && !$addresses_grid->Recordset->EOF) {
	$addresses_grid->Recordset->MoveFirst();
	$bSelectLimit = $addresses_grid->UseSelectLimit;
	if (!$bSelectLimit && $addresses_grid->StartRec > 1)
		$addresses_grid->Recordset->Move($addresses_grid->StartRec - 1);
} elseif (!$addresses->AllowAddDeleteRow && $addresses_grid->StopRec == 0) {
	$addresses_grid->StopRec = $addresses->GridAddRowCount;
}

// Initialize aggregate
$addresses->RowType = EW_ROWTYPE_AGGREGATEINIT;
$addresses->ResetAttrs();
$addresses_grid->RenderRow();
if ($addresses->CurrentAction == "gridadd")
	$addresses_grid->RowIndex = 0;
if ($addresses->CurrentAction == "gridedit")
	$addresses_grid->RowIndex = 0;
while ($addresses_grid->RecCnt < $addresses_grid->StopRec) {
	$addresses_grid->RecCnt++;
	if (intval($addresses_grid->RecCnt) >= intval($addresses_grid->StartRec)) {
		$addresses_grid->RowCnt++;
		if ($addresses->CurrentAction == "gridadd" || $addresses->CurrentAction == "gridedit" || $addresses->CurrentAction == "F") {
			$addresses_grid->RowIndex++;
			$objForm->Index = $addresses_grid->RowIndex;
			if ($objForm->HasValue($addresses_grid->FormActionName))
				$addresses_grid->RowAction = strval($objForm->GetValue($addresses_grid->FormActionName));
			elseif ($addresses->CurrentAction == "gridadd")
				$addresses_grid->RowAction = "insert";
			else
				$addresses_grid->RowAction = "";
		}

		// Set up key count
		$addresses_grid->KeyCount = $addresses_grid->RowIndex;

		// Init row class and style
		$addresses->ResetAttrs();
		$addresses->CssClass = "";
		if ($addresses->CurrentAction == "gridadd") {
			if ($addresses->CurrentMode == "copy") {
				$addresses_grid->LoadRowValues($addresses_grid->Recordset); // Load row values
				$addresses_grid->SetRecordKey($addresses_grid->RowOldKey, $addresses_grid->Recordset); // Set old record key
			} else {
				$addresses_grid->LoadRowValues(); // Load default values
				$addresses_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$addresses_grid->LoadRowValues($addresses_grid->Recordset); // Load row values
		}
		$addresses->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($addresses->CurrentAction == "gridadd") // Grid add
			$addresses->RowType = EW_ROWTYPE_ADD; // Render add
		if ($addresses->CurrentAction == "gridadd" && $addresses->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$addresses_grid->RestoreCurrentRowFormValues($addresses_grid->RowIndex); // Restore form values
		if ($addresses->CurrentAction == "gridedit") { // Grid edit
			if ($addresses->EventCancelled) {
				$addresses_grid->RestoreCurrentRowFormValues($addresses_grid->RowIndex); // Restore form values
			}
			if ($addresses_grid->RowAction == "insert")
				$addresses->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$addresses->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($addresses->CurrentAction == "gridedit" && ($addresses->RowType == EW_ROWTYPE_EDIT || $addresses->RowType == EW_ROWTYPE_ADD) && $addresses->EventCancelled) // Update failed
			$addresses_grid->RestoreCurrentRowFormValues($addresses_grid->RowIndex); // Restore form values
		if ($addresses->RowType == EW_ROWTYPE_EDIT) // Edit row
			$addresses_grid->EditRowCnt++;
		if ($addresses->CurrentAction == "F") // Confirm row
			$addresses_grid->RestoreCurrentRowFormValues($addresses_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$addresses->RowAttrs = array_merge($addresses->RowAttrs, array('data-rowindex'=>$addresses_grid->RowCnt, 'id'=>'r' . $addresses_grid->RowCnt . '_addresses', 'data-rowtype'=>$addresses->RowType));

		// Render row
		$addresses_grid->RenderRow();

		// Render list options
		$addresses_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($addresses_grid->RowAction <> "delete" && $addresses_grid->RowAction <> "insertdelete" && !($addresses_grid->RowAction == "insert" && $addresses->CurrentAction == "F" && $addresses_grid->EmptyRow())) {
?>
	<tr<?php echo $addresses->RowAttributes() ?>>
<?php

// Render list options (body, left)
$addresses_grid->ListOptions->Render("body", "left", $addresses_grid->RowCnt);
?>
	<?php if ($addresses->CustomerID->Visible) { // CustomerID ?>
		<td data-name="CustomerID"<?php echo $addresses->CustomerID->CellAttributes() ?>>
<?php if ($addresses->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($addresses->CustomerID->getSessionValue() <> "") { ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_CustomerID" class="form-group addresses_CustomerID">
<span<?php echo $addresses->CustomerID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $addresses->CustomerID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_CustomerID" class="form-group addresses_CustomerID">
<select data-table="addresses" data-field="x_CustomerID" data-value-separator="<?php echo $addresses->CustomerID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID"<?php echo $addresses->CustomerID->EditAttributes() ?>>
<?php echo $addresses->CustomerID->SelectOptionListHtml("x<?php echo $addresses_grid->RowIndex ?>_CustomerID") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="o<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="o<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->OldValue) ?>">
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($addresses->CustomerID->getSessionValue() <> "") { ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_CustomerID" class="form-group addresses_CustomerID">
<span<?php echo $addresses->CustomerID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $addresses->CustomerID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_CustomerID" class="form-group addresses_CustomerID">
<select data-table="addresses" data-field="x_CustomerID" data-value-separator="<?php echo $addresses->CustomerID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID"<?php echo $addresses->CustomerID->EditAttributes() ?>>
<?php echo $addresses->CustomerID->SelectOptionListHtml("x<?php echo $addresses_grid->RowIndex ?>_CustomerID") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_CustomerID" class="addresses_CustomerID">
<span<?php echo $addresses->CustomerID->ViewAttributes() ?>>
<?php echo $addresses->CustomerID->ListViewValue() ?></span>
</span>
<?php if ($addresses->CurrentAction <> "F") { ?>
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->FormValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="o<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="o<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="faddressesgrid$x<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="faddressesgrid$x<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->FormValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="faddressesgrid$o<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="faddressesgrid$o<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="addresses" data-field="x_AddressID" name="x<?php echo $addresses_grid->RowIndex ?>_AddressID" id="x<?php echo $addresses_grid->RowIndex ?>_AddressID" value="<?php echo ew_HtmlEncode($addresses->AddressID->CurrentValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_AddressID" name="o<?php echo $addresses_grid->RowIndex ?>_AddressID" id="o<?php echo $addresses_grid->RowIndex ?>_AddressID" value="<?php echo ew_HtmlEncode($addresses->AddressID->OldValue) ?>">
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_EDIT || $addresses->CurrentMode == "edit") { ?>
<input type="hidden" data-table="addresses" data-field="x_AddressID" name="x<?php echo $addresses_grid->RowIndex ?>_AddressID" id="x<?php echo $addresses_grid->RowIndex ?>_AddressID" value="<?php echo ew_HtmlEncode($addresses->AddressID->CurrentValue) ?>">
<?php } ?>
	<?php if ($addresses->ProvinceID->Visible) { // ProvinceID ?>
		<td data-name="ProvinceID"<?php echo $addresses->ProvinceID->CellAttributes() ?>>
<?php if ($addresses->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_ProvinceID" class="form-group addresses_ProvinceID">
<select data-table="addresses" data-field="x_ProvinceID" data-value-separator="<?php echo $addresses->ProvinceID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" name="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID"<?php echo $addresses->ProvinceID->EditAttributes() ?>>
<?php echo $addresses->ProvinceID->SelectOptionListHtml("x<?php echo $addresses_grid->RowIndex ?>_ProvinceID") ?>
</select>
</span>
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->OldValue) ?>">
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_ProvinceID" class="form-group addresses_ProvinceID">
<select data-table="addresses" data-field="x_ProvinceID" data-value-separator="<?php echo $addresses->ProvinceID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" name="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID"<?php echo $addresses->ProvinceID->EditAttributes() ?>>
<?php echo $addresses->ProvinceID->SelectOptionListHtml("x<?php echo $addresses_grid->RowIndex ?>_ProvinceID") ?>
</select>
</span>
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_ProvinceID" class="addresses_ProvinceID">
<span<?php echo $addresses->ProvinceID->ViewAttributes() ?>>
<?php echo $addresses->ProvinceID->ListViewValue() ?></span>
</span>
<?php if ($addresses->CurrentAction <> "F") { ?>
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->FormValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="faddressesgrid$x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="faddressesgrid$x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->FormValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="faddressesgrid$o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="faddressesgrid$o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($addresses->POBox->Visible) { // POBox ?>
		<td data-name="POBox"<?php echo $addresses->POBox->CellAttributes() ?>>
<?php if ($addresses->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_POBox" class="form-group addresses_POBox">
<input type="text" data-table="addresses" data-field="x_POBox" name="x<?php echo $addresses_grid->RowIndex ?>_POBox" id="x<?php echo $addresses_grid->RowIndex ?>_POBox" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($addresses->POBox->getPlaceHolder()) ?>" value="<?php echo $addresses->POBox->EditValue ?>"<?php echo $addresses->POBox->EditAttributes() ?>>
</span>
<input type="hidden" data-table="addresses" data-field="x_POBox" name="o<?php echo $addresses_grid->RowIndex ?>_POBox" id="o<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->OldValue) ?>">
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_POBox" class="form-group addresses_POBox">
<input type="text" data-table="addresses" data-field="x_POBox" name="x<?php echo $addresses_grid->RowIndex ?>_POBox" id="x<?php echo $addresses_grid->RowIndex ?>_POBox" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($addresses->POBox->getPlaceHolder()) ?>" value="<?php echo $addresses->POBox->EditValue ?>"<?php echo $addresses->POBox->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($addresses->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $addresses_grid->RowCnt ?>_addresses_POBox" class="addresses_POBox">
<span<?php echo $addresses->POBox->ViewAttributes() ?>>
<?php echo $addresses->POBox->ListViewValue() ?></span>
</span>
<?php if ($addresses->CurrentAction <> "F") { ?>
<input type="hidden" data-table="addresses" data-field="x_POBox" name="x<?php echo $addresses_grid->RowIndex ?>_POBox" id="x<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->FormValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_POBox" name="o<?php echo $addresses_grid->RowIndex ?>_POBox" id="o<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="addresses" data-field="x_POBox" name="faddressesgrid$x<?php echo $addresses_grid->RowIndex ?>_POBox" id="faddressesgrid$x<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->FormValue) ?>">
<input type="hidden" data-table="addresses" data-field="x_POBox" name="faddressesgrid$o<?php echo $addresses_grid->RowIndex ?>_POBox" id="faddressesgrid$o<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$addresses_grid->ListOptions->Render("body", "right", $addresses_grid->RowCnt);
?>
	</tr>
<?php if ($addresses->RowType == EW_ROWTYPE_ADD || $addresses->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
faddressesgrid.UpdateOpts(<?php echo $addresses_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($addresses->CurrentAction <> "gridadd" || $addresses->CurrentMode == "copy")
		if (!$addresses_grid->Recordset->EOF) $addresses_grid->Recordset->MoveNext();
}
?>
<?php
	if ($addresses->CurrentMode == "add" || $addresses->CurrentMode == "copy" || $addresses->CurrentMode == "edit") {
		$addresses_grid->RowIndex = '$rowindex$';
		$addresses_grid->LoadRowValues();

		// Set row properties
		$addresses->ResetAttrs();
		$addresses->RowAttrs = array_merge($addresses->RowAttrs, array('data-rowindex'=>$addresses_grid->RowIndex, 'id'=>'r0_addresses', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($addresses->RowAttrs["class"], "ewTemplate");
		$addresses->RowType = EW_ROWTYPE_ADD;

		// Render row
		$addresses_grid->RenderRow();

		// Render list options
		$addresses_grid->RenderListOptions();
		$addresses_grid->StartRowCnt = 0;
?>
	<tr<?php echo $addresses->RowAttributes() ?>>
<?php

// Render list options (body, left)
$addresses_grid->ListOptions->Render("body", "left", $addresses_grid->RowIndex);
?>
	<?php if ($addresses->CustomerID->Visible) { // CustomerID ?>
		<td data-name="CustomerID">
<?php if ($addresses->CurrentAction <> "F") { ?>
<?php if ($addresses->CustomerID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_addresses_CustomerID" class="form-group addresses_CustomerID">
<span<?php echo $addresses->CustomerID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $addresses->CustomerID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_addresses_CustomerID" class="form-group addresses_CustomerID">
<select data-table="addresses" data-field="x_CustomerID" data-value-separator="<?php echo $addresses->CustomerID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID"<?php echo $addresses->CustomerID->EditAttributes() ?>>
<?php echo $addresses->CustomerID->SelectOptionListHtml("x<?php echo $addresses_grid->RowIndex ?>_CustomerID") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_addresses_CustomerID" class="form-group addresses_CustomerID">
<span<?php echo $addresses->CustomerID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $addresses->CustomerID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="x<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="addresses" data-field="x_CustomerID" name="o<?php echo $addresses_grid->RowIndex ?>_CustomerID" id="o<?php echo $addresses_grid->RowIndex ?>_CustomerID" value="<?php echo ew_HtmlEncode($addresses->CustomerID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($addresses->ProvinceID->Visible) { // ProvinceID ?>
		<td data-name="ProvinceID">
<?php if ($addresses->CurrentAction <> "F") { ?>
<span id="el$rowindex$_addresses_ProvinceID" class="form-group addresses_ProvinceID">
<select data-table="addresses" data-field="x_ProvinceID" data-value-separator="<?php echo $addresses->ProvinceID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" name="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID"<?php echo $addresses->ProvinceID->EditAttributes() ?>>
<?php echo $addresses->ProvinceID->SelectOptionListHtml("x<?php echo $addresses_grid->RowIndex ?>_ProvinceID") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_addresses_ProvinceID" class="form-group addresses_ProvinceID">
<span<?php echo $addresses->ProvinceID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $addresses->ProvinceID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="x<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="addresses" data-field="x_ProvinceID" name="o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" id="o<?php echo $addresses_grid->RowIndex ?>_ProvinceID" value="<?php echo ew_HtmlEncode($addresses->ProvinceID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($addresses->POBox->Visible) { // POBox ?>
		<td data-name="POBox">
<?php if ($addresses->CurrentAction <> "F") { ?>
<span id="el$rowindex$_addresses_POBox" class="form-group addresses_POBox">
<input type="text" data-table="addresses" data-field="x_POBox" name="x<?php echo $addresses_grid->RowIndex ?>_POBox" id="x<?php echo $addresses_grid->RowIndex ?>_POBox" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($addresses->POBox->getPlaceHolder()) ?>" value="<?php echo $addresses->POBox->EditValue ?>"<?php echo $addresses->POBox->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_addresses_POBox" class="form-group addresses_POBox">
<span<?php echo $addresses->POBox->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $addresses->POBox->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="addresses" data-field="x_POBox" name="x<?php echo $addresses_grid->RowIndex ?>_POBox" id="x<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="addresses" data-field="x_POBox" name="o<?php echo $addresses_grid->RowIndex ?>_POBox" id="o<?php echo $addresses_grid->RowIndex ?>_POBox" value="<?php echo ew_HtmlEncode($addresses->POBox->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$addresses_grid->ListOptions->Render("body", "right", $addresses_grid->RowIndex);
?>
<script type="text/javascript">
faddressesgrid.UpdateOpts(<?php echo $addresses_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($addresses->CurrentMode == "add" || $addresses->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $addresses_grid->FormKeyCountName ?>" id="<?php echo $addresses_grid->FormKeyCountName ?>" value="<?php echo $addresses_grid->KeyCount ?>">
<?php echo $addresses_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($addresses->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $addresses_grid->FormKeyCountName ?>" id="<?php echo $addresses_grid->FormKeyCountName ?>" value="<?php echo $addresses_grid->KeyCount ?>">
<?php echo $addresses_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($addresses->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="faddressesgrid">
</div>
<?php

// Close recordset
if ($addresses_grid->Recordset)
	$addresses_grid->Recordset->Close();
?>
<?php if ($addresses_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($addresses_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($addresses_grid->TotalRecs == 0 && $addresses->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($addresses_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($addresses->Export == "") { ?>
<script type="text/javascript">
faddressesgrid.Init();
</script>
<?php } ?>
<?php
$addresses_grid->Page_Terminate();
?>
