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

$employees_edit = NULL; // Initialize page object first

class cemployees_edit extends cemployees {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'employees';

	// Page object name
	var $PageObjName = 'employees_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->EmployeeID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->EmployeeID->Visible = FALSE;
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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_EmployeeID")) {
				$this->EmployeeID->setFormValue($objForm->GetValue("x_EmployeeID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["EmployeeID"])) {
				$this->EmployeeID->setQueryStringValue($_GET["EmployeeID"]);
				$loadByQuery = TRUE;
			} else {
				$this->EmployeeID->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("employeeslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "employeeslist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->EmployeeID->FldIsDetailKey)
			$this->EmployeeID->setFormValue($objForm->GetValue("x_EmployeeID"));
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
		$this->EmployeeID->CurrentValue = $this->EmployeeID->FormValue;
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
		$row = array();
		$row['EmployeeID'] = NULL;
		$row['FullName'] = NULL;
		$row['UserName'] = NULL;
		$row['UserPass'] = NULL;
		$row['Phone'] = NULL;
		$row['Mobile'] = NULL;
		$row['ProvinceID'] = NULL;
		$row['Address'] = NULL;
		$row['ZipCode'] = NULL;
		$row['Level'] = NULL;
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

		// EmployeeID
		$this->EmployeeID->ViewValue = $this->EmployeeID->CurrentValue;
		$this->EmployeeID->ViewCustomAttributes = "";

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

			// EmployeeID
			$this->EmployeeID->LinkCustomAttributes = "";
			$this->EmployeeID->HrefValue = "";
			$this->EmployeeID->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// EmployeeID
			$this->EmployeeID->EditAttrs["class"] = "form-control";
			$this->EmployeeID->EditCustomAttributes = "";
			$this->EmployeeID->EditValue = $this->EmployeeID->CurrentValue;
			$this->EmployeeID->ViewCustomAttributes = "";

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

			// Edit refer script
			// EmployeeID

			$this->EmployeeID->LinkCustomAttributes = "";
			$this->EmployeeID->HrefValue = "";

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

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// FullName
			$this->FullName->SetDbValueDef($rsnew, $this->FullName->CurrentValue, "", $this->FullName->ReadOnly);

			// UserName
			$this->UserName->SetDbValueDef($rsnew, $this->UserName->CurrentValue, NULL, $this->UserName->ReadOnly);

			// UserPass
			$this->UserPass->SetDbValueDef($rsnew, $this->UserPass->CurrentValue, NULL, $this->UserPass->ReadOnly || (EW_ENCRYPTED_PASSWORD && $rs->fields('UserPass') == $this->UserPass->CurrentValue));

			// Phone
			$this->Phone->SetDbValueDef($rsnew, $this->Phone->CurrentValue, NULL, $this->Phone->ReadOnly);

			// Mobile
			$this->Mobile->SetDbValueDef($rsnew, $this->Mobile->CurrentValue, NULL, $this->Mobile->ReadOnly);

			// ProvinceID
			$this->ProvinceID->SetDbValueDef($rsnew, $this->ProvinceID->CurrentValue, NULL, $this->ProvinceID->ReadOnly);

			// Address
			$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, NULL, $this->Address->ReadOnly);

			// ZipCode
			$this->ZipCode->SetDbValueDef($rsnew, $this->ZipCode->CurrentValue, NULL, $this->ZipCode->ReadOnly);

			// Level
			if ($Security->CanAdmin()) { // System admin
			$this->Level->SetDbValueDef($rsnew, $this->Level->CurrentValue, NULL, $this->Level->ReadOnly);
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("employeeslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($employees_edit)) $employees_edit = new cemployees_edit();

// Page init
$employees_edit->Page_Init();

// Page main
$employees_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$employees_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = femployeesedit = new ew_Form("femployeesedit", "edit");

// Validate form
femployeesedit.Validate = function() {
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
femployeesedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
femployeesedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
femployeesedit.Lists["x_ProvinceID"] = {"LinkField":"x_ProvinceID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
femployeesedit.Lists["x_ProvinceID"].Data = "<?php echo $employees_edit->ProvinceID->LookupFilterQuery(FALSE, "edit") ?>";
femployeesedit.Lists["x_Level"] = {"LinkField":"x_userlevelid","Ajax":true,"AutoFill":false,"DisplayFields":["x_userlevelname","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"userlevels"};
femployeesedit.Lists["x_Level"].Data = "<?php echo $employees_edit->Level->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $employees_edit->ShowPageHeader(); ?>
<?php
$employees_edit->ShowMessage();
?>
<form name="femployeesedit" id="femployeesedit" class="<?php echo $employees_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($employees_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $employees_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="employees">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($employees_edit->IsModal) ?>">
<!-- Fields to prevent google autofill -->
<input class="hidden" type="text" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<input class="hidden" type="password" name="<?php echo ew_Encrypt(ew_Random()) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($employees->EmployeeID->Visible) { // EmployeeID ?>
	<div id="r_EmployeeID" class="form-group">
		<label id="elh_employees_EmployeeID" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->EmployeeID->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->EmployeeID->CellAttributes() ?>>
<span id="el_employees_EmployeeID">
<span<?php echo $employees->EmployeeID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $employees->EmployeeID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="employees" data-field="x_EmployeeID" name="x_EmployeeID" id="x_EmployeeID" value="<?php echo ew_HtmlEncode($employees->EmployeeID->CurrentValue) ?>">
<?php echo $employees->EmployeeID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->FullName->Visible) { // FullName ?>
	<div id="r_FullName" class="form-group">
		<label id="elh_employees_FullName" for="x_FullName" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->FullName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->FullName->CellAttributes() ?>>
<span id="el_employees_FullName">
<input type="text" data-table="employees" data-field="x_FullName" name="x_FullName" id="x_FullName" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($employees->FullName->getPlaceHolder()) ?>" value="<?php echo $employees->FullName->EditValue ?>"<?php echo $employees->FullName->EditAttributes() ?>>
</span>
<?php echo $employees->FullName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->UserName->Visible) { // UserName ?>
	<div id="r_UserName" class="form-group">
		<label id="elh_employees_UserName" for="x_UserName" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->UserName->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->UserName->CellAttributes() ?>>
<span id="el_employees_UserName">
<input type="text" data-table="employees" data-field="x_UserName" name="x_UserName" id="x_UserName" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($employees->UserName->getPlaceHolder()) ?>" value="<?php echo $employees->UserName->EditValue ?>"<?php echo $employees->UserName->EditAttributes() ?>>
</span>
<?php echo $employees->UserName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->UserPass->Visible) { // UserPass ?>
	<div id="r_UserPass" class="form-group">
		<label id="elh_employees_UserPass" for="x_UserPass" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->UserPass->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->UserPass->CellAttributes() ?>>
<span id="el_employees_UserPass">
<input type="password" data-field="x_UserPass" name="x_UserPass" id="x_UserPass" value="<?php echo $employees->UserPass->EditValue ?>" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($employees->UserPass->getPlaceHolder()) ?>"<?php echo $employees->UserPass->EditAttributes() ?>>
</span>
<?php echo $employees->UserPass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Phone->Visible) { // Phone ?>
	<div id="r_Phone" class="form-group">
		<label id="elh_employees_Phone" for="x_Phone" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->Phone->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->Phone->CellAttributes() ?>>
<span id="el_employees_Phone">
<input type="text" data-table="employees" data-field="x_Phone" name="x_Phone" id="x_Phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($employees->Phone->getPlaceHolder()) ?>" value="<?php echo $employees->Phone->EditValue ?>"<?php echo $employees->Phone->EditAttributes() ?>>
</span>
<?php echo $employees->Phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Mobile->Visible) { // Mobile ?>
	<div id="r_Mobile" class="form-group">
		<label id="elh_employees_Mobile" for="x_Mobile" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->Mobile->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->Mobile->CellAttributes() ?>>
<span id="el_employees_Mobile">
<input type="text" data-table="employees" data-field="x_Mobile" name="x_Mobile" id="x_Mobile" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($employees->Mobile->getPlaceHolder()) ?>" value="<?php echo $employees->Mobile->EditValue ?>"<?php echo $employees->Mobile->EditAttributes() ?>>
</span>
<?php echo $employees->Mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->ProvinceID->Visible) { // ProvinceID ?>
	<div id="r_ProvinceID" class="form-group">
		<label id="elh_employees_ProvinceID" for="x_ProvinceID" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->ProvinceID->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->ProvinceID->CellAttributes() ?>>
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
		<label id="elh_employees_Address" for="x_Address" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->Address->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->Address->CellAttributes() ?>>
<span id="el_employees_Address">
<input type="text" data-table="employees" data-field="x_Address" name="x_Address" id="x_Address" size="30" maxlength="120" placeholder="<?php echo ew_HtmlEncode($employees->Address->getPlaceHolder()) ?>" value="<?php echo $employees->Address->EditValue ?>"<?php echo $employees->Address->EditAttributes() ?>>
</span>
<?php echo $employees->Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->ZipCode->Visible) { // ZipCode ?>
	<div id="r_ZipCode" class="form-group">
		<label id="elh_employees_ZipCode" for="x_ZipCode" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->ZipCode->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->ZipCode->CellAttributes() ?>>
<span id="el_employees_ZipCode">
<input type="text" data-table="employees" data-field="x_ZipCode" name="x_ZipCode" id="x_ZipCode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($employees->ZipCode->getPlaceHolder()) ?>" value="<?php echo $employees->ZipCode->EditValue ?>"<?php echo $employees->ZipCode->EditAttributes() ?>>
</span>
<?php echo $employees->ZipCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($employees->Level->Visible) { // Level ?>
	<div id="r_Level" class="form-group">
		<label id="elh_employees_Level" for="x_Level" class="<?php echo $employees_edit->LeftColumnClass ?>"><?php echo $employees->Level->FldCaption() ?></label>
		<div class="<?php echo $employees_edit->RightColumnClass ?>"><div<?php echo $employees->Level->CellAttributes() ?>>
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
<?php if (!$employees_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $employees_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $employees_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
femployeesedit.Init();
</script>
<?php
$employees_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$employees_edit->Page_Terminate();
?>
