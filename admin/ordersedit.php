<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "ordersinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "orderdetailsgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$orders_edit = NULL; // Initialize page object first

class corders_edit extends corders {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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
		if (!$Security->CanEdit()) {
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
		$this->OrderID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->OrderID->Visible = FALSE;
		$this->CustomerID->SetVisibility();
		$this->FullName->SetVisibility();
		$this->ProvinceID->SetVisibility();
		$this->Address->SetVisibility();
		$this->ZipCode->SetVisibility();
		$this->Phone->SetVisibility();
		$this->Discount->SetVisibility();
		$this->TotalPrice->SetVisibility();
		$this->PaymentTypeID->SetVisibility();
		$this->DeliveryTypeID->SetVisibility();
		$this->Description->SetVisibility();
		$this->FeedBack->SetVisibility();
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

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("orderdetails", $DetailTblVar)) {

					// Process auto fill for detail table 'orderdetails'
					if (preg_match('/^forderdetails(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["orderdetails_grid"])) $GLOBALS["orderdetails_grid"] = new corderdetails_grid;
						$GLOBALS["orderdetails_grid"]->Page_Init();
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
			if ($objForm->HasValue("x_OrderID")) {
				$this->OrderID->setFormValue($objForm->GetValue("x_OrderID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["OrderID"])) {
				$this->OrderID->setQueryStringValue($_GET["OrderID"]);
				$loadByQuery = TRUE;
			} else {
				$this->OrderID->CurrentValue = NULL;
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
					$this->Page_Terminate("orderslist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "orderslist.php")
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
		if (!$this->OrderID->FldIsDetailKey)
			$this->OrderID->setFormValue($objForm->GetValue("x_OrderID"));
		if (!$this->CustomerID->FldIsDetailKey) {
			$this->CustomerID->setFormValue($objForm->GetValue("x_CustomerID"));
		}
		if (!$this->FullName->FldIsDetailKey) {
			$this->FullName->setFormValue($objForm->GetValue("x_FullName"));
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
		if (!$this->Phone->FldIsDetailKey) {
			$this->Phone->setFormValue($objForm->GetValue("x_Phone"));
		}
		if (!$this->Discount->FldIsDetailKey) {
			$this->Discount->setFormValue($objForm->GetValue("x_Discount"));
		}
		if (!$this->TotalPrice->FldIsDetailKey) {
			$this->TotalPrice->setFormValue($objForm->GetValue("x_TotalPrice"));
		}
		if (!$this->PaymentTypeID->FldIsDetailKey) {
			$this->PaymentTypeID->setFormValue($objForm->GetValue("x_PaymentTypeID"));
		}
		if (!$this->DeliveryTypeID->FldIsDetailKey) {
			$this->DeliveryTypeID->setFormValue($objForm->GetValue("x_DeliveryTypeID"));
		}
		if (!$this->Description->FldIsDetailKey) {
			$this->Description->setFormValue($objForm->GetValue("x_Description"));
		}
		if (!$this->FeedBack->FldIsDetailKey) {
			$this->FeedBack->setFormValue($objForm->GetValue("x_FeedBack"));
		}
		if (!$this->OrderDateTime->FldIsDetailKey) {
			$this->OrderDateTime->setFormValue($objForm->GetValue("x_OrderDateTime"));
			$this->OrderDateTime->CurrentValue = ew_UnFormatDateTime($this->OrderDateTime->CurrentValue, 0);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->OrderID->CurrentValue = $this->OrderID->FormValue;
		$this->CustomerID->CurrentValue = $this->CustomerID->FormValue;
		$this->FullName->CurrentValue = $this->FullName->FormValue;
		$this->ProvinceID->CurrentValue = $this->ProvinceID->FormValue;
		$this->Address->CurrentValue = $this->Address->FormValue;
		$this->ZipCode->CurrentValue = $this->ZipCode->FormValue;
		$this->Phone->CurrentValue = $this->Phone->FormValue;
		$this->Discount->CurrentValue = $this->Discount->FormValue;
		$this->TotalPrice->CurrentValue = $this->TotalPrice->FormValue;
		$this->PaymentTypeID->CurrentValue = $this->PaymentTypeID->FormValue;
		$this->DeliveryTypeID->CurrentValue = $this->DeliveryTypeID->FormValue;
		$this->Description->CurrentValue = $this->Description->FormValue;
		$this->FeedBack->CurrentValue = $this->FeedBack->FormValue;
		$this->OrderDateTime->CurrentValue = $this->OrderDateTime->FormValue;
		$this->OrderDateTime->CurrentValue = ew_UnFormatDateTime($this->OrderDateTime->CurrentValue, 0);
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("OrderID")) <> "")
			$this->OrderID->CurrentValue = $this->getKey("OrderID"); // OrderID
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

		// Address
		$this->Address->ViewValue = $this->Address->CurrentValue;
		$this->Address->ViewCustomAttributes = "";

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

		// Description
		$this->Description->ViewValue = $this->Description->CurrentValue;
		$this->Description->ViewCustomAttributes = "";

		// FeedBack
		$this->FeedBack->ViewValue = $this->FeedBack->CurrentValue;
		$this->FeedBack->ViewCustomAttributes = "";

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

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";
			$this->Address->TooltipValue = "";

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

			// Description
			$this->Description->LinkCustomAttributes = "";
			$this->Description->HrefValue = "";
			$this->Description->TooltipValue = "";

			// FeedBack
			$this->FeedBack->LinkCustomAttributes = "";
			$this->FeedBack->HrefValue = "";
			$this->FeedBack->TooltipValue = "";

			// OrderDateTime
			$this->OrderDateTime->LinkCustomAttributes = "";
			$this->OrderDateTime->HrefValue = "";
			$this->OrderDateTime->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// OrderID
			$this->OrderID->EditAttrs["class"] = "form-control";
			$this->OrderID->EditCustomAttributes = "";
			$this->OrderID->EditValue = $this->OrderID->CurrentValue;
			$this->OrderID->ViewCustomAttributes = "";

			// CustomerID
			$this->CustomerID->EditAttrs["class"] = "form-control";
			$this->CustomerID->EditCustomAttributes = "";
			if (trim(strval($this->CustomerID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`CustomerID`" . ew_SearchString("=", $this->CustomerID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `CustomerID`, `FullName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `customers`";
			$sWhereWrk = "";
			$this->CustomerID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->CustomerID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `FullName`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->CustomerID->EditValue = $arwrk;

			// FullName
			$this->FullName->EditAttrs["class"] = "form-control";
			$this->FullName->EditCustomAttributes = "";
			$this->FullName->EditValue = ew_HtmlEncode($this->FullName->CurrentValue);
			$this->FullName->PlaceHolder = ew_RemoveHtml($this->FullName->FldCaption());

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

			// Phone
			$this->Phone->EditAttrs["class"] = "form-control";
			$this->Phone->EditCustomAttributes = "";
			$this->Phone->EditValue = ew_HtmlEncode($this->Phone->CurrentValue);
			$this->Phone->PlaceHolder = ew_RemoveHtml($this->Phone->FldCaption());

			// Discount
			$this->Discount->EditAttrs["class"] = "form-control";
			$this->Discount->EditCustomAttributes = "";
			$this->Discount->EditValue = ew_HtmlEncode($this->Discount->CurrentValue);
			$this->Discount->PlaceHolder = ew_RemoveHtml($this->Discount->FldCaption());
			if (strval($this->Discount->EditValue) <> "" && is_numeric($this->Discount->EditValue)) $this->Discount->EditValue = ew_FormatNumber($this->Discount->EditValue, -2, -1, -2, 0);

			// TotalPrice
			$this->TotalPrice->EditAttrs["class"] = "form-control";
			$this->TotalPrice->EditCustomAttributes = "";
			$this->TotalPrice->EditValue = ew_HtmlEncode($this->TotalPrice->CurrentValue);
			$this->TotalPrice->PlaceHolder = ew_RemoveHtml($this->TotalPrice->FldCaption());
			if (strval($this->TotalPrice->EditValue) <> "" && is_numeric($this->TotalPrice->EditValue)) $this->TotalPrice->EditValue = ew_FormatNumber($this->TotalPrice->EditValue, -2, -2, -2, -2);

			// PaymentTypeID
			$this->PaymentTypeID->EditAttrs["class"] = "form-control";
			$this->PaymentTypeID->EditCustomAttributes = "";
			if (trim(strval($this->PaymentTypeID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`PaymentTypeID`" . ew_SearchString("=", $this->PaymentTypeID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `PaymentTypeID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `paymenttypes`";
			$sWhereWrk = "";
			$this->PaymentTypeID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->PaymentTypeID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->PaymentTypeID->EditValue = $arwrk;

			// DeliveryTypeID
			$this->DeliveryTypeID->EditAttrs["class"] = "form-control";
			$this->DeliveryTypeID->EditCustomAttributes = "";
			if (trim(strval($this->DeliveryTypeID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`DeliveryTypeID`" . ew_SearchString("=", $this->DeliveryTypeID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `DeliveryTypeID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `deliverytypes`";
			$sWhereWrk = "";
			$this->DeliveryTypeID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->DeliveryTypeID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->DeliveryTypeID->EditValue = $arwrk;

			// Description
			$this->Description->EditAttrs["class"] = "form-control";
			$this->Description->EditCustomAttributes = "";
			$this->Description->EditValue = ew_HtmlEncode($this->Description->CurrentValue);
			$this->Description->PlaceHolder = ew_RemoveHtml($this->Description->FldCaption());

			// FeedBack
			$this->FeedBack->EditAttrs["class"] = "form-control";
			$this->FeedBack->EditCustomAttributes = "";
			$this->FeedBack->EditValue = ew_HtmlEncode($this->FeedBack->CurrentValue);
			$this->FeedBack->PlaceHolder = ew_RemoveHtml($this->FeedBack->FldCaption());

			// OrderDateTime
			// Edit refer script
			// OrderID

			$this->OrderID->LinkCustomAttributes = "";
			$this->OrderID->HrefValue = "";

			// CustomerID
			$this->CustomerID->LinkCustomAttributes = "";
			$this->CustomerID->HrefValue = "";

			// FullName
			$this->FullName->LinkCustomAttributes = "";
			$this->FullName->HrefValue = "";

			// ProvinceID
			$this->ProvinceID->LinkCustomAttributes = "";
			$this->ProvinceID->HrefValue = "";

			// Address
			$this->Address->LinkCustomAttributes = "";
			$this->Address->HrefValue = "";

			// ZipCode
			$this->ZipCode->LinkCustomAttributes = "";
			$this->ZipCode->HrefValue = "";

			// Phone
			$this->Phone->LinkCustomAttributes = "";
			$this->Phone->HrefValue = "";

			// Discount
			$this->Discount->LinkCustomAttributes = "";
			$this->Discount->HrefValue = "";

			// TotalPrice
			$this->TotalPrice->LinkCustomAttributes = "";
			$this->TotalPrice->HrefValue = "";

			// PaymentTypeID
			$this->PaymentTypeID->LinkCustomAttributes = "";
			$this->PaymentTypeID->HrefValue = "";

			// DeliveryTypeID
			$this->DeliveryTypeID->LinkCustomAttributes = "";
			$this->DeliveryTypeID->HrefValue = "";

			// Description
			$this->Description->LinkCustomAttributes = "";
			$this->Description->HrefValue = "";

			// FeedBack
			$this->FeedBack->LinkCustomAttributes = "";
			$this->FeedBack->HrefValue = "";

			// OrderDateTime
			$this->OrderDateTime->LinkCustomAttributes = "";
			$this->OrderDateTime->HrefValue = "";
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
		if (!$this->ProvinceID->FldIsDetailKey && !is_null($this->ProvinceID->FormValue) && $this->ProvinceID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ProvinceID->FldCaption(), $this->ProvinceID->ReqErrMsg));
		}
		if (!$this->Address->FldIsDetailKey && !is_null($this->Address->FormValue) && $this->Address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Address->FldCaption(), $this->Address->ReqErrMsg));
		}
		if (!$this->ZipCode->FldIsDetailKey && !is_null($this->ZipCode->FormValue) && $this->ZipCode->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->ZipCode->FldCaption(), $this->ZipCode->ReqErrMsg));
		}
		if (!$this->Phone->FldIsDetailKey && !is_null($this->Phone->FormValue) && $this->Phone->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Phone->FldCaption(), $this->Phone->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Discount->FormValue)) {
			ew_AddMessage($gsFormError, $this->Discount->FldErrMsg());
		}
		if (!$this->TotalPrice->FldIsDetailKey && !is_null($this->TotalPrice->FormValue) && $this->TotalPrice->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->TotalPrice->FldCaption(), $this->TotalPrice->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->TotalPrice->FormValue)) {
			ew_AddMessage($gsFormError, $this->TotalPrice->FldErrMsg());
		}
		if (!$this->PaymentTypeID->FldIsDetailKey && !is_null($this->PaymentTypeID->FormValue) && $this->PaymentTypeID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->PaymentTypeID->FldCaption(), $this->PaymentTypeID->ReqErrMsg));
		}
		if (!$this->DeliveryTypeID->FldIsDetailKey && !is_null($this->DeliveryTypeID->FormValue) && $this->DeliveryTypeID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->DeliveryTypeID->FldCaption(), $this->DeliveryTypeID->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("orderdetails", $DetailTblVar) && $GLOBALS["orderdetails"]->DetailEdit) {
			if (!isset($GLOBALS["orderdetails_grid"])) $GLOBALS["orderdetails_grid"] = new corderdetails_grid(); // get detail page object
			$GLOBALS["orderdetails_grid"]->ValidateGridForm();
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

			// CustomerID
			$this->CustomerID->SetDbValueDef($rsnew, $this->CustomerID->CurrentValue, NULL, $this->CustomerID->ReadOnly);

			// FullName
			$this->FullName->SetDbValueDef($rsnew, $this->FullName->CurrentValue, "", $this->FullName->ReadOnly);

			// ProvinceID
			$this->ProvinceID->SetDbValueDef($rsnew, $this->ProvinceID->CurrentValue, 0, $this->ProvinceID->ReadOnly);

			// Address
			$this->Address->SetDbValueDef($rsnew, $this->Address->CurrentValue, "", $this->Address->ReadOnly);

			// ZipCode
			$this->ZipCode->SetDbValueDef($rsnew, $this->ZipCode->CurrentValue, "", $this->ZipCode->ReadOnly);

			// Phone
			$this->Phone->SetDbValueDef($rsnew, $this->Phone->CurrentValue, "", $this->Phone->ReadOnly);

			// Discount
			$this->Discount->SetDbValueDef($rsnew, $this->Discount->CurrentValue, NULL, $this->Discount->ReadOnly);

			// TotalPrice
			$this->TotalPrice->SetDbValueDef($rsnew, $this->TotalPrice->CurrentValue, 0, $this->TotalPrice->ReadOnly);

			// PaymentTypeID
			$this->PaymentTypeID->SetDbValueDef($rsnew, $this->PaymentTypeID->CurrentValue, 0, $this->PaymentTypeID->ReadOnly);

			// DeliveryTypeID
			$this->DeliveryTypeID->SetDbValueDef($rsnew, $this->DeliveryTypeID->CurrentValue, 0, $this->DeliveryTypeID->ReadOnly);

			// Description
			$this->Description->SetDbValueDef($rsnew, $this->Description->CurrentValue, NULL, $this->Description->ReadOnly);

			// FeedBack
			$this->FeedBack->SetDbValueDef($rsnew, $this->FeedBack->CurrentValue, NULL, $this->FeedBack->ReadOnly);

			// OrderDateTime
			$this->OrderDateTime->SetDbValueDef($rsnew, ew_CurrentDateTime(), ew_CurrentDate());
			$rsnew['OrderDateTime'] = &$this->OrderDateTime->DbValue;

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
					if (in_array("orderdetails", $DetailTblVar) && $GLOBALS["orderdetails"]->DetailEdit) {
						if (!isset($GLOBALS["orderdetails_grid"])) $GLOBALS["orderdetails_grid"] = new corderdetails_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "orderdetails"); // Load user level of detail table
						$EditRow = $GLOBALS["orderdetails_grid"]->GridUpdate();
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
			if (in_array("orderdetails", $DetailTblVar)) {
				if (!isset($GLOBALS["orderdetails_grid"]))
					$GLOBALS["orderdetails_grid"] = new corderdetails_grid;
				if ($GLOBALS["orderdetails_grid"]->DetailEdit) {
					$GLOBALS["orderdetails_grid"]->CurrentMode = "edit";
					$GLOBALS["orderdetails_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["orderdetails_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["orderdetails_grid"]->setStartRecordNumber(1);
					$GLOBALS["orderdetails_grid"]->OrderID->FldIsDetailKey = TRUE;
					$GLOBALS["orderdetails_grid"]->OrderID->CurrentValue = $this->OrderID->CurrentValue;
					$GLOBALS["orderdetails_grid"]->OrderID->setSessionValue($GLOBALS["orderdetails_grid"]->OrderID->CurrentValue);
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
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_CustomerID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `CustomerID` AS `LinkFld`, `FullName` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `customers`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`CustomerID` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->CustomerID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `FullName`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
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
		case "x_PaymentTypeID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `PaymentTypeID` AS `LinkFld`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `paymenttypes`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`PaymentTypeID` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->PaymentTypeID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_DeliveryTypeID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `DeliveryTypeID` AS `LinkFld`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `deliverytypes`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`DeliveryTypeID` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->DeliveryTypeID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
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
if (!isset($orders_edit)) $orders_edit = new corders_edit();

// Page init
$orders_edit->Page_Init();

// Page main
$orders_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fordersedit = new ew_Form("fordersedit", "edit");

// Validate form
fordersedit.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->FullName->FldCaption(), $orders->FullName->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ProvinceID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->ProvinceID->FldCaption(), $orders->ProvinceID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Address");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->Address->FldCaption(), $orders->Address->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_ZipCode");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->ZipCode->FldCaption(), $orders->ZipCode->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Phone");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->Phone->FldCaption(), $orders->Phone->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Discount");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->Discount->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_TotalPrice");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->TotalPrice->FldCaption(), $orders->TotalPrice->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_TotalPrice");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($orders->TotalPrice->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_PaymentTypeID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->PaymentTypeID->FldCaption(), $orders->PaymentTypeID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_DeliveryTypeID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $orders->DeliveryTypeID->FldCaption(), $orders->DeliveryTypeID->ReqErrMsg)) ?>");

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
fordersedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fordersedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fordersedit.Lists["x_CustomerID"] = {"LinkField":"x_CustomerID","Ajax":true,"AutoFill":false,"DisplayFields":["x_FullName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
fordersedit.Lists["x_CustomerID"].Data = "<?php echo $orders_edit->CustomerID->LookupFilterQuery(FALSE, "edit") ?>";
fordersedit.Lists["x_ProvinceID"] = {"LinkField":"x_ProvinceID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
fordersedit.Lists["x_ProvinceID"].Data = "<?php echo $orders_edit->ProvinceID->LookupFilterQuery(FALSE, "edit") ?>";
fordersedit.Lists["x_PaymentTypeID"] = {"LinkField":"x_PaymentTypeID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"paymenttypes"};
fordersedit.Lists["x_PaymentTypeID"].Data = "<?php echo $orders_edit->PaymentTypeID->LookupFilterQuery(FALSE, "edit") ?>";
fordersedit.Lists["x_DeliveryTypeID"] = {"LinkField":"x_DeliveryTypeID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"deliverytypes"};
fordersedit.Lists["x_DeliveryTypeID"].Data = "<?php echo $orders_edit->DeliveryTypeID->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $orders_edit->ShowPageHeader(); ?>
<?php
$orders_edit->ShowMessage();
?>
<form name="fordersedit" id="fordersedit" class="<?php echo $orders_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($orders_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($orders->OrderID->Visible) { // OrderID ?>
	<div id="r_OrderID" class="form-group">
		<label id="elh_orders_OrderID" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->OrderID->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->OrderID->CellAttributes() ?>>
<span id="el_orders_OrderID">
<span<?php echo $orders->OrderID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $orders->OrderID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="orders" data-field="x_OrderID" name="x_OrderID" id="x_OrderID" value="<?php echo ew_HtmlEncode($orders->OrderID->CurrentValue) ?>">
<?php echo $orders->OrderID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
	<div id="r_CustomerID" class="form-group">
		<label id="elh_orders_CustomerID" for="x_CustomerID" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->CustomerID->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->CustomerID->CellAttributes() ?>>
<span id="el_orders_CustomerID">
<select data-table="orders" data-field="x_CustomerID" data-value-separator="<?php echo $orders->CustomerID->DisplayValueSeparatorAttribute() ?>" id="x_CustomerID" name="x_CustomerID"<?php echo $orders->CustomerID->EditAttributes() ?>>
<?php echo $orders->CustomerID->SelectOptionListHtml("x_CustomerID") ?>
</select>
</span>
<?php echo $orders->CustomerID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->FullName->Visible) { // FullName ?>
	<div id="r_FullName" class="form-group">
		<label id="elh_orders_FullName" for="x_FullName" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->FullName->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->FullName->CellAttributes() ?>>
<span id="el_orders_FullName">
<input type="text" data-table="orders" data-field="x_FullName" name="x_FullName" id="x_FullName" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($orders->FullName->getPlaceHolder()) ?>" value="<?php echo $orders->FullName->EditValue ?>"<?php echo $orders->FullName->EditAttributes() ?>>
</span>
<?php echo $orders->FullName->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
	<div id="r_ProvinceID" class="form-group">
		<label id="elh_orders_ProvinceID" for="x_ProvinceID" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->ProvinceID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->ProvinceID->CellAttributes() ?>>
<span id="el_orders_ProvinceID">
<select data-table="orders" data-field="x_ProvinceID" data-value-separator="<?php echo $orders->ProvinceID->DisplayValueSeparatorAttribute() ?>" id="x_ProvinceID" name="x_ProvinceID"<?php echo $orders->ProvinceID->EditAttributes() ?>>
<?php echo $orders->ProvinceID->SelectOptionListHtml("x_ProvinceID") ?>
</select>
</span>
<?php echo $orders->ProvinceID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->Address->Visible) { // Address ?>
	<div id="r_Address" class="form-group">
		<label id="elh_orders_Address" for="x_Address" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->Address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->Address->CellAttributes() ?>>
<span id="el_orders_Address">
<textarea data-table="orders" data-field="x_Address" name="x_Address" id="x_Address" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($orders->Address->getPlaceHolder()) ?>"<?php echo $orders->Address->EditAttributes() ?>><?php echo $orders->Address->EditValue ?></textarea>
</span>
<?php echo $orders->Address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
	<div id="r_ZipCode" class="form-group">
		<label id="elh_orders_ZipCode" for="x_ZipCode" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->ZipCode->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->ZipCode->CellAttributes() ?>>
<span id="el_orders_ZipCode">
<input type="text" data-table="orders" data-field="x_ZipCode" name="x_ZipCode" id="x_ZipCode" size="30" maxlength="6" placeholder="<?php echo ew_HtmlEncode($orders->ZipCode->getPlaceHolder()) ?>" value="<?php echo $orders->ZipCode->EditValue ?>"<?php echo $orders->ZipCode->EditAttributes() ?>>
</span>
<?php echo $orders->ZipCode->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->Phone->Visible) { // Phone ?>
	<div id="r_Phone" class="form-group">
		<label id="elh_orders_Phone" for="x_Phone" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->Phone->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->Phone->CellAttributes() ?>>
<span id="el_orders_Phone">
<input type="text" data-table="orders" data-field="x_Phone" name="x_Phone" id="x_Phone" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($orders->Phone->getPlaceHolder()) ?>" value="<?php echo $orders->Phone->EditValue ?>"<?php echo $orders->Phone->EditAttributes() ?>>
</span>
<?php echo $orders->Phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->Discount->Visible) { // Discount ?>
	<div id="r_Discount" class="form-group">
		<label id="elh_orders_Discount" for="x_Discount" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->Discount->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->Discount->CellAttributes() ?>>
<span id="el_orders_Discount">
<input type="text" data-table="orders" data-field="x_Discount" name="x_Discount" id="x_Discount" size="30" placeholder="<?php echo ew_HtmlEncode($orders->Discount->getPlaceHolder()) ?>" value="<?php echo $orders->Discount->EditValue ?>"<?php echo $orders->Discount->EditAttributes() ?>>
</span>
<?php echo $orders->Discount->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
	<div id="r_TotalPrice" class="form-group">
		<label id="elh_orders_TotalPrice" for="x_TotalPrice" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->TotalPrice->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->TotalPrice->CellAttributes() ?>>
<span id="el_orders_TotalPrice">
<input type="text" data-table="orders" data-field="x_TotalPrice" name="x_TotalPrice" id="x_TotalPrice" size="30" placeholder="<?php echo ew_HtmlEncode($orders->TotalPrice->getPlaceHolder()) ?>" value="<?php echo $orders->TotalPrice->EditValue ?>"<?php echo $orders->TotalPrice->EditAttributes() ?>>
</span>
<?php echo $orders->TotalPrice->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
	<div id="r_PaymentTypeID" class="form-group">
		<label id="elh_orders_PaymentTypeID" for="x_PaymentTypeID" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->PaymentTypeID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->PaymentTypeID->CellAttributes() ?>>
<span id="el_orders_PaymentTypeID">
<select data-table="orders" data-field="x_PaymentTypeID" data-value-separator="<?php echo $orders->PaymentTypeID->DisplayValueSeparatorAttribute() ?>" id="x_PaymentTypeID" name="x_PaymentTypeID"<?php echo $orders->PaymentTypeID->EditAttributes() ?>>
<?php echo $orders->PaymentTypeID->SelectOptionListHtml("x_PaymentTypeID") ?>
</select>
</span>
<?php echo $orders->PaymentTypeID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
	<div id="r_DeliveryTypeID" class="form-group">
		<label id="elh_orders_DeliveryTypeID" for="x_DeliveryTypeID" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->DeliveryTypeID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->DeliveryTypeID->CellAttributes() ?>>
<span id="el_orders_DeliveryTypeID">
<select data-table="orders" data-field="x_DeliveryTypeID" data-value-separator="<?php echo $orders->DeliveryTypeID->DisplayValueSeparatorAttribute() ?>" id="x_DeliveryTypeID" name="x_DeliveryTypeID"<?php echo $orders->DeliveryTypeID->EditAttributes() ?>>
<?php echo $orders->DeliveryTypeID->SelectOptionListHtml("x_DeliveryTypeID") ?>
</select>
</span>
<?php echo $orders->DeliveryTypeID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->Description->Visible) { // Description ?>
	<div id="r_Description" class="form-group">
		<label id="elh_orders_Description" for="x_Description" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->Description->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->Description->CellAttributes() ?>>
<span id="el_orders_Description">
<textarea data-table="orders" data-field="x_Description" name="x_Description" id="x_Description" cols="50" rows="7" placeholder="<?php echo ew_HtmlEncode($orders->Description->getPlaceHolder()) ?>"<?php echo $orders->Description->EditAttributes() ?>><?php echo $orders->Description->EditValue ?></textarea>
</span>
<?php echo $orders->Description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($orders->FeedBack->Visible) { // FeedBack ?>
	<div id="r_FeedBack" class="form-group">
		<label id="elh_orders_FeedBack" for="x_FeedBack" class="<?php echo $orders_edit->LeftColumnClass ?>"><?php echo $orders->FeedBack->FldCaption() ?></label>
		<div class="<?php echo $orders_edit->RightColumnClass ?>"><div<?php echo $orders->FeedBack->CellAttributes() ?>>
<span id="el_orders_FeedBack">
<textarea data-table="orders" data-field="x_FeedBack" name="x_FeedBack" id="x_FeedBack" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($orders->FeedBack->getPlaceHolder()) ?>"<?php echo $orders->FeedBack->EditAttributes() ?>><?php echo $orders->FeedBack->EditValue ?></textarea>
</span>
<?php echo $orders->FeedBack->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("orderdetails", explode(",", $orders->getCurrentDetailTable())) && $orderdetails->DetailEdit) {
?>
<?php if ($orders->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("orderdetails", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "orderdetailsgrid.php" ?>
<?php } ?>
<?php if (!$orders_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $orders_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $orders_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fordersedit.Init();
</script>
<?php
$orders_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$orders_edit->Page_Terminate();
?>
