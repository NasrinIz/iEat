<?php

// Global variable for table object
$timings = NULL;

//
// Table class for timings
//
class ctimings extends cTable {
	var $store_id;
	var $day_of_the_week;
	var $order_time_from;
	var $order_time_to;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'timings';
		$this->TableName = 'timings';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`timings`";
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

		// store_id
		$this->store_id = new cField('timings', 'timings', 'x_store_id', 'store_id', '`store_id`', '`store_id`', 3, -1, FALSE, '`store_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->store_id->Sortable = FALSE; // Allow sort
		$this->store_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->store_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->store_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['store_id'] = &$this->store_id;

		// day_of_the_week
		$this->day_of_the_week = new cField('timings', 'timings', 'x_day_of_the_week', 'day_of_the_week', '`day_of_the_week`', '`day_of_the_week`', 3, -1, FALSE, '`day_of_the_week`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->day_of_the_week->Sortable = TRUE; // Allow sort
		$this->day_of_the_week->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->day_of_the_week->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->day_of_the_week->OptionCount = 7;
		$this->day_of_the_week->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['day_of_the_week'] = &$this->day_of_the_week;

		// order_time_from
		$this->order_time_from = new cField('timings', 'timings', 'x_order_time_from', 'order_time_from', '`order_time_from`', ew_CastDateFieldForLike('`order_time_from`', 4, "DB"), 134, 4, FALSE, '`order_time_from`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->order_time_from->Sortable = TRUE; // Allow sort
		$this->order_time_from->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['order_time_from'] = &$this->order_time_from;

		// order_time_to
		$this->order_time_to = new cField('timings', 'timings', 'x_order_time_to', 'order_time_to', '`order_time_to`', ew_CastDateFieldForLike('`order_time_to`', 4, "DB"), 134, 4, FALSE, '`order_time_to`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->order_time_to->Sortable = TRUE; // Allow sort
		$this->order_time_to->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_TIME_SEPARATOR"], $Language->Phrase("IncorrectTime"));
		$this->fields['order_time_to'] = &$this->order_time_to;
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`timings`";
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
			if (array_key_exists('store_id', $rs))
				ew_AddFilter($where, ew_QuotedName('store_id', $this->DBID) . '=' . ew_QuotedValue($rs['store_id'], $this->store_id->FldDataType, $this->DBID));
			if (array_key_exists('day_of_the_week', $rs))
				ew_AddFilter($where, ew_QuotedName('day_of_the_week', $this->DBID) . '=' . ew_QuotedValue($rs['day_of_the_week'], $this->day_of_the_week->FldDataType, $this->DBID));
			if (array_key_exists('order_time_from', $rs))
				ew_AddFilter($where, ew_QuotedName('order_time_from', $this->DBID) . '=' . ew_QuotedValue($rs['order_time_from'], $this->order_time_from->FldDataType, $this->DBID));
			if (array_key_exists('order_time_to', $rs))
				ew_AddFilter($where, ew_QuotedName('order_time_to', $this->DBID) . '=' . ew_QuotedValue($rs['order_time_to'], $this->order_time_to->FldDataType, $this->DBID));
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
		return "`store_id` = @store_id@ AND `day_of_the_week` = @day_of_the_week@ AND `order_time_from` = '@order_time_from@' AND `order_time_to` = '@order_time_to@'";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->store_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->store_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@store_id@", ew_AdjustSql($this->store_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (!is_numeric($this->day_of_the_week->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->day_of_the_week->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@day_of_the_week@", ew_AdjustSql($this->day_of_the_week->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (is_null($this->order_time_from->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@order_time_from@", ew_AdjustSql($this->order_time_from->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		if (is_null($this->order_time_to->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@order_time_to@", ew_AdjustSql($this->order_time_to->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "timingslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "timingsview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "timingsedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "timingsadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "timingslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("timingsview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("timingsview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "timingsadd.php?" . $this->UrlParm($parm);
		else
			$url = "timingsadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("timingsedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("timingsadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("timingsdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "store_id:" . ew_VarToJson($this->store_id->CurrentValue, "number", "'");
		$json .= ",day_of_the_week:" . ew_VarToJson($this->day_of_the_week->CurrentValue, "number", "'");
		$json .= ",order_time_from:" . ew_VarToJson($this->order_time_from->CurrentValue, "string", "'");
		$json .= ",order_time_to:" . ew_VarToJson($this->order_time_to->CurrentValue, "string", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->store_id->CurrentValue)) {
			$sUrl .= "store_id=" . urlencode($this->store_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->day_of_the_week->CurrentValue)) {
			$sUrl .= "&day_of_the_week=" . urlencode($this->day_of_the_week->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->order_time_from->CurrentValue)) {
			$sUrl .= "&order_time_from=" . urlencode($this->order_time_from->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		if (!is_null($this->order_time_to->CurrentValue)) {
			$sUrl .= "&order_time_to=" . urlencode($this->order_time_to->CurrentValue);
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
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
			for ($i = 0; $i < $cnt; $i++)
				$arKeys[$i] = explode($EW_COMPOSITE_KEY_SEPARATOR, $arKeys[$i]);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["store_id"]))
				$arKey[] = $_POST["store_id"];
			elseif (isset($_GET["store_id"]))
				$arKey[] = $_GET["store_id"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["day_of_the_week"]))
				$arKey[] = $_POST["day_of_the_week"];
			elseif (isset($_GET["day_of_the_week"]))
				$arKey[] = $_GET["day_of_the_week"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["order_time_from"]))
				$arKey[] = $_POST["order_time_from"];
			elseif (isset($_GET["order_time_from"]))
				$arKey[] = $_GET["order_time_from"];
			else
				$arKeys = NULL; // Do not setup
			if ($isPost && isset($_POST["order_time_to"]))
				$arKey[] = $_POST["order_time_to"];
			elseif (isset($_GET["order_time_to"]))
				$arKey[] = $_GET["order_time_to"];
			else
				$arKeys = NULL; // Do not setup
			if (is_array($arKeys)) $arKeys[] = $arKey;

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_array($key) || count($key) <> 4)
					continue; // Just skip so other keys will still work
				if (!is_numeric($key[0])) // store_id
					continue;
				if (!is_numeric($key[1])) // day_of_the_week
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
			$this->store_id->CurrentValue = $key[0];
			$this->day_of_the_week->CurrentValue = $key[1];
			$this->order_time_from->CurrentValue = $key[2];
			$this->order_time_to->CurrentValue = $key[3];
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
		$this->store_id->setDbValue($rs->fields('store_id'));
		$this->day_of_the_week->setDbValue($rs->fields('day_of_the_week'));
		$this->order_time_from->setDbValue($rs->fields('order_time_from'));
		$this->order_time_to->setDbValue($rs->fields('order_time_to'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// store_id
		// day_of_the_week
		// order_time_from
		// order_time_to
		// store_id

		if (strval($this->store_id->CurrentValue) <> "") {
			$sFilterWrk = "`store_id`" . ew_SearchString("=", $this->store_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `store_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `stores`";
		$sWhereWrk = "";
		$this->store_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->store_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->store_id->ViewValue = $this->store_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->store_id->ViewValue = $this->store_id->CurrentValue;
			}
		} else {
			$this->store_id->ViewValue = NULL;
		}
		$this->store_id->ViewCustomAttributes = "";

		// day_of_the_week
		if (strval($this->day_of_the_week->CurrentValue) <> "") {
			$this->day_of_the_week->ViewValue = $this->day_of_the_week->OptionCaption($this->day_of_the_week->CurrentValue);
		} else {
			$this->day_of_the_week->ViewValue = NULL;
		}
		$this->day_of_the_week->ViewCustomAttributes = "";

		// order_time_from
		$this->order_time_from->ViewValue = $this->order_time_from->CurrentValue;
		$this->order_time_from->ViewValue = ew_FormatDateTime($this->order_time_from->ViewValue, 4);
		$this->order_time_from->ViewCustomAttributes = "";

		// order_time_to
		$this->order_time_to->ViewValue = $this->order_time_to->CurrentValue;
		$this->order_time_to->ViewValue = ew_FormatDateTime($this->order_time_to->ViewValue, 4);
		$this->order_time_to->ViewCustomAttributes = "";

		// store_id
		$this->store_id->LinkCustomAttributes = "";
		$this->store_id->HrefValue = "";
		$this->store_id->TooltipValue = "";

		// day_of_the_week
		$this->day_of_the_week->LinkCustomAttributes = "";
		$this->day_of_the_week->HrefValue = "";
		$this->day_of_the_week->TooltipValue = "";

		// order_time_from
		$this->order_time_from->LinkCustomAttributes = "";
		$this->order_time_from->HrefValue = "";
		$this->order_time_from->TooltipValue = "";

		// order_time_to
		$this->order_time_to->LinkCustomAttributes = "";
		$this->order_time_to->HrefValue = "";
		$this->order_time_to->TooltipValue = "";

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

		// store_id
		$this->store_id->EditAttrs["class"] = "form-control";
		$this->store_id->EditCustomAttributes = "";
		if (strval($this->store_id->CurrentValue) <> "") {
			$sFilterWrk = "`store_id`" . ew_SearchString("=", $this->store_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `store_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `stores`";
		$sWhereWrk = "";
		$this->store_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->store_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->store_id->EditValue = $this->store_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->store_id->EditValue = $this->store_id->CurrentValue;
			}
		} else {
			$this->store_id->EditValue = NULL;
		}
		$this->store_id->ViewCustomAttributes = "";

		// day_of_the_week
		$this->day_of_the_week->EditAttrs["class"] = "form-control";
		$this->day_of_the_week->EditCustomAttributes = "";
		if (strval($this->day_of_the_week->CurrentValue) <> "") {
			$this->day_of_the_week->EditValue = $this->day_of_the_week->OptionCaption($this->day_of_the_week->CurrentValue);
		} else {
			$this->day_of_the_week->EditValue = NULL;
		}
		$this->day_of_the_week->ViewCustomAttributes = "";

		// order_time_from
		$this->order_time_from->EditAttrs["class"] = "form-control";
		$this->order_time_from->EditCustomAttributes = "";
		$this->order_time_from->EditValue = $this->order_time_from->CurrentValue;
		$this->order_time_from->EditValue = ew_FormatDateTime($this->order_time_from->EditValue, 4);
		$this->order_time_from->ViewCustomAttributes = "";

		// order_time_to
		$this->order_time_to->EditAttrs["class"] = "form-control";
		$this->order_time_to->EditCustomAttributes = "";
		$this->order_time_to->EditValue = $this->order_time_to->CurrentValue;
		$this->order_time_to->EditValue = ew_FormatDateTime($this->order_time_to->EditValue, 4);
		$this->order_time_to->ViewCustomAttributes = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

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
					if ($this->store_id->Exportable) $Doc->ExportCaption($this->store_id);
					if ($this->day_of_the_week->Exportable) $Doc->ExportCaption($this->day_of_the_week);
					if ($this->order_time_from->Exportable) $Doc->ExportCaption($this->order_time_from);
					if ($this->order_time_to->Exportable) $Doc->ExportCaption($this->order_time_to);
				} else {
					if ($this->day_of_the_week->Exportable) $Doc->ExportCaption($this->day_of_the_week);
					if ($this->order_time_from->Exportable) $Doc->ExportCaption($this->order_time_from);
					if ($this->order_time_to->Exportable) $Doc->ExportCaption($this->order_time_to);
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

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->store_id->Exportable) $Doc->ExportField($this->store_id);
						if ($this->day_of_the_week->Exportable) $Doc->ExportField($this->day_of_the_week);
						if ($this->order_time_from->Exportable) $Doc->ExportField($this->order_time_from);
						if ($this->order_time_to->Exportable) $Doc->ExportField($this->order_time_to);
					} else {
						if ($this->day_of_the_week->Exportable) $Doc->ExportField($this->day_of_the_week);
						if ($this->order_time_from->Exportable) $Doc->ExportField($this->order_time_from);
						if ($this->order_time_to->Exportable) $Doc->ExportField($this->order_time_to);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
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
