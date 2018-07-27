<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ordersinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "order_detailsgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$orders_add = NULL; // Initialize page object first

class corders_add extends corders {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("orderslist.php"));
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
		$this->full_name->SetVisibility();
		$this->province_id->SetVisibility();
		$this->address->SetVisibility();
		$this->zip_code->SetVisibility();
		$this->phone->SetVisibility();
		$this->discount->SetVisibility();
		$this->total_price->SetVisibility();
		$this->payment_type_id->SetVisibility();
		$this->delivery_type_id->SetVisibility();
		$this->description->SetVisibility();
		$this->feedback->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("order_details", $DetailTblVar)) {

					// Process auto fill for detail table 'order_details'
					if (preg_match('/^forder_details(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["order_details_grid"])) $GLOBALS["order_details_grid"] = new corder_details_grid;
						$GLOBALS["order_details_grid"]->Page_Init();
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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "ordersview.php")
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
			if (@$_GET["order_id"] != "") {
				$this->order_id->setQueryStringValue($_GET["order_id"]);
				$this->setKey("order_id", $this->order_id->CurrentValue); // Set up key
			} else {
				$this->setKey("order_id", ""); // Clear key
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
					$this->Page_Terminate("orderslist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "orderslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "ordersview.php")
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
		$this->order_id->CurrentValue = NULL;
		$this->order_id->OldValue = $this->order_id->CurrentValue;
		$this->customer_id->CurrentValue = NULL;
		$this->customer_id->OldValue = $this->customer_id->CurrentValue;
		$this->full_name->CurrentValue = NULL;
		$this->full_name->OldValue = $this->full_name->CurrentValue;
		$this->province_id->CurrentValue = NULL;
		$this->province_id->OldValue = $this->province_id->CurrentValue;
		$this->address->CurrentValue = NULL;
		$this->address->OldValue = $this->address->CurrentValue;
		$this->zip_code->CurrentValue = NULL;
		$this->zip_code->OldValue = $this->zip_code->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->discount->CurrentValue = 0;
		$this->total_price->CurrentValue = NULL;
		$this->total_price->OldValue = $this->total_price->CurrentValue;
		$this->payment_type_id->CurrentValue = NULL;
		$this->payment_type_id->OldValue = $this->payment_type_id->CurrentValue;
		$this->delivery_type_id->CurrentValue = NULL;
		$this->delivery_type_id->OldValue = $this->delivery_type_id->CurrentValue;
		$this->description->CurrentValue = NULL;
		$this->description->OldValue = $this->description->CurrentValue;
		$this->feedback->CurrentValue = NULL;
		$this->feedback->OldValue = $this->feedback->CurrentValue;
		$this->order_date_time->CurrentValue = NULL;
		$this->order_date_time->OldValue = $this->order_date_time->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->customer_id->FldIsDetailKey) {
			$this->customer_id->setFormValue($objForm->GetValue("x_customer_id"));
		}
		if (!$this->full_name->FldIsDetailKey) {
			$this->full_name->setFormValue($objForm->GetValue("x_full_name"));
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
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->discount->FldIsDetailKey) {
			$this->discount->setFormValue($objForm->GetValue("x_discount"));
		}
		if (!$this->total_price->FldIsDetailKey) {
			$this->total_price->setFormValue($objForm->GetValue("x_total_price"));
		}
		if (!$this->payment_type_id->FldIsDetailKey) {
			$this->payment_type_id->setFormValue($objForm->GetValue("x_payment_type_id"));
		}
		if (!$this->delivery_type_id->FldIsDetailKey) {
			$this->delivery_type_id->setFormValue($objForm->GetValue("x_delivery_type_id"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->feedback->FldIsDetailKey) {
			$this->feedback->setFormValue($objForm->GetValue("x_feedback"));
		}
		if (!$this->order_date_time->FldIsDetailKey) {
			$this->order_date_time->setFormValue($objForm->GetValue("x_order_date_time"));
			$this->order_date_time->CurrentValue = ew_UnFormatDateTime($this->order_date_time->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->customer_id->CurrentValue = $this->customer_id->FormValue;
		$this->full_name->CurrentValue = $this->full_name->FormValue;
		$this->province_id->CurrentValue = $this->province_id->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->zip_code->CurrentValue = $this->zip_code->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->discount->CurrentValue = $this->discount->FormValue;
		$this->total_price->CurrentValue = $this->total_price->FormValue;
		$this->payment_type_id->CurrentValue = $this->payment_type_id->FormValue;
		$this->delivery_type_id->CurrentValue = $this->delivery_type_id->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->feedback->CurrentValue = $this->feedback->FormValue;
		$this->order_date_time->CurrentValue = $this->order_date_time->FormValue;
		$this->order_date_time->CurrentValue = ew_UnFormatDateTime($this->order_date_time->CurrentValue, 0);
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
		$this->LoadDefaultValues();
		$row = array();
		$row['order_id'] = $this->order_id->CurrentValue;
		$row['customer_id'] = $this->customer_id->CurrentValue;
		$row['full_name'] = $this->full_name->CurrentValue;
		$row['province_id'] = $this->province_id->CurrentValue;
		$row['address'] = $this->address->CurrentValue;
		$row['zip_code'] = $this->zip_code->CurrentValue;
		$row['phone'] = $this->phone->CurrentValue;
		$row['discount'] = $this->discount->CurrentValue;
		$row['total_price'] = $this->total_price->CurrentValue;
		$row['payment_type_id'] = $this->payment_type_id->CurrentValue;
		$row['delivery_type_id'] = $this->delivery_type_id->CurrentValue;
		$row['description'] = $this->description->CurrentValue;
		$row['feedback'] = $this->feedback->CurrentValue;
		$row['order_date_time'] = $this->order_date_time->CurrentValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("order_id")) <> "")
			$this->order_id->CurrentValue = $this->getKey("order_id"); // order_id
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

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

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

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// feedback
		$this->feedback->ViewValue = $this->feedback->CurrentValue;
		$this->feedback->ViewCustomAttributes = "";

		// order_date_time
		$this->order_date_time->ViewValue = $this->order_date_time->CurrentValue;
		$this->order_date_time->ViewValue = ew_FormatDateTime($this->order_date_time->ViewValue, 0);
		$this->order_date_time->ViewCustomAttributes = "";

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

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

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

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

			// feedback
			$this->feedback->LinkCustomAttributes = "";
			$this->feedback->HrefValue = "";
			$this->feedback->TooltipValue = "";

			// order_date_time
			$this->order_date_time->LinkCustomAttributes = "";
			$this->order_date_time->HrefValue = "";
			$this->order_date_time->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// customer_id
			$this->customer_id->EditAttrs["class"] = "form-control";
			$this->customer_id->EditCustomAttributes = "";
			if (trim(strval($this->customer_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`customer_id`" . ew_SearchString("=", $this->customer_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `customer_id`, `full_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `customers`";
			$sWhereWrk = "";
			$this->customer_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->customer_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `full_name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->customer_id->EditValue = $arwrk;

			// full_name
			$this->full_name->EditAttrs["class"] = "form-control";
			$this->full_name->EditCustomAttributes = "";
			$this->full_name->EditValue = ew_HtmlEncode($this->full_name->CurrentValue);
			$this->full_name->PlaceHolder = ew_RemoveHtml($this->full_name->FldCaption());

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

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// discount
			$this->discount->EditAttrs["class"] = "form-control";
			$this->discount->EditCustomAttributes = "";
			$this->discount->EditValue = ew_HtmlEncode($this->discount->CurrentValue);
			$this->discount->PlaceHolder = ew_RemoveHtml($this->discount->FldCaption());
			if (strval($this->discount->EditValue) <> "" && is_numeric($this->discount->EditValue)) $this->discount->EditValue = ew_FormatNumber($this->discount->EditValue, -2, -1, -2, 0);

			// total_price
			$this->total_price->EditAttrs["class"] = "form-control";
			$this->total_price->EditCustomAttributes = "";
			$this->total_price->EditValue = ew_HtmlEncode($this->total_price->CurrentValue);
			$this->total_price->PlaceHolder = ew_RemoveHtml($this->total_price->FldCaption());
			if (strval($this->total_price->EditValue) <> "" && is_numeric($this->total_price->EditValue)) $this->total_price->EditValue = ew_FormatNumber($this->total_price->EditValue, -2, -2, -2, -2);

			// payment_type_id
			$this->payment_type_id->EditAttrs["class"] = "form-control";
			$this->payment_type_id->EditCustomAttributes = "";
			if (trim(strval($this->payment_type_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`payment_type_id`" . ew_SearchString("=", $this->payment_type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `payment_type_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `payment_types`";
			$sWhereWrk = "";
			$this->payment_type_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->payment_type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->payment_type_id->EditValue = $arwrk;

			// delivery_type_id
			$this->delivery_type_id->EditAttrs["class"] = "form-control";
			$this->delivery_type_id->EditCustomAttributes = "";
			if (trim(strval($this->delivery_type_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`delivery_type_id`" . ew_SearchString("=", $this->delivery_type_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `delivery_type_id`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `delivery_types`";
			$sWhereWrk = "";
			$this->delivery_type_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->delivery_type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->delivery_type_id->EditValue = $arwrk;

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = ew_HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

			// feedback
			$this->feedback->EditAttrs["class"] = "form-control";
			$this->feedback->EditCustomAttributes = "";
			$this->feedback->EditValue = ew_HtmlEncode($this->feedback->CurrentValue);
			$this->feedback->PlaceHolder = ew_RemoveHtml($this->feedback->FldCaption());

			// order_date_time
			// Add refer script
			// customer_id

			$this->customer_id->LinkCustomAttributes = "";
			$this->customer_id->HrefValue = "";

			// full_name
			$this->full_name->LinkCustomAttributes = "";
			$this->full_name->HrefValue = "";

			// province_id
			$this->province_id->LinkCustomAttributes = "";
			$this->province_id->HrefValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";

			// zip_code
			$this->zip_code->LinkCustomAttributes = "";
			$this->zip_code->HrefValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// discount
			$this->discount->LinkCustomAttributes = "";
			$this->discount->HrefValue = "";

			// total_price
			$this->total_price->LinkCustomAttributes = "";
			$this->total_price->HrefValue = "";

			// payment_type_id
			$this->payment_type_id->LinkCustomAttributes = "";
			$this->payment_type_id->HrefValue = "";

			// delivery_type_id
			$this->delivery_type_id->LinkCustomAttributes = "";
			$this->delivery_type_id->HrefValue = "";

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// feedback
			$this->feedback->LinkCustomAttributes = "";
			$this->feedback->HrefValue = "";

			// order_date_time
			$this->order_date_time->LinkCustomAttributes = "";
			$this->order_date_time->HrefValue = "";
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
		if (!$this->province_id->FldIsDetailKey && !is_null($this->province_id->FormValue) && $this->province_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->province_id->FldCaption(), $this->province_id->ReqErrMsg));
		}
		if (!$this->address->FldIsDetailKey && !is_null($this->address->FormValue) && $this->address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->address->FldCaption(), $this->address->ReqErrMsg));
		}
		if (!$this->zip_code->FldIsDetailKey && !is_null($this->zip_code->FormValue) && $this->zip_code->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->zip_code->FldCaption(), $this->zip_code->ReqErrMsg));
		}
		if (!$this->phone->FldIsDetailKey && !is_null($this->phone->FormValue) && $this->phone->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->phone->FldCaption(), $this->phone->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->discount->FormValue)) {
			ew_AddMessage($gsFormError, $this->discount->FldErrMsg());
		}
		if (!$this->total_price->FldIsDetailKey && !is_null($this->total_price->FormValue) && $this->total_price->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->total_price->FldCaption(), $this->total_price->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->total_price->FormValue)) {
			ew_AddMessage($gsFormError, $this->total_price->FldErrMsg());
		}
		if (!$this->payment_type_id->FldIsDetailKey && !is_null($this->payment_type_id->FormValue) && $this->payment_type_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->payment_type_id->FldCaption(), $this->payment_type_id->ReqErrMsg));
		}
		if (!$this->delivery_type_id->FldIsDetailKey && !is_null($this->delivery_type_id->FormValue) && $this->delivery_type_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->delivery_type_id->FldCaption(), $this->delivery_type_id->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("order_details", $DetailTblVar) && $GLOBALS["order_details"]->DetailAdd) {
			if (!isset($GLOBALS["order_details_grid"])) $GLOBALS["order_details_grid"] = new corder_details_grid(); // get detail page object
			$GLOBALS["order_details_grid"]->ValidateGridForm();
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

		// customer_id
		$this->customer_id->SetDbValueDef($rsnew, $this->customer_id->CurrentValue, NULL, FALSE);

		// full_name
		$this->full_name->SetDbValueDef($rsnew, $this->full_name->CurrentValue, "", FALSE);

		// province_id
		$this->province_id->SetDbValueDef($rsnew, $this->province_id->CurrentValue, 0, FALSE);

		// address
		$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, "", FALSE);

		// zip_code
		$this->zip_code->SetDbValueDef($rsnew, $this->zip_code->CurrentValue, "", FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, "", FALSE);

		// discount
		$this->discount->SetDbValueDef($rsnew, $this->discount->CurrentValue, NULL, FALSE);

		// total_price
		$this->total_price->SetDbValueDef($rsnew, $this->total_price->CurrentValue, 0, FALSE);

		// payment_type_id
		$this->payment_type_id->SetDbValueDef($rsnew, $this->payment_type_id->CurrentValue, 0, FALSE);

		// delivery_type_id
		$this->delivery_type_id->SetDbValueDef($rsnew, $this->delivery_type_id->CurrentValue, 0, FALSE);

		// description
		$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, FALSE);

		// feedback
		$this->feedback->SetDbValueDef($rsnew, $this->feedback->CurrentValue, NULL, FALSE);

		// order_date_time
		$this->order_date_time->SetDbValueDef($rsnew, ew_CurrentDateTime(), ew_CurrentDate());
		$rsnew['order_date_time'] = &$this->order_date_time->DbValue;

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
			if (in_array("order_details", $DetailTblVar) && $GLOBALS["order_details"]->DetailAdd) {
				$GLOBALS["order_details"]->order_id->setSessionValue($this->order_id->CurrentValue); // Set master key
				if (!isset($GLOBALS["order_details_grid"])) $GLOBALS["order_details_grid"] = new corder_details_grid(); // Get detail page object
				$Security->LoadCurrentUserLevel($this->ProjectID . "order_details"); // Load user level of detail table
				$AddRow = $GLOBALS["order_details_grid"]->GridInsert();
				$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
				if (!$AddRow)
					$GLOBALS["order_details"]->order_id->setSessionValue(""); // Clear master key if insert failed
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
			if (in_array("order_details", $DetailTblVar)) {
				if (!isset($GLOBALS["order_details_grid"]))
					$GLOBALS["order_details_grid"] = new corder_details_grid;
				if ($GLOBALS["order_details_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["order_details_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["order_details_grid"]->CurrentMode = "add";
					$GLOBALS["order_details_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["order_details_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["order_details_grid"]->setStartRecordNumber(1);
					$GLOBALS["order_details_grid"]->order_id->FldIsDetailKey = TRUE;
					$GLOBALS["order_details_grid"]->order_id->CurrentValue = $this->order_id->CurrentValue;
					$GLOBALS["order_details_grid"]->order_id->setSessionValue($GLOBALS["order_details_grid"]->order_id->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("orderslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_customer_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `customer_id` AS `LinkFld`, `full_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `customers`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`customer_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->customer_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `full_name`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
		case "x_payment_type_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `payment_type_id` AS `LinkFld`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `payment_types`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`payment_type_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->payment_type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `name`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_delivery_type_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `delivery_type_id` AS `LinkFld`, `name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `delivery_types`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`delivery_type_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->delivery_type_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `name`";
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
if (!isset($orders_add)) $orders_add = new corders_add();

// Page init
$orders_add->Page_Init();

// Page main
$orders_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fordersadd = new ew_Form("fordersadd", "add");

// Validate form
fordersadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->full_name->FldCaption(), $orders->full_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_province_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->province_id->FldCaption(), $orders->province_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_address");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->address->FldCaption(), $orders->address->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_zip_code");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->zip_code->FldCaption(), $orders->zip_code->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_phone");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->phone->FldCaption(), $orders->phone->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_discount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->discount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_total_price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->total_price->FldCaption(), $orders->total_price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_total_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->total_price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_payment_type_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->payment_type_id->FldCaption(), $orders->payment_type_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_delivery_type_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->delivery_type_id->FldCaption(), $orders->delivery_type_id->ReqErrMsg)) ?>");

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
fordersadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fordersadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fordersadd.Lists["x_customer_id"] = {"LinkField":"x_customer_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_full_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
fordersadd.Lists["x_customer_id"].Data = "<?php echo $orders_add->customer_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_province_id"] = {"LinkField":"x_province_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
fordersadd.Lists["x_province_id"].Data = "<?php echo $orders_add->province_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_payment_type_id"] = {"LinkField":"x_payment_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"payment_types"};
fordersadd.Lists["x_payment_type_id"].Data = "<?php echo $orders_add->payment_type_id->LookupFilterQuery(FALSE, "add") ?>";
fordersadd.Lists["x_delivery_type_id"] = {"LinkField":"x_delivery_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"delivery_types"};
fordersadd.Lists["x_delivery_type_id"].Data = "<?php echo $orders_add->delivery_type_id->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $orders_add->ShowPageHeader(); ?>
<?php
$orders_add->ShowMessage();
?>
<form name="fordersadd" id="fordersadd" class="<?php echo $orders_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($orders_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($orders->customer_id->Visible) { // customer_id ?>
	<div id="r_customer_id" class="form-group">
		<label id="elh_orders_customer_id" for="x_customer_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->customer_id->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->customer_id->CellAttributes() ?>>
<span id="el_orders_customer_id">
<select data-table="orders" data-field="x_customer_id" data-value-separator="<?php echo $orders->customer_id->DisplayValueSeparatorAttribute() ?>" id="x_customer_id" name="x_customer_id"<?php echo $orders->customer_id->EditAttributes() ?>>
<?php echo $orders->customer_id->SelectOptionListHtml("x_customer_id") ?>
</select>
</span>
<?php echo $orders->customer_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->full_name->Visible) { // full_name ?>
	<div id="r_full_name" class="form-group">
		<label id="elh_orders_full_name" for="x_full_name" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->full_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->full_name->CellAttributes() ?>>
<span id="el_orders_full_name">
<input type="text" data-table="orders" data-field="x_full_name" name="x_full_name" id="x_full_name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($orders->full_name->getPlaceHolder()) ?>" value="<?php echo $orders->full_name->EditValue ?>"<?php echo $orders->full_name->EditAttributes() ?>>
</span>
<?php echo $orders->full_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->province_id->Visible) { // province_id ?>
	<div id="r_province_id" class="form-group">
		<label id="elh_orders_province_id" for="x_province_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->province_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->province_id->CellAttributes() ?>>
<span id="el_orders_province_id">
<select data-table="orders" data-field="x_province_id" data-value-separator="<?php echo $orders->province_id->DisplayValueSeparatorAttribute() ?>" id="x_province_id" name="x_province_id"<?php echo $orders->province_id->EditAttributes() ?>>
<?php echo $orders->province_id->SelectOptionListHtml("x_province_id") ?>
</select>
</span>
<?php echo $orders->province_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->address->Visible) { // address ?>
	<div id="r_address" class="form-group">
		<label id="elh_orders_address" for="x_address" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->address->CellAttributes() ?>>
<span id="el_orders_address">
<textarea data-table="orders" data-field="x_address" name="x_address" id="x_address" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($orders->address->getPlaceHolder()) ?>"<?php echo $orders->address->EditAttributes() ?>><?php echo $orders->address->EditValue ?></textarea>
</span>
<?php echo $orders->address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->zip_code->Visible) { // zip_code ?>
	<div id="r_zip_code" class="form-group">
		<label id="elh_orders_zip_code" for="x_zip_code" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->zip_code->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->zip_code->CellAttributes() ?>>
<span id="el_orders_zip_code">
<input type="text" data-table="orders" data-field="x_zip_code" name="x_zip_code" id="x_zip_code" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($orders->zip_code->getPlaceHolder()) ?>" value="<?php echo $orders->zip_code->EditValue ?>"<?php echo $orders->zip_code->EditAttributes() ?>>
</span>
<?php echo $orders->zip_code->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_orders_phone" for="x_phone" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->phone->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->phone->CellAttributes() ?>>
<span id="el_orders_phone">
<input type="text" data-table="orders" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($orders->phone->getPlaceHolder()) ?>" value="<?php echo $orders->phone->EditValue ?>"<?php echo $orders->phone->EditAttributes() ?>>
</span>
<?php echo $orders->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->discount->Visible) { // discount ?>
	<div id="r_discount" class="form-group">
		<label id="elh_orders_discount" for="x_discount" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->discount->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->discount->CellAttributes() ?>>
<span id="el_orders_discount">
<input type="text" data-table="orders" data-field="x_discount" name="x_discount" id="x_discount" size="30" placeholder="<?php echo ew_HtmlEncode($orders->discount->getPlaceHolder()) ?>" value="<?php echo $orders->discount->EditValue ?>"<?php echo $orders->discount->EditAttributes() ?>>
</span>
<?php echo $orders->discount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->total_price->Visible) { // total_price ?>
	<div id="r_total_price" class="form-group">
		<label id="elh_orders_total_price" for="x_total_price" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->total_price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->total_price->CellAttributes() ?>>
<span id="el_orders_total_price">
<input type="text" data-table="orders" data-field="x_total_price" name="x_total_price" id="x_total_price" size="30" placeholder="<?php echo ew_HtmlEncode($orders->total_price->getPlaceHolder()) ?>" value="<?php echo $orders->total_price->EditValue ?>"<?php echo $orders->total_price->EditAttributes() ?>>
</span>
<?php echo $orders->total_price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
	<div id="r_payment_type_id" class="form-group">
		<label id="elh_orders_payment_type_id" for="x_payment_type_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->payment_type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->payment_type_id->CellAttributes() ?>>
<span id="el_orders_payment_type_id">
<select data-table="orders" data-field="x_payment_type_id" data-value-separator="<?php echo $orders->payment_type_id->DisplayValueSeparatorAttribute() ?>" id="x_payment_type_id" name="x_payment_type_id"<?php echo $orders->payment_type_id->EditAttributes() ?>>
<?php echo $orders->payment_type_id->SelectOptionListHtml("x_payment_type_id") ?>
</select>
</span>
<?php echo $orders->payment_type_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
	<div id="r_delivery_type_id" class="form-group">
		<label id="elh_orders_delivery_type_id" for="x_delivery_type_id" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->delivery_type_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->delivery_type_id->CellAttributes() ?>>
<span id="el_orders_delivery_type_id">
<select data-table="orders" data-field="x_delivery_type_id" data-value-separator="<?php echo $orders->delivery_type_id->DisplayValueSeparatorAttribute() ?>" id="x_delivery_type_id" name="x_delivery_type_id"<?php echo $orders->delivery_type_id->EditAttributes() ?>>
<?php echo $orders->delivery_type_id->SelectOptionListHtml("x_delivery_type_id") ?>
</select>
</span>
<?php echo $orders->delivery_type_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_orders_description" for="x_description" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->description->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->description->CellAttributes() ?>>
<span id="el_orders_description">
<textarea data-table="orders" data-field="x_description" name="x_description" id="x_description" cols="50" rows="7" placeholder="<?php echo ew_HtmlEncode($orders->description->getPlaceHolder()) ?>"<?php echo $orders->description->EditAttributes() ?>><?php echo $orders->description->EditValue ?></textarea>
</span>
<?php echo $orders->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->feedback->Visible) { // feedback ?>
	<div id="r_feedback" class="form-group">
		<label id="elh_orders_feedback" for="x_feedback" class="<?php echo $orders_add->LeftColumnClass ?>"><?php echo $orders->feedback->FldCaption() ?></label>
		<div class="<?php echo $orders_add->RightColumnClass ?>"><div<?php echo $orders->feedback->CellAttributes() ?>>
<span id="el_orders_feedback">
<textarea data-table="orders" data-field="x_feedback" name="x_feedback" id="x_feedback" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($orders->feedback->getPlaceHolder()) ?>"<?php echo $orders->feedback->EditAttributes() ?>><?php echo $orders->feedback->EditValue ?></textarea>
</span>
<?php echo $orders->feedback->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("order_details", explode(",", $orders->getCurrentDetailTable())) && $order_details->DetailAdd) {
?>
<?php if ($orders->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("order_details", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "order_detailsgrid.php" ?>
<?php } ?>
<?php if (!$orders_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $orders_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $orders_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fordersadd.Init();
</script>
<?php
$orders_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$orders_add->Page_Terminate();
?>
