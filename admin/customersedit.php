<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "customersinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "addressesgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$customers_edit = NULL; // Initialize page object first

class ccustomers_edit extends ccustomers {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'customers';

	// Page object name
	var $PageObjName = 'customers_edit';

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

		// Table object (customers)
		if (!isset($GLOBALS["customers"]) || get_class($GLOBALS["customers"]) == "ccustomers") {
			$GLOBALS["customers"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["customers"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'customers', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("customerslist.php"));
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
		$this->customer_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->customer_id->Visible = FALSE;
		$this->full_name->SetVisibility();
		$this->phone->SetVisibility();
		$this->mobile->SetVisibility();
		$this->reward->SetVisibility();
		$this->user_name->SetVisibility();
		$this->user_pass->SetVisibility();
		$this->activity_status->SetVisibility();

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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("addresses", $DetailTblVar)) {

					// Process auto fill for detail table 'addresses'
					if (preg_match('/^faddresses(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["addresses_grid"])) $GLOBALS["addresses_grid"] = new caddresses_grid;
						$GLOBALS["addresses_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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
		global $EW_EXPORT, $customers;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($customers);
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
					if ($pageName == "customersview.php")
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
			if ($objForm->HasValue("x_customer_id")) {
				$this->customer_id->setFormValue($objForm->GetValue("x_customer_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["customer_id"])) {
				$this->customer_id->setQueryStringValue($_GET["customer_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->customer_id->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetupDetailParms();
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
					$this->Page_Terminate("customerslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "customerslist.php")
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

					// Set up detail parameters
					$this->SetupDetailParms();
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
		if (!$this->customer_id->FldIsDetailKey)
			$this->customer_id->setFormValue($objForm->GetValue("x_customer_id"));
		if (!$this->full_name->FldIsDetailKey) {
			$this->full_name->setFormValue($objForm->GetValue("x_full_name"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->mobile->FldIsDetailKey) {
			$this->mobile->setFormValue($objForm->GetValue("x_mobile"));
		}
		if (!$this->reward->FldIsDetailKey) {
			$this->reward->setFormValue($objForm->GetValue("x_reward"));
		}
		if (!$this->user_name->FldIsDetailKey) {
			$this->user_name->setFormValue($objForm->GetValue("x_user_name"));
		}
		if (!$this->user_pass->FldIsDetailKey) {
			$this->user_pass->setFormValue($objForm->GetValue("x_user_pass"));
		}
		if (!$this->activity_status->FldIsDetailKey) {
			$this->activity_status->setFormValue($objForm->GetValue("x_activity_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->customer_id->CurrentValue = $this->customer_id->FormValue;
		$this->full_name->CurrentValue = $this->full_name->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->reward->CurrentValue = $this->reward->FormValue;
		$this->user_name->CurrentValue = $this->user_name->FormValue;
		$this->user_pass->CurrentValue = $this->user_pass->FormValue;
		$this->activity_status->CurrentValue = $this->activity_status->FormValue;
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
		$this->customer_id->setDbValue($row['customer_id']);
		$this->full_name->setDbValue($row['full_name']);
		$this->phone->setDbValue($row['phone']);
		$this->mobile->setDbValue($row['mobile']);
		$this->reward->setDbValue($row['reward']);
		$this->user_name->setDbValue($row['user_name']);
		$this->user_pass->setDbValue($row['user_pass']);
		$this->activity_status->setDbValue($row['activity_status']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['customer_id'] = NULL;
		$row['full_name'] = NULL;
		$row['phone'] = NULL;
		$row['mobile'] = NULL;
		$row['reward'] = NULL;
		$row['user_name'] = NULL;
		$row['user_pass'] = NULL;
		$row['activity_status'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->customer_id->DbValue = $row['customer_id'];
		$this->full_name->DbValue = $row['full_name'];
		$this->phone->DbValue = $row['phone'];
		$this->mobile->DbValue = $row['mobile'];
		$this->reward->DbValue = $row['reward'];
		$this->user_name->DbValue = $row['user_name'];
		$this->user_pass->DbValue = $row['user_pass'];
		$this->activity_status->DbValue = $row['activity_status'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("customer_id")) <> "")
			$this->customer_id->CurrentValue = $this->getKey("customer_id"); // customer_id
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
		// customer_id
		// full_name
		// phone
		// mobile
		// reward
		// user_name
		// user_pass
		// activity_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// customer_id
		$this->customer_id->ViewValue = $this->customer_id->CurrentValue;
		$this->customer_id->ViewCustomAttributes = "";

		// full_name
		$this->full_name->ViewValue = $this->full_name->CurrentValue;
		$this->full_name->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

		// reward
		$this->reward->ViewValue = $this->reward->CurrentValue;
		$this->reward->ViewCustomAttributes = "";

		// user_name
		$this->user_name->ViewValue = $this->user_name->CurrentValue;
		$this->user_name->ViewCustomAttributes = "";

		// user_pass
		$this->user_pass->ViewValue = $Language->Phrase("PasswordMask");
		$this->user_pass->ViewCustomAttributes = "";

		// activity_status
		if (strval($this->activity_status->CurrentValue) <> "") {
			$this->activity_status->ViewValue = $this->activity_status->OptionCaption($this->activity_status->CurrentValue);
		} else {
			$this->activity_status->ViewValue = NULL;
		}
		$this->activity_status->ViewCustomAttributes = "";

			// customer_id
			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";
			$this->customer_id->TooltipValue = "";

			// full_name
			$this->full_name->LinkCustomAttributes = "";
			$this->full_name->HrefValue = "";
			$this->full_name->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

			// reward
			$this->reward->LinkCustomAttributes = "";
			$this->reward->HrefValue = "";
			$this->reward->TooltipValue = "";

			// user_name
			$this->user_name->LinkCustomAttributes = "";
			$this->user_name->HrefValue = "";
			$this->user_name->TooltipValue = "";

			// user_pass
			$this->user_pass->LinkCustomAttributes = "";
			$this->user_pass->HrefValue = "";
			$this->user_pass->TooltipValue = "";

			// activity_status
			$this->activity_status->LinkCustomAttributes = "";
			$this->activity_status->HrefValue = "";
			$this->activity_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// customer_id
			$this->customer_id->EditAttrs["class"] = "form-control";
			$this->customer_id->EditCustomAttributes = "";
			$this->customer_id->EditValue = $this->customer_id->CurrentValue;
			$this->customer_id->ViewCustomAttributes = "";

			// full_name
			$this->full_name->EditAttrs["class"] = "form-control";
			$this->full_name->EditCustomAttributes = "";
			$this->full_name->EditValue = ew_HtmlEncode($this->full_name->CurrentValue);
			$this->full_name->PlaceHolder = ew_RemoveHtml($this->full_name->FldCaption());

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

			// reward
			$this->reward->EditAttrs["class"] = "form-control";
			$this->reward->EditCustomAttributes = "";
			$this->reward->EditValue = ew_HtmlEncode($this->reward->CurrentValue);
			$this->reward->PlaceHolder = ew_RemoveHtml($this->reward->FldCaption());

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

			// activity_status
			$this->activity_status->EditCustomAttributes = "";
			$this->activity_status->EditValue = $this->activity_status->Options(FALSE);

			// Edit refer script
			// customer_id

			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";

			// full_name
			$this->full_name->LinkCustomAttributes = "";
			$this->full_name->HrefValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// reward
			$this->reward->LinkCustomAttributes = "";
			$this->reward->HrefValue = "";

			// user_name
			$this->user_name->LinkCustomAttributes = "";
			$this->user_name->HrefValue = "";

			// user_pass
			$this->user_pass->LinkCustomAttributes = "";
			$this->user_pass->HrefValue = "";

			// activity_status
			$this->activity_status->LinkCustomAttributes = "";
			$this->activity_status->HrefValue = "";
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
		if (!ew_CheckInteger($this->reward->FormValue)) {
			ew_AddMessage($gsFormError, $this->reward->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("addresses", $DetailTblVar) && $GLOBALS["addresses"]->DetailEdit) {
			if (!isset($GLOBALS["addresses_grid"])) $GLOBALS["addresses_grid"] = new caddresses_grid(); // get detail page object
			$GLOBALS["addresses_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// full_name
			$this->full_name->SetDbValueDef($rsnew, $this->full_name->CurrentValue, NULL, $this->full_name->ReadOnly);

			// phone
			$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, $this->phone->ReadOnly);

			// mobile
			$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, NULL, $this->mobile->ReadOnly);

			// reward
			$this->reward->SetDbValueDef($rsnew, $this->reward->CurrentValue, NULL, $this->reward->ReadOnly);

			// user_name
			$this->user_name->SetDbValueDef($rsnew, $this->user_name->CurrentValue, NULL, $this->user_name->ReadOnly);

			// user_pass
			$this->user_pass->SetDbValueDef($rsnew, $this->user_pass->CurrentValue, NULL, $this->user_pass->ReadOnly);

			// activity_status
			$this->activity_status->SetDbValueDef($rsnew, $this->activity_status->CurrentValue, NULL, $this->activity_status->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("addresses", $DetailTblVar) && $GLOBALS["addresses"]->DetailEdit) {
						if (!isset($GLOBALS["addresses_grid"])) $GLOBALS["addresses_grid"] = new caddresses_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "addresses"); // Load user level of detail table
						$EditRow = $GLOBALS["addresses_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("addresses", $DetailTblVar)) {
				if (!isset($GLOBALS["addresses_grid"]))
					$GLOBALS["addresses_grid"] = new caddresses_grid;
				if ($GLOBALS["addresses_grid"]->DetailEdit) {
					$GLOBALS["addresses_grid"]->CurrentMode = "edit";
					$GLOBALS["addresses_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["addresses_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["addresses_grid"]->setStartRecordNumber(1);
					$GLOBALS["addresses_grid"]->customer_id->FldIsDetailKey = TRUE;
					$GLOBALS["addresses_grid"]->customer_id->CurrentValue = $this->customer_id->CurrentValue;
					$GLOBALS["addresses_grid"]->customer_id->setSessionValue($GLOBALS["addresses_grid"]->customer_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("customerslist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($customers_edit)) $customers_edit = new ccustomers_edit();

// Page init
$customers_edit->Page_Init();

// Page main
$customers_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$customers_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcustomersedit = new ew_Form("fcustomersedit", "edit");

// Validate form
fcustomersedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_reward");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($customers->reward->FldErrMsg()) ?>");

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
fcustomersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcustomersedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcustomersedit.Lists["x_activity_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcustomersedit.Lists["x_activity_status"].Options = <?php echo json_encode($customers_edit->activity_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $customers_edit->ShowPageHeader(); ?>
<?php
$customers_edit->ShowMessage();
?>
<form name="fcustomersedit" id="fcustomersedit" class="<?php echo $customers_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($customers_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $customers_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="customers">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($customers_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($customers->customer_id->Visible) { // customer_id ?>
	<div id="r_customer_id" class="form-group">
		<label id="elh_customers_customer_id" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->customer_id->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->customer_id->CellAttributes() ?>>
<span id="el_customers_customer_id">
<span<?php echo $customers->customer_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $customers->customer_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="customers" data-field="x_customer_id" name="x_customer_id" id="x_customer_id" value="<?php echo ew_HtmlEncode($customers->customer_id->CurrentValue) ?>">
<?php echo $customers->customer_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->full_name->Visible) { // full_name ?>
	<div id="r_full_name" class="form-group">
		<label id="elh_customers_full_name" for="x_full_name" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->full_name->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->full_name->CellAttributes() ?>>
<span id="el_customers_full_name">
<input type="text" data-table="customers" data-field="x_full_name" name="x_full_name" id="x_full_name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->full_name->getPlaceHolder()) ?>" value="<?php echo $customers->full_name->EditValue ?>"<?php echo $customers->full_name->EditAttributes() ?>>
</span>
<?php echo $customers->full_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_customers_phone" for="x_phone" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->phone->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->phone->CellAttributes() ?>>
<span id="el_customers_phone">
<input type="text" data-table="customers" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($customers->phone->getPlaceHolder()) ?>" value="<?php echo $customers->phone->EditValue ?>"<?php echo $customers->phone->EditAttributes() ?>>
</span>
<?php echo $customers->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_customers_mobile" for="x_mobile" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->mobile->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->mobile->CellAttributes() ?>>
<span id="el_customers_mobile">
<input type="text" data-table="customers" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($customers->mobile->getPlaceHolder()) ?>" value="<?php echo $customers->mobile->EditValue ?>"<?php echo $customers->mobile->EditAttributes() ?>>
</span>
<?php echo $customers->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->reward->Visible) { // reward ?>
	<div id="r_reward" class="form-group">
		<label id="elh_customers_reward" for="x_reward" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->reward->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->reward->CellAttributes() ?>>
<span id="el_customers_reward">
<input type="text" data-table="customers" data-field="x_reward" name="x_reward" id="x_reward" size="30" placeholder="<?php echo ew_HtmlEncode($customers->reward->getPlaceHolder()) ?>" value="<?php echo $customers->reward->EditValue ?>"<?php echo $customers->reward->EditAttributes() ?>>
</span>
<?php echo $customers->reward->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->user_name->Visible) { // user_name ?>
	<div id="r_user_name" class="form-group">
		<label id="elh_customers_user_name" for="x_user_name" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->user_name->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->user_name->CellAttributes() ?>>
<span id="el_customers_user_name">
<input type="text" data-table="customers" data-field="x_user_name" name="x_user_name" id="x_user_name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->user_name->getPlaceHolder()) ?>" value="<?php echo $customers->user_name->EditValue ?>"<?php echo $customers->user_name->EditAttributes() ?>>
</span>
<?php echo $customers->user_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->user_pass->Visible) { // user_pass ?>
	<div id="r_user_pass" class="form-group">
		<label id="elh_customers_user_pass" for="x_user_pass" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->user_pass->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->user_pass->CellAttributes() ?>>
<span id="el_customers_user_pass">
<input type="password" data-field="x_user_pass" name="x_user_pass" id="x_user_pass" value="<?php echo $customers->user_pass->EditValue ?>" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->user_pass->getPlaceHolder()) ?>"<?php echo $customers->user_pass->EditAttributes() ?>>
</span>
<?php echo $customers->user_pass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->activity_status->Visible) { // activity_status ?>
	<div id="r_activity_status" class="form-group">
		<label id="elh_customers_activity_status" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->activity_status->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->activity_status->CellAttributes() ?>>
<span id="el_customers_activity_status">
<div id="tp_x_activity_status" class="ewTemplate"><input type="radio" data-table="customers" data-field="x_activity_status" data-value-separator="<?php echo $customers->activity_status->DisplayValueSeparatorAttribute() ?>" name="x_activity_status" id="x_activity_status" value="{value}"<?php echo $customers->activity_status->EditAttributes() ?>></div>
<div id="dsl_x_activity_status" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $customers->activity_status->RadioButtonListHtml(FALSE, "x_activity_status") ?>
</div></div>
</span>
<?php echo $customers->activity_status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("addresses", explode(",", $customers->getCurrentDetailTable())) && $addresses->DetailEdit) {
?>
<?php if ($customers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("addresses", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "addressesgrid.php" ?>
<?php } ?>
<?php if (!$customers_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $customers_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $customers_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcustomersedit.Init();
</script>
<?php
$customers_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$customers_edit->Page_Terminate();
?>
