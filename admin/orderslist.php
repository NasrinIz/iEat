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

$orders_list = NULL; // Initialize page object first

class corders_list extends corders {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'orders';

	// Page object name
	var $PageObjName = 'orders_list';

	// Grid form hidden field names
	var $FormName = 'forderslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "ordersadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "ordersdelete.php";
		$this->MultiUpdateUrl = "ordersupdate.php";

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption forderslistsrch";

		// List actions
		$this->ListActions = new cListActions();
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
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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
		if ($this->IsAddOrEdit())
			$this->OrderDateTime->Visible = FALSE;

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Set up records per page
			$this->SetupDisplayRecs();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Set up number of records displayed per page
	function SetupDisplayRecs() {
		$sWrk = @$_GET[EW_TABLE_REC_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayRecs = intval($sWrk);
			} else {
				if (strtolower($sWrk) == "all") { // Display all records
					$this->DisplayRecs = -1;
				} else {
					$this->DisplayRecs = 20; // Non-numeric, load default
				}
			}
			$this->setRecordsPerPage($this->DisplayRecs); // Save to Session

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->OrderID->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->OrderID->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->OrderID->AdvancedSearch->ToJson(), ","); // Field OrderID
		$sFilterList = ew_Concat($sFilterList, $this->CustomerID->AdvancedSearch->ToJson(), ","); // Field CustomerID
		$sFilterList = ew_Concat($sFilterList, $this->FullName->AdvancedSearch->ToJson(), ","); // Field FullName
		$sFilterList = ew_Concat($sFilterList, $this->ProvinceID->AdvancedSearch->ToJson(), ","); // Field ProvinceID
		$sFilterList = ew_Concat($sFilterList, $this->Address->AdvancedSearch->ToJson(), ","); // Field Address
		$sFilterList = ew_Concat($sFilterList, $this->ZipCode->AdvancedSearch->ToJson(), ","); // Field ZipCode
		$sFilterList = ew_Concat($sFilterList, $this->Phone->AdvancedSearch->ToJson(), ","); // Field Phone
		$sFilterList = ew_Concat($sFilterList, $this->Discount->AdvancedSearch->ToJson(), ","); // Field Discount
		$sFilterList = ew_Concat($sFilterList, $this->TotalPrice->AdvancedSearch->ToJson(), ","); // Field TotalPrice
		$sFilterList = ew_Concat($sFilterList, $this->PaymentTypeID->AdvancedSearch->ToJson(), ","); // Field PaymentTypeID
		$sFilterList = ew_Concat($sFilterList, $this->DeliveryTypeID->AdvancedSearch->ToJson(), ","); // Field DeliveryTypeID
		$sFilterList = ew_Concat($sFilterList, $this->Description->AdvancedSearch->ToJson(), ","); // Field Description
		$sFilterList = ew_Concat($sFilterList, $this->FeedBack->AdvancedSearch->ToJson(), ","); // Field FeedBack
		$sFilterList = ew_Concat($sFilterList, $this->OrderDateTime->AdvancedSearch->ToJson(), ","); // Field OrderDateTime
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "forderslistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field OrderID
		$this->OrderID->AdvancedSearch->SearchValue = @$filter["x_OrderID"];
		$this->OrderID->AdvancedSearch->SearchOperator = @$filter["z_OrderID"];
		$this->OrderID->AdvancedSearch->SearchCondition = @$filter["v_OrderID"];
		$this->OrderID->AdvancedSearch->SearchValue2 = @$filter["y_OrderID"];
		$this->OrderID->AdvancedSearch->SearchOperator2 = @$filter["w_OrderID"];
		$this->OrderID->AdvancedSearch->Save();

		// Field CustomerID
		$this->CustomerID->AdvancedSearch->SearchValue = @$filter["x_CustomerID"];
		$this->CustomerID->AdvancedSearch->SearchOperator = @$filter["z_CustomerID"];
		$this->CustomerID->AdvancedSearch->SearchCondition = @$filter["v_CustomerID"];
		$this->CustomerID->AdvancedSearch->SearchValue2 = @$filter["y_CustomerID"];
		$this->CustomerID->AdvancedSearch->SearchOperator2 = @$filter["w_CustomerID"];
		$this->CustomerID->AdvancedSearch->Save();

