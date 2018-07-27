<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ordersinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$orders_delete = NULL; // Initialize page object first

class corders_delete extends corders {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (orders)
		if (!isset($GLOBALS["orders"]) || get_class($GLOBALS["orders"]) == "corders") {
			$GLOBALS["orders"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["orders"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'orders', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

		// User table object (employees)
		if (!isset($UserTable)) {
			$UserTable = new cemployees();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("orderslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->order_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->order_id->Visible = FALSE;
		$this->customer_id->SetVisibility();
		$this->full_name->SetVisibility();
		$this->province_id->SetVisibility();
		$this->zip_code->SetVisibility();
		$this->phone->SetVisibility();
		$this->discount->SetVisibility();
		$this->total_price->SetVisibility();
		$this->payment_type_id->SetVisibility();
		$this->delivery_type_id->SetVisibility();
		$this->order_date_time->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $orders;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($orders);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		// Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("orderslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in orders class, ordersinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("orderslist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->order_id->setDbValue($row['order_id']);
		$this->customer_id->setDbValue($row['customer_id']);
		$this->full_name->setDbValue($row['full_name']);
		$this->province_id->setDbValue($row['province_id']);
		$this->address->setDbValue($row['address']);
		$this->zip_code->setDbValue($row['zip_code']);
		$this->phone->setDbValue($row['phone']);
		$this->discount->setDbValue($row['discount']);
		$this->total_price->setDbValue($row['total_price']);
		$this->payment_type_id->setDbValue($row['payment_type_id']);
		$this->delivery_type_id->setDbValue($row['delivery_type_id']);
		$this->description->setDbValue($row['description']);
		$this->feedback->setDbValue($row['feedback']);
		$this->order_date_time->setDbValue($row['order_date_time']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['order_id'] = NULL;
		$row['customer_id'] = NULL;
		$row['full_name'] = NULL;
		$row['province_id'] = NULL;
		$row['address'] = NULL;
		$row['zip_code'] = NULL;
		$row['phone'] = NULL;
		$row['discount'] = NULL;
		$row['total_price'] = NULL;
		$row['payment_type_id'] = NULL;
		$row['delivery_type_id'] = NULL;
		$row['description'] = NULL;
		$row['feedback'] = NULL;
		$row['order_date_time'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->order_id->DbValue = $row['order_id'];
		$this->customer_id->DbValue = $row['customer_id'];
		$this->full_name->DbValue = $row['full_name'];
		$this->province_id->DbValue = $row['province_id'];
		$this->address->DbValue = $row['address'];
		$this->zip_code->DbValue = $row['zip_code'];
		$this->phone->DbValue = $row['phone'];
		$this->discount->DbValue = $row['discount'];
		$this->total_price->DbValue = $row['total_price'];
		$this->payment_type_id->DbValue = $row['payment_type_id'];
		$this->delivery_type_id->DbValue = $row['delivery_type_id'];
		$this->description->DbValue = $row['description'];
		$this->feedback->DbValue = $row['feedback'];
		$this->order_date_time->DbValue = $row['order_date_time'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->discount->FormValue == $this->discount->CurrentValue && is_numeric(ew_StrToFloat($this->discount->CurrentValue)))
			$this->discount->CurrentValue = ew_StrToFloat($this->discount->CurrentValue);

		// Convert decimal values if posted back
		if ($this->total_price->FormValue == $this->total_price->CurrentValue && is_numeric(ew_StrToFloat($this->total_price->CurrentValue)))
			$this->total_price->CurrentValue = ew_StrToFloat($this->total_price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// order_date_time
			$this->order_date_time->LinkCustomAttributes = "";
			$this->order_date_time->HrefValue = "";
			$this->order_date_time->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['order_id'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("orderslist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($orders_delete)) $orders_delete = new corders_delete();

// Page init
$orders_delete->Page_Init();

// Page main
$orders_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fordersdelete = new ew_Form("fordersdelete", "delete");

// Form_CustomValidate event
fordersdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fordersdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fordersdelete.Lists["x_customer_id"] = {"LinkField":"x_customer_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_full_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
fordersdelete.Lists["x_customer_id"].Data = "<?php echo $orders_delete->customer_id->LookupFilterQuery(FALSE, "delete") ?>";
fordersdelete.Lists["x_province_id"] = {"LinkField":"x_province_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
fordersdelete.Lists["x_province_id"].Data = "<?php echo $orders_delete->province_id->LookupFilterQuery(FALSE, "delete") ?>";
fordersdelete.Lists["x_payment_type_id"] = {"LinkField":"x_payment_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"payment_types"};
fordersdelete.Lists["x_payment_type_id"].Data = "<?php echo $orders_delete->payment_type_id->LookupFilterQuery(FALSE, "delete") ?>";
fordersdelete.Lists["x_delivery_type_id"] = {"LinkField":"x_delivery_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"delivery_types"};
fordersdelete.Lists["x_delivery_type_id"].Data = "<?php echo $orders_delete->delivery_type_id->LookupFilterQuery(FALSE, "delete") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $orders_delete->ShowPageHeader(); ?>
<?php
$orders_delete->ShowMessage();
?>
<form name="fordersdelete" id="fordersdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($orders_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($orders->order_id->Visible) { // order_id ?>
		<th class="<?php echo $orders->order_id->HeaderCellClass() ?>"><span id="elh_orders_order_id" class="orders_order_id"><?php echo $orders->order_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->customer_id->Visible) { // customer_id ?>
		<th class="<?php echo $orders->customer_id->HeaderCellClass() ?>"><span id="elh_orders_customer_id" class="orders_customer_id"><?php echo $orders->customer_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->full_name->Visible) { // full_name ?>
		<th class="<?php echo $orders->full_name->HeaderCellClass() ?>"><span id="elh_orders_full_name" class="orders_full_name"><?php echo $orders->full_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->province_id->Visible) { // province_id ?>
		<th class="<?php echo $orders->province_id->HeaderCellClass() ?>"><span id="elh_orders_province_id" class="orders_province_id"><?php echo $orders->province_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->zip_code->Visible) { // zip_code ?>
		<th class="<?php echo $orders->zip_code->HeaderCellClass() ?>"><span id="elh_orders_zip_code" class="orders_zip_code"><?php echo $orders->zip_code->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->phone->Visible) { // phone ?>
		<th class="<?php echo $orders->phone->HeaderCellClass() ?>"><span id="elh_orders_phone" class="orders_phone"><?php echo $orders->phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->discount->Visible) { // discount ?>
		<th class="<?php echo $orders->discount->HeaderCellClass() ?>"><span id="elh_orders_discount" class="orders_discount"><?php echo $orders->discount->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->total_price->Visible) { // total_price ?>
		<th class="<?php echo $orders->total_price->HeaderCellClass() ?>"><span id="elh_orders_total_price" class="orders_total_price"><?php echo $orders->total_price->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
		<th class="<?php echo $orders->payment_type_id->HeaderCellClass() ?>"><span id="elh_orders_payment_type_id" class="orders_payment_type_id"><?php echo $orders->payment_type_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
		<th class="<?php echo $orders->delivery_type_id->HeaderCellClass() ?>"><span id="elh_orders_delivery_type_id" class="orders_delivery_type_id"><?php echo $orders->delivery_type_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
		<th class="<?php echo $orders->order_date_time->HeaderCellClass() ?>"><span id="elh_orders_order_date_time" class="orders_order_date_time"><?php echo $orders->order_date_time->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$orders_delete->RecCnt = 0;
$i = 0;
while (!$orders_delete->Recordset->EOF) {
	$orders_delete->RecCnt++;
	$orders_delete->RowCnt++;

	// Set row properties
	$orders->ResetAttrs();
	$orders->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$orders_delete->LoadRowValues($orders_delete->Recordset);

	// Render row
	$orders_delete->RenderRow();
?>
	<tr<?php echo $orders->RowAttributes() ?>>
<?php if ($orders->order_id->Visible) { // order_id ?>
		<td<?php echo $orders->order_id->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_order_id" class="orders_order_id">
<span<?php echo $orders->order_id->ViewAttributes() ?>>
<?php echo $orders->order_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->customer_id->Visible) { // customer_id ?>
		<td<?php echo $orders->customer_id->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_customer_id" class="orders_customer_id">
<span<?php echo $orders->customer_id->ViewAttributes() ?>>
<?php echo $orders->customer_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->full_name->Visible) { // full_name ?>
		<td<?php echo $orders->full_name->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_full_name" class="orders_full_name">
<span<?php echo $orders->full_name->ViewAttributes() ?>>
<?php echo $orders->full_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->province_id->Visible) { // province_id ?>
		<td<?php echo $orders->province_id->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_province_id" class="orders_province_id">
<span<?php echo $orders->province_id->ViewAttributes() ?>>
<?php echo $orders->province_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->zip_code->Visible) { // zip_code ?>
		<td<?php echo $orders->zip_code->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_zip_code" class="orders_zip_code">
<span<?php echo $orders->zip_code->ViewAttributes() ?>>
<?php echo $orders->zip_code->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->phone->Visible) { // phone ?>
		<td<?php echo $orders->phone->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_phone" class="orders_phone">
<span<?php echo $orders->phone->ViewAttributes() ?>>
<?php echo $orders->phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->discount->Visible) { // discount ?>
		<td<?php echo $orders->discount->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_discount" class="orders_discount">
<span<?php echo $orders->discount->ViewAttributes() ?>>
<?php echo $orders->discount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->total_price->Visible) { // total_price ?>
		<td<?php echo $orders->total_price->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_total_price" class="orders_total_price">
<span<?php echo $orders->total_price->ViewAttributes() ?>>
<?php echo $orders->total_price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
		<td<?php echo $orders->payment_type_id->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_payment_type_id" class="orders_payment_type_id">
<span<?php echo $orders->payment_type_id->ViewAttributes() ?>>
<?php echo $orders->payment_type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
		<td<?php echo $orders->delivery_type_id->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_delivery_type_id" class="orders_delivery_type_id">
<span<?php echo $orders->delivery_type_id->ViewAttributes() ?>>
<?php echo $orders->delivery_type_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
		<td<?php echo $orders->order_date_time->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_order_date_time" class="orders_order_date_time">
<span<?php echo $orders->order_date_time->ViewAttributes() ?>>
<?php echo $orders->order_date_time->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$orders_delete->Recordset->MoveNext();
}
$orders_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $orders_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fordersdelete.Init();
</script>
<?php
$orders_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$orders_delete->Page_Terminate();
?>
