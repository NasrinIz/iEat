<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$employees_add = NULL; // Initialize page object first

class cemployees_add extends cemployees {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'employees';

	// Page object name
	var $PageObjName = 'employees_add';

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

		// Table object (employees)
		if (!isset($GLOBALS["employees"]) || get_class($GLOBALS["employees"]) == "cemployees") {
			$GLOBALS["employees"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["employees"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'employees', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanAdd()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("employeeslist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->FullName->SetVisibility();
		$this->UserName->SetVisibility();
		$this->UserPass->SetVisibility();
		$this->Phone->SetVisibility();
		$this->Mobile->SetVisibility();
		$this->ProvinceID->SetVisibility();
		$this->Address->SetVisibility();
		$this->ZipCode->SetVisibility();
		$this->Level->SetVisibility();

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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
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
		global $EW_EXPORT, $employees;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($employees);
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "employeesview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["EmployeeID"] != "") {
				$this->EmployeeID->setQueryStringValue($_GET["EmployeeID"]);
				$this->setKey("EmployeeID", $this->EmployeeID->CurrentValue); // Set up key
			} else {
				$this->setKey("EmployeeID", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Load old record / default values
		$loaded = $this->LoadOldRecord();

		// Load form values
		if (@$_POST["a_add"] <> "") {
			$this->LoadFormValues(); // Load form values
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Blank record
				break;
			case "C": // Copy an existing record
				if (!$loaded) { // Record not loaded
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("employeeslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "employeeslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "employeesview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->EmployeeID->CurrentValue = NULL;
		$this->EmployeeID->OldValue = $this->EmployeeID->CurrentValue;
		$this->FullName->CurrentValue = NULL;
		$this->FullName->OldValue = $this->FullName->CurrentValue;
		$this->UserName->CurrentValue = NULL;
		$this->UserName->OldValue = $this->UserName->CurrentValue;
		$this->UserPass->CurrentValue = NULL;
		$this->UserPass->OldValue = $this->UserPass->CurrentValue;
		$this->Phone->CurrentValue = NULL;
		$this->Phone->OldValue = $this->Phone->CurrentValue;
		$this->Mobile->CurrentValue = NULL;
		$this->Mobile->OldValue = $this->Mobile->CurrentValue;
		$this->ProvinceID->CurrentValue = NULL;
		$this->ProvinceID->OldValue = $this->ProvinceID->CurrentValue;
		$this->Address->CurrentValue = NULL;
		$this->Address->OldValue = $this->Address->CurrentValue;
		$this->ZipCode->CurrentValue = NULL;
		$this->ZipCode->OldValue = $this->ZipCode->CurrentValue;
		$this->Level->CurrentValue = NULL;
		$this->Level->OldValue = $this->Level->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->FullName->FldIsDetailKey) {
			$this->FullName->setFormValue($objForm->GetValue("x_FullName"));
		}
		if (!$this->UserName->FldIsDetailKey) {
			$this->UserName->setFormValue($objForm->GetValue("x_UserName"));
		}
		if (!$this->UserPass->FldIsDetailKey) {
			$this->UserPass->setFormValue($objForm->GetValue("x_UserPass"));
		}
		if (!$this->Phone->FldIsDetailKey) {
			$this->Phone->setFormValue($objForm->GetValue("x_Phone"));
		}
		if (!$this->Mobile->FldIsDetailKey) {
			$this->Mobile->setFormValue($objForm->GetValue("x_Mobile"));
		}
		if (!$this->ProvinceID->FldIsDetailKey) {
			$this->ProvinceID->setFormValue($objForm->GetValue("x_ProvinceID"));
		}
		if (!$this->Address->FldIsDetailKey) {
			$this->Address->setFormValue($objForm->GetValue("x_Address"));
		}
		if (!$this->ZipCode->FldIsDetailKey) {
			$this->ZipCode->setFormValue($objForm->GetValue("x_ZipCode"));
		}
		if (!$this->Level->FldIsDetailKey) {
			$this->Level->setFormValue($objForm->GetValue("x_Level"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->FullName->CurrentValue = $this->FullName->FormValue;
		$this->UserName->CurrentValue = $this->UserName->FormValue;
		$this->UserPass->CurrentValue = $this->UserPass->FormValue;
		$this->Phone->CurrentValue = $this->Phone->FormValue;
		$this->Mobile->CurrentValue = $this->Mobile->FormValue;
		$this->ProvinceID->CurrentValue = $this->ProvinceID->FormValue;
		$this->Address->CurrentValue = $this->Address->FormValue;
		$this->ZipCode->CurrentValue = $this->ZipCode->FormValue;
		$this->Level->CurrentValue = $this->Level->FormValue;
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
		$this->EmployeeID->setDbValue($row['EmployeeID']);
		$this->FullName->setDbValue($row['FullName']);
		$this->UserName->setDbValue($row['UserName']);
		$this->UserPass->setDbValue($row['UserPass']);
		$this->Phone->setDbValue($row['Phone']);
		$this->Mobile->setDbValue($row['Mobile']);
		$this->ProvinceID->setDbValue($row['ProvinceID']);
		$this->Address->setDbValue($row['Address']);
		$this->ZipCode->setDbValue($row['ZipCode']);
		$this->Level->setDbValue($row['Level']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['EmployeeID'] = $this->EmployeeID->CurrentValue;
		$row['FullName'] = $this->FullName->CurrentValue;
		$row['UserName'] = $this->UserName->CurrentValue;
		$row['UserPass'] = $this->UserPass->CurrentValue;
		$row['Phone'] = $this->Phone->CurrentValue;
		$row['Mobile'] = $this->Mobile->CurrentValue;
		$row['ProvinceID'] = $this->ProvinceID->CurrentValue;
		$row['Address'] = $this->Address->CurrentValue;
		$row['ZipCode'] = $this->ZipCode->CurrentValue;
		$row['Level'] = $this->Level->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->EmployeeID->DbValue = $row['EmployeeID'];
		$this->FullName->DbValue = $row['FullName'];
		$this->UserName->DbValue = $row['UserName'];
		$this->UserPass->DbValue = $row['UserPass'];
		$this->Phone->DbValue = $row['Phone'];
		$this->Mobile->DbValue = $row['Mobile'];
		$this->ProvinceID->DbValue = $row['ProvinceID'];
		$this->Address->DbValue = $row['Address'];
		$this->ZipCode->DbValue = $row['ZipCode'];
		$this->Level->DbValue = $row['Level'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("EmployeeID")) <> "")
			$this->EmployeeID->CurrentValue = $this->getKey("EmployeeID"); // EmployeeID
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// EmployeeID
		// FullName
		// UserName
		// UserPass
		// Phone
		// Mobile
		// ProvinceID
		// Address
		// ZipCode
		// Level

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// FullName
		$this->FullName->ViewValue = $this->FullName->CurrentValue;
		$this->FullName->ViewCustomAttributes = "";

		// UserName
		$this->UserName->ViewValue = $this->UserName->CurrentValue;
		$this->UserName->ViewCustomAttributes = "";

		// UserPass
		$this->UserPass->ViewValue = $Language->Phrase("PasswordMask");
		$this->UserPass->ViewCustomAttributes = "";

		// Phone
		$this->Phone->ViewValue = $this->Phone->CurrentValue;
		$this->Phone->ViewCustomAttributes = "";

		// Mobile
		$this->Mobile->ViewValue = $this->Mobile->CurrentValue;
		$this->Mobile->ViewCustomAttributes = "";

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

		// Level
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->Level->CurrentValue) <> "") {
			$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Level->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
		$sWhereWrk = "";
		$this->Level->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Level, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Level->ViewValue = $this->Level->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Level->ViewValue = $this->Level->CurrentValue;
			}
		} else {
			$this->Level->ViewValue = NULL;
		}
		} else {
			$this->Level->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->Level->ViewCustomAttributes = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";
			$this->FullName->TooltipValue = "";

			// UserName
			$this->UserName->LinkCustomAttributes = "";
			$this->UserName->HrefValue = "";
			$this->UserName->TooltipValue = "";

			// UserPass
			$this->UserPass->LinkCustomAttributes = "";
			$this->UserPass->HrefValue = "";
			$this->UserPass->TooltipValue = "";

			// Phone
			$this->Phone->LinkCustomAttributes = "";
			$this->Phone->HrefValue = "";
			$this->Phone->TooltipValue = "";

			// Mobile
			$this->Mobile->LinkCustomAttributes = "";
			$this->Mobile->HrefValue = "";
			$this->Mobile->TooltipValue = "";

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

			// Level
			$this->Level->LinkCustomAttributes = "";
			$this->Level->HrefValue = "";
			$this->Level->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// FullName
			$this->FullName->EditAttrs["class"] = "form-control";
			$this->FullName->EditCustomAttributes = "";
			$this->FullName->EditValue = ew_HtmlEncode($this->FullName->CurrentValue);
			$this->FullName->PlaceHolder = ew_RemoveHtml($this->FullName->FldCaption());

			// UserName
			$this->UserName->EditAttrs["class"] = "form-control";
			$this->UserName->EditCustomAttributes = "";
			$this->UserName->EditValue = ew_HtmlEncode($this->UserName->CurrentValue);
			$this->UserName->PlaceHolder = ew_RemoveHtml($this->UserName->FldCaption());

			// UserPass
			$this->UserPass->EditAttrs["class"] = "form-control";
			$this->UserPass->EditCustomAttributes = "";
			$this->UserPass->EditValue = ew_HtmlEncode($this->UserPass->CurrentValue);
			$this->UserPass->PlaceHolder = ew_RemoveHtml($this->UserPass->FldCaption());

			// Phone
			$this->Phone->EditAttrs["class"] = "form-control";
			$this->Phone->EditCustomAttributes = "";
			$this->Phone->EditValue = ew_HtmlEncode($this->Phone->CurrentValue);
			$this->Phone->PlaceHolder = ew_RemoveHtml($this->Phone->FldCaption());

			// Mobile
			$this->Mobile->EditAttrs["class"] = "form-control";
			$this->Mobile->EditCustomAttributes = "";
			$this->Mobile->EditValue = ew_HtmlEncode($this->Mobile->CurrentValue);
			$this->Mobile->PlaceHolder = ew_RemoveHtml($this->Mobile->FldCaption());

			// ProvinceID
			$this->ProvinceID->EditAttrs["class"] = "form-control";
			$this->ProvinceID->EditCustomAttributes = "";
			if (trim(strval($this->ProvinceID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`ProvinceID`" . ew_SearchString("=", $this->ProvinceID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `ProvinceID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provinces`";
			$sWhereWrk = "";
			$this->ProvinceID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->ProvinceID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->ProvinceID->EditValue = $arwrk;

			// Address
			$this->Address->EditAttrs["class"] = "form-control";
			$this->Address->EditCustomAttributes = "";
			$this->Address->EditValue = ew_HtmlEncode($this->Address->CurrentValue);
			$this->Address->PlaceHolder = ew_RemoveHtml($this->Address->FldCaption());

			// ZipCode
			$this->ZipCode->EditAttrs["class"] = "form-control";
			$this->ZipCode->EditCustomAttributes = "";
			$this->ZipCode->EditValue = ew_HtmlEncode($this->ZipCode->CurrentValue);
			$this->ZipCode->PlaceHolder = ew_RemoveHtml($this->ZipCode->FldCaption());

			// Level
			$this->Level->EditAttrs["class"] = "form-control";
			$this->Level->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->Level->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->Level->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`userlevelid`" . ew_SearchString("=", $this->Level->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `userlevelid`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `userlevels`";
			$sWhereWrk = "";
			$this->Level->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Level, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Level->EditValue = $arwrk;
			}

			// Add refer script
			// FullName

			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";

			// UserName
			$this->UserName->LinkCustomAttributes = "";
			$this->UserName->HrefValue = "";

			// UserPass
			$this->UserPass->LinkCustomAttributes = "";
			$this->UserPass->HrefValue = "";

			// Phone
			$this->Phone->LinkCustomAttributes = "";
			$this->Phone->HrefValue = "";

			// Mobile
			$this->Mobile->LinkCustomAttributes = "";
			$this->Mobile->HrefValue = "";

			// ProvinceID
			$this->ProvinceID->LinkCustomAttributes = "";
			$this->ProvinceID->HrefValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";

			// ZipCode
			$this->ZipCode->LinkCustomAttributes = "";
			$this->ZipCode->HrefValue = "";

			// Level
			$this->Level->LinkCustomAttributes = "";
			$this->Level->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->FullName->FldIsDetailKey && !is_null($this->FullName->FormValue) && $this->FullName->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->FullName->FldCaption(), $this->FullName->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// FullName
		$this->FullName->SetDbValueDef($rsnew, $this->FullName->CurrentValue, "", FALSE);

		// UserName
		$this->UserName->SetDbValueDef($rsnew, $this->UserName->CurrentValue, NULL, FALSE);

		// UserPass
		$this->UserPass->SetDbValueDef($rsnew, $this->UserPass->CurrentValue, NULL, FALSE);

		// Phone
		$this->Phone->SetDbValueDef($rsnew, $this->Phone->CurrentValue, NULL, FALSE);

		// Mobile
		$this->Mobile->SetDbValueDef($rsnew, $this->Mobile->CurrentValue, NULL, FALSE);

		// ProvinceID
		$this->ProvinceID->SetDbValueDef($rsnew, $this->ProvinceID->CurrentValue, NULL, FALSE);

		// Address
		$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, NULL, FALSE);

		// ZipCode
		$this->ZipCode->SetDbValueDef($rsnew, $this->ZipCode->CurrentValue, NULL, FALSE);

		// Level
		if ($Security->CanAdmin()) { // System admin
		$this->Level->SetDbValueDef($rsnew, $this->Level->CurrentValue, NULL, FALSE);
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("employeeslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_ProvinceID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `ProvinceID` AS `LinkFld`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provinces`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`ProvinceID` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->ProvinceID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Level":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `userlevelid` AS `LinkFld`, `userlevelname` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `userlevels`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`userlevelid` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Level, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($employees_add)) $employees_add = new cemployees_add();

// Page init
$employees_add->Page_Init();

// Page main
$employees_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = femployeesadd = new ew_Form("femployeesadd", "add");

// Validate form
femployeesadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_FullName");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $employees->FullName->FldCaption(), $employees->FullName->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
femployeesadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
femployeesadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
femployeesadd.Lists["x_ProvinceID"] = {"LinkField":"x_ProvinceID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
femployeesadd.Lists["x_ProvinceID"].Data = "<?php echo $employees_add->ProvinceID->LookupFilterQuery(FALSE, "add") ?>";
femployeesadd.Lists["x_Level"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
femployeesadd.Lists["x_Level"].Data = "<?php echo $employees_add->Level->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $employees_add->ShowPageHeader(); ?>
<?php
$employees_add->ShowMessage();
?>
<form name="femployeesadd" id="femployeesadd" class="<?php echo $employees_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($employees_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $employees_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($employees_add->IsModal) ?>">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($employees->FullName->Visible) { // FullName ?>
	<div id="r_FullName" class="form-group">
		<label id="elh_employees_FullName" for="x_FullName" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->FullName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->FullName->CellAttributes() ?>>
<span id="el_employees_FullName">
<input type="text" data-table="employees" data-field="x_FullName" name="x_FullName" id="x_FullName" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($employees->FullName->getPlaceHolder()) ?>" value="<?php echo $employees->FullName->EditValue ?>"<?php echo $employees->FullName->EditAttributes() ?>>
</span>
<?php echo $employees->FullName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->UserName->Visible) { // UserName ?>
	<div id="r_UserName" class="form-group">
		<label id="elh_employees_UserName" for="x_UserName" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->UserName->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->UserName->CellAttributes() ?>>
<span id="el_employees_UserName">
<input type="text" data-table="employees" data-field="x_UserName" name="x_UserName" id="x_UserName" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($employees->UserName->getPlaceHolder()) ?>" value="<?php echo $employees->UserName->EditValue ?>"<?php echo $employees->UserName->EditAttributes() ?>>
</span>
<?php echo $employees->UserName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->UserPass->Visible) { // UserPass ?>
	<div id="r_UserPass" class="form-group">
		<label id="elh_employees_UserPass" for="x_UserPass" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->UserPass->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->UserPass->CellAttributes() ?>>
<span id="el_employees_UserPass">
<input type="password" data-field="x_UserPass" name="x_UserPass" id="x_UserPass" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($employees->UserPass->getPlaceHolder()) ?>"<?php echo $employees->UserPass->EditAttributes() ?>>
</span>
<?php echo $employees->UserPass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Phone->Visible) { // Phone ?>
	<div id="r_Phone" class="form-group">
		<label id="elh_employees_Phone" for="x_Phone" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->Phone->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->Phone->CellAttributes() ?>>
<span id="el_employees_Phone">
<input type="text" data-table="employees" data-field="x_Phone" name="x_Phone" id="x_Phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($employees->Phone->getPlaceHolder()) ?>" value="<?php echo $employees->Phone->EditValue ?>"<?php echo $employees->Phone->EditAttributes() ?>>
</span>
<?php echo $employees->Phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Mobile->Visible) { // Mobile ?>
	<div id="r_Mobile" class="form-group">
		<label id="elh_employees_Mobile" for="x_Mobile" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->Mobile->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->Mobile->CellAttributes() ?>>
<span id="el_employees_Mobile">
<input type="text" data-table="employees" data-field="x_Mobile" name="x_Mobile" id="x_Mobile" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($employees->Mobile->getPlaceHolder()) ?>" value="<?php echo $employees->Mobile->EditValue ?>"<?php echo $employees->Mobile->EditAttributes() ?>>
</span>
<?php echo $employees->Mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->ProvinceID->Visible) { // ProvinceID ?>
	<div id="r_ProvinceID" class="form-group">
		<label id="elh_employees_ProvinceID" for="x_ProvinceID" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->ProvinceID->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->ProvinceID->CellAttributes() ?>>
<span id="el_employees_ProvinceID">
<select data-table="employees" data-field="x_ProvinceID" data-value-separator="<?php echo $employees->ProvinceID->DisplayValueSeparatorAttribute() ?>" id="x_ProvinceID" name="x_ProvinceID"<?php echo $employees->ProvinceID->EditAttributes() ?>>
<?php echo $employees->ProvinceID->SelectOptionListHtml("x_ProvinceID") ?>
</select>
</span>
<?php echo $employees->ProvinceID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Address->Visible) { // Address ?>
	<div id="r_Address" class="form-group">
		<label id="elh_employees_Address" for="x_Address" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->Address->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->Address->CellAttributes() ?>>
<span id="el_employees_Address">
<input type="text" data-table="employees" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($employees->Address->getPlaceHolder()) ?>" value="<?php echo $employees->Address->EditValue ?>"<?php echo $employees->Address->EditAttributes() ?>>
</span>
<?php echo $employees->Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->ZipCode->Visible) { // ZipCode ?>
	<div id="r_ZipCode" class="form-group">
		<label id="elh_employees_ZipCode" for="x_ZipCode" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->ZipCode->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->ZipCode->CellAttributes() ?>>
<span id="el_employees_ZipCode">
<input type="text" data-table="employees" data-field="x_ZipCode" name="x_ZipCode" id="x_ZipCode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($employees->ZipCode->getPlaceHolder()) ?>" value="<?php echo $employees->ZipCode->EditValue ?>"<?php echo $employees->ZipCode->EditAttributes() ?>>
</span>
<?php echo $employees->ZipCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Level->Visible) { // Level ?>
	<div id="r_Level" class="form-group">
		<label id="elh_employees_Level" for="x_Level" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->Level->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->Level->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_employees_Level">
<p class="form-control-static"><?php echo $employees->Level->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_employees_Level">
<select data-table="employees" data-field="x_Level" data-value-separator="<?php echo $employees->Level->DisplayValueSeparatorAttribute() ?>" id="x_Level" name="x_Level"<?php echo $employees->Level->EditAttributes() ?>>
<?php echo $employees->Level->SelectOptionListHtml("x_Level") ?>
</select>
</span>
<?php } ?>
<?php echo $employees->Level->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$employees_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $employees_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $employees_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
femployeesadd.Init();
</script>
<?php
$employees_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$employees_add->Page_Terminate();
?>