		// Field FullName
		$this->FullName->AdvancedSearch->SearchValue = @$filter["x_FullName"];
		$this->FullName->AdvancedSearch->SearchOperator = @$filter["z_FullName"];
		$this->FullName->AdvancedSearch->SearchCondition = @$filter["v_FullName"];
		$this->FullName->AdvancedSearch->SearchValue2 = @$filter["y_FullName"];
		$this->FullName->AdvancedSearch->SearchOperator2 = @$filter["w_FullName"];
		$this->FullName->AdvancedSearch->Save();

		// Field ProvinceID
		$this->ProvinceID->AdvancedSearch->SearchValue = @$filter["x_ProvinceID"];
		$this->ProvinceID->AdvancedSearch->SearchOperator = @$filter["z_ProvinceID"];
		$this->ProvinceID->AdvancedSearch->SearchCondition = @$filter["v_ProvinceID"];
		$this->ProvinceID->AdvancedSearch->SearchValue2 = @$filter["y_ProvinceID"];
		$this->ProvinceID->AdvancedSearch->SearchOperator2 = @$filter["w_ProvinceID"];
		$this->ProvinceID->AdvancedSearch->Save();

		// Field Address
		$this->Address->AdvancedSearch->SearchValue = @$filter["x_Address"];
		$this->Address->AdvancedSearch->SearchOperator = @$filter["z_Address"];
		$this->Address->AdvancedSearch->SearchCondition = @$filter["v_Address"];
		$this->Address->AdvancedSearch->SearchValue2 = @$filter["y_Address"];
		$this->Address->AdvancedSearch->SearchOperator2 = @$filter["w_Address"];
		$this->Address->AdvancedSearch->Save();

		// Field ZipCode
		$this->ZipCode->AdvancedSearch->SearchValue = @$filter["x_ZipCode"];
		$this->ZipCode->AdvancedSearch->SearchOperator = @$filter["z_ZipCode"];
		$this->ZipCode->AdvancedSearch->SearchCondition = @$filter["v_ZipCode"];
		$this->ZipCode->AdvancedSearch->SearchValue2 = @$filter["y_ZipCode"];
		$this->ZipCode->AdvancedSearch->SearchOperator2 = @$filter["w_ZipCode"];
		$this->ZipCode->AdvancedSearch->Save();

		// Field Phone
		$this->Phone->AdvancedSearch->SearchValue = @$filter["x_Phone"];
		$this->Phone->AdvancedSearch->SearchOperator = @$filter["z_Phone"];
		$this->Phone->AdvancedSearch->SearchCondition = @$filter["v_Phone"];
		$this->Phone->AdvancedSearch->SearchValue2 = @$filter["y_Phone"];
		$this->Phone->AdvancedSearch->SearchOperator2 = @$filter["w_Phone"];
		$this->Phone->AdvancedSearch->Save();

		// Field Discount
		$this->Discount->AdvancedSearch->SearchValue = @$filter["x_Discount"];
		$this->Discount->AdvancedSearch->SearchOperator = @$filter["z_Discount"];
		$this->Discount->AdvancedSearch->SearchCondition = @$filter["v_Discount"];
		$this->Discount->AdvancedSearch->SearchValue2 = @$filter["y_Discount"];
		$this->Discount->AdvancedSearch->SearchOperator2 = @$filter["w_Discount"];
		$this->Discount->AdvancedSearch->Save();

		// Field TotalPrice
		$this->TotalPrice->AdvancedSearch->SearchValue = @$filter["x_TotalPrice"];
		$this->TotalPrice->AdvancedSearch->SearchOperator = @$filter["z_TotalPrice"];
		$this->TotalPrice->AdvancedSearch->SearchCondition = @$filter["v_TotalPrice"];
		$this->TotalPrice->AdvancedSearch->SearchValue2 = @$filter["y_TotalPrice"];
		$this->TotalPrice->AdvancedSearch->SearchOperator2 = @$filter["w_TotalPrice"];
		$this->TotalPrice->AdvancedSearch->Save();

		// Field PaymentTypeID
		$this->PaymentTypeID->AdvancedSearch->SearchValue = @$filter["x_PaymentTypeID"];
		$this->PaymentTypeID->AdvancedSearch->SearchOperator = @$filter["z_PaymentTypeID"];
		$this->PaymentTypeID->AdvancedSearch->SearchCondition = @$filter["v_PaymentTypeID"];
		$this->PaymentTypeID->AdvancedSearch->SearchValue2 = @$filter["y_PaymentTypeID"];
		$this->PaymentTypeID->AdvancedSearch->SearchOperator2 = @$filter["w_PaymentTypeID"];
		$this->PaymentTypeID->AdvancedSearch->Save();

