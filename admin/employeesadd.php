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
		$this->full_name->SetVisibility();
		$this->user_name->SetVisibility();
		$this->user_pass->SetVisibility();
		$this->phone->SetVisibility();
		$this->mobile->SetVisibility();
		$this->province_id->SetVisibility();
		$this->address->SetVisibility();
		$this->zip_code->SetVisibility();
		$this->level_no->SetVisibility();

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
			if (@$_GET["employee_id"] != "") {
				$this->employee_id->setQueryStringValue($_GET["employee_id"]);
				$this->setKey("employee_id", $this->employee_id->CurrentValue); // Set up key
			} else {
				$this->setKey("employee_id", ""); // Clear key
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
		$this->employee_id->CurrentValue = NULL;
		$this->employee_id->OldValue = $this->employee_id->CurrentValue;
		$this->full_name->CurrentValue = NULL;
		$this->full_name->OldValue = $this->full_name->CurrentValue;
		$this->user_name->CurrentValue = NULL;
		$this->user_name->OldValue = $this->user_name->CurrentValue;
		$this->user_pass->CurrentValue = NULL;
		$this->user_pass->OldValue = $this->user_pass->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->mobile->CurrentValue = NULL;
		$this->mobile->OldValue = $this->mobile->CurrentValue;
		$this->province_id->CurrentValue = NULL;
		$this->province_id->OldValue = $this->province_id->CurrentValue;
		$this->address->CurrentValue = NULL;
		$this->address->OldValue = $this->address->CurrentValue;
		$this->zip_code->CurrentValue = NULL;
		$this->zip_code->OldValue = $this->zip_code->CurrentValue;
		$this->level_no->CurrentValue = NULL;
		$this->level_no->OldValue = $this->level_no->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->full_name->FldIsDetailKey) {
			$this->full_name->setFormValue($objForm->GetValue("x_full_name"));
		}
		if (!$this->user_name->FldIsDetailKey) {
			$this->user_name->setFormValue($objForm->GetValue("x_user_name"));
		}
		if (!$this->user_pass->FldIsDetailKey) {
			$this->user_pass->setFormValue($objForm->GetValue("x_user_pass"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->mobile->FldIsDetailKey) {
			$this->mobile->setFormValue($objForm->GetValue("x_mobile"));
		}
		if (!$this->province_id->FldIsDetailKey) {
			$this->province_id->setFormValue($objForm->GetValue("x_province_id"));
		}
		if (!$this->address->FldIsDetailKey) {
			$this->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$this->zip_code->FldIsDetailKey) {
			$this->zip_code->setFormValue($objForm->GetValue("x_zip_code"));
		}
		if (!$this->level_no->FldIsDetailKey) {
			$this->level_no->setFormValue($objForm->GetValue("x_level_no"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->full_name->CurrentValue = $this->full_name->FormValue;
		$this->user_name->CurrentValue = $this->user_name->FormValue;
		$this->user_pass->CurrentValue = $this->user_pass->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->province_id->CurrentValue = $this->province_id->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->zip_code->CurrentValue = $this->zip_code->FormValue;
		$this->level_no->CurrentValue = $this->level_no->FormValue;
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
		$this->employee_id->setDbValue($row['employee_id']);
		$this->full_name->setDbValue($row['full_name']);
		$this->user_name->setDbValue($row['user_name']);
		$this->user_pass->setDbValue($row['user_pass']);
		$this->phone->setDbValue($row['phone']);
		$this->mobile->setDbValue($row['mobile']);
		$this->province_id->setDbValue($row['province_id']);
		$this->address->setDbValue($row['address']);
		$this->zip_code->setDbValue($row['zip_code']);
		$this->level_no->setDbValue($row['level_no']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['employee_id'] = $this->employee_id->CurrentValue;
		$row['full_name'] = $this->full_name->CurrentValue;
		$row['user_name'] = $this->user_name->CurrentValue;
		$row['user_pass'] = $this->user_pass->CurrentValue;
		$row['phone'] = $this->phone->CurrentValue;
		$row['mobile'] = $this->mobile->CurrentValue;
		$row['province_id'] = $this->province_id->CurrentValue;
		$row['address'] = $this->address->CurrentValue;
		$row['zip_code'] = $this->zip_code->CurrentValue;
		$row['level_no'] = $this->level_no->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->employee_id->DbValue = $row['employee_id'];
		$this->full_name->DbValue = $row['full_name'];
		$this->user_name->DbValue = $row['user_name'];
		$this->user_pass->DbValue = $row['user_pass'];
		$this->phone->DbValue = $row['phone'];
		$this->mobile->DbValue = $row['mobile'];
		$this->province_id->DbValue = $row['province_id'];
		$this->address->DbValue = $row['address'];
		$this->zip_code->DbValue = $row['zip_code'];
		$this->level_no->DbValue = $row['level_no'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("employee_id")) <> "")
			$this->employee_id->CurrentValue = $this->getKey("employee_id"); // employee_id
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
		// employee_id
		// full_name
		// user_name
		// user_pass
		// phone
		// mobile
		// province_id
		// address
		// zip_code
		// level_no

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// full_name
		$this->full_name->ViewValue = $this->full_name->CurrentValue;
		$this->full_name->ViewCustomAttributes = "";

		// user_name
		$this->user_name->ViewValue = $this->user_name->CurrentValue;
		$this->user_name->ViewCustomAttributes = "";

		// user_pass
		$this->user_pass->ViewValue = $Language->Phrase("PasswordMask");
		$this->user_pass->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

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

		// level_no
		if ($Security->CanAdmin()) { // System admin
		if (strval($this->level_no->CurrentValue) <> "") {
			$sFilterWrk = "`user_level_id`" . ew_SearchString("=", $this->level_no->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `user_level_id`, `user_level_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `user_levels`";
		$sWhereWrk = "";
		$this->level_no->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->level_no, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->level_no->ViewValue = $this->level_no->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->level_no->ViewValue = $this->level_no->CurrentValue;
			}
		} else {
			$this->level_no->ViewValue = NULL;
		}
		} else {
			$this->level_no->ViewValue = $Language->Phrase("PasswordMask");
		}
		$this->level_no->ViewCustomAttributes = "";

			// full_name
			$this->full_name->LinkCustomAttributes = "";
			$this->full_name->HrefValue = "";
			$this->full_name->TooltipValue = "";

			// user_name
			$this->user_name->LinkCustomAttributes = "";
			$this->user_name->HrefValue = "";
			$this->user_name->TooltipValue = "";

			// user_pass
			$this->user_pass->LinkCustomAttributes = "";
			$this->user_pass->HrefValue = "";
			$this->user_pass->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

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

			// level_no
			$this->level_no->LinkCustomAttributes = "";
			$this->level_no->HrefValue = "";
			$this->level_no->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// full_name
			$this->full_name->EditAttrs["class"] = "form-control";
			$this->full_name->EditCustomAttributes = "";
			$this->full_name->EditValue = ew_HtmlEncode($this->full_name->CurrentValue);
			$this->full_name->PlaceHolder = ew_RemoveHtml($this->full_name->FldCaption());

			// user_name
			$this->user_name->EditAttrs["class"] = "form-control";
			$this->user_name->EditCustomAttributes = "";
			$this->user_name->EditValue = ew_HtmlEncode($this->user_name->CurrentValue);
			$this->user_name->PlaceHolder = ew_RemoveHtml($this->user_name->FldCaption());

			// user_pass
			$this->user_pass->EditAttrs["class"] = "form-control";
			$this->user_pass->EditCustomAttributes = "";
			$this->user_pass->EditValue = ew_HtmlEncode($this->user_pass->CurrentValue);
			$this->user_pass->PlaceHolder = ew_RemoveHtml($this->user_pass->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// mobile
			$this->mobile->EditAttrs["class"] = "form-control";
			$this->mobile->EditCustomAttributes = "";
			$this->mobile->EditValue = ew_HtmlEncode($this->mobile->CurrentValue);
			$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

			// province_id
			$this->province_id->EditAttrs["class"] = "form-control";
			$this->province_id->EditCustomAttributes = "";
			if (trim(strval($this->province_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`province_id`" . ew_SearchString("=", $this->province_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `province_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `provinces`";
			$sWhereWrk = "";
			$this->province_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->province_id->EditValue = $arwrk;

			// address
			$this->address->EditAttrs["class"] = "form-control";
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = ew_HtmlEncode($this->address->CurrentValue);
			$this->address->PlaceHolder = ew_RemoveHtml($this->address->FldCaption());

			// zip_code
			$this->zip_code->EditAttrs["class"] = "form-control";
			$this->zip_code->EditCustomAttributes = "";
			$this->zip_code->EditValue = ew_HtmlEncode($this->zip_code->CurrentValue);
			$this->zip_code->PlaceHolder = ew_RemoveHtml($this->zip_code->FldCaption());

			// level_no
			$this->level_no->EditAttrs["class"] = "form-control";
			$this->level_no->EditCustomAttributes = "";
			if (!$Security->CanAdmin()) { // System admin
				$this->level_no->EditValue = $Language->Phrase("PasswordMask");
			} else {
			if (trim(strval($this->level_no->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`user_level_id`" . ew_SearchString("=", $this->level_no->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `user_level_id`, `user_level_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `user_levels`";
			$sWhereWrk = "";
			$this->level_no->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->level_no, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->level_no->EditValue = $arwrk;
			}

			// Add refer script
			// full_name

			$this->full_name->LinkCustomAttributes = "";
			$this->full_name->HrefValue = "";

			// user_name
			$this->user_name->LinkCustomAttributes = "";
			$this->user_name->HrefValue = "";

			// user_pass
			$this->user_pass->LinkCustomAttributes = "";
			$this->user_pass->HrefValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// province_id
			$this->province_id->LinkCustomAttributes = "";
			$this->province_id->HrefValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";

			// zip_code
			$this->zip_code->LinkCustomAttributes = "";
			$this->zip_code->HrefValue = "";

			// level_no
			$this->level_no->LinkCustomAttributes = "";
			$this->level_no->HrefValue = "";
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
		if (!$this->full_name->FldIsDetailKey && !is_null($this->full_name->FormValue) && $this->full_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->full_name->FldCaption(), $this->full_name->ReqErrMsg));
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

		// full_name
		$this->full_name->SetDbValueDef($rsnew, $this->full_name->CurrentValue, "", FALSE);

		// user_name
		$this->user_name->SetDbValueDef($rsnew, $this->user_name->CurrentValue, NULL, FALSE);

		// user_pass
		$this->user_pass->SetDbValueDef($rsnew, $this->user_pass->CurrentValue, NULL, FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// mobile
		$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, NULL, FALSE);

		// province_id
		$this->province_id->SetDbValueDef($rsnew, $this->province_id->CurrentValue, NULL, FALSE);

		// address
		$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, NULL, FALSE);

		// zip_code
		$this->zip_code->SetDbValueDef($rsnew, $this->zip_code->CurrentValue, NULL, FALSE);

		// level_no
		if ($Security->CanAdmin()) { // System admin
		$this->level_no->SetDbValueDef($rsnew, $this->level_no->CurrentValue, NULL, FALSE);
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
		case "x_province_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `province_id` AS `LinkFld`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `provinces`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`province_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->province_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `name`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_level_no":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `user_level_id` AS `LinkFld`, `user_level_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `user_levels`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`user_level_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->level_no, $sWhereWrk); // Call Lookup Selecting
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
			elm = this.GetElements("x" + infix + "_full_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $employees->full_name->FldCaption(), $employees->full_name->ReqErrMsg)) ?>");

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
femployeesadd.Lists["x_province_id"] = {"LinkField":"x_province_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
femployeesadd.Lists["x_province_id"].Data = "<?php echo $employees_add->province_id->LookupFilterQuery(FALSE, "add") ?>";
femployeesadd.Lists["x_level_no"] = {"LinkField":"x_user_level_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_user_level_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"user_levels"};
femployeesadd.Lists["x_level_no"].Data = "<?php echo $employees_add->level_no->LookupFilterQuery(FALSE, "add") ?>";

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
<?php if ($employees->full_name->Visible) { // full_name ?>
	<div id="r_full_name" class="form-group">
		<label id="elh_employees_full_name" for="x_full_name" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->full_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->full_name->CellAttributes() ?>>
<span id="el_employees_full_name">
<input type="text" data-table="employees" data-field="x_full_name" name="x_full_name" id="x_full_name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($employees->full_name->getPlaceHolder()) ?>" value="<?php echo $employees->full_name->EditValue ?>"<?php echo $employees->full_name->EditAttributes() ?>>
</span>
<?php echo $employees->full_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->user_name->Visible) { // user_name ?>
	<div id="r_user_name" class="form-group">
		<label id="elh_employees_user_name" for="x_user_name" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->user_name->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->user_name->CellAttributes() ?>>
<span id="el_employees_user_name">
<input type="text" data-table="employees" data-field="x_user_name" name="x_user_name" id="x_user_name" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($employees->user_name->getPlaceHolder()) ?>" value="<?php echo $employees->user_name->EditValue ?>"<?php echo $employees->user_name->EditAttributes() ?>>
</span>
<?php echo $employees->user_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->user_pass->Visible) { // user_pass ?>
	<div id="r_user_pass" class="form-group">
		<label id="elh_employees_user_pass" for="x_user_pass" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->user_pass->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->user_pass->CellAttributes() ?>>
<span id="el_employees_user_pass">
<input type="password" data-field="x_user_pass" name="x_user_pass" id="x_user_pass" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($employees->user_pass->getPlaceHolder()) ?>"<?php echo $employees->user_pass->EditAttributes() ?>>
</span>
<?php echo $employees->user_pass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_employees_phone" for="x_phone" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->phone->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->phone->CellAttributes() ?>>
<span id="el_employees_phone">
<input type="text" data-table="employees" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($employees->phone->getPlaceHolder()) ?>" value="<?php echo $employees->phone->EditValue ?>"<?php echo $employees->phone->EditAttributes() ?>>
</span>
<?php echo $employees->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_employees_mobile" for="x_mobile" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->mobile->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->mobile->CellAttributes() ?>>
<span id="el_employees_mobile">
<input type="text" data-table="employees" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($employees->mobile->getPlaceHolder()) ?>" value="<?php echo $employees->mobile->EditValue ?>"<?php echo $employees->mobile->EditAttributes() ?>>
</span>
<?php echo $employees->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->province_id->Visible) { // province_id ?>
	<div id="r_province_id" class="form-group">
		<label id="elh_employees_province_id" for="x_province_id" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->province_id->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->province_id->CellAttributes() ?>>
<span id="el_employees_province_id">
<select data-table="employees" data-field="x_province_id" data-value-separator="<?php echo $employees->province_id->DisplayValueSeparatorAttribute() ?>" id="x_province_id" name="x_province_id"<?php echo $employees->province_id->EditAttributes() ?>>
<?php echo $employees->province_id->SelectOptionListHtml("x_province_id") ?>
</select>
</span>
<?php echo $employees->province_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->address->Visible) { // address ?>
	<div id="r_address" class="form-group">
		<label id="elh_employees_address" for="x_address" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->address->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->address->CellAttributes() ?>>
<span id="el_employees_address">
<input type="text" data-table="employees" data-field="x_address" name="x_address" id="x_address" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($employees->address->getPlaceHolder()) ?>" value="<?php echo $employees->address->EditValue ?>"<?php echo $employees->address->EditAttributes() ?>>
</span>
<?php echo $employees->address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->zip_code->Visible) { // zip_code ?>
	<div id="r_zip_code" class="form-group">
		<label id="elh_employees_zip_code" for="x_zip_code" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->zip_code->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->zip_code->CellAttributes() ?>>
<span id="el_employees_zip_code">
<input type="text" data-table="employees" data-field="x_zip_code" name="x_zip_code" id="x_zip_code" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($employees->zip_code->getPlaceHolder()) ?>" value="<?php echo $employees->zip_code->EditValue ?>"<?php echo $employees->zip_code->EditAttributes() ?>>
</span>
<?php echo $employees->zip_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->level_no->Visible) { // level_no ?>
	<div id="r_level_no" class="form-group">
		<label id="elh_employees_level_no" for="x_level_no" class="<?php echo $employees_add->LeftColumnClass ?>"><?php echo $employees->level_no->FldCaption() ?></label>
		<div class="<?php echo $employees_add->RightColumnClass ?>"><div<?php echo $employees->level_no->CellAttributes() ?>>
<?php if (!$Security->IsAdmin() && $Security->IsLoggedIn()) { // Non system admin ?>
<span id="el_employees_level_no">
<p class="form-control-static"><?php echo $employees->level_no->EditValue ?></p>
</span>
<?php } else { ?>
<span id="el_employees_level_no">
<select data-table="employees" data-field="x_level_no" data-value-separator="<?php echo $employees->level_no->DisplayValueSeparatorAttribute() ?>" id="x_level_no" name="x_level_no"<?php echo $employees->level_no->EditAttributes() ?>>
<?php echo $employees->level_no->SelectOptionListHtml("x_level_no") ?>
</select>
</span>
<?php } ?>
<?php echo $employees->level_no->CustomMsg ?></div></div>
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
