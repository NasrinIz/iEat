<?php

// Global variable for table object
$orders = NULL;

//
// Table class for orders
//
class corders extends cTable {
	var $order_id;
	var $customer_id;
	var $full_name;
	var $province_id;
	var $address;
	var $zip_code;
	var $phone;
	var $discount;
	var $total_price;
	var $payment_type_id;
	var $delivery_type_id;
	var $description;
	var $feedback;
	var $order_date_time;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'orders';
		$this->TableName = 'orders';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`orders`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// order_id
		$this->order_id = new cField('orders', 'orders', 'x_order_id', 'order_id', '`order_id`', '`order_id`', 3, -1, FALSE, '`order_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->order_id->Sortable = TRUE; // Allow sort
		$this->order_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['order_id'] = &$this->order_id;

		// customer_id
		$this->customer_id = new cField('orders', 'orders', 'x_customer_id', 'customer_id', '`customer_id`', '`customer_id`', 3, -1, FALSE, '`customer_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->customer_id->Sortable = TRUE; // Allow sort
		$this->customer_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->customer_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->customer_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['customer_id'] = &$this->customer_id;

		// full_name
		$this->full_name = new cField('orders', 'orders', 'x_full_name', 'full_name', '`full_name`', '`full_name`', 200, -1, FALSE, '`full_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->full_name->Sortable = TRUE; // Allow sort
		$this->fields['full_name'] = &$this->full_name;

		// province_id
		$this->province_id = new cField('orders', 'orders', 'x_province_id', 'province_id', '`province_id`', '`province_id`', 3, -1, FALSE, '`province_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->province_id->Sortable = TRUE; // Allow sort
		$this->province_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->province_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->province_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['province_id'] = &$this->province_id;

		// address
		$this->address = new cField('orders', 'orders', 'x_address', 'address', '`address`', '`address`', 201, -1, FALSE, '`address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->address->Sortable = TRUE; // Allow sort
		$this->fields['address'] = &$this->address;

		// zip_code
		$this->zip_code = new cField('orders', 'orders', 'x_zip_code', 'zip_code', '`zip_code`', '`zip_code`', 200, -1, FALSE, '`zip_code`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->zip_code->Sortable = TRUE; // Allow sort
		$this->fields['zip_code'] = &$this->zip_code;

		// phone
		$this->phone = new cField('orders', 'orders', 'x_phone', 'phone', '`phone`', '`phone`', 200, -1, FALSE, '`phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->phone->Sortable = TRUE; // Allow sort
		$this->fields['phone'] = &$this->phone;

		// discount
		$this->discount = new cField('orders', 'orders', 'x_discount', 'discount', '`discount`', '`discount`', 5, -1, FALSE, '`discount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->discount->Sortable = TRUE; // Allow sort
		$this->discount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['discount'] = &$this->discount;

		// total_price
		$this->total_price = new cField('orders', 'orders', 'x_total_price', 'total_price', '`total_price`', '`total_price`', 5, -1, FALSE, '`total_price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->total_price->Sortable = TRUE; // Allow sort
		$this->total_price->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['total_price'] = &$this->total_price;

		// payment_type_id
		$this->payment_type_id = new cField('orders', 'orders', 'x_payment_type_id', 'payment_type_id', '`payment_type_id`', '`payment_type_id`', 3, -1, FALSE, '`payment_type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->payment_type_id->Sortable = TRUE; // Allow sort
		$this->payment_type_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->payment_type_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->payment_type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['payment_type_id'] = &$this->payment_type_id;

		// delivery_type_id
		$this->delivery_type_id = new cField('orders', 'orders', 'x_delivery_type_id', 'delivery_type_id', '`delivery_type_id`', '`delivery_type_id`', 3, -1, FALSE, '`delivery_type_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->delivery_type_id->Sortable = TRUE; // Allow sort
		$this->delivery_type_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->delivery_type_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->delivery_type_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['delivery_type_id'] = &$this->delivery_type_id;

		// description
		$this->description = new cField('orders', 'orders', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// feedback
		$this->feedback = new cField('orders', 'orders', 'x_feedback', 'feedback', '`feedback`', '`feedback`', 201, -1, FALSE, '`feedback`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->feedback->Sortable = TRUE; // Allow sort
		$this->fields['feedback'] = &$this->feedback;

		// order_date_time
		$this->order_date_time = new cField('orders', 'orders', 'x_order_date_time', 'order_date_time', '`order_date_time`', ew_CastDateFieldForLike('`order_date_time`', 0, "DB"), 135, 0, FALSE, '`order_date_time`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->order_date_time->Sortable = TRUE; // Allow sort
		$this->order_date_time->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['order_date_time'] = &$this->order_date_time;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "order_details") {
			$sDetailUrl = $GLOBALS["order_details"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_order_id=" . urlencode($this->order_id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "orderslist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`orders`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->order_id->setDbValue($conn->Insert_ID());
			$rs['order_id'] = $this->order_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('order_id', $rs))
				ew_AddFilter($where, ew_QuotedName('order_id', $this->DBID) . '=' . ew_QuotedValue($rs['order_id'], $this->order_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`order_id` = @order_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->order_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->order_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@order_id@", ew_AdjustSql($this->order_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "orderslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "ordersview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "ordersedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "ordersadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "orderslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ordersview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ordersview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "ordersadd.php?" . $this->UrlParm($parm);
		else
			$url = "ordersadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ordersedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ordersedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("ordersadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("ordersadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("ordersdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "order_id:" . ew_VarToJson($this->order_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->order_id->CurrentValue)) {
			$sUrl .= "order_id=" . urlencode($this->order_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["order_id"]))
				$arKeys[] = $_POST["order_id"];
			elseif (isset($_GET["order_id"]))
				$arKeys[] = $_GET["order_id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->order_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->order_id->setDbValue($rs->fields('order_id'));
		$this->customer_id->setDbValue($rs->fields('customer_id'));
		$this->full_name->setDbValue($rs->fields('full_name'));
		$this->province_id->setDbValue($rs->fields('province_id'));
		$this->address->setDbValue($rs->fields('address'));
		$this->zip_code->setDbValue($rs->fields('zip_code'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->discount->setDbValue($rs->fields('discount'));
		$this->total_price->setDbValue($rs->fields('total_price'));
		$this->payment_type_id->setDbValue($rs->fields('payment_type_id'));
		$this->delivery_type_id->setDbValue($rs->fields('delivery_type_id'));
		$this->description->setDbValue($rs->fields('description'));
		$this->feedback->setDbValue($rs->fields('feedback'));
		$this->order_date_time->setDbValue($rs->fields('order_date_time'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// order_id
		// customer_id
		// full_name
		// province_id
		// address
		// zip_code
		// phone
		// discount
		// total_price
		// payment_type_id
		// delivery_type_id
		// description
		// feedback
		// order_date_time
		// order_id

		$this->order_id->ViewValue = $this->order_id->CurrentValue;
		$this->order_id->ViewCustomAttributes = "";

		// customer_id
		if (strval($this->customer_id->CurrentValue) <> "") {
			$sFilterWrk = "`customer_id`" . ew_SearchString("=", $this->customer_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `customer_id`, `full_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `customers`";
		$sWhereWrk = "";
		$this->customer_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->customer_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `full_name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->customer_id->ViewValue = $this->customer_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
			}
		} else {
			$this->customer_id->ViewValue = NULL;
		}
		$this->customer_id->ViewCustomAttributes = "";

		// full_name
		$this->full_name->ViewValue = $this->full_name->CurrentValue;
		$this->full_name->ViewCustomAttributes = "";

		// province_id
		if (strval($this->province_id->CurrentValue) <> "") {
			$sFilterWrk = "`province_id`" . ew_SearchString("=", $this->province_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `province_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provinces`";
		$sWhereWrk = "";
		$this->province_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->province_id->ViewValue = $this->province_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->province_id->ViewValue = $this->province_id->CurrentValue;
			}
		} else {
			$this->province_id->ViewValue = NULL;
		}
		$this->province_id->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// zip_code
		$this->zip_code->ViewValue = $this->zip_code->CurrentValue;
		$this->zip_code->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// discount
		$this->discount->ViewValue = $this->discount->CurrentValue;
		$this->discount->ViewCustomAttributes = "";

		// total_price
		$this->total_price->ViewValue = $this->total_price->CurrentValue;
		$this->total_price->ViewValue = ew_FormatCurrency($this->total_price->ViewValue, 0, -2, -2, -2);
		$this->total_price->ViewCustomAttributes = "";

		// payment_type_id
		if (strval($this->payment_type_id->CurrentValue) <> "") {
			$sFilterWrk = "`payment_type_id`" . ew_SearchString("=", $this->payment_type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `payment_type_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `payment_types`";
		$sWhereWrk = "";
		$this->payment_type_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->payment_type_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->payment_type_id->ViewValue = $this->payment_type_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->payment_type_id->ViewValue = $this->payment_type_id->CurrentValue;
			}
		} else {
			$this->payment_type_id->ViewValue = NULL;
		}
		$this->payment_type_id->ViewCustomAttributes = "";

		// delivery_type_id
		if (strval($this->delivery_type_id->CurrentValue) <> "") {
			$sFilterWrk = "`delivery_type_id`" . ew_SearchString("=", $this->delivery_type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `delivery_type_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `delivery_types`";
		$sWhereWrk = "";
		$this->delivery_type_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->delivery_type_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->delivery_type_id->ViewValue = $this->delivery_type_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->delivery_type_id->ViewValue = $this->delivery_type_id->CurrentValue;
			}
		} else {
			$this->delivery_type_id->ViewValue = NULL;
		}
		$this->delivery_type_id->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// feedback
		$this->feedback->ViewValue = $this->feedback->CurrentValue;
		$this->feedback->ViewCustomAttributes = "";

		// order_date_time
		$this->order_date_time->ViewValue = $this->order_date_time->CurrentValue;
		$this->order_date_time->ViewValue = ew_FormatDateTime($this->order_date_time->ViewValue, 0);
		$this->order_date_time->ViewCustomAttributes = "";

		// order_id
		$this->order_id->LinkCustomAttributes = "";
		$this->order_id->HrefValue = "";
		$this->order_id->TooltipValue = "";

		// customer_id
		$this->customer_id->LinkCustomAttributes = "";
		$this->customer_id->HrefValue = "";
		$this->customer_id->TooltipValue = "";

		// full_name
		$this->full_name->LinkCustomAttributes = "";
		$this->full_name->HrefValue = "";
		$this->full_name->TooltipValue = "";

		// province_id
		$this->province_id->LinkCustomAttributes = "";
		$this->province_id->HrefValue = "";
		$this->province_id->TooltipValue = "";

		// address
		$this->address->LinkCustomAttributes = "";
		$this->address->HrefValue = "";
		$this->address->TooltipValue = "";

		// zip_code
		$this->zip_code->LinkCustomAttributes = "";
		$this->zip_code->HrefValue = "";
		$this->zip_code->TooltipValue = "";

		// phone
		$this->phone->LinkCustomAttributes = "";
		$this->phone->HrefValue = "";
		$this->phone->TooltipValue = "";

		// discount
		$this->discount->LinkCustomAttributes = "";
		$this->discount->HrefValue = "";
		$this->discount->TooltipValue = "";

		// total_price
		$this->total_price->LinkCustomAttributes = "";
		$this->total_price->HrefValue = "";
		$this->total_price->TooltipValue = "";

		// payment_type_id
		$this->payment_type_id->LinkCustomAttributes = "";
		$this->payment_type_id->HrefValue = "";
		$this->payment_type_id->TooltipValue = "";

		// delivery_type_id
		$this->delivery_type_id->LinkCustomAttributes = "";
		$this->delivery_type_id->HrefValue = "";
		$this->delivery_type_id->TooltipValue = "";

		// description
		$this->description->LinkCustomAttributes = "";
		$this->description->HrefValue = "";
		$this->description->TooltipValue = "";

		// feedback
		$this->feedback->LinkCustomAttributes = "";
		$this->feedback->HrefValue = "";
		$this->feedback->TooltipValue = "";

		// order_date_time
		$this->order_date_time->LinkCustomAttributes = "";
		$this->order_date_time->HrefValue = "";
		$this->order_date_time->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// order_id
		$this->order_id->EditAttrs["class"] = "form-control";
		$this->order_id->EditCustomAttributes = "";
		$this->order_id->EditValue = $this->order_id->CurrentValue;
		$this->order_id->ViewCustomAttributes = "";

		// customer_id
		$this->customer_id->EditAttrs["class"] = "form-control";
		$this->customer_id->EditCustomAttributes = "";

		// full_name
		$this->full_name->EditAttrs["class"] = "form-control";
		$this->full_name->EditCustomAttributes = "";
		$this->full_name->EditValue = $this->full_name->CurrentValue;
		$this->full_name->PlaceHolder = ew_RemoveHtml($this->full_name->FldCaption());

		// province_id
		$this->province_id->EditAttrs["class"] = "form-control";
		$this->province_id->EditCustomAttributes = "";

		// address
		$this->address->EditAttrs["class"] = "form-control";
		$this->address->EditCustomAttributes = "";
		$this->address->EditValue = $this->address->CurrentValue;
		$this->address->PlaceHolder = ew_RemoveHtml($this->address->FldCaption());

		// zip_code
		$this->zip_code->EditAttrs["class"] = "form-control";
		$this->zip_code->EditCustomAttributes = "";
		$this->zip_code->EditValue = $this->zip_code->CurrentValue;
		$this->zip_code->PlaceHolder = ew_RemoveHtml($this->zip_code->FldCaption());

		// phone
		$this->phone->EditAttrs["class"] = "form-control";
		$this->phone->EditCustomAttributes = "";
		$this->phone->EditValue = $this->phone->CurrentValue;
		$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

		// discount
		$this->discount->EditAttrs["class"] = "form-control";
		$this->discount->EditCustomAttributes = "";
		$this->discount->EditValue = $this->discount->CurrentValue;
		$this->discount->PlaceHolder = ew_RemoveHtml($this->discount->FldCaption());
		if (strval($this->discount->EditValue) <> "" && is_numeric($this->discount->EditValue)) $this->discount->EditValue = ew_FormatNumber($this->discount->EditValue, -2, -1, -2, 0);

		// total_price
		$this->total_price->EditAttrs["class"] = "form-control";
		$this->total_price->EditCustomAttributes = "";
		$this->total_price->EditValue = $this->total_price->CurrentValue;
		$this->total_price->PlaceHolder = ew_RemoveHtml($this->total_price->FldCaption());
		if (strval($this->total_price->EditValue) <> "" && is_numeric($this->total_price->EditValue)) $this->total_price->EditValue = ew_FormatNumber($this->total_price->EditValue, -2, -2, -2, -2);

		// payment_type_id
		$this->payment_type_id->EditAttrs["class"] = "form-control";
		$this->payment_type_id->EditCustomAttributes = "";

		// delivery_type_id
		$this->delivery_type_id->EditAttrs["class"] = "form-control";
		$this->delivery_type_id->EditCustomAttributes = "";

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

		// feedback
		$this->feedback->EditAttrs["class"] = "form-control";
		$this->feedback->EditCustomAttributes = "";
		$this->feedback->EditValue = $this->feedback->CurrentValue;
		$this->feedback->PlaceHolder = ew_RemoveHtml($this->feedback->FldCaption());

		// order_date_time
		// Call Row Rendered event

		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->total_price->CurrentValue))
				$this->total_price->Total += $this->total_price->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->total_price->CurrentValue = $this->total_price->Total;
			$this->total_price->ViewValue = $this->total_price->CurrentValue;
			$this->total_price->ViewValue = ew_FormatCurrency($this->total_price->ViewValue, 0, -2, -2, -2);
			$this->total_price->ViewCustomAttributes = "";
			$this->total_price->HrefValue = ""; // Clear href value

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->order_id->Exportable) $Doc->ExportCaption($this->order_id);
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->full_name->Exportable) $Doc->ExportCaption($this->full_name);
					if ($this->province_id->Exportable) $Doc->ExportCaption($this->province_id);
					if ($this->address->Exportable) $Doc->ExportCaption($this->address);
					if ($this->zip_code->Exportable) $Doc->ExportCaption($this->zip_code);
					if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
					if ($this->discount->Exportable) $Doc->ExportCaption($this->discount);
					if ($this->total_price->Exportable) $Doc->ExportCaption($this->total_price);
					if ($this->payment_type_id->Exportable) $Doc->ExportCaption($this->payment_type_id);
					if ($this->delivery_type_id->Exportable) $Doc->ExportCaption($this->delivery_type_id);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->feedback->Exportable) $Doc->ExportCaption($this->feedback);
					if ($this->order_date_time->Exportable) $Doc->ExportCaption($this->order_date_time);
				} else {
					if ($this->order_id->Exportable) $Doc->ExportCaption($this->order_id);
					if ($this->customer_id->Exportable) $Doc->ExportCaption($this->customer_id);
					if ($this->full_name->Exportable) $Doc->ExportCaption($this->full_name);
					if ($this->province_id->Exportable) $Doc->ExportCaption($this->province_id);
					if ($this->zip_code->Exportable) $Doc->ExportCaption($this->zip_code);
					if ($this->phone->Exportable) $Doc->ExportCaption($this->phone);
					if ($this->discount->Exportable) $Doc->ExportCaption($this->discount);
					if ($this->total_price->Exportable) $Doc->ExportCaption($this->total_price);
					if ($this->payment_type_id->Exportable) $Doc->ExportCaption($this->payment_type_id);
					if ($this->delivery_type_id->Exportable) $Doc->ExportCaption($this->delivery_type_id);
					if ($this->order_date_time->Exportable) $Doc->ExportCaption($this->order_date_time);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);
				$this->AggregateListRowValues(); // Aggregate row values

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->order_id->Exportable) $Doc->ExportField($this->order_id);
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->full_name->Exportable) $Doc->ExportField($this->full_name);
						if ($this->province_id->Exportable) $Doc->ExportField($this->province_id);
						if ($this->address->Exportable) $Doc->ExportField($this->address);
						if ($this->zip_code->Exportable) $Doc->ExportField($this->zip_code);
						if ($this->phone->Exportable) $Doc->ExportField($this->phone);
						if ($this->discount->Exportable) $Doc->ExportField($this->discount);
						if ($this->total_price->Exportable) $Doc->ExportField($this->total_price);
						if ($this->payment_type_id->Exportable) $Doc->ExportField($this->payment_type_id);
						if ($this->delivery_type_id->Exportable) $Doc->ExportField($this->delivery_type_id);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->feedback->Exportable) $Doc->ExportField($this->feedback);
						if ($this->order_date_time->Exportable) $Doc->ExportField($this->order_date_time);
					} else {
						if ($this->order_id->Exportable) $Doc->ExportField($this->order_id);
						if ($this->customer_id->Exportable) $Doc->ExportField($this->customer_id);
						if ($this->full_name->Exportable) $Doc->ExportField($this->full_name);
						if ($this->province_id->Exportable) $Doc->ExportField($this->province_id);
						if ($this->zip_code->Exportable) $Doc->ExportField($this->zip_code);
						if ($this->phone->Exportable) $Doc->ExportField($this->phone);
						if ($this->discount->Exportable) $Doc->ExportField($this->discount);
						if ($this->total_price->Exportable) $Doc->ExportField($this->total_price);
						if ($this->payment_type_id->Exportable) $Doc->ExportField($this->payment_type_id);
						if ($this->delivery_type_id->Exportable) $Doc->ExportField($this->delivery_type_id);
						if ($this->order_date_time->Exportable) $Doc->ExportField($this->order_date_time);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}

		// Export aggregates (horizontal format only)
		if ($Doc->Horizontal) {
			$this->RowType = EW_ROWTYPE_AGGREGATE;
			$this->ResetAttrs();
			$this->AggregateListRow();
			if (!$Doc->ExportCustom) {
				$Doc->BeginExportRow(-1);
				if ($this->order_id->Exportable) $Doc->ExportAggregate($this->order_id, '');
				if ($this->customer_id->Exportable) $Doc->ExportAggregate($this->customer_id, '');
				if ($this->full_name->Exportable) $Doc->ExportAggregate($this->full_name, '');
				if ($this->province_id->Exportable) $Doc->ExportAggregate($this->province_id, '');
				if ($this->zip_code->Exportable) $Doc->ExportAggregate($this->zip_code, '');
				if ($this->phone->Exportable) $Doc->ExportAggregate($this->phone, '');
				if ($this->discount->Exportable) $Doc->ExportAggregate($this->discount, '');
				if ($this->total_price->Exportable) $Doc->ExportAggregate($this->total_price, 'TOTAL');
				if ($this->payment_type_id->Exportable) $Doc->ExportAggregate($this->payment_type_id, '');
				if ($this->delivery_type_id->Exportable) $Doc->ExportAggregate($this->delivery_type_id, '');
				if ($this->order_date_time->Exportable) $Doc->ExportAggregate($this->order_date_time, '');
				$Doc->EndExportRow();
			}
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