		// Field DeliveryTypeID
		$this->DeliveryTypeID->AdvancedSearch->SearchValue = @$filter["x_DeliveryTypeID"];
		$this->DeliveryTypeID->AdvancedSearch->SearchOperator = @$filter["z_DeliveryTypeID"];
		$this->DeliveryTypeID->AdvancedSearch->SearchCondition = @$filter["v_DeliveryTypeID"];
		$this->DeliveryTypeID->AdvancedSearch->SearchValue2 = @$filter["y_DeliveryTypeID"];
		$this->DeliveryTypeID->AdvancedSearch->SearchOperator2 = @$filter["w_DeliveryTypeID"];
		$this->DeliveryTypeID->AdvancedSearch->Save();

		// Field Description
		$this->Description->AdvancedSearch->SearchValue = @$filter["x_Description"];
		$this->Description->AdvancedSearch->SearchOperator = @$filter["z_Description"];
		$this->Description->AdvancedSearch->SearchCondition = @$filter["v_Description"];
		$this->Description->AdvancedSearch->SearchValue2 = @$filter["y_Description"];
		$this->Description->AdvancedSearch->SearchOperator2 = @$filter["w_Description"];
		$this->Description->AdvancedSearch->Save();

		// Field FeedBack
		$this->FeedBack->AdvancedSearch->SearchValue = @$filter["x_FeedBack"];
		$this->FeedBack->AdvancedSearch->SearchOperator = @$filter["z_FeedBack"];
		$this->FeedBack->AdvancedSearch->SearchCondition = @$filter["v_FeedBack"];
		$this->FeedBack->AdvancedSearch->SearchValue2 = @$filter["y_FeedBack"];
		$this->FeedBack->AdvancedSearch->SearchOperator2 = @$filter["w_FeedBack"];
		$this->FeedBack->AdvancedSearch->Save();

