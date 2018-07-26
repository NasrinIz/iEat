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
		$this->OrderID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->OrderID->Visible = FALSE;
		$this->CustomerID->SetVisibility();
		$this->FullName->SetVisibility();
		$this->ProvinceID->SetVisibility();
		$this->ZipCode->SetVisibility();
		$this->Phone->SetVisibility();
		$this->Discount->SetVisibility();
		$this->TotalPrice->SetVisibility();
		$this->PaymentTypeID->SetVisibility();
		$this->DeliveryTypeID->SetVisibility();
		$this->OrderDateTime->SetVisibility();

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
		$this->OrderID->setDbValue($row['OrderID']);
		$this->CustomerID->setDbValue($row['CustomerID']);
		$this->FullName->setDbValue($row['FullName']);
		$this->ProvinceID->setDbValue($row['ProvinceID']);
		$this->Address->setDbValue($row['Address']);
		$this->ZipCode->setDbValue($row['ZipCode']);
		$this->Phone->setDbValue($row['Phone']);
		$this->Discount->setDbValue($row['Discount']);
		$this->TotalPrice->setDbValue($row['TotalPrice']);
		$this->PaymentTypeID->setDbValue($row['PaymentTypeID']);
		$this->DeliveryTypeID->setDbValue($row['DeliveryTypeID']);
		$this->Description->setDbValue($row['Description']);
		$this->FeedBack->setDbValue($row['FeedBack']);
		$this->OrderDateTime->setDbValue($row['OrderDateTime']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['OrderID'] = NULL;
		$row['CustomerID'] = NULL;
		$row['FullName'] = NULL;
		$row['ProvinceID'] = NULL;
		$row['Address'] = NULL;
		$row['ZipCode'] = NULL;
		$row['Phone'] = NULL;
		$row['Discount'] = NULL;
		$row['TotalPrice'] = NULL;
		$row['PaymentTypeID'] = NULL;
		$row['DeliveryTypeID'] = NULL;
		$row['Description'] = NULL;
		$row['FeedBack'] = NULL;
		$row['OrderDateTime'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->OrderID->DbValue = $row['OrderID'];
		$this->CustomerID->DbValue = $row['CustomerID'];
		$this->FullName->DbValue = $row['FullName'];
		$this->ProvinceID->DbValue = $row['ProvinceID'];
		$this->Address->DbValue = $row['Address'];
		$this->ZipCode->DbValue = $row['ZipCode'];
		$this->Phone->DbValue = $row['Phone'];
		$this->Discount->DbValue = $row['Discount'];
		$this->TotalPrice->DbValue = $row['TotalPrice'];
		$this->PaymentTypeID->DbValue = $row['PaymentTypeID'];
		$this->DeliveryTypeID->DbValue = $row['DeliveryTypeID'];
		$this->Description->DbValue = $row['Description'];
		$this->FeedBack->DbValue = $row['FeedBack'];
		$this->OrderDateTime->DbValue = $row['OrderDateTime'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->Discount->FormValue == $this->Discount->CurrentValue && is_numeric(ew_StrToFloat($this->Discount->CurrentValue)))
			$this->Discount->CurrentValue = ew_StrToFloat($this->Discount->CurrentValue);

		// Convert decimal values if posted back
		if ($this->TotalPrice->FormValue == $this->TotalPrice->CurrentValue && is_numeric(ew_StrToFloat($this->TotalPrice->CurrentValue)))
			$this->TotalPrice->CurrentValue = ew_StrToFloat($this->TotalPrice->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// OrderDateTime
			$this->OrderDateTime->LinkCustomAttributes = "";
			$this->OrderDateTime->HrefValue = "";
			$this->OrderDateTime->TooltipValue = "";
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
				$sThisKey .= $row['OrderID'];
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
fordersdelete.Lists["x_CustomerID"] = {"LinkField":"x_CustomerID","Ajax":true,"AutoFill":false,"DisplayFields":["x_FullName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
fordersdelete.Lists["x_CustomerID"].Data = "<?php echo $orders_delete->CustomerID->LookupFilterQuery(FALSE, "delete") ?>";
fordersdelete.Lists["x_ProvinceID"] = {"LinkField":"x_ProvinceID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
fordersdelete.Lists["x_ProvinceID"].Data = "<?php echo $orders_delete->ProvinceID->LookupFilterQuery(FALSE, "delete") ?>";
fordersdelete.Lists["x_PaymentTypeID"] = {"LinkField":"x_PaymentTypeID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"paymenttypes"};
fordersdelete.Lists["x_PaymentTypeID"].Data = "<?php echo $orders_delete->PaymentTypeID->LookupFilterQuery(FALSE, "delete") ?>";
fordersdelete.Lists["x_DeliveryTypeID"] = {"LinkField":"x_DeliveryTypeID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"deliverytypes"};
fordersdelete.Lists["x_DeliveryTypeID"].Data = "<?php echo $orders_delete->DeliveryTypeID->LookupFilterQuery(FALSE, "delete") ?>";

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
<?php if ($orders->OrderID->Visible) { // OrderID ?>
		<th class="<?php echo $orders->OrderID->HeaderCellClass() ?>"><span id="elh_orders_OrderID" class="orders_OrderID"><?php echo $orders->OrderID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
		<th class="<?php echo $orders->CustomerID->HeaderCellClass() ?>"><span id="elh_orders_CustomerID" class="orders_CustomerID"><?php echo $orders->CustomerID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->FullName->Visible) { // FullName ?>
		<th class="<?php echo $orders->FullName->HeaderCellClass() ?>"><span id="elh_orders_FullName" class="orders_FullName"><?php echo $orders->FullName->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
		<th class="<?php echo $orders->ProvinceID->HeaderCellClass() ?>"><span id="elh_orders_ProvinceID" class="orders_ProvinceID"><?php echo $orders->ProvinceID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
		<th class="<?php echo $orders->ZipCode->HeaderCellClass() ?>"><span id="elh_orders_ZipCode" class="orders_ZipCode"><?php echo $orders->ZipCode->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->Phone->Visible) { // Phone ?>
		<th class="<?php echo $orders->Phone->HeaderCellClass() ?>"><span id="elh_orders_Phone" class="orders_Phone"><?php echo $orders->Phone->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->Discount->Visible) { // Discount ?>
		<th class="<?php echo $orders->Discount->HeaderCellClass() ?>"><span id="elh_orders_Discount" class="orders_Discount"><?php echo $orders->Discount->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
		<th class="<?php echo $orders->TotalPrice->HeaderCellClass() ?>"><span id="elh_orders_TotalPrice" class="orders_TotalPrice"><?php echo $orders->TotalPrice->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
		<th class="<?php echo $orders->PaymentTypeID->HeaderCellClass() ?>"><span id="elh_orders_PaymentTypeID" class="orders_PaymentTypeID"><?php echo $orders->PaymentTypeID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
		<th class="<?php echo $orders->DeliveryTypeID->HeaderCellClass() ?>"><span id="elh_orders_DeliveryTypeID" class="orders_DeliveryTypeID"><?php echo $orders->DeliveryTypeID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
		<th class="<?php echo $orders->OrderDateTime->HeaderCellClass() ?>"><span id="elh_orders_OrderDateTime" class="orders_OrderDateTime"><?php echo $orders->OrderDateTime->FldCaption() ?></span></th>
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
<?php if ($orders->OrderID->Visible) { // OrderID ?>
		<td<?php echo $orders->OrderID->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_OrderID" class="orders_OrderID">
<span<?php echo $orders->OrderID->ViewAttributes() ?>>
<?php echo $orders->OrderID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
		<td<?php echo $orders->CustomerID->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_CustomerID" class="orders_CustomerID">
<span<?php echo $orders->CustomerID->ViewAttributes() ?>>
<?php echo $orders->CustomerID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->FullName->Visible) { // FullName ?>
		<td<?php echo $orders->FullName->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_FullName" class="orders_FullName">
<span<?php echo $orders->FullName->ViewAttributes() ?>>
<?php echo $orders->FullName->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
		<td<?php echo $orders->ProvinceID->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_ProvinceID" class="orders_ProvinceID">
<span<?php echo $orders->ProvinceID->ViewAttributes() ?>>
<?php echo $orders->ProvinceID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
		<td<?php echo $orders->ZipCode->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_ZipCode" class="orders_ZipCode">
<span<?php echo $orders->ZipCode->ViewAttributes() ?>>
<?php echo $orders->ZipCode->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->Phone->Visible) { // Phone ?>
		<td<?php echo $orders->Phone->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_Phone" class="orders_Phone">
<span<?php echo $orders->Phone->ViewAttributes() ?>>
<?php echo $orders->Phone->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->Discount->Visible) { // Discount ?>
		<td<?php echo $orders->Discount->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_Discount" class="orders_Discount">
<span<?php echo $orders->Discount->ViewAttributes() ?>>
<?php echo $orders->Discount->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
		<td<?php echo $orders->TotalPrice->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_TotalPrice" class="orders_TotalPrice">
<span<?php echo $orders->TotalPrice->ViewAttributes() ?>>
<?php echo $orders->TotalPrice->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
		<td<?php echo $orders->PaymentTypeID->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_PaymentTypeID" class="orders_PaymentTypeID">
<span<?php echo $orders->PaymentTypeID->ViewAttributes() ?>>
<?php echo $orders->PaymentTypeID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
		<td<?php echo $orders->DeliveryTypeID->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_DeliveryTypeID" class="orders_DeliveryTypeID">
<span<?php echo $orders->DeliveryTypeID->ViewAttributes() ?>>
<?php echo $orders->DeliveryTypeID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
		<td<?php echo $orders->OrderDateTime->CellAttributes() ?>>
<span id="el<?php echo $orders_delete->RowCnt ?>_orders_OrderDateTime" class="orders_OrderDateTime">
<span<?php echo $orders->OrderDateTime->ViewAttributes() ?>>
<?php echo $orders->OrderDateTime->ListViewValue() ?></span>
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
