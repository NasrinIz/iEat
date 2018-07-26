<?php include_once "employeesinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($sub_menus_grid)) $sub_menus_grid = new csub_menus_grid();

// Page init
$sub_menus_grid->Page_Init();

// Page main
$sub_menus_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sub_menus_grid->Page_Render();
?>
<?php if ($sub_menus->Export == "") { ?>
<script type="text/javascript">

// Form object
var fsub_menusgrid = new ew_Form("fsub_menusgrid", "grid");
fsub_menusgrid.FormKeyCountName = '<?php echo $sub_menus_grid->FormKeyCountName ?>';

// Validate form
fsub_menusgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_MenuID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sub_menus->MenuID->FldCaption(), $sub_menus->MenuID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($sub_menus->Price->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fsub_menusgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "MenuID", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Picture", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Price", false)) return false;
	return true;
}

// Form_CustomValidate event
fsub_menusgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fsub_menusgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fsub_menusgrid.Lists["x_MenuID"] = {"LinkField":"x_MenuID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"menus"};
fsub_menusgrid.Lists["x_MenuID"].Data = "<?php echo $sub_menus_grid->MenuID->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($sub_menus->CurrentAction == "gridadd") {
	if ($sub_menus->CurrentMode == "copy") {
		$bSelectLimit = $sub_menus_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$sub_menus_grid->TotalRecs = $sub_menus->ListRecordCount();
			$sub_menus_grid->Recordset = $sub_menus_grid->LoadRecordset($sub_menus_grid->StartRec-1, $sub_menus_grid->DisplayRecs);
		} else {
			if ($sub_menus_grid->Recordset = $sub_menus_grid->LoadRecordset())
				$sub_menus_grid->TotalRecs = $sub_menus_grid->Recordset->RecordCount();
		}
		$sub_menus_grid->StartRec = 1;
		$sub_menus_grid->DisplayRecs = $sub_menus_grid->TotalRecs;
	} else {
		$sub_menus->CurrentFilter = "0=1";
		$sub_menus_grid->StartRec = 1;
		$sub_menus_grid->DisplayRecs = $sub_menus->GridAddRowCount;
	}
	$sub_menus_grid->TotalRecs = $sub_menus_grid->DisplayRecs;
	$sub_menus_grid->StopRec = $sub_menus_grid->DisplayRecs;
} else {
	$bSelectLimit = $sub_menus_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($sub_menus_grid->TotalRecs <= 0)
			$sub_menus_grid->TotalRecs = $sub_menus->ListRecordCount();
	} else {
		if (!$sub_menus_grid->Recordset && ($sub_menus_grid->Recordset = $sub_menus_grid->LoadRecordset()))
			$sub_menus_grid->TotalRecs = $sub_menus_grid->Recordset->RecordCount();
	}
	$sub_menus_grid->StartRec = 1;
	$sub_menus_grid->DisplayRecs = $sub_menus_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$sub_menus_grid->Recordset = $sub_menus_grid->LoadRecordset($sub_menus_grid->StartRec-1, $sub_menus_grid->DisplayRecs);

	// Set no record found message
	if ($sub_menus->CurrentAction == "" && $sub_menus_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$sub_menus_grid->setWarningMessage(ew_DeniedMsg());
		if ($sub_menus_grid->SearchWhere == "0=101")
			$sub_menus_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$sub_menus_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$sub_menus_grid->RenderOtherOptions();
?>
<?php $sub_menus_grid->ShowPageHeader(); ?>
<?php
$sub_menus_grid->ShowMessage();
?>
<?php if ($sub_menus_grid->TotalRecs > 0 || $sub_menus->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($sub_menus_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> sub_menus">
<div id="fsub_menusgrid" class="ewForm ewListForm form-inline">
<?php if ($sub_menus_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($sub_menus_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_sub_menus" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_sub_menusgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$sub_menus_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$sub_menus_grid->RenderListOptions();

// Render list options (header, left)
$sub_menus_grid->ListOptions->Render("header", "left");
?>
<?php if ($sub_menus->MenuID->Visible) { // MenuID ?>
	<?php if ($sub_menus->SortUrl($sub_menus->MenuID) == "") { ?>
		<th data-name="MenuID" class="<?php echo $sub_menus->MenuID->HeaderCellClass() ?>"><div id="elh_sub_menus_MenuID" class="sub_menus_MenuID"><div class="ewTableHeaderCaption"><?php echo $sub_menus->MenuID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="MenuID" class="<?php echo $sub_menus->MenuID->HeaderCellClass() ?>"><div><div id="elh_sub_menus_MenuID" class="sub_menus_MenuID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sub_menus->MenuID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sub_menus->MenuID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sub_menus->MenuID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($sub_menus->Name->Visible) { // Name ?>
	<?php if ($sub_menus->SortUrl($sub_menus->Name) == "") { ?>
		<th data-name="Name" class="<?php echo $sub_menus->Name->HeaderCellClass() ?>"><div id="elh_sub_menus_Name" class="sub_menus_Name"><div class="ewTableHeaderCaption"><?php echo $sub_menus->Name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Name" class="<?php echo $sub_menus->Name->HeaderCellClass() ?>"><div><div id="elh_sub_menus_Name" class="sub_menus_Name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sub_menus->Name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sub_menus->Name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sub_menus->Name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($sub_menus->Picture->Visible) { // Picture ?>
	<?php if ($sub_menus->SortUrl($sub_menus->Picture) == "") { ?>
		<th data-name="Picture" class="<?php echo $sub_menus->Picture->HeaderCellClass() ?>"><div id="elh_sub_menus_Picture" class="sub_menus_Picture"><div class="ewTableHeaderCaption"><?php echo $sub_menus->Picture->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Picture" class="<?php echo $sub_menus->Picture->HeaderCellClass() ?>"><div><div id="elh_sub_menus_Picture" class="sub_menus_Picture">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sub_menus->Picture->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sub_menus->Picture->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sub_menus->Picture->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($sub_menus->Price->Visible) { // Price ?>
	<?php if ($sub_menus->SortUrl($sub_menus->Price) == "") { ?>
		<th data-name="Price" class="<?php echo $sub_menus->Price->HeaderCellClass() ?>"><div id="elh_sub_menus_Price" class="sub_menus_Price"><div class="ewTableHeaderCaption"><?php echo $sub_menus->Price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Price" class="<?php echo $sub_menus->Price->HeaderCellClass() ?>"><div><div id="elh_sub_menus_Price" class="sub_menus_Price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sub_menus->Price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sub_menus->Price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sub_menus->Price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$sub_menus_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$sub_menus_grid->StartRec = 1;
$sub_menus_grid->StopRec = $sub_menus_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($sub_menus_grid->FormKeyCountName) && ($sub_menus->CurrentAction == "gridadd" || $sub_menus->CurrentAction == "gridedit" || $sub_menus->CurrentAction == "F")) {
		$sub_menus_grid->KeyCount = $objForm->GetValue($sub_menus_grid->FormKeyCountName);
		$sub_menus_grid->StopRec = $sub_menus_grid->StartRec + $sub_menus_grid->KeyCount - 1;
	}
}
$sub_menus_grid->RecCnt = $sub_menus_grid->StartRec - 1;
if ($sub_menus_grid->Recordset && !$sub_menus_grid->Recordset->EOF) {
	$sub_menus_grid->Recordset->MoveFirst();
	$bSelectLimit = $sub_menus_grid->UseSelectLimit;
	if (!$bSelectLimit && $sub_menus_grid->StartRec > 1)
		$sub_menus_grid->Recordset->Move($sub_menus_grid->StartRec - 1);
} elseif (!$sub_menus->AllowAddDeleteRow && $sub_menus_grid->StopRec == 0) {
	$sub_menus_grid->StopRec = $sub_menus->GridAddRowCount;
}

// Initialize aggregate
$sub_menus->RowType = EW_ROWTYPE_AGGREGATEINIT;
$sub_menus->ResetAttrs();
$sub_menus_grid->RenderRow();
if ($sub_menus->CurrentAction == "gridadd")
	$sub_menus_grid->RowIndex = 0;
if ($sub_menus->CurrentAction == "gridedit")
	$sub_menus_grid->RowIndex = 0;
while ($sub_menus_grid->RecCnt < $sub_menus_grid->StopRec) {
	$sub_menus_grid->RecCnt++;
	if (intval($sub_menus_grid->RecCnt) >= intval($sub_menus_grid->StartRec)) {
		$sub_menus_grid->RowCnt++;
		if ($sub_menus->CurrentAction == "gridadd" || $sub_menus->CurrentAction == "gridedit" || $sub_menus->CurrentAction == "F") {
			$sub_menus_grid->RowIndex++;
			$objForm->Index = $sub_menus_grid->RowIndex;
			if ($objForm->HasValue($sub_menus_grid->FormActionName))
				$sub_menus_grid->RowAction = strval($objForm->GetValue($sub_menus_grid->FormActionName));
			elseif ($sub_menus->CurrentAction == "gridadd")
				$sub_menus_grid->RowAction = "insert";
			else
				$sub_menus_grid->RowAction = "";
		}

		// Set up key count
		$sub_menus_grid->KeyCount = $sub_menus_grid->RowIndex;

		// Init row class and style
		$sub_menus->ResetAttrs();
		$sub_menus->CssClass = "";
		if ($sub_menus->CurrentAction == "gridadd") {
			if ($sub_menus->CurrentMode == "copy") {
				$sub_menus_grid->LoadRowValues($sub_menus_grid->Recordset); // Load row values
				$sub_menus_grid->SetRecordKey($sub_menus_grid->RowOldKey, $sub_menus_grid->Recordset); // Set old record key
			} else {
				$sub_menus_grid->LoadRowValues(); // Load default values
				$sub_menus_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$sub_menus_grid->LoadRowValues($sub_menus_grid->Recordset); // Load row values
		}
		$sub_menus->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($sub_menus->CurrentAction == "gridadd") // Grid add
			$sub_menus->RowType = EW_ROWTYPE_ADD; // Render add
		if ($sub_menus->CurrentAction == "gridadd" && $sub_menus->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$sub_menus_grid->RestoreCurrentRowFormValues($sub_menus_grid->RowIndex); // Restore form values
		if ($sub_menus->CurrentAction == "gridedit") { // Grid edit
			if ($sub_menus->EventCancelled) {
				$sub_menus_grid->RestoreCurrentRowFormValues($sub_menus_grid->RowIndex); // Restore form values
			}
			if ($sub_menus_grid->RowAction == "insert")
				$sub_menus->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$sub_menus->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($sub_menus->CurrentAction == "gridedit" && ($sub_menus->RowType == EW_ROWTYPE_EDIT || $sub_menus->RowType == EW_ROWTYPE_ADD) && $sub_menus->EventCancelled) // Update failed
			$sub_menus_grid->RestoreCurrentRowFormValues($sub_menus_grid->RowIndex); // Restore form values
		if ($sub_menus->RowType == EW_ROWTYPE_EDIT) // Edit row
			$sub_menus_grid->EditRowCnt++;
		if ($sub_menus->CurrentAction == "F") // Confirm row
			$sub_menus_grid->RestoreCurrentRowFormValues($sub_menus_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$sub_menus->RowAttrs = array_merge($sub_menus->RowAttrs, array('data-rowindex'=>$sub_menus_grid->RowCnt, 'id'=>'r' . $sub_menus_grid->RowCnt . '_sub_menus', 'data-rowtype'=>$sub_menus->RowType));

		// Render row
		$sub_menus_grid->RenderRow();

		// Render list options
		$sub_menus_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($sub_menus_grid->RowAction <> "delete" && $sub_menus_grid->RowAction <> "insertdelete" && !($sub_menus_grid->RowAction == "insert" && $sub_menus->CurrentAction == "F" && $sub_menus_grid->EmptyRow())) {
?>
	<tr<?php echo $sub_menus->RowAttributes() ?>>
<?php

// Render list options (body, left)
$sub_menus_grid->ListOptions->Render("body", "left", $sub_menus_grid->RowCnt);
?>
	<?php if ($sub_menus->MenuID->Visible) { // MenuID ?>
		<td data-name="MenuID"<?php echo $sub_menus->MenuID->CellAttributes() ?>>
<?php if ($sub_menus->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($sub_menus->MenuID->getSessionValue() <> "") { ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<span<?php echo $sub_menus->MenuID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->MenuID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<select data-table="sub_menus" data-field="x_MenuID" data-value-separator="<?php echo $sub_menus->MenuID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID"<?php echo $sub_menus->MenuID->EditAttributes() ?>>
<?php echo $sub_menus->MenuID->SelectOptionListHtml("x<?php echo $sub_menus_grid->RowIndex ?>_MenuID") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->OldValue) ?>">
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($sub_menus->MenuID->getSessionValue() <> "") { ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<span<?php echo $sub_menus->MenuID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->MenuID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<select data-table="sub_menus" data-field="x_MenuID" data-value-separator="<?php echo $sub_menus->MenuID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID"<?php echo $sub_menus->MenuID->EditAttributes() ?>>
<?php echo $sub_menus->MenuID->SelectOptionListHtml("x<?php echo $sub_menus_grid->RowIndex ?>_MenuID") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_MenuID" class="sub_menus_MenuID">
<span<?php echo $sub_menus->MenuID->ViewAttributes() ?>>
<?php echo $sub_menus->MenuID->ListViewValue() ?></span>
</span>
<?php if ($sub_menus->CurrentAction <> "F") { ?>
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->FormValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="fsub_menusgrid$x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="fsub_menusgrid$x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->FormValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="fsub_menusgrid$o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="fsub_menusgrid$o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="sub_menus" data-field="x_SubMenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_SubMenuID" id="x<?php echo $sub_menus_grid->RowIndex ?>_SubMenuID" value="<?php echo ew_HtmlEncode($sub_menus->SubMenuID->CurrentValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_SubMenuID" name="o<?php echo $sub_menus_grid->RowIndex ?>_SubMenuID" id="o<?php echo $sub_menus_grid->RowIndex ?>_SubMenuID" value="<?php echo ew_HtmlEncode($sub_menus->SubMenuID->OldValue) ?>">
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_EDIT || $sub_menus->CurrentMode == "edit") { ?>
<input type="hidden" data-table="sub_menus" data-field="x_SubMenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_SubMenuID" id="x<?php echo $sub_menus_grid->RowIndex ?>_SubMenuID" value="<?php echo ew_HtmlEncode($sub_menus->SubMenuID->CurrentValue) ?>">
<?php } ?>
	<?php if ($sub_menus->Name->Visible) { // Name ?>
		<td data-name="Name"<?php echo $sub_menus->Name->CellAttributes() ?>>
<?php if ($sub_menus->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Name" class="form-group sub_menus_Name">
<input type="text" data-table="sub_menus" data-field="x_Name" name="x<?php echo $sub_menus_grid->RowIndex ?>_Name" id="x<?php echo $sub_menus_grid->RowIndex ?>_Name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($sub_menus->Name->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Name->EditValue ?>"<?php echo $sub_menus->Name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="o<?php echo $sub_menus_grid->RowIndex ?>_Name" id="o<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->OldValue) ?>">
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Name" class="form-group sub_menus_Name">
<input type="text" data-table="sub_menus" data-field="x_Name" name="x<?php echo $sub_menus_grid->RowIndex ?>_Name" id="x<?php echo $sub_menus_grid->RowIndex ?>_Name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($sub_menus->Name->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Name->EditValue ?>"<?php echo $sub_menus->Name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Name" class="sub_menus_Name">
<span<?php echo $sub_menus->Name->ViewAttributes() ?>>
<?php echo $sub_menus->Name->ListViewValue() ?></span>
</span>
<?php if ($sub_menus->CurrentAction <> "F") { ?>
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="x<?php echo $sub_menus_grid->RowIndex ?>_Name" id="x<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->FormValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="o<?php echo $sub_menus_grid->RowIndex ?>_Name" id="o<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="fsub_menusgrid$x<?php echo $sub_menus_grid->RowIndex ?>_Name" id="fsub_menusgrid$x<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->FormValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="fsub_menusgrid$o<?php echo $sub_menus_grid->RowIndex ?>_Name" id="fsub_menusgrid$o<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($sub_menus->Picture->Visible) { // Picture ?>
		<td data-name="Picture"<?php echo $sub_menus->Picture->CellAttributes() ?>>
<?php if ($sub_menus_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_sub_menus_Picture" class="form-group sub_menus_Picture">
<div id="fd_x<?php echo $sub_menus_grid->RowIndex ?>_Picture">
<span title="<?php echo $sub_menus->Picture->FldTitle() ? $sub_menus->Picture->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($sub_menus->Picture->ReadOnly || $sub_menus->Picture->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="sub_menus" data-field="x_Picture" name="x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id="x<?php echo $sub_menus_grid->RowIndex ?>_Picture"<?php echo $sub_menus->Picture->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fn_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="0">
<input type="hidden" name="fs_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fs_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="60">
<input type="hidden" name="fx_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fx_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fm_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_Picture" name="o<?php echo $sub_menus_grid->RowIndex ?>_Picture" id="o<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo ew_HtmlEncode($sub_menus->Picture->OldValue) ?>">
<?php } elseif ($sub_menus->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Picture" class="sub_menus_Picture">
<span>
<?php echo ew_GetFileViewTag($sub_menus->Picture, $sub_menus->Picture->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Picture" class="form-group sub_menus_Picture">
<div id="fd_x<?php echo $sub_menus_grid->RowIndex ?>_Picture">
<span title="<?php echo $sub_menus->Picture->FldTitle() ? $sub_menus->Picture->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($sub_menus->Picture->ReadOnly || $sub_menus->Picture->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="sub_menus" data-field="x_Picture" name="x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id="x<?php echo $sub_menus_grid->RowIndex ?>_Picture"<?php echo $sub_menus->Picture->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fn_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fs_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="60">
<input type="hidden" name="fx_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fx_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fm_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($sub_menus->Price->Visible) { // Price ?>
		<td data-name="Price"<?php echo $sub_menus->Price->CellAttributes() ?>>
<?php if ($sub_menus->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Price" class="form-group sub_menus_Price">
<input type="text" data-table="sub_menus" data-field="x_Price" name="x<?php echo $sub_menus_grid->RowIndex ?>_Price" id="x<?php echo $sub_menus_grid->RowIndex ?>_Price" size="30" placeholder="<?php echo ew_HtmlEncode($sub_menus->Price->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Price->EditValue ?>"<?php echo $sub_menus->Price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="o<?php echo $sub_menus_grid->RowIndex ?>_Price" id="o<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->OldValue) ?>">
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Price" class="form-group sub_menus_Price">
<input type="text" data-table="sub_menus" data-field="x_Price" name="x<?php echo $sub_menus_grid->RowIndex ?>_Price" id="x<?php echo $sub_menus_grid->RowIndex ?>_Price" size="30" placeholder="<?php echo ew_HtmlEncode($sub_menus->Price->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Price->EditValue ?>"<?php echo $sub_menus->Price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($sub_menus->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sub_menus_grid->RowCnt ?>_sub_menus_Price" class="sub_menus_Price">
<span<?php echo $sub_menus->Price->ViewAttributes() ?>>
<?php echo $sub_menus->Price->ListViewValue() ?></span>
</span>
<?php if ($sub_menus->CurrentAction <> "F") { ?>
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="x<?php echo $sub_menus_grid->RowIndex ?>_Price" id="x<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->FormValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="o<?php echo $sub_menus_grid->RowIndex ?>_Price" id="o<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="fsub_menusgrid$x<?php echo $sub_menus_grid->RowIndex ?>_Price" id="fsub_menusgrid$x<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->FormValue) ?>">
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="fsub_menusgrid$o<?php echo $sub_menus_grid->RowIndex ?>_Price" id="fsub_menusgrid$o<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$sub_menus_grid->ListOptions->Render("body", "right", $sub_menus_grid->RowCnt);
?>
	</tr>
<?php if ($sub_menus->RowType == EW_ROWTYPE_ADD || $sub_menus->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsub_menusgrid.UpdateOpts(<?php echo $sub_menus_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($sub_menus->CurrentAction <> "gridadd" || $sub_menus->CurrentMode == "copy")
		if (!$sub_menus_grid->Recordset->EOF) $sub_menus_grid->Recordset->MoveNext();
}
?>
<?php
	if ($sub_menus->CurrentMode == "add" || $sub_menus->CurrentMode == "copy" || $sub_menus->CurrentMode == "edit") {
		$sub_menus_grid->RowIndex = '$rowindex$';
		$sub_menus_grid->LoadRowValues();

		// Set row properties
		$sub_menus->ResetAttrs();
		$sub_menus->RowAttrs = array_merge($sub_menus->RowAttrs, array('data-rowindex'=>$sub_menus_grid->RowIndex, 'id'=>'r0_sub_menus', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($sub_menus->RowAttrs["class"], "ewTemplate");
		$sub_menus->RowType = EW_ROWTYPE_ADD;

		// Render row
		$sub_menus_grid->RenderRow();

		// Render list options
		$sub_menus_grid->RenderListOptions();
		$sub_menus_grid->StartRowCnt = 0;
?>
	<tr<?php echo $sub_menus->RowAttributes() ?>>
<?php

// Render list options (body, left)
$sub_menus_grid->ListOptions->Render("body", "left", $sub_menus_grid->RowIndex);
?>
	<?php if ($sub_menus->MenuID->Visible) { // MenuID ?>
		<td data-name="MenuID">
<?php if ($sub_menus->CurrentAction <> "F") { ?>
<?php if ($sub_menus->MenuID->getSessionValue() <> "") { ?>
<span id="el$rowindex$_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<span<?php echo $sub_menus->MenuID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->MenuID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<select data-table="sub_menus" data-field="x_MenuID" data-value-separator="<?php echo $sub_menus->MenuID->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID"<?php echo $sub_menus->MenuID->EditAttributes() ?>>
<?php echo $sub_menus->MenuID->SelectOptionListHtml("x<?php echo $sub_menus_grid->RowIndex ?>_MenuID") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sub_menus_MenuID" class="form-group sub_menus_MenuID">
<span<?php echo $sub_menus->MenuID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->MenuID->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="x<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_menus" data-field="x_MenuID" name="o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" id="o<?php echo $sub_menus_grid->RowIndex ?>_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sub_menus->Name->Visible) { // Name ?>
		<td data-name="Name">
<?php if ($sub_menus->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sub_menus_Name" class="form-group sub_menus_Name">
<input type="text" data-table="sub_menus" data-field="x_Name" name="x<?php echo $sub_menus_grid->RowIndex ?>_Name" id="x<?php echo $sub_menus_grid->RowIndex ?>_Name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($sub_menus->Name->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Name->EditValue ?>"<?php echo $sub_menus->Name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_menus_Name" class="form-group sub_menus_Name">
<span<?php echo $sub_menus->Name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->Name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="x<?php echo $sub_menus_grid->RowIndex ?>_Name" id="x<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_menus" data-field="x_Name" name="o<?php echo $sub_menus_grid->RowIndex ?>_Name" id="o<?php echo $sub_menus_grid->RowIndex ?>_Name" value="<?php echo ew_HtmlEncode($sub_menus->Name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sub_menus->Picture->Visible) { // Picture ?>
		<td data-name="Picture">
<span id="el$rowindex$_sub_menus_Picture" class="form-group sub_menus_Picture">
<div id="fd_x<?php echo $sub_menus_grid->RowIndex ?>_Picture">
<span title="<?php echo $sub_menus->Picture->FldTitle() ? $sub_menus->Picture->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($sub_menus->Picture->ReadOnly || $sub_menus->Picture->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="sub_menus" data-field="x_Picture" name="x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id="x<?php echo $sub_menus_grid->RowIndex ?>_Picture"<?php echo $sub_menus->Picture->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fn_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fa_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="0">
<input type="hidden" name="fs_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fs_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="60">
<input type="hidden" name="fx_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fx_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" id= "fm_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo $sub_menus->Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $sub_menus_grid->RowIndex ?>_Picture" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_Picture" name="o<?php echo $sub_menus_grid->RowIndex ?>_Picture" id="o<?php echo $sub_menus_grid->RowIndex ?>_Picture" value="<?php echo ew_HtmlEncode($sub_menus->Picture->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sub_menus->Price->Visible) { // Price ?>
		<td data-name="Price">
<?php if ($sub_menus->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sub_menus_Price" class="form-group sub_menus_Price">
<input type="text" data-table="sub_menus" data-field="x_Price" name="x<?php echo $sub_menus_grid->RowIndex ?>_Price" id="x<?php echo $sub_menus_grid->RowIndex ?>_Price" size="30" placeholder="<?php echo ew_HtmlEncode($sub_menus->Price->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Price->EditValue ?>"<?php echo $sub_menus->Price->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_sub_menus_Price" class="form-group sub_menus_Price">
<span<?php echo $sub_menus->Price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->Price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="x<?php echo $sub_menus_grid->RowIndex ?>_Price" id="x<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sub_menus" data-field="x_Price" name="o<?php echo $sub_menus_grid->RowIndex ?>_Price" id="o<?php echo $sub_menus_grid->RowIndex ?>_Price" value="<?php echo ew_HtmlEncode($sub_menus->Price->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$sub_menus_grid->ListOptions->Render("body", "right", $sub_menus_grid->RowIndex);
?>
<script type="text/javascript">
fsub_menusgrid.UpdateOpts(<?php echo $sub_menus_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($sub_menus->CurrentMode == "add" || $sub_menus->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $sub_menus_grid->FormKeyCountName ?>" id="<?php echo $sub_menus_grid->FormKeyCountName ?>" value="<?php echo $sub_menus_grid->KeyCount ?>">
<?php echo $sub_menus_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($sub_menus->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $sub_menus_grid->FormKeyCountName ?>" id="<?php echo $sub_menus_grid->FormKeyCountName ?>" value="<?php echo $sub_menus_grid->KeyCount ?>">
<?php echo $sub_menus_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($sub_menus->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsub_menusgrid">
</div>
<?php

// Close recordset
if ($sub_menus_grid->Recordset)
	$sub_menus_grid->Recordset->Close();
?>
<?php if ($sub_menus_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($sub_menus_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($sub_menus_grid->TotalRecs == 0 && $sub_menus->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($sub_menus_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($sub_menus->Export == "") { ?>
<script type="text/javascript">
fsub_menusgrid.Init();
</script>
<?php } ?>
<?php
$sub_menus_grid->Page_Terminate();
?>