		// Field OrderDateTime
		$this->OrderDateTime->AdvancedSearch->SearchValue = @$filter["x_OrderDateTime"];
		$this->OrderDateTime->AdvancedSearch->SearchOperator = @$filter["z_OrderDateTime"];
		$this->OrderDateTime->AdvancedSearch->SearchCondition = @$filter["v_OrderDateTime"];
		$this->OrderDateTime->AdvancedSearch->SearchValue2 = @$filter["y_OrderDateTime"];
		$this->OrderDateTime->AdvancedSearch->SearchOperator2 = @$filter["w_OrderDateTime"];
		$this->OrderDateTime->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->FullName, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Address, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->ZipCode, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->FeedBack, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->OrderID); // OrderID
			$this->UpdateSort($this->CustomerID); // CustomerID
			$this->UpdateSort($this->FullName); // FullName
			$this->UpdateSort($this->ProvinceID); // ProvinceID
			$this->UpdateSort($this->ZipCode); // ZipCode
			$this->UpdateSort($this->Phone); // Phone
			$this->UpdateSort($this->Discount); // Discount
			$this->UpdateSort($this->TotalPrice); // TotalPrice
			$this->UpdateSort($this->PaymentTypeID); // PaymentTypeID
			$this->UpdateSort($this->DeliveryTypeID); // DeliveryTypeID
			$this->UpdateSort($this->OrderDateTime); // OrderDateTime
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->OrderID->setSort("");
				$this->CustomerID->setSort("");
				$this->FullName->setSort("");
				$this->ProvinceID->setSort("");
				$this->ZipCode->setSort("");
				$this->Phone->setSort("");
				$this->Discount->setSort("");
				$this->TotalPrice->setSort("");
				$this->PaymentTypeID->setSort("");
				$this->DeliveryTypeID->setSort("");
				$this->OrderDateTime->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanAdd();
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = TRUE;

		// "detail_orderdetails"
		$item = &$this->ListOptions->Add("detail_orderdetails");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'orderdetails') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["orderdetails_grid"])) $GLOBALS["orderdetails_grid"] = new corderdetails_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("orderdetails");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_orderdetails"
		$oListOpt = &$this->ListOptions->Items["detail_orderdetails"];
		if ($Security->AllowList(CurrentProjectID() . 'orderdetails')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("orderdetails", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("orderdetailslist.php?" . EW_TABLE_SHOW_MASTER . "=orders&fk_OrderID=" . urlencode(strval($this->OrderID->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["orderdetails_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'orderdetails')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=orderdetails");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "orderdetails";
			}
			if ($GLOBALS["orderdetails_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'orderdetails')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=orderdetails");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "orderdetails";
			}
			if ($GLOBALS["orderdetails_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'orderdetails')) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=orderdetails");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "orderdetails";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->OrderID->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_orderdetails");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=orderdetails");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["orderdetails"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["orderdetails"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'orderdetails') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "orderdetails";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$caption = $Language->Phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"forderslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"forderslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.forderslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"forderslistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		// Accumulate aggregate value

		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			if (is_numeric($this->TotalPrice->CurrentValue))
				$this->TotalPrice->Total += $this->TotalPrice->CurrentValue; // Accumulate total
		}
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
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->TotalPrice->Total = 0; // Initialize total
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->TotalPrice->CurrentValue = $this->TotalPrice->Total;
			$this->TotalPrice->ViewValue = $this->TotalPrice->CurrentValue;
			$this->TotalPrice->ViewValue = ew_FormatCurrency($this->TotalPrice->ViewValue, 0, -2, -2, -2);
			$this->TotalPrice->ViewCustomAttributes = "";
			$this->TotalPrice->HrefValue = ""; // Clear href value
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($orders_list)) $orders_list = new corders_list();

// Page init
$orders_list->Page_Init();

// Page main
$orders_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$orders_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = forderslist = new ew_Form("forderslist", "list");
forderslist.FormKeyCountName = '<?php echo $orders_list->FormKeyCountName ?>';

// Form_CustomValidate event
forderslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
forderslist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
forderslist.Lists["x_CustomerID"] = {"LinkField":"x_CustomerID","Ajax":true,"AutoFill":false,"DisplayFields":["x_FullName","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
forderslist.Lists["x_CustomerID"].Data = "<?php echo $orders_list->CustomerID->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_ProvinceID"] = {"LinkField":"x_ProvinceID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
forderslist.Lists["x_ProvinceID"].Data = "<?php echo $orders_list->ProvinceID->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_PaymentTypeID"] = {"LinkField":"x_PaymentTypeID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"paymenttypes"};
forderslist.Lists["x_PaymentTypeID"].Data = "<?php echo $orders_list->PaymentTypeID->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_DeliveryTypeID"] = {"LinkField":"x_DeliveryTypeID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"deliverytypes"};
forderslist.Lists["x_DeliveryTypeID"].Data = "<?php echo $orders_list->DeliveryTypeID->LookupFilterQuery(FALSE, "list") ?>";

// Form object for search
var CurrentSearchForm = forderslistsrch = new ew_Form("forderslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($orders_list->TotalRecs > 0 && $orders_list->ExportOptions->Visible()) { ?>
<?php $orders_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($orders_list->SearchOptions->Visible()) { ?>
<?php $orders_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($orders_list->FilterOptions->Visible()) { ?>
<?php $orders_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $orders_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($orders_list->TotalRecs <= 0)
			$orders_list->TotalRecs = $orders->ListRecordCount();
	} else {
		if (!$orders_list->Recordset && ($orders_list->Recordset = $orders_list->LoadRecordset()))
			$orders_list->TotalRecs = $orders_list->Recordset->RecordCount();
	}
	$orders_list->StartRec = 1;
	if ($orders_list->DisplayRecs <= 0 || ($orders->Export <> "" && $orders->ExportAll)) // Display all records
		$orders_list->DisplayRecs = $orders_list->TotalRecs;
	if (!($orders->Export <> "" && $orders->ExportAll))
		$orders_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$orders_list->Recordset = $orders_list->LoadRecordset($orders_list->StartRec-1, $orders_list->DisplayRecs);

	// Set no record found message
	if ($orders->CurrentAction == "" && $orders_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$orders_list->setWarningMessage(ew_DeniedMsg());
		if ($orders_list->SearchWhere == "0=101")
			$orders_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$orders_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$orders_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($orders->Export == "" && $orders->CurrentAction == "") { ?>
<form name="forderslistsrch" id="forderslistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($orders_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="forderslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="orders">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($orders_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($orders_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $orders_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($orders_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($orders_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($orders_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($orders_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $orders_list->ShowPageHeader(); ?>
<?php
$orders_list->ShowMessage();
?>
<?php if ($orders_list->TotalRecs > 0 || $orders->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($orders_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> orders">
<div class="box-header ewGridUpperPanel">
<?php if ($orders->CurrentAction <> "gridadd" && $orders->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($orders_list->Pager)) $orders_list->Pager = new cPrevNextPager($orders_list->StartRec, $orders_list->DisplayRecs, $orders_list->TotalRecs, $orders_list->AutoHidePager) ?>
<?php if ($orders_list->Pager->RecordCount > 0 && $orders_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($orders_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($orders_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $orders_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($orders_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($orders_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $orders_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($orders_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $orders_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $orders_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $orders_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($orders_list->TotalRecs > 0 && (!$orders_list->AutoHidePageSizeSelector || $orders_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="orders">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="20"<?php if ($orders_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($orders_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="50"<?php if ($orders_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="ALL"<?php if ($orders->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="forderslist" id="forderslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($orders_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $orders_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="orders">
<div id="gmp_orders" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($orders_list->TotalRecs > 0 || $orders->CurrentAction == "gridedit") { ?>
<table id="tbl_orderslist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$orders_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$orders_list->RenderListOptions();

// Render list options (header, left)
$orders_list->ListOptions->Render("header", "left");
?>
<?php if ($orders->OrderID->Visible) { // OrderID ?>
	<?php if ($orders->SortUrl($orders->OrderID) == "") { ?>
		<th data-name="OrderID" class="<?php echo $orders->OrderID->HeaderCellClass() ?>"><div id="elh_orders_OrderID" class="orders_OrderID"><div class="ewTableHeaderCaption"><?php echo $orders->OrderID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="OrderID" class="<?php echo $orders->OrderID->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->OrderID) ?>',1);"><div id="elh_orders_OrderID" class="orders_OrderID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->OrderID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->OrderID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->OrderID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
	<?php if ($orders->SortUrl($orders->CustomerID) == "") { ?>
		<th data-name="CustomerID" class="<?php echo $orders->CustomerID->HeaderCellClass() ?>"><div id="elh_orders_CustomerID" class="orders_CustomerID"><div class="ewTableHeaderCaption"><?php echo $orders->CustomerID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="CustomerID" class="<?php echo $orders->CustomerID->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->CustomerID) ?>',1);"><div id="elh_orders_CustomerID" class="orders_CustomerID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->CustomerID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->CustomerID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->CustomerID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->FullName->Visible) { // FullName ?>
	<?php if ($orders->SortUrl($orders->FullName) == "") { ?>
		<th data-name="FullName" class="<?php echo $orders->FullName->HeaderCellClass() ?>"><div id="elh_orders_FullName" class="orders_FullName"><div class="ewTableHeaderCaption"><?php echo $orders->FullName->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="FullName" class="<?php echo $orders->FullName->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->FullName) ?>',1);"><div id="elh_orders_FullName" class="orders_FullName">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->FullName->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->FullName->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->FullName->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
	<?php if ($orders->SortUrl($orders->ProvinceID) == "") { ?>
		<th data-name="ProvinceID" class="<?php echo $orders->ProvinceID->HeaderCellClass() ?>"><div id="elh_orders_ProvinceID" class="orders_ProvinceID"><div class="ewTableHeaderCaption"><?php echo $orders->ProvinceID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ProvinceID" class="<?php echo $orders->ProvinceID->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->ProvinceID) ?>',1);"><div id="elh_orders_ProvinceID" class="orders_ProvinceID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->ProvinceID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->ProvinceID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->ProvinceID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
	<?php if ($orders->SortUrl($orders->ZipCode) == "") { ?>
		<th data-name="ZipCode" class="<?php echo $orders->ZipCode->HeaderCellClass() ?>"><div id="elh_orders_ZipCode" class="orders_ZipCode"><div class="ewTableHeaderCaption"><?php echo $orders->ZipCode->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ZipCode" class="<?php echo $orders->ZipCode->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->ZipCode) ?>',1);"><div id="elh_orders_ZipCode" class="orders_ZipCode">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->ZipCode->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->ZipCode->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->ZipCode->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->Phone->Visible) { // Phone ?>
	<?php if ($orders->SortUrl($orders->Phone) == "") { ?>
		<th data-name="Phone" class="<?php echo $orders->Phone->HeaderCellClass() ?>"><div id="elh_orders_Phone" class="orders_Phone"><div class="ewTableHeaderCaption"><?php echo $orders->Phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Phone" class="<?php echo $orders->Phone->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->Phone) ?>',1);"><div id="elh_orders_Phone" class="orders_Phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->Phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->Phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->Phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->Discount->Visible) { // Discount ?>
	<?php if ($orders->SortUrl($orders->Discount) == "") { ?>
		<th data-name="Discount" class="<?php echo $orders->Discount->HeaderCellClass() ?>"><div id="elh_orders_Discount" class="orders_Discount"><div class="ewTableHeaderCaption"><?php echo $orders->Discount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Discount" class="<?php echo $orders->Discount->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->Discount) ?>',1);"><div id="elh_orders_Discount" class="orders_Discount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->Discount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->Discount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->Discount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
	<?php if ($orders->SortUrl($orders->TotalPrice) == "") { ?>
		<th data-name="TotalPrice" class="<?php echo $orders->TotalPrice->HeaderCellClass() ?>"><div id="elh_orders_TotalPrice" class="orders_TotalPrice"><div class="ewTableHeaderCaption"><?php echo $orders->TotalPrice->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="TotalPrice" class="<?php echo $orders->TotalPrice->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->TotalPrice) ?>',1);"><div id="elh_orders_TotalPrice" class="orders_TotalPrice">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->TotalPrice->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->TotalPrice->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->TotalPrice->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
	<?php if ($orders->SortUrl($orders->PaymentTypeID) == "") { ?>
		<th data-name="PaymentTypeID" class="<?php echo $orders->PaymentTypeID->HeaderCellClass() ?>"><div id="elh_orders_PaymentTypeID" class="orders_PaymentTypeID"><div class="ewTableHeaderCaption"><?php echo $orders->PaymentTypeID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="PaymentTypeID" class="<?php echo $orders->PaymentTypeID->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->PaymentTypeID) ?>',1);"><div id="elh_orders_PaymentTypeID" class="orders_PaymentTypeID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->PaymentTypeID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->PaymentTypeID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->PaymentTypeID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
	<?php if ($orders->SortUrl($orders->DeliveryTypeID) == "") { ?>
		<th data-name="DeliveryTypeID" class="<?php echo $orders->DeliveryTypeID->HeaderCellClass() ?>"><div id="elh_orders_DeliveryTypeID" class="orders_DeliveryTypeID"><div class="ewTableHeaderCaption"><?php echo $orders->DeliveryTypeID->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="DeliveryTypeID" class="<?php echo $orders->DeliveryTypeID->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->DeliveryTypeID) ?>',1);"><div id="elh_orders_DeliveryTypeID" class="orders_DeliveryTypeID">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->DeliveryTypeID->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->DeliveryTypeID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->DeliveryTypeID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
	<?php if ($orders->SortUrl($orders->OrderDateTime) == "") { ?>
		<th data-name="OrderDateTime" class="<?php echo $orders->OrderDateTime->HeaderCellClass() ?>"><div id="elh_orders_OrderDateTime" class="orders_OrderDateTime"><div class="ewTableHeaderCaption"><?php echo $orders->OrderDateTime->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="OrderDateTime" class="<?php echo $orders->OrderDateTime->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->OrderDateTime) ?>',1);"><div id="elh_orders_OrderDateTime" class="orders_OrderDateTime">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->OrderDateTime->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->OrderDateTime->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->OrderDateTime->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$orders_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($orders->ExportAll && $orders->Export <> "") {
	$orders_list->StopRec = $orders_list->TotalRecs;
} else {

	// Set the last record to display
	if ($orders_list->TotalRecs > $orders_list->StartRec + $orders_list->DisplayRecs - 1)
		$orders_list->StopRec = $orders_list->StartRec + $orders_list->DisplayRecs - 1;
	else
		$orders_list->StopRec = $orders_list->TotalRecs;
}
$orders_list->RecCnt = $orders_list->StartRec - 1;
if ($orders_list->Recordset && !$orders_list->Recordset->EOF) {
	$orders_list->Recordset->MoveFirst();
	$bSelectLimit = $orders_list->UseSelectLimit;
	if (!$bSelectLimit && $orders_list->StartRec > 1)
		$orders_list->Recordset->Move($orders_list->StartRec - 1);
} elseif (!$orders->AllowAddDeleteRow && $orders_list->StopRec == 0) {
	$orders_list->StopRec = $orders->GridAddRowCount;
}

// Initialize aggregate
$orders->RowType = EW_ROWTYPE_AGGREGATEINIT;
$orders->ResetAttrs();
$orders_list->RenderRow();
while ($orders_list->RecCnt < $orders_list->StopRec) {
	$orders_list->RecCnt++;
	if (intval($orders_list->RecCnt) >= intval($orders_list->StartRec)) {
		$orders_list->RowCnt++;

		// Set up key count
		$orders_list->KeyCount = $orders_list->RowIndex;

		// Init row class and style
		$orders->ResetAttrs();
		$orders->CssClass = "";
		if ($orders->CurrentAction == "gridadd") {
		} else {
			$orders_list->LoadRowValues($orders_list->Recordset); // Load row values
		}
		$orders->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$orders->RowAttrs = array_merge($orders->RowAttrs, array('data-rowindex'=>$orders_list->RowCnt, 'id'=>'r' . $orders_list->RowCnt . '_orders', 'data-rowtype'=>$orders->RowType));

		// Render row
		$orders_list->RenderRow();

		// Render list options
		$orders_list->RenderListOptions();
?>
	<tr<?php echo $orders->RowAttributes() ?>>
<?php

// Render list options (body, left)
$orders_list->ListOptions->Render("body", "left", $orders_list->RowCnt);
?>
	<?php if ($orders->OrderID->Visible) { // OrderID ?>
		<td data-name="OrderID"<?php echo $orders->OrderID->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_OrderID" class="orders_OrderID">
<span<?php echo $orders->OrderID->ViewAttributes() ?>>
<?php echo $orders->OrderID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
		<td data-name="CustomerID"<?php echo $orders->CustomerID->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_CustomerID" class="orders_CustomerID">
<span<?php echo $orders->CustomerID->ViewAttributes() ?>>
<?php echo $orders->CustomerID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->FullName->Visible) { // FullName ?>
		<td data-name="FullName"<?php echo $orders->FullName->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_FullName" class="orders_FullName">
<span<?php echo $orders->FullName->ViewAttributes() ?>>
<?php echo $orders->FullName->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
		<td data-name="ProvinceID"<?php echo $orders->ProvinceID->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_ProvinceID" class="orders_ProvinceID">
<span<?php echo $orders->ProvinceID->ViewAttributes() ?>>
<?php echo $orders->ProvinceID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
		<td data-name="ZipCode"<?php echo $orders->ZipCode->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_ZipCode" class="orders_ZipCode">
<span<?php echo $orders->ZipCode->ViewAttributes() ?>>
<?php echo $orders->ZipCode->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->Phone->Visible) { // Phone ?>
		<td data-name="Phone"<?php echo $orders->Phone->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_Phone" class="orders_Phone">
<span<?php echo $orders->Phone->ViewAttributes() ?>>
<?php echo $orders->Phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->Discount->Visible) { // Discount ?>
		<td data-name="Discount"<?php echo $orders->Discount->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_Discount" class="orders_Discount">
<span<?php echo $orders->Discount->ViewAttributes() ?>>
<?php echo $orders->Discount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
		<td data-name="TotalPrice"<?php echo $orders->TotalPrice->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_TotalPrice" class="orders_TotalPrice">
<span<?php echo $orders->TotalPrice->ViewAttributes() ?>>
<?php echo $orders->TotalPrice->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
		<td data-name="PaymentTypeID"<?php echo $orders->PaymentTypeID->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_PaymentTypeID" class="orders_PaymentTypeID">
<span<?php echo $orders->PaymentTypeID->ViewAttributes() ?>>
<?php echo $orders->PaymentTypeID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
		<td data-name="DeliveryTypeID"<?php echo $orders->DeliveryTypeID->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_DeliveryTypeID" class="orders_DeliveryTypeID">
<span<?php echo $orders->DeliveryTypeID->ViewAttributes() ?>>
<?php echo $orders->DeliveryTypeID->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
		<td data-name="OrderDateTime"<?php echo $orders->OrderDateTime->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_OrderDateTime" class="orders_OrderDateTime">
<span<?php echo $orders->OrderDateTime->ViewAttributes() ?>>
<?php echo $orders->OrderDateTime->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$orders_list->ListOptions->Render("body", "right", $orders_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($orders->CurrentAction <> "gridadd")
		$orders_list->Recordset->MoveNext();
}
?>
</tbody>
<?php

// Render aggregate row
$orders->RowType = EW_ROWTYPE_AGGREGATE;
$orders->ResetAttrs();
$orders_list->RenderRow();
?>
<?php if ($orders_list->TotalRecs > 0 && ($orders->CurrentAction <> "gridadd" && $orders->CurrentAction <> "gridedit")) { ?>
<tfoot><!-- Table footer -->
	<tr class="ewTableFooter">
<?php

// Render list options
$orders_list->RenderListOptions();

// Render list options (footer, left)
$orders_list->ListOptions->Render("footer", "left");
?>
	<?php if ($orders->OrderID->Visible) { // OrderID ?>
		<td data-name="OrderID" class="<?php echo $orders->OrderID->FooterCellClass() ?>"><span id="elf_orders_OrderID" class="orders_OrderID">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->CustomerID->Visible) { // CustomerID ?>
		<td data-name="CustomerID" class="<?php echo $orders->CustomerID->FooterCellClass() ?>"><span id="elf_orders_CustomerID" class="orders_CustomerID">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->FullName->Visible) { // FullName ?>
		<td data-name="FullName" class="<?php echo $orders->FullName->FooterCellClass() ?>"><span id="elf_orders_FullName" class="orders_FullName">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->ProvinceID->Visible) { // ProvinceID ?>
		<td data-name="ProvinceID" class="<?php echo $orders->ProvinceID->FooterCellClass() ?>"><span id="elf_orders_ProvinceID" class="orders_ProvinceID">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->ZipCode->Visible) { // ZipCode ?>
		<td data-name="ZipCode" class="<?php echo $orders->ZipCode->FooterCellClass() ?>"><span id="elf_orders_ZipCode" class="orders_ZipCode">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->Phone->Visible) { // Phone ?>
		<td data-name="Phone" class="<?php echo $orders->Phone->FooterCellClass() ?>"><span id="elf_orders_Phone" class="orders_Phone">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->Discount->Visible) { // Discount ?>
		<td data-name="Discount" class="<?php echo $orders->Discount->FooterCellClass() ?>"><span id="elf_orders_Discount" class="orders_Discount">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->TotalPrice->Visible) { // TotalPrice ?>
		<td data-name="TotalPrice" class="<?php echo $orders->TotalPrice->FooterCellClass() ?>"><span id="elf_orders_TotalPrice" class="orders_TotalPrice">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?></span><span class="ewAggregateValue">
<?php echo $orders->TotalPrice->ViewValue ?></span>
		</span></td>
	<?php } ?>
	<?php if ($orders->PaymentTypeID->Visible) { // PaymentTypeID ?>
		<td data-name="PaymentTypeID" class="<?php echo $orders->PaymentTypeID->FooterCellClass() ?>"><span id="elf_orders_PaymentTypeID" class="orders_PaymentTypeID">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->DeliveryTypeID->Visible) { // DeliveryTypeID ?>
		<td data-name="DeliveryTypeID" class="<?php echo $orders->DeliveryTypeID->FooterCellClass() ?>"><span id="elf_orders_DeliveryTypeID" class="orders_DeliveryTypeID">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->OrderDateTime->Visible) { // OrderDateTime ?>
		<td data-name="OrderDateTime" class="<?php echo $orders->OrderDateTime->FooterCellClass() ?>"><span id="elf_orders_OrderDateTime" class="orders_OrderDateTime">
		&nbsp;
		</span></td>
	<?php } ?>
<?php

// Render list options (footer, right)
$orders_list->ListOptions->Render("footer", "right");
?>
	</tr>
</tfoot>
<?php } ?>
</table>
<?php } ?>
<?php if ($orders->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($orders_list->Recordset)
	$orders_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($orders->CurrentAction <> "gridadd" && $orders->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($orders_list->Pager)) $orders_list->Pager = new cPrevNextPager($orders_list->StartRec, $orders_list->DisplayRecs, $orders_list->TotalRecs, $orders_list->AutoHidePager) ?>
<?php if ($orders_list->Pager->RecordCount > 0 && $orders_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($orders_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($orders_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $orders_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($orders_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($orders_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $orders_list->PageUrl() ?>start=<?php echo $orders_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $orders_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($orders_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $orders_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $orders_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $orders_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
<?php if ($orders_list->TotalRecs > 0 && (!$orders_list->AutoHidePageSizeSelector || $orders_list->Pager->Visible)) { ?>
<div class="ewPager">
<input type="hidden" name="t" value="orders">
<select name="<?php echo EW_TABLE_REC_PER_PAGE ?>" class="form-control input-sm ewTooltip" title="<?php echo $Language->Phrase("RecordsPerPage") ?>" onchange="this.form.submit();">
<option value="20"<?php if ($orders_list->DisplayRecs == 20) { ?> selected<?php } ?>>20</option>
<option value="30"<?php if ($orders_list->DisplayRecs == 30) { ?> selected<?php } ?>>30</option>
<option value="50"<?php if ($orders_list->DisplayRecs == 50) { ?> selected<?php } ?>>50</option>
<option value="ALL"<?php if ($orders->getRecordsPerPage() == -1) { ?> selected<?php } ?>><?php echo $Language->Phrase("AllRecords") ?></option>
</select>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($orders_list->TotalRecs == 0 && $orders->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($orders_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
forderslistsrch.FilterList = <?php echo $orders_list->GetFilterList() ?>;
forderslistsrch.Init();
forderslist.Init();
</script>
<?php
$orders_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$orders_list->Page_Terminate();
?>
