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

$customers_add = NULL; // Initialize page object first

class ccustomers_add extends ccustomers {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'customers';

	// Page object name
	var $PageObjName = 'customers_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
		if (!$Security->CanAdd()) {
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
			if (@$_GET["customer_id"] != "") {
				$this->customer_id->setQueryStringValue($_GET["customer_id"]);
				$this->setKey("customer_id", $this->customer_id->CurrentValue); // Set up key
			} else {
				$this->setKey("customer_id", ""); // Clear key
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

		// Set up detail parameters
		$this->SetupDetailParms();

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
					$this->Page_Terminate("customerslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "customerslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "customersview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->customer_id->CurrentValue = NULL;
		$this->customer_id->OldValue = $this->customer_id->CurrentValue;
		$this->full_name->CurrentValue = NULL;
		$this->full_name->OldValue = $this->full_name->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->mobile->CurrentValue = NULL;
		$this->mobile->OldValue = $this->mobile->CurrentValue;
		$this->reward->CurrentValue = NULL;
		$this->reward->OldValue = $this->reward->CurrentValue;
		$this->user_name->CurrentValue = NULL;
		$this->user_name->OldValue = $this->user_name->CurrentValue;
		$this->user_pass->CurrentValue = NULL;
		$this->user_pass->OldValue = $this->user_pass->CurrentValue;
		$this->activity_status->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
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
		$this->LoadDefaultValues();
		$row = array();
		$row['customer_id'] = $this->customer_id->CurrentValue;
		$row['full_name'] = $this->full_name->CurrentValue;
		$row['phone'] = $this->phone->CurrentValue;
		$row['mobile'] = $this->mobile->CurrentValue;
		$row['reward'] = $this->reward->CurrentValue;
		$row['user_name'] = $this->user_name->CurrentValue;
		$row['user_pass'] = $this->user_pass->CurrentValue;
		$row['activity_status'] = $this->activity_status->CurrentValue;
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

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

			// Add refer script
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
		if (in_array("addresses", $DetailTblVar) && $GLOBALS["addresses"]->DetailAdd) {
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// full_name
		$this->full_name->SetDbValueDef($rsnew, $this->full_name->CurrentValue, NULL, FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// mobile
		$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, NULL, FALSE);

		// reward
		$this->reward->SetDbValueDef($rsnew, $this->reward->CurrentValue, NULL, FALSE);

		// user_name
		$this->user_name->SetDbValueDef($rsnew, $this->user_name->CurrentValue, NULL, FALSE);

		// user_pass
		$this->user_pass->SetDbValueDef($rsnew, $this->user_pass->CurrentValue, NULL, FALSE);

		// activity_status
		$this->activity_status->SetDbValueDef($rsnew, $this->activity_status->CurrentValue, NULL, strval($this->activity_status->CurrentValue) == "");

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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("addresses", $DetailTblVar) && $GLOBALS["addresses"]->DetailAdd) {
				$GLOBALS["addresses"]->customer_id->setSessionValue($this->customer_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["addresses_grid"])) $GLOBALS["addresses_grid"] = new caddresses_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "addresses"); // Load user level of detail table
				$AddRow = $GLOBALS["addresses_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["addresses"]->customer_id->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
				if ($GLOBALS["addresses_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["addresses_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["addresses_grid"]->CurrentMode = "add";
					$GLOBALS["addresses_grid"]->CurrentAction = "gridadd";

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
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($customers_add)) $customers_add = new ccustomers_add();

// Page init
$customers_add->Page_Init();

// Page main
$customers_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$customers_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcustomersadd = new ew_Form("fcustomersadd", "add");

// Validate form
fcustomersadd.Validate = function() {
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
fcustomersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fcustomersadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcustomersadd.Lists["x_activity_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcustomersadd.Lists["x_activity_status"].Options = <?php echo json_encode($customers_add->activity_status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $customers_add->ShowPageHeader(); ?>
<?php
$customers_add->ShowMessage();
?>
<form name="fcustomersadd" id="fcustomersadd" class="<?php echo $customers_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($customers_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $customers_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="customers">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($customers_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($customers->full_name->Visible) { // full_name ?>
	<div id="r_full_name" class="form-group">
		<label id="elh_customers_full_name" for="x_full_name" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->full_name->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->full_name->CellAttributes() ?>>
<span id="el_customers_full_name">
<input type="text" data-table="customers" data-field="x_full_name" name="x_full_name" id="x_full_name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->full_name->getPlaceHolder()) ?>" value="<?php echo $customers->full_name->EditValue ?>"<?php echo $customers->full_name->EditAttributes() ?>>
</span>
<?php echo $customers->full_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_customers_phone" for="x_phone" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->phone->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->phone->CellAttributes() ?>>
<span id="el_customers_phone">
<input type="text" data-table="customers" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($customers->phone->getPlaceHolder()) ?>" value="<?php echo $customers->phone->EditValue ?>"<?php echo $customers->phone->EditAttributes() ?>>
</span>
<?php echo $customers->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_customers_mobile" for="x_mobile" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->mobile->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->mobile->CellAttributes() ?>>
<span id="el_customers_mobile">
<input type="text" data-table="customers" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($customers->mobile->getPlaceHolder()) ?>" value="<?php echo $customers->mobile->EditValue ?>"<?php echo $customers->mobile->EditAttributes() ?>>
</span>
<?php echo $customers->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->reward->Visible) { // reward ?>
	<div id="r_reward" class="form-group">
		<label id="elh_customers_reward" for="x_reward" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->reward->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->reward->CellAttributes() ?>>
<span id="el_customers_reward">
<input type="text" data-table="customers" data-field="x_reward" name="x_reward" id="x_reward" size="30" placeholder="<?php echo ew_HtmlEncode($customers->reward->getPlaceHolder()) ?>" value="<?php echo $customers->reward->EditValue ?>"<?php echo $customers->reward->EditAttributes() ?>>
</span>
<?php echo $customers->reward->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->user_name->Visible) { // user_name ?>
	<div id="r_user_name" class="form-group">
		<label id="elh_customers_user_name" for="x_user_name" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->user_name->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->user_name->CellAttributes() ?>>
<span id="el_customers_user_name">
<input type="text" data-table="customers" data-field="x_user_name" name="x_user_name" id="x_user_name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->user_name->getPlaceHolder()) ?>" value="<?php echo $customers->user_name->EditValue ?>"<?php echo $customers->user_name->EditAttributes() ?>>
</span>
<?php echo $customers->user_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->user_pass->Visible) { // user_pass ?>
	<div id="r_user_pass" class="form-group">
		<label id="elh_customers_user_pass" for="x_user_pass" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->user_pass->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->user_pass->CellAttributes() ?>>
<span id="el_customers_user_pass">
<input type="password" data-field="x_user_pass" name="x_user_pass" id="x_user_pass" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->user_pass->getPlaceHolder()) ?>"<?php echo $customers->user_pass->EditAttributes() ?>>
</span>
<?php echo $customers->user_pass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->activity_status->Visible) { // activity_status ?>
	<div id="r_activity_status" class="form-group">
		<label id="elh_customers_activity_status" class="<?php echo $customers_add->LeftColumnClass ?>"><?php echo $customers->activity_status->FldCaption() ?></label>
		<div class="<?php echo $customers_add->RightColumnClass ?>"><div<?php echo $customers->activity_status->CellAttributes() ?>>
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
	if (in_array("addresses", explode(",", $customers->getCurrentDetailTable())) && $addresses->DetailAdd) {
?>
<?php if ($customers->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("addresses", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "addressesgrid.php" ?>
<?php } ?>
<?php if (!$customers_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $customers_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $customers_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fcustomersadd.Init();
</script>
<?php
$customers_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$customers_add->Page_Terminate();
?>
