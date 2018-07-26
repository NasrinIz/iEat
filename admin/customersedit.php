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
		$this->CustomerID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->CustomerID->Visible = FALSE;
		$this->FullName->SetVisibility();
		$this->Phone->SetVisibility();
		$this->Mobile->SetVisibility();
		$this->Reward->SetVisibility();
		$this->UserName->SetVisibility();
		$this->UserPass->SetVisibility();
		$this->ActivityStatus->SetVisibility();

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
			if ($objForm->HasValue("x_CustomerID")) {
				$this->CustomerID->setFormValue($objForm->GetValue("x_CustomerID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["CustomerID"])) {
				$this->CustomerID->setQueryStringValue($_GET["CustomerID"]);
				$loadByQuery = TRUE;
			} else {
				$this->CustomerID->CurrentValue = NULL;
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
		if (!$this->CustomerID->FldIsDetailKey)
			$this->CustomerID->setFormValue($objForm->GetValue("x_CustomerID"));
		if (!$this->FullName->FldIsDetailKey) {
			$this->FullName->setFormValue($objForm->GetValue("x_FullName"));
		}
		if (!$this->Phone->FldIsDetailKey) {
			$this->Phone->setFormValue($objForm->GetValue("x_Phone"));
		}
		if (!$this->Mobile->FldIsDetailKey) {
			$this->Mobile->setFormValue($objForm->GetValue("x_Mobile"));
		}
		if (!$this->Reward->FldIsDetailKey) {
			$this->Reward->setFormValue($objForm->GetValue("x_Reward"));
		}
		if (!$this->UserName->FldIsDetailKey) {
			$this->UserName->setFormValue($objForm->GetValue("x_UserName"));
		}
		if (!$this->UserPass->FldIsDetailKey) {
			$this->UserPass->setFormValue($objForm->GetValue("x_UserPass"));
		}
		if (!$this->ActivityStatus->FldIsDetailKey) {
			$this->ActivityStatus->setFormValue($objForm->GetValue("x_ActivityStatus"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->CustomerID->CurrentValue = $this->CustomerID->FormValue;
		$this->FullName->CurrentValue = $this->FullName->FormValue;
		$this->Phone->CurrentValue = $this->Phone->FormValue;
		$this->Mobile->CurrentValue = $this->Mobile->FormValue;
		$this->Reward->CurrentValue = $this->Reward->FormValue;
		$this->UserName->CurrentValue = $this->UserName->FormValue;
		$this->UserPass->CurrentValue = $this->UserPass->FormValue;
		$this->ActivityStatus->CurrentValue = $this->ActivityStatus->FormValue;
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
		$this->CustomerID->setDbValue($row['CustomerID']);
		$this->FullName->setDbValue($row['FullName']);
		$this->Phone->setDbValue($row['Phone']);
		$this->Mobile->setDbValue($row['Mobile']);
		$this->Reward->setDbValue($row['Reward']);
		$this->UserName->setDbValue($row['UserName']);
		$this->UserPass->setDbValue($row['UserPass']);
		$this->ActivityStatus->setDbValue($row['ActivityStatus']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['CustomerID'] = NULL;
		$row['FullName'] = NULL;
		$row['Phone'] = NULL;
		$row['Mobile'] = NULL;
		$row['Reward'] = NULL;
		$row['UserName'] = NULL;
		$row['UserPass'] = NULL;
		$row['ActivityStatus'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->CustomerID->DbValue = $row['CustomerID'];
		$this->FullName->DbValue = $row['FullName'];
		$this->Phone->DbValue = $row['Phone'];
		$this->Mobile->DbValue = $row['Mobile'];
		$this->Reward->DbValue = $row['Reward'];
		$this->UserName->DbValue = $row['UserName'];
		$this->UserPass->DbValue = $row['UserPass'];
		$this->ActivityStatus->DbValue = $row['ActivityStatus'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("CustomerID")) <> "")
			$this->CustomerID->CurrentValue = $this->getKey("CustomerID"); // CustomerID
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
		// CustomerID
		// FullName
		// Phone
		// Mobile
		// Reward
		// UserName
		// UserPass
		// ActivityStatus

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// CustomerID
		$this->CustomerID->ViewValue = $this->CustomerID->CurrentValue;
		$this->CustomerID->ViewCustomAttributes = "";

		// FullName
		$this->FullName->ViewValue = $this->FullName->CurrentValue;
		$this->FullName->ViewCustomAttributes = "";

		// Phone
		$this->Phone->ViewValue = $this->Phone->CurrentValue;
		$this->Phone->ViewCustomAttributes = "";

		// Mobile
		$this->Mobile->ViewValue = $this->Mobile->CurrentValue;
		$this->Mobile->ViewCustomAttributes = "";

		// Reward
		$this->Reward->ViewValue = $this->Reward->CurrentValue;
		$this->Reward->ViewCustomAttributes = "";

		// UserName
		$this->UserName->ViewValue = $this->UserName->CurrentValue;
		$this->UserName->ViewCustomAttributes = "";

		// UserPass
		$this->UserPass->ViewValue = $Language->Phrase("PasswordMask");
		$this->UserPass->ViewCustomAttributes = "";

		// ActivityStatus
		if (strval($this->ActivityStatus->CurrentValue) <> "") {
			$this->ActivityStatus->ViewValue = $this->ActivityStatus->OptionCaption($this->ActivityStatus->CurrentValue);
		} else {
			$this->ActivityStatus->ViewValue = NULL;
		}
		$this->ActivityStatus->ViewCustomAttributes = "";

			// CustomerID
			$this->CustomerID->LinkCustomAttributes = "";
			$this->CustomerID->HrefValue = "";
			$this->CustomerID->TooltipValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";
			$this->FullName->TooltipValue = "";

			// Phone
			$this->Phone->LinkCustomAttributes = "";
			$this->Phone->HrefValue = "";
			$this->Phone->TooltipValue = "";

			// Mobile
			$this->Mobile->LinkCustomAttributes = "";
			$this->Mobile->HrefValue = "";
			$this->Mobile->TooltipValue = "";

			// Reward
			$this->Reward->LinkCustomAttributes = "";
			$this->Reward->HrefValue = "";
			$this->Reward->TooltipValue = "";

			// UserName
			$this->UserName->LinkCustomAttributes = "";
			$this->UserName->HrefValue = "";
			$this->UserName->TooltipValue = "";

			// UserPass
			$this->UserPass->LinkCustomAttributes = "";
			$this->UserPass->HrefValue = "";
			$this->UserPass->TooltipValue = "";

			// ActivityStatus
			$this->ActivityStatus->LinkCustomAttributes = "";
			$this->ActivityStatus->HrefValue = "";
			$this->ActivityStatus->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// CustomerID
			$this->CustomerID->EditAttrs["class"] = "form-control";
			$this->CustomerID->EditCustomAttributes = "";
			$this->CustomerID->EditValue = $this->CustomerID->CurrentValue;
			$this->CustomerID->ViewCustomAttributes = "";

			// FullName
			$this->FullName->EditAttrs["class"] = "form-control";
			$this->FullName->EditCustomAttributes = "";
			$this->FullName->EditValue = ew_HtmlEncode($this->FullName->CurrentValue);
			$this->FullName->PlaceHolder = ew_RemoveHtml($this->FullName->FldCaption());

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

			// Reward
			$this->Reward->EditAttrs["class"] = "form-control";
			$this->Reward->EditCustomAttributes = "";
			$this->Reward->EditValue = ew_HtmlEncode($this->Reward->CurrentValue);
			$this->Reward->PlaceHolder = ew_RemoveHtml($this->Reward->FldCaption());

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

			// ActivityStatus
			$this->ActivityStatus->EditCustomAttributes = "";
			$this->ActivityStatus->EditValue = $this->ActivityStatus->Options(FALSE);

			// Edit refer script
			// CustomerID

			$this->CustomerID->LinkCustomAttributes = "";
			$this->CustomerID->HrefValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";

			// Phone
			$this->Phone->LinkCustomAttributes = "";
			$this->Phone->HrefValue = "";

			// Mobile
			$this->Mobile->LinkCustomAttributes = "";
			$this->Mobile->HrefValue = "";

			// Reward
			$this->Reward->LinkCustomAttributes = "";
			$this->Reward->HrefValue = "";

			// UserName
			$this->UserName->LinkCustomAttributes = "";
			$this->UserName->HrefValue = "";

			// UserPass
			$this->UserPass->LinkCustomAttributes = "";
			$this->UserPass->HrefValue = "";

			// ActivityStatus
			$this->ActivityStatus->LinkCustomAttributes = "";
			$this->ActivityStatus->HrefValue = "";
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
		if (!ew_CheckInteger($this->Reward->FormValue)) {
			ew_AddMessage($gsFormError, $this->Reward->FldErrMsg());
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

			// FullName
			$this->FullName->SetDbValueDef($rsnew, $this->FullName->CurrentValue, NULL, $this->FullName->ReadOnly);

			// Phone
			$this->Phone->SetDbValueDef($rsnew, $this->Phone->CurrentValue, NULL, $this->Phone->ReadOnly);

			// Mobile
			$this->Mobile->SetDbValueDef($rsnew, $this->Mobile->CurrentValue, NULL, $this->Mobile->ReadOnly);

			// Reward
			$this->Reward->SetDbValueDef($rsnew, $this->Reward->CurrentValue, NULL, $this->Reward->ReadOnly);

			// UserName
			$this->UserName->SetDbValueDef($rsnew, $this->UserName->CurrentValue, NULL, $this->UserName->ReadOnly);

			// UserPass
			$this->UserPass->SetDbValueDef($rsnew, $this->UserPass->CurrentValue, NULL, $this->UserPass->ReadOnly);

			// ActivityStatus
			$this->ActivityStatus->SetDbValueDef($rsnew, $this->ActivityStatus->CurrentValue, NULL, $this->ActivityStatus->ReadOnly);

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
					$GLOBALS["addresses_grid"]->CustomerID->FldIsDetailKey = TRUE;
					$GLOBALS["addresses_grid"]->CustomerID->CurrentValue = $this->CustomerID->CurrentValue;
					$GLOBALS["addresses_grid"]->CustomerID->setSessionValue($GLOBALS["addresses_grid"]->CustomerID->CurrentValue);
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
			elm = this.GetElements("x" + infix + "_Reward");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($customers->Reward->FldErrMsg()) ?>");

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
fcustomersedit.Lists["x_ActivityStatus"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcustomersedit.Lists["x_ActivityStatus"].Options = <?php echo json_encode($customers_edit->ActivityStatus->Options()) ?>;

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
<?php if ($customers->CustomerID->Visible) { // CustomerID ?>
	<div id="r_CustomerID" class="form-group">
		<label id="elh_customers_CustomerID" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->CustomerID->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->CustomerID->CellAttributes() ?>>
<span id="el_customers_CustomerID">
<span<?php echo $customers->CustomerID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $customers->CustomerID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="customers" data-field="x_CustomerID" name="x_CustomerID" id="x_CustomerID" value="<?php echo ew_HtmlEncode($customers->CustomerID->CurrentValue) ?>">
<?php echo $customers->CustomerID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->FullName->Visible) { // FullName ?>
	<div id="r_FullName" class="form-group">
		<label id="elh_customers_FullName" for="x_FullName" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->FullName->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->FullName->CellAttributes() ?>>
<span id="el_customers_FullName">
<input type="text" data-table="customers" data-field="x_FullName" name="x_FullName" id="x_FullName" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->FullName->getPlaceHolder()) ?>" value="<?php echo $customers->FullName->EditValue ?>"<?php echo $customers->FullName->EditAttributes() ?>>
</span>
<?php echo $customers->FullName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->Phone->Visible) { // Phone ?>
	<div id="r_Phone" class="form-group">
		<label id="elh_customers_Phone" for="x_Phone" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->Phone->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->Phone->CellAttributes() ?>>
<span id="el_customers_Phone">
<input type="text" data-table="customers" data-field="x_Phone" name="x_Phone" id="x_Phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($customers->Phone->getPlaceHolder()) ?>" value="<?php echo $customers->Phone->EditValue ?>"<?php echo $customers->Phone->EditAttributes() ?>>
</span>
<?php echo $customers->Phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->Mobile->Visible) { // Mobile ?>
	<div id="r_Mobile" class="form-group">
		<label id="elh_customers_Mobile" for="x_Mobile" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->Mobile->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->Mobile->CellAttributes() ?>>
<span id="el_customers_Mobile">
<input type="text" data-table="customers" data-field="x_Mobile" name="x_Mobile" id="x_Mobile" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($customers->Mobile->getPlaceHolder()) ?>" value="<?php echo $customers->Mobile->EditValue ?>"<?php echo $customers->Mobile->EditAttributes() ?>>
</span>
<?php echo $customers->Mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->Reward->Visible) { // Reward ?>
	<div id="r_Reward" class="form-group">
		<label id="elh_customers_Reward" for="x_Reward" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->Reward->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->Reward->CellAttributes() ?>>
<span id="el_customers_Reward">
<input type="text" data-table="customers" data-field="x_Reward" name="x_Reward" id="x_Reward" size="30" placeholder="<?php echo ew_HtmlEncode($customers->Reward->getPlaceHolder()) ?>" value="<?php echo $customers->Reward->EditValue ?>"<?php echo $customers->Reward->EditAttributes() ?>>
</span>
<?php echo $customers->Reward->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->UserName->Visible) { // UserName ?>
	<div id="r_UserName" class="form-group">
		<label id="elh_customers_UserName" for="x_UserName" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->UserName->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->UserName->CellAttributes() ?>>
<span id="el_customers_UserName">
<input type="text" data-table="customers" data-field="x_UserName" name="x_UserName" id="x_UserName" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->UserName->getPlaceHolder()) ?>" value="<?php echo $customers->UserName->EditValue ?>"<?php echo $customers->UserName->EditAttributes() ?>>
</span>
<?php echo $customers->UserName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->UserPass->Visible) { // UserPass ?>
	<div id="r_UserPass" class="form-group">
		<label id="elh_customers_UserPass" for="x_UserPass" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->UserPass->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->UserPass->CellAttributes() ?>>
<span id="el_customers_UserPass">
<input type="password" data-field="x_UserPass" name="x_UserPass" id="x_UserPass" value="<?php echo $customers->UserPass->EditValue ?>" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($customers->UserPass->getPlaceHolder()) ?>"<?php echo $customers->UserPass->EditAttributes() ?>>
</span>
<?php echo $customers->UserPass->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($customers->ActivityStatus->Visible) { // ActivityStatus ?>
	<div id="r_ActivityStatus" class="form-group">
		<label id="elh_customers_ActivityStatus" class="<?php echo $customers_edit->LeftColumnClass ?>"><?php echo $customers->ActivityStatus->FldCaption() ?></label>
		<div class="<?php echo $customers_edit->RightColumnClass ?>"><div<?php echo $customers->ActivityStatus->CellAttributes() ?>>
<span id="el_customers_ActivityStatus">
<div id="tp_x_ActivityStatus" class="ewTemplate"><input type="radio" data-table="customers" data-field="x_ActivityStatus" data-value-separator="<?php echo $customers->ActivityStatus->DisplayValueSeparatorAttribute() ?>" name="x_ActivityStatus" id="x_ActivityStatus" value="{value}"<?php echo $customers->ActivityStatus->EditAttributes() ?>></div>
<div id="dsl_x_ActivityStatus" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $customers->ActivityStatus->RadioButtonListHtml(FALSE, "x_ActivityStatus") ?>
</div></div>
</span>
<?php echo $customers->ActivityStatus->CustomMsg ?></div></div>
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
