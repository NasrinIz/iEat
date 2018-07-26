<?php

// Global variable for table object
$orders = NULL;

//
// Table class for orders
//
class corders extends cTable {
	var $OrderID;
	var $CustomerID;
	var $FullName;
	var $ProvinceID;
	var $Address;
	var $ZipCode;
	var $Phone;
	var $Discount;
	var $TotalPrice;
	var $PaymentTypeID;
	var $DeliveryTypeID;
	var $Description;
	var $FeedBack;
	var $OrderDateTime;

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

		// OrderID
		$this->OrderID = new cField('orders', 'orders', 'x_OrderID', 'OrderID', '`OrderID`', '`OrderID`', 3, -1, FALSE, '`OrderID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->OrderID->Sortable = TRUE; // Allow sort
		$this->OrderID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['OrderID'] = &$this->OrderID;

		// CustomerID
		$this->CustomerID = new cField('orders', 'orders', 'x_CustomerID', 'CustomerID', '`CustomerID`', '`CustomerID`', 3, -1, FALSE, '`CustomerID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->CustomerID->Sortable = TRUE; // Allow sort
		$this->CustomerID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->CustomerID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->CustomerID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['CustomerID'] = &$this->CustomerID;

		// FullName
		$this->FullName = new cField('orders', 'orders', 'x_FullName', 'FullName', '`FullName`', '`FullName`', 200, -1, FALSE, '`FullName`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->FullName->Sortable = TRUE; // Allow sort
		$this->fields['FullName'] = &$this->FullName;

		// ProvinceID
		$this->ProvinceID = new cField('orders', 'orders', 'x_ProvinceID', 'ProvinceID', '`ProvinceID`', '`ProvinceID`', 3, -1, FALSE, '`ProvinceID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->ProvinceID->Sortable = TRUE; // Allow sort
		$this->ProvinceID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->ProvinceID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->ProvinceID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['ProvinceID'] = &$this->ProvinceID;

		// Address
		$this->Address = new cField('orders', 'orders', 'x_Address', 'Address', '`Address`', '`Address`', 201, -1, FALSE, '`Address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Address->Sortable = TRUE; // Allow sort
		$this->fields['Address'] = &$this->Address;

		// ZipCode
		$this->ZipCode = new cField('orders', 'orders', 'x_ZipCode', 'ZipCode', '`ZipCode`', '`ZipCode`', 200, -1, FALSE, '`ZipCode`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->ZipCode->Sortable = TRUE; // Allow sort
		$this->fields['ZipCode'] = &$this->ZipCode;

		// Phone
		$this->Phone = new cField('orders', 'orders', 'x_Phone', 'Phone', '`Phone`', '`Phone`', 200, -1, FALSE, '`Phone`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Phone->Sortable = TRUE; // Allow sort
		$this->fields['Phone'] = &$this->Phone;

		// Discount
		$this->Discount = new cField('orders', 'orders', 'x_Discount', 'Discount', '`Discount`', '`Discount`', 5, -1, FALSE, '`Discount`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Discount->Sortable = TRUE; // Allow sort
		$this->Discount->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['Discount'] = &$this->Discount;

		// TotalPrice
		$this->TotalPrice = new cField('orders', 'orders', 'x_TotalPrice', 'TotalPrice', '`TotalPrice`', '`TotalPrice`', 5, -1, FALSE, '`TotalPrice`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->TotalPrice->Sortable = TRUE; // Allow sort
		$this->TotalPrice->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['TotalPrice'] = &$this->TotalPrice;

		// PaymentTypeID
		$this->PaymentTypeID = new cField('orders', 'orders', 'x_PaymentTypeID', 'PaymentTypeID', '`PaymentTypeID`', '`PaymentTypeID`', 3, -1, FALSE, '`PaymentTypeID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->PaymentTypeID->Sortable = TRUE; // Allow sort
		$this->PaymentTypeID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->PaymentTypeID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->PaymentTypeID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['PaymentTypeID'] = &$this->PaymentTypeID;

		// DeliveryTypeID
		$this->DeliveryTypeID = new cField('orders', 'orders', 'x_DeliveryTypeID', 'DeliveryTypeID', '`DeliveryTypeID`', '`DeliveryTypeID`', 3, -1, FALSE, '`DeliveryTypeID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->DeliveryTypeID->Sortable = TRUE; // Allow sort
		$this->DeliveryTypeID->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->DeliveryTypeID->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->DeliveryTypeID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['DeliveryTypeID'] = &$this->DeliveryTypeID;

		// Description
		$this->Description = new cField('orders', 'orders', 'x_Description', 'Description', '`Description`', '`Description`', 201, -1, FALSE, '`Description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->Description->Sortable = TRUE; // Allow sort
		$this->fields['Description'] = &$this->Description;

		// FeedBack
		$this->FeedBack = new cField('orders', 'orders', 'x_FeedBack', 'FeedBack', '`FeedBack`', '`FeedBack`', 201, -1, FALSE, '`FeedBack`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->FeedBack->Sortable = TRUE; // Allow sort
		$this->fields['FeedBack'] = &$this->FeedBack;

		// OrderDateTime
		$this->OrderDateTime = new cField('orders', 'orders', 'x_OrderDateTime', 'OrderDateTime', '`OrderDateTime`', ew_CastDateFieldForLike('`OrderDateTime`', 0, "DB"), 135, 0, FALSE, '`OrderDateTime`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->OrderDateTime->Sortable = TRUE; // Allow sort
		$this->OrderDateTime->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['OrderDateTime'] = &$this->OrderDateTime;
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
		if ($this->getCurrentDetailTable() == "orderdetails") {
			$sDetailUrl = $GLOBALS["orderdetails"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_OrderID=" . urlencode($this->OrderID->CurrentValue);
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
			$this->OrderID->setDbValue($conn->Insert_ID());
			$rs['OrderID'] = $this->OrderID->DbValue;
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
			if (array_key_exists('OrderID', $rs))
				ew_AddFilter($where, ew_QuotedName('OrderID', $this->DBID) . '=' . ew_QuotedValue($rs['OrderID'], $this->OrderID->FldDataType, $this->DBID));
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
		return "`OrderID` = @OrderID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->OrderID->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->OrderID->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@OrderID@", ew_AdjustSql($this->OrderID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
		$json .= "OrderID:" . ew_VarToJson($this->OrderID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->OrderID->CurrentValue)) {
			$sUrl .= "OrderID=" . urlencode($this->OrderID->CurrentValue);
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
			if ($isPost && isset($_POST["OrderID"]))
				$arKeys[] = $_POST["OrderID"];
			elseif (isset($_GET["OrderID"]))
				$arKeys[] = $_GET["OrderID"];
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
			$this->OrderID->CurrentValue = $key;
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
		$this->OrderID->setDbValue($rs->fields('OrderID'));
		$this->CustomerID->setDbValue($rs->fields('CustomerID'));
		$this->FullName->setDbValue($rs->fields('FullName'));
		$this->ProvinceID->setDbValue($rs->fields('ProvinceID'));
		$this->Address->setDbValue($rs->fields('Address'));
		$this->ZipCode->setDbValue($rs->fields('ZipCode'));
		$this->Phone->setDbValue($rs->fields('Phone'));
		$this->Discount->setDbValue($rs->fields('Discount'));
		$this->TotalPrice->setDbValue($rs->fields('TotalPrice'));
		$this->PaymentTypeID->setDbValue($rs->fields('PaymentTypeID'));
		$this->DeliveryTypeID->setDbValue($rs->fields('DeliveryTypeID'));
		$this->Description->setDbValue($rs->fields('Description'));
		$this->FeedBack->setDbValue($rs->fields('FeedBack'));
		$this->OrderDateTime->setDbValue($rs->fields('OrderDateTime'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// OrderID
		// CustomerID
		// FullName
		// ProvinceID
		// Address
		// ZipCode
		// Phone
		// Discount
		// TotalPrice
		// PaymentTypeID
		// DeliveryTypeID
		// Description
		// FeedBack
		// OrderDateTime
		// OrderID

		$this->OrderID->ViewValue = $this->OrderID->CurrentValue;
		$this->OrderID->ViewCustomAttributes = "";

		// CustomerID
		if (strval($this->CustomerID->CurrentValue) <> "") {
			$sFilterWrk = "`CustomerID`" . ew_SearchString("=", $this->CustomerID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `CustomerID`, `FullName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `customers`";
		$sWhereWrk = "";
		$this->CustomerID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->CustomerID, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `FullName`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->CustomerID->ViewValue = $this->CustomerID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->CustomerID->ViewValue = $this->CustomerID->CurrentValue;
			}
		} else {
			$this->CustomerID->ViewValue = NULL;
		}
		$this->CustomerID->ViewCustomAttributes = "";

		// FullName
		$this->FullName->ViewValue = $this->FullName->CurrentValue;
		$this->FullName->ViewCustomAttributes = "";

		// ProvinceID
		if (strval($this->ProvinceID->CurrentValue) <> "") {
			$sFilterWrk = "`ProvinceID`" . ew_SearchString("=", $this->ProvinceID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `ProvinceID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provinces`";
		$sWhereWrk = "";
		$this->ProvinceID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->ProvinceID, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->ProvinceID->ViewValue = $this->ProvinceID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->ProvinceID->ViewValue = $this->ProvinceID->CurrentValue;
			}
		} else {
			$this->ProvinceID->ViewValue = NULL;
		}
		$this->ProvinceID->ViewCustomAttributes = "";

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

		// ZipCode
		$this->ZipCode->ViewValue = $this->ZipCode->CurrentValue;
		$this->ZipCode->ViewCustomAttributes = "";

		// Phone
		$this->Phone->ViewValue = $this->Phone->CurrentValue;
		$this->Phone->ViewCustomAttributes = "";

		// Discount
		$this->Discount->ViewValue = $this->Discount->CurrentValue;
		$this->Discount->ViewCustomAttributes = "";

		// TotalPrice
		$this->TotalPrice->ViewValue = $this->TotalPrice->CurrentValue;
		$this->TotalPrice->ViewValue = ew_FormatCurrency($this->TotalPrice->ViewValue, 0, -2, -2, -2);
		$this->TotalPrice->ViewCustomAttributes = "";

		// PaymentTypeID
		if (strval($this->PaymentTypeID->CurrentValue) <> "") {
			$sFilterWrk = "`PaymentTypeID`" . ew_SearchString("=", $this->PaymentTypeID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `PaymentTypeID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `paymenttypes`";
		$sWhereWrk = "";
		$this->PaymentTypeID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->PaymentTypeID, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->PaymentTypeID->ViewValue = $this->PaymentTypeID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->PaymentTypeID->ViewValue = $this->PaymentTypeID->CurrentValue;
			}
		} else {
			$this->PaymentTypeID->ViewValue = NULL;
		}
		$this->PaymentTypeID->ViewCustomAttributes = "";

		// DeliveryTypeID
		if (strval($this->DeliveryTypeID->CurrentValue) <> "") {
			$sFilterWrk = "`DeliveryTypeID`" . ew_SearchString("=", $this->DeliveryTypeID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `DeliveryTypeID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `deliverytypes`";
		$sWhereWrk = "";
		$this->DeliveryTypeID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->DeliveryTypeID, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->DeliveryTypeID->ViewValue = $this->DeliveryTypeID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->DeliveryTypeID->ViewValue = $this->DeliveryTypeID->CurrentValue;
			}
		} else {
			$this->DeliveryTypeID->ViewValue = NULL;
		}
		$this->DeliveryTypeID->ViewCustomAttributes = "";

		// Description
		$this->Description->ViewValue = $this->Description->CurrentValue;
		$this->Description->ViewCustomAttributes = "";

		// FeedBack
		$this->FeedBack->ViewValue = $this->FeedBack->CurrentValue;
		$this->FeedBack->ViewCustomAttributes = "";

		// OrderDateTime
		$this->OrderDateTime->ViewValue = $this->OrderDateTime->CurrentValue;
		$this->OrderDateTime->ViewValue = ew_FormatDateTime($this->OrderDateTime->ViewValue, 0);
		$this->OrderDateTime->ViewCustomAttributes = "";

		// OrderID
		$this->OrderID->LinkCustomAttributes = "";
		$this->OrderID->HrefValue = "";
		$this->OrderID->TooltipValue = "";

		// CustomerID
		$this->CustomerID->LinkCustomAttributes = "";
		$this->CustomerID->HrefValue = "";
		$this->CustomerID->TooltipValue = "";

		// FullName
		$this->FullName->LinkCustomAttributes = "";
		$this->FullName->HrefValue = "";
		$this->FullName->TooltipValue = "";

		// ProvinceID
		$this->ProvinceID->LinkCustomAttributes = "";
		$this->ProvinceID->HrefValue = "";
		$this->ProvinceID->TooltipValue = "";

		// Address
		$this->Address->LinkCustomAttributes = "";
		$this->Address->HrefValue = "";
		$this->Address->TooltipValue = "";

		// ZipCode
		$this->ZipCode->LinkCustomAttributes = "";
		$this->ZipCode->HrefValue = "";
		$this->ZipCode->TooltipValue = "";

		// Phone
		$this->Phone->LinkCustomAttributes = "";
		$this->Phone->HrefValue = "";
		$this->Phone->TooltipValue = "";

		// Discount
		$this->Discount->LinkCustomAttributes = "";
		$this->Discount->HrefValue = "";
		$this->Discount->TooltipValue = "";

		// TotalPrice
		$this->TotalPrice->LinkCustomAttributes = "";
		$this->TotalPrice->HrefValue = "";
		$this->TotalPrice->TooltipValue = "";

		// PaymentTypeID
		$this->PaymentTypeID->LinkCustomAttributes = "";
		$this->PaymentTypeID->HrefValue = "";
		$this->PaymentTypeID->TooltipValue = "";

		// DeliveryTypeID
		$this->DeliveryTypeID->LinkCustomAttributes = "";
		$this->DeliveryTypeID->HrefValue = "";
		$this->DeliveryTypeID->TooltipValue = "";

		// Description
		$this->Description->LinkCustomAttributes = "";
		$this->Description->HrefValue = "";
		$this->Description->TooltipValue = "";

		// FeedBack
		$this->FeedBack->LinkCustomAttributes = "";
		$this->FeedBack->HrefValue = "";
		$this->FeedBack->TooltipValue = "";

		// OrderDateTime
		$this->OrderDateTime->LinkCustomAttributes = "";
		$this->OrderDateTime->HrefValue = "";
		$this->OrderDateTime->TooltipValue = "";

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

		// OrderID
		$this->OrderID->EditAttrs["class"] = "form-control";
		$this->OrderID->EditCustomAttributes = "";
		$this->OrderID->EditValue = $this->OrderID->CurrentValue;
		$this->OrderID->ViewCustomAttributes = "";

		// CustomerID
		$this->CustomerID->EditAttrs["class"] = "form-control";
		$this->CustomerID->EditCustomAttributes = "";

		// FullName
		$this->FullName->EditAttrs["class"] = "form-control";
		$this->FullName->EditCustomAttributes = "";
		$this->FullName->EditValue = $this->FullName->CurrentValue;
		$this->FullName->PlaceHolder = ew_RemoveHtml($this->FullName->FldCaption());

		// ProvinceID
		$this->ProvinceID->EditAttrs["class"] = "form-control";
		$this->ProvinceID->EditCustomAttributes = "";

		// Address
		$this->Address->EditAttrs["class"] = "form-control";
		$this->Address->EditCustomAttributes = "";
		$this->Address->EditValue = $this->Address->CurrentValue;
		$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

		// ZipCode
		$this->ZipCode->EditAttrs["class"] = "form-control";
		$this->ZipCode->EditCustomAttributes = "";
		$this->ZipCode->EditValue = $this->ZipCode->CurrentValue;
		$this->ZipCode->PlaceHolder = ew_RemoveHtml($this->ZipCode->FldCaption());

		// Phone
		$this->Phone->EditAttrs["class"] = "form-control";
		$this->Phone->EditCustomAttributes = "";
		$this->Phone->EditValue = $this->Phone->CurrentValue;
		$this->Phone->PlaceHolder = ew_RemoveHtml($this->Phone->FldCaption());

		// Discount
		$this->Discount->EditAttrs["class"] = "form-control";
		$this->Discount->EditCustomAttributes = "";
		$this->Discount->EditValue = $this->Discount->CurrentValue;
		$this->Discount->PlaceHolder = ew_RemoveHtml($this->Discount->FldCaption());
		if (strval($this->Discount->EditValue) <> "" && is_numeric($this->Discount->EditValue)) $this->Discount->EditValue = ew_FormatNumber($this->Discount->EditValue, -2, -1, -2, 0);

		// TotalPrice
		$this->TotalPrice->EditAttrs["class"] = "form-control";
		$this->TotalPrice->EditCustomAttributes = "";
		$this->TotalPrice->EditValue = $this->TotalPrice->CurrentValue;
		$this->TotalPrice->PlaceHolder = ew_RemoveHtml($this->TotalPrice->FldCaption());
		if (strval($this->TotalPrice->EditValue) <> "" && is_numeric($this->TotalPrice->EditValue)) $this->TotalPrice->EditValue = ew_FormatNumber($this->TotalPrice->EditValue, -2, -2, -2, -2);

		// PaymentTypeID
		$this->PaymentTypeID->EditAttrs["class"] = "form-control";
		$this->PaymentTypeID->EditCustomAttributes = "";

		// DeliveryTypeID
		$this->DeliveryTypeID->EditAttrs["class"] = "form-control";
		$this->DeliveryTypeID->EditCustomAttributes = "";

		// Description
		$this->Description->EditAttrs["class"] = "form-control";
		$this->Description->EditCustomAttributes = "";
		$this->Description->EditValue = $this->Description->CurrentValue;
		$this->Description->PlaceHolder = ew_RemoveHtml($this->Description->FldCaption());

		// FeedBack
		$this->FeedBack->EditAttrs["class"] = "form-control";
		$this->FeedBack->EditCustomAttributes = "";
		$this->FeedBack->EditValue = $this->FeedBack->CurrentValue;
		$this->FeedBack->PlaceHolder = ew_RemoveHtml($this->FeedBack->FldCaption());

		// OrderDateTime
		// Call Row Rendered event

		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
			if (is_numeric($this->TotalPrice->CurrentValue))
				$this->TotalPrice->Total += $this->TotalPrice->CurrentValue; // Accumulate total
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
			$this->TotalPrice->CurrentValue = $this->TotalPrice->Total;
			$this->TotalPrice->ViewValue = $this->TotalPrice->CurrentValue;
			$this->TotalPrice->ViewValue = ew_FormatCurrency($this->TotalPrice->ViewValue, 0, -2, -2, -2);
			$this->TotalPrice->ViewCustomAttributes = "";
			$this->TotalPrice->HrefValue = ""; // Clear href value

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
					if ($this->OrderID->Exportable) $Doc->ExportCaption($this->OrderID);
					if ($this->CustomerID->Exportable) $Doc->ExportCaption($this->CustomerID);
					if ($this->FullName->Exportable) $Doc->ExportCaption($this->FullName);
					if ($this->ProvinceID->Exportable) $Doc->ExportCaption($this->ProvinceID);
					if ($this->Address->Exportable) $Doc->ExportCaption($this->Address);
					if ($this->ZipCode->Exportable) $Doc->ExportCaption($this->ZipCode);
					if ($this->Phone->Exportable) $Doc->ExportCaption($this->Phone);
					if ($this->Discount->Exportable) $Doc->ExportCaption($this->Discount);
					if ($this->TotalPrice->Exportable) $Doc->ExportCaption($this->TotalPrice);
					if ($this->PaymentTypeID->Exportable) $Doc->ExportCaption($this->PaymentTypeID);
					if ($this->DeliveryTypeID->Exportable) $Doc->ExportCaption($this->DeliveryTypeID);
					if ($this->Description->Exportable) $Doc->ExportCaption($this->Description);
					if ($this->FeedBack->Exportable) $Doc->ExportCaption($this->FeedBack);
					if ($this->OrderDateTime->Exportable) $Doc->ExportCaption($this->OrderDateTime);
				} else {
					if ($this->OrderID->Exportable) $Doc->ExportCaption($this->OrderID);
					if ($this->CustomerID->Exportable) $Doc->ExportCaption($this->CustomerID);
					if ($this->FullName->Exportable) $Doc->ExportCaption($this->FullName);
					if ($this->ProvinceID->Exportable) $Doc->ExportCaption($this->ProvinceID);
					if ($this->ZipCode->Exportable) $Doc->ExportCaption($this->ZipCode);
					if ($this->Phone->Exportable) $Doc->ExportCaption($this->Phone);
					if ($this->Discount->Exportable) $Doc->ExportCaption($this->Discount);
					if ($this->TotalPrice->Exportable) $Doc->ExportCaption($this->TotalPrice);
					if ($this->PaymentTypeID->Exportable) $Doc->ExportCaption($this->PaymentTypeID);
					if ($this->DeliveryTypeID->Exportable) $Doc->ExportCaption($this->DeliveryTypeID);
					if ($this->OrderDateTime->Exportable) $Doc->ExportCaption($this->OrderDateTime);
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
						if ($this->OrderID->Exportable) $Doc->ExportField($this->OrderID);
						if ($this->CustomerID->Exportable) $Doc->ExportField($this->CustomerID);
						if ($this->FullName->Exportable) $Doc->ExportField($this->FullName);
						if ($this->ProvinceID->Exportable) $Doc->ExportField($this->ProvinceID);
						if ($this->Address->Exportable) $Doc->ExportField($this->Address);
						if ($this->ZipCode->Exportable) $Doc->ExportField($this->ZipCode);
						if ($this->Phone->Exportable) $Doc->ExportField($this->Phone);
						if ($this->Discount->Exportable) $Doc->ExportField($this->Discount);
						if ($this->TotalPrice->Exportable) $Doc->ExportField($this->TotalPrice);
						if ($this->PaymentTypeID->Exportable) $Doc->ExportField($this->PaymentTypeID);
						if ($this->DeliveryTypeID->Exportable) $Doc->ExportField($this->DeliveryTypeID);
						if ($this->Description->Exportable) $Doc->ExportField($this->Description);
						if ($this->FeedBack->Exportable) $Doc->ExportField($this->FeedBack);
						if ($this->OrderDateTime->Exportable) $Doc->ExportField($this->OrderDateTime);
					} else {
						if ($this->OrderID->Exportable) $Doc->ExportField($this->OrderID);
						if ($this->CustomerID->Exportable) $Doc->ExportField($this->CustomerID);
						if ($this->FullName->Exportable) $Doc->ExportField($this->FullName);
						if ($this->ProvinceID->Exportable) $Doc->ExportField($this->ProvinceID);
						if ($this->ZipCode->Exportable) $Doc->ExportField($this->ZipCode);
						if ($this->Phone->Exportable) $Doc->ExportField($this->Phone);
						if ($this->Discount->Exportable) $Doc->ExportField($this->Discount);
						if ($this->TotalPrice->Exportable) $Doc->ExportField($this->TotalPrice);
						if ($this->PaymentTypeID->Exportable) $Doc->ExportField($this->PaymentTypeID);
						if ($this->DeliveryTypeID->Exportable) $Doc->ExportField($this->DeliveryTypeID);
						if ($this->OrderDateTime->Exportable) $Doc->ExportField($this->OrderDateTime);
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
				if ($this->OrderID->Exportable) $Doc->ExportAggregate($this->OrderID, '');
				if ($this->CustomerID->Exportable) $Doc->ExportAggregate($this->CustomerID, '');
				if ($this->FullName->Exportable) $Doc->ExportAggregate($this->FullName, '');
				if ($this->ProvinceID->Exportable) $Doc->ExportAggregate($this->ProvinceID, '');
				if ($this->ZipCode->Exportable) $Doc->ExportAggregate($this->ZipCode, '');
				if ($this->Phone->Exportable) $Doc->ExportAggregate($this->Phone, '');
				if ($this->Discount->Exportable) $Doc->ExportAggregate($this->Discount, '');
				if ($this->TotalPrice->Exportable) $Doc->ExportAggregate($this->TotalPrice, 'TOTAL');
				if ($this->PaymentTypeID->Exportable) $Doc->ExportAggregate($this->PaymentTypeID, '');
				if ($this->DeliveryTypeID->Exportable) $Doc->ExportAggregate($this->DeliveryTypeID, '');
				if ($this->OrderDateTime->Exportable) $Doc->ExportAggregate($this->OrderDateTime, '');
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
