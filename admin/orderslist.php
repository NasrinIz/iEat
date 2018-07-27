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
		$this->order_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->order_id->Visible = FALSE;
		$this->customer_id->SetVisibility();
		$this->full_name->SetVisibility();
		$this->province_id->SetVisibility();
		$this->zip_code->SetVisibility();
		$this->phone->SetVisibility();
		$this->discount->SetVisibility();
		$this->total_price->SetVisibility();
		$this->payment_type_id->SetVisibility();
		$this->delivery_type_id->SetVisibility();
		$this->order_date_time->SetVisibility();
		if ($this->IsAddOrEdit())
			$this->order_date_time->Visible = FALSE;

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
			$this->order_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->order_id->FormValue))
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
		$sFilterList = ew_Concat($sFilterList, $this->order_id->AdvancedSearch->ToJson(), ","); // Field order_id
		$sFilterList = ew_Concat($sFilterList, $this->customer_id->AdvancedSearch->ToJson(), ","); // Field customer_id
		$sFilterList = ew_Concat($sFilterList, $this->full_name->AdvancedSearch->ToJson(), ","); // Field full_name
		$sFilterList = ew_Concat($sFilterList, $this->province_id->AdvancedSearch->ToJson(), ","); // Field province_id
		$sFilterList = ew_Concat($sFilterList, $this->address->AdvancedSearch->ToJson(), ","); // Field address
		$sFilterList = ew_Concat($sFilterList, $this->zip_code->AdvancedSearch->ToJson(), ","); // Field zip_code
		$sFilterList = ew_Concat($sFilterList, $this->phone->AdvancedSearch->ToJson(), ","); // Field phone
		$sFilterList = ew_Concat($sFilterList, $this->discount->AdvancedSearch->ToJson(), ","); // Field discount
		$sFilterList = ew_Concat($sFilterList, $this->total_price->AdvancedSearch->ToJson(), ","); // Field total_price
		$sFilterList = ew_Concat($sFilterList, $this->payment_type_id->AdvancedSearch->ToJson(), ","); // Field payment_type_id
		$sFilterList = ew_Concat($sFilterList, $this->delivery_type_id->AdvancedSearch->ToJson(), ","); // Field delivery_type_id
		$sFilterList = ew_Concat($sFilterList, $this->description->AdvancedSearch->ToJson(), ","); // Field description
		$sFilterList = ew_Concat($sFilterList, $this->feedback->AdvancedSearch->ToJson(), ","); // Field feedback
		$sFilterList = ew_Concat($sFilterList, $this->order_date_time->AdvancedSearch->ToJson(), ","); // Field order_date_time
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

		// Field order_id
		$this->order_id->AdvancedSearch->SearchValue = @$filter["x_order_id"];
		$this->order_id->AdvancedSearch->SearchOperator = @$filter["z_order_id"];
		$this->order_id->AdvancedSearch->SearchCondition = @$filter["v_order_id"];
		$this->order_id->AdvancedSearch->SearchValue2 = @$filter["y_order_id"];
		$this->order_id->AdvancedSearch->SearchOperator2 = @$filter["w_order_id"];
		$this->order_id->AdvancedSearch->Save();

		// Field customer_id
		$this->customer_id->AdvancedSearch->SearchValue = @$filter["x_customer_id"];
		$this->customer_id->AdvancedSearch->SearchOperator = @$filter["z_customer_id"];
		$this->customer_id->AdvancedSearch->SearchCondition = @$filter["v_customer_id"];
		$this->customer_id->AdvancedSearch->SearchValue2 = @$filter["y_customer_id"];
		$this->customer_id->AdvancedSearch->SearchOperator2 = @$filter["w_customer_id"];
		$this->customer_id->AdvancedSearch->Save();

		// Field full_name
		$this->full_name->AdvancedSearch->SearchValue = @$filter["x_full_name"];
		$this->full_name->AdvancedSearch->SearchOperator = @$filter["z_full_name"];
		$this->full_name->AdvancedSearch->SearchCondition = @$filter["v_full_name"];
		$this->full_name->AdvancedSearch->SearchValue2 = @$filter["y_full_name"];
		$this->full_name->AdvancedSearch->SearchOperator2 = @$filter["w_full_name"];
		$this->full_name->AdvancedSearch->Save();

		// Field province_id
		$this->province_id->AdvancedSearch->SearchValue = @$filter["x_province_id"];
		$this->province_id->AdvancedSearch->SearchOperator = @$filter["z_province_id"];
		$this->province_id->AdvancedSearch->SearchCondition = @$filter["v_province_id"];
		$this->province_id->AdvancedSearch->SearchValue2 = @$filter["y_province_id"];
		$this->province_id->AdvancedSearch->SearchOperator2 = @$filter["w_province_id"];
		$this->province_id->AdvancedSearch->Save();

		// Field address
		$this->address->AdvancedSearch->SearchValue = @$filter["x_address"];
		$this->address->AdvancedSearch->SearchOperator = @$filter["z_address"];
		$this->address->AdvancedSearch->SearchCondition = @$filter["v_address"];
		$this->address->AdvancedSearch->SearchValue2 = @$filter["y_address"];
		$this->address->AdvancedSearch->SearchOperator2 = @$filter["w_address"];
		$this->address->AdvancedSearch->Save();

		// Field zip_code
		$this->zip_code->AdvancedSearch->SearchValue = @$filter["x_zip_code"];
		$this->zip_code->AdvancedSearch->SearchOperator = @$filter["z_zip_code"];
		$this->zip_code->AdvancedSearch->SearchCondition = @$filter["v_zip_code"];
		$this->zip_code->AdvancedSearch->SearchValue2 = @$filter["y_zip_code"];
		$this->zip_code->AdvancedSearch->SearchOperator2 = @$filter["w_zip_code"];
		$this->zip_code->AdvancedSearch->Save();

		// Field phone
		$this->phone->AdvancedSearch->SearchValue = @$filter["x_phone"];
		$this->phone->AdvancedSearch->SearchOperator = @$filter["z_phone"];
		$this->phone->AdvancedSearch->SearchCondition = @$filter["v_phone"];
		$this->phone->AdvancedSearch->SearchValue2 = @$filter["y_phone"];
		$this->phone->AdvancedSearch->SearchOperator2 = @$filter["w_phone"];
		$this->phone->AdvancedSearch->Save();

		// Field discount
		$this->discount->AdvancedSearch->SearchValue = @$filter["x_discount"];
		$this->discount->AdvancedSearch->SearchOperator = @$filter["z_discount"];
		$this->discount->AdvancedSearch->SearchCondition = @$filter["v_discount"];
		$this->discount->AdvancedSearch->SearchValue2 = @$filter["y_discount"];
		$this->discount->AdvancedSearch->SearchOperator2 = @$filter["w_discount"];
		$this->discount->AdvancedSearch->Save();

		// Field total_price
		$this->total_price->AdvancedSearch->SearchValue = @$filter["x_total_price"];
		$this->total_price->AdvancedSearch->SearchOperator = @$filter["z_total_price"];
		$this->total_price->AdvancedSearch->SearchCondition = @$filter["v_total_price"];
		$this->total_price->AdvancedSearch->SearchValue2 = @$filter["y_total_price"];
		$this->total_price->AdvancedSearch->SearchOperator2 = @$filter["w_total_price"];
		$this->total_price->AdvancedSearch->Save();

		// Field payment_type_id
		$this->payment_type_id->AdvancedSearch->SearchValue = @$filter["x_payment_type_id"];
		$this->payment_type_id->AdvancedSearch->SearchOperator = @$filter["z_payment_type_id"];
		$this->payment_type_id->AdvancedSearch->SearchCondition = @$filter["v_payment_type_id"];
		$this->payment_type_id->AdvancedSearch->SearchValue2 = @$filter["y_payment_type_id"];
		$this->payment_type_id->AdvancedSearch->SearchOperator2 = @$filter["w_payment_type_id"];
		$this->payment_type_id->AdvancedSearch->Save();

		// Field delivery_type_id
		$this->delivery_type_id->AdvancedSearch->SearchValue = @$filter["x_delivery_type_id"];
		$this->delivery_type_id->AdvancedSearch->SearchOperator = @$filter["z_delivery_type_id"];
		$this->delivery_type_id->AdvancedSearch->SearchCondition = @$filter["v_delivery_type_id"];
		$this->delivery_type_id->AdvancedSearch->SearchValue2 = @$filter["y_delivery_type_id"];
		$this->delivery_type_id->AdvancedSearch->SearchOperator2 = @$filter["w_delivery_type_id"];
		$this->delivery_type_id->AdvancedSearch->Save();

		// Field description
		$this->description->AdvancedSearch->SearchValue = @$filter["x_description"];
		$this->description->AdvancedSearch->SearchOperator = @$filter["z_description"];
		$this->description->AdvancedSearch->SearchCondition = @$filter["v_description"];
		$this->description->AdvancedSearch->SearchValue2 = @$filter["y_description"];
		$this->description->AdvancedSearch->SearchOperator2 = @$filter["w_description"];
		$this->description->AdvancedSearch->Save();

		// Field feedback
		$this->feedback->AdvancedSearch->SearchValue = @$filter["x_feedback"];
		$this->feedback->AdvancedSearch->SearchOperator = @$filter["z_feedback"];
		$this->feedback->AdvancedSearch->SearchCondition = @$filter["v_feedback"];
		$this->feedback->AdvancedSearch->SearchValue2 = @$filter["y_feedback"];
		$this->feedback->AdvancedSearch->SearchOperator2 = @$filter["w_feedback"];
		$this->feedback->AdvancedSearch->Save();

		// Field order_date_time
		$this->order_date_time->AdvancedSearch->SearchValue = @$filter["x_order_date_time"];
		$this->order_date_time->AdvancedSearch->SearchOperator = @$filter["z_order_date_time"];
		$this->order_date_time->AdvancedSearch->SearchCondition = @$filter["v_order_date_time"];
		$this->order_date_time->AdvancedSearch->SearchValue2 = @$filter["y_order_date_time"];
		$this->order_date_time->AdvancedSearch->SearchOperator2 = @$filter["w_order_date_time"];
		$this->order_date_time->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->full_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->address, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->zip_code, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->phone, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->feedback, $arKeywords, $type);
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
			$this->UpdateSort($this->order_id); // order_id
			$this->UpdateSort($this->customer_id); // customer_id
			$this->UpdateSort($this->full_name); // full_name
			$this->UpdateSort($this->province_id); // province_id
			$this->UpdateSort($this->zip_code); // zip_code
			$this->UpdateSort($this->phone); // phone
			$this->UpdateSort($this->discount); // discount
			$this->UpdateSort($this->total_price); // total_price
			$this->UpdateSort($this->payment_type_id); // payment_type_id
			$this->UpdateSort($this->delivery_type_id); // delivery_type_id
			$this->UpdateSort($this->order_date_time); // order_date_time
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
				$this->order_id->setSort("");
				$this->customer_id->setSort("");
				$this->full_name->setSort("");
				$this->province_id->setSort("");
				$this->zip_code->setSort("");
				$this->phone->setSort("");
				$this->discount->setSort("");
				$this->total_price->setSort("");
				$this->payment_type_id->setSort("");
				$this->delivery_type_id->setSort("");
				$this->order_date_time->setSort("");
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

		// "detail_order_details"
		$item = &$this->ListOptions->Add("detail_order_details");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'order_details') && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["order_details_grid"])) $GLOBALS["order_details_grid"] = new corder_details_grid;

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
		$pages->Add("order_details");
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

		// "detail_order_details"
		$oListOpt = &$this->ListOptions->Items["detail_order_details"];
		if ($Security->AllowList(CurrentProjectID() . 'order_details')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("order_details", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("order_detailslist.php?" . EW_TABLE_SHOW_MASTER . "=orders&fk_order_id=" . urlencode(strval($this->order_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["order_details_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'order_details')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=order_details");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "order_details";
			}
			if ($GLOBALS["order_details_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'order_details')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=order_details");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "order_details";
			}
			if ($GLOBALS["order_details_grid"]->DetailAdd && $Security->CanAdd() && $Security->AllowAdd(CurrentProjectID() . 'order_details')) {
				$caption = $Language->Phrase("MasterDetailCopyLink");
				$url = $this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=order_details");
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "order_details";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->order_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
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
		$item = &$option->Add("detailadd_order_details");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=order_details");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["order_details"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["order_details"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'order_details') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "order_details";
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
		$row = array();
		$row['order_id'] = NULL;
		$row['customer_id'] = NULL;
		$row['full_name'] = NULL;
		$row['province_id'] = NULL;
		$row['address'] = NULL;
		$row['zip_code'] = NULL;
		$row['phone'] = NULL;
		$row['discount'] = NULL;
		$row['total_price'] = NULL;
		$row['payment_type_id'] = NULL;
		$row['delivery_type_id'] = NULL;
		$row['description'] = NULL;
		$row['feedback'] = NULL;
		$row['order_date_time'] = NULL;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		// Accumulate aggregate value

		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT && $this->RowType <> EW_ROWTYPE_AGGREGATE) {
			if (is_numeric($this->total_price->CurrentValue))
				$this->total_price->Total += $this->total_price->CurrentValue; // Accumulate total
		}
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

		// order_date_time
		$this->order_date_time->ViewValue = $this->order_date_time->CurrentValue;
		$this->order_date_time->ViewValue = ew_FormatDateTime($this->order_date_time->ViewValue, 0);
		$this->order_date_time->ViewCustomAttributes = "";

			// order_id
			$this->order_id->LinkCustomAttributes = "";
			$this->order_id->HrefValue = "";
			$this->order_id->TooltipValue = "";

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

			// order_date_time
			$this->order_date_time->LinkCustomAttributes = "";
			$this->order_date_time->HrefValue = "";
			$this->order_date_time->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATEINIT) { // Initialize aggregate row
			$this->total_price->Total = 0; // Initialize total
		} elseif ($this->RowType == EW_ROWTYPE_AGGREGATE) { // Aggregate row
			$this->total_price->CurrentValue = $this->total_price->Total;
			$this->total_price->ViewValue = $this->total_price->CurrentValue;
			$this->total_price->ViewValue = ew_FormatCurrency($this->total_price->ViewValue, 0, -2, -2, -2);
			$this->total_price->ViewCustomAttributes = "";
			$this->total_price->HrefValue = ""; // Clear href value
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
forderslist.Lists["x_customer_id"] = {"LinkField":"x_customer_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_full_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"customers"};
forderslist.Lists["x_customer_id"].Data = "<?php echo $orders_list->customer_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_province_id"] = {"LinkField":"x_province_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"provinces"};
forderslist.Lists["x_province_id"].Data = "<?php echo $orders_list->province_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_payment_type_id"] = {"LinkField":"x_payment_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"payment_types"};
forderslist.Lists["x_payment_type_id"].Data = "<?php echo $orders_list->payment_type_id->LookupFilterQuery(FALSE, "list") ?>";
forderslist.Lists["x_delivery_type_id"] = {"LinkField":"x_delivery_type_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"delivery_types"};
forderslist.Lists["x_delivery_type_id"].Data = "<?php echo $orders_list->delivery_type_id->LookupFilterQuery(FALSE, "list") ?>";

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
<?php if ($orders->order_id->Visible) { // order_id ?>
	<?php if ($orders->SortUrl($orders->order_id) == "") { ?>
		<th data-name="order_id" class="<?php echo $orders->order_id->HeaderCellClass() ?>"><div id="elh_orders_order_id" class="orders_order_id"><div class="ewTableHeaderCaption"><?php echo $orders->order_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="order_id" class="<?php echo $orders->order_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->order_id) ?>',1);"><div id="elh_orders_order_id" class="orders_order_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->order_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->order_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->order_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->customer_id->Visible) { // customer_id ?>
	<?php if ($orders->SortUrl($orders->customer_id) == "") { ?>
		<th data-name="customer_id" class="<?php echo $orders->customer_id->HeaderCellClass() ?>"><div id="elh_orders_customer_id" class="orders_customer_id"><div class="ewTableHeaderCaption"><?php echo $orders->customer_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="customer_id" class="<?php echo $orders->customer_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->customer_id) ?>',1);"><div id="elh_orders_customer_id" class="orders_customer_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->customer_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->customer_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->customer_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->full_name->Visible) { // full_name ?>
	<?php if ($orders->SortUrl($orders->full_name) == "") { ?>
		<th data-name="full_name" class="<?php echo $orders->full_name->HeaderCellClass() ?>"><div id="elh_orders_full_name" class="orders_full_name"><div class="ewTableHeaderCaption"><?php echo $orders->full_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="full_name" class="<?php echo $orders->full_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->full_name) ?>',1);"><div id="elh_orders_full_name" class="orders_full_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->full_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->full_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->full_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->province_id->Visible) { // province_id ?>
	<?php if ($orders->SortUrl($orders->province_id) == "") { ?>
		<th data-name="province_id" class="<?php echo $orders->province_id->HeaderCellClass() ?>"><div id="elh_orders_province_id" class="orders_province_id"><div class="ewTableHeaderCaption"><?php echo $orders->province_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="province_id" class="<?php echo $orders->province_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->province_id) ?>',1);"><div id="elh_orders_province_id" class="orders_province_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->province_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->province_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->province_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->zip_code->Visible) { // zip_code ?>
	<?php if ($orders->SortUrl($orders->zip_code) == "") { ?>
		<th data-name="zip_code" class="<?php echo $orders->zip_code->HeaderCellClass() ?>"><div id="elh_orders_zip_code" class="orders_zip_code"><div class="ewTableHeaderCaption"><?php echo $orders->zip_code->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="zip_code" class="<?php echo $orders->zip_code->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->zip_code) ?>',1);"><div id="elh_orders_zip_code" class="orders_zip_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->zip_code->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->zip_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->zip_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->phone->Visible) { // phone ?>
	<?php if ($orders->SortUrl($orders->phone) == "") { ?>
		<th data-name="phone" class="<?php echo $orders->phone->HeaderCellClass() ?>"><div id="elh_orders_phone" class="orders_phone"><div class="ewTableHeaderCaption"><?php echo $orders->phone->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="phone" class="<?php echo $orders->phone->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->phone) ?>',1);"><div id="elh_orders_phone" class="orders_phone">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->phone->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($orders->phone->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->phone->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->discount->Visible) { // discount ?>
	<?php if ($orders->SortUrl($orders->discount) == "") { ?>
		<th data-name="discount" class="<?php echo $orders->discount->HeaderCellClass() ?>"><div id="elh_orders_discount" class="orders_discount"><div class="ewTableHeaderCaption"><?php echo $orders->discount->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="discount" class="<?php echo $orders->discount->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->discount) ?>',1);"><div id="elh_orders_discount" class="orders_discount">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->discount->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->discount->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->discount->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->total_price->Visible) { // total_price ?>
	<?php if ($orders->SortUrl($orders->total_price) == "") { ?>
		<th data-name="total_price" class="<?php echo $orders->total_price->HeaderCellClass() ?>"><div id="elh_orders_total_price" class="orders_total_price"><div class="ewTableHeaderCaption"><?php echo $orders->total_price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="total_price" class="<?php echo $orders->total_price->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->total_price) ?>',1);"><div id="elh_orders_total_price" class="orders_total_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->total_price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->total_price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->total_price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
	<?php if ($orders->SortUrl($orders->payment_type_id) == "") { ?>
		<th data-name="payment_type_id" class="<?php echo $orders->payment_type_id->HeaderCellClass() ?>"><div id="elh_orders_payment_type_id" class="orders_payment_type_id"><div class="ewTableHeaderCaption"><?php echo $orders->payment_type_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="payment_type_id" class="<?php echo $orders->payment_type_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->payment_type_id) ?>',1);"><div id="elh_orders_payment_type_id" class="orders_payment_type_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->payment_type_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->payment_type_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->payment_type_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
	<?php if ($orders->SortUrl($orders->delivery_type_id) == "") { ?>
		<th data-name="delivery_type_id" class="<?php echo $orders->delivery_type_id->HeaderCellClass() ?>"><div id="elh_orders_delivery_type_id" class="orders_delivery_type_id"><div class="ewTableHeaderCaption"><?php echo $orders->delivery_type_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="delivery_type_id" class="<?php echo $orders->delivery_type_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->delivery_type_id) ?>',1);"><div id="elh_orders_delivery_type_id" class="orders_delivery_type_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->delivery_type_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->delivery_type_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->delivery_type_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
	<?php if ($orders->SortUrl($orders->order_date_time) == "") { ?>
		<th data-name="order_date_time" class="<?php echo $orders->order_date_time->HeaderCellClass() ?>"><div id="elh_orders_order_date_time" class="orders_order_date_time"><div class="ewTableHeaderCaption"><?php echo $orders->order_date_time->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="order_date_time" class="<?php echo $orders->order_date_time->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $orders->SortUrl($orders->order_date_time) ?>',1);"><div id="elh_orders_order_date_time" class="orders_order_date_time">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $orders->order_date_time->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($orders->order_date_time->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($orders->order_date_time->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	<?php if ($orders->order_id->Visible) { // order_id ?>
		<td data-name="order_id"<?php echo $orders->order_id->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_order_id" class="orders_order_id">
<span<?php echo $orders->order_id->ViewAttributes() ?>>
<?php echo $orders->order_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->customer_id->Visible) { // customer_id ?>
		<td data-name="customer_id"<?php echo $orders->customer_id->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_customer_id" class="orders_customer_id">
<span<?php echo $orders->customer_id->ViewAttributes() ?>>
<?php echo $orders->customer_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->full_name->Visible) { // full_name ?>
		<td data-name="full_name"<?php echo $orders->full_name->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_full_name" class="orders_full_name">
<span<?php echo $orders->full_name->ViewAttributes() ?>>
<?php echo $orders->full_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->province_id->Visible) { // province_id ?>
		<td data-name="province_id"<?php echo $orders->province_id->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_province_id" class="orders_province_id">
<span<?php echo $orders->province_id->ViewAttributes() ?>>
<?php echo $orders->province_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->zip_code->Visible) { // zip_code ?>
		<td data-name="zip_code"<?php echo $orders->zip_code->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_zip_code" class="orders_zip_code">
<span<?php echo $orders->zip_code->ViewAttributes() ?>>
<?php echo $orders->zip_code->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->phone->Visible) { // phone ?>
		<td data-name="phone"<?php echo $orders->phone->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_phone" class="orders_phone">
<span<?php echo $orders->phone->ViewAttributes() ?>>
<?php echo $orders->phone->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->discount->Visible) { // discount ?>
		<td data-name="discount"<?php echo $orders->discount->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_discount" class="orders_discount">
<span<?php echo $orders->discount->ViewAttributes() ?>>
<?php echo $orders->discount->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->total_price->Visible) { // total_price ?>
		<td data-name="total_price"<?php echo $orders->total_price->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_total_price" class="orders_total_price">
<span<?php echo $orders->total_price->ViewAttributes() ?>>
<?php echo $orders->total_price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
		<td data-name="payment_type_id"<?php echo $orders->payment_type_id->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_payment_type_id" class="orders_payment_type_id">
<span<?php echo $orders->payment_type_id->ViewAttributes() ?>>
<?php echo $orders->payment_type_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
		<td data-name="delivery_type_id"<?php echo $orders->delivery_type_id->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_delivery_type_id" class="orders_delivery_type_id">
<span<?php echo $orders->delivery_type_id->ViewAttributes() ?>>
<?php echo $orders->delivery_type_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
		<td data-name="order_date_time"<?php echo $orders->order_date_time->CellAttributes() ?>>
<span id="el<?php echo $orders_list->RowCnt ?>_orders_order_date_time" class="orders_order_date_time">
<span<?php echo $orders->order_date_time->ViewAttributes() ?>>
<?php echo $orders->order_date_time->ListViewValue() ?></span>
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
	<?php if ($orders->order_id->Visible) { // order_id ?>
		<td data-name="order_id" class="<?php echo $orders->order_id->FooterCellClass() ?>"><span id="elf_orders_order_id" class="orders_order_id">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->customer_id->Visible) { // customer_id ?>
		<td data-name="customer_id" class="<?php echo $orders->customer_id->FooterCellClass() ?>"><span id="elf_orders_customer_id" class="orders_customer_id">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->full_name->Visible) { // full_name ?>
		<td data-name="full_name" class="<?php echo $orders->full_name->FooterCellClass() ?>"><span id="elf_orders_full_name" class="orders_full_name">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->province_id->Visible) { // province_id ?>
		<td data-name="province_id" class="<?php echo $orders->province_id->FooterCellClass() ?>"><span id="elf_orders_province_id" class="orders_province_id">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->zip_code->Visible) { // zip_code ?>
		<td data-name="zip_code" class="<?php echo $orders->zip_code->FooterCellClass() ?>"><span id="elf_orders_zip_code" class="orders_zip_code">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->phone->Visible) { // phone ?>
		<td data-name="phone" class="<?php echo $orders->phone->FooterCellClass() ?>"><span id="elf_orders_phone" class="orders_phone">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->discount->Visible) { // discount ?>
		<td data-name="discount" class="<?php echo $orders->discount->FooterCellClass() ?>"><span id="elf_orders_discount" class="orders_discount">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->total_price->Visible) { // total_price ?>
		<td data-name="total_price" class="<?php echo $orders->total_price->FooterCellClass() ?>"><span id="elf_orders_total_price" class="orders_total_price">
<span class="ewAggregate"><?php echo $Language->Phrase("TOTAL") ?></span><span class="ewAggregateValue">
<?php echo $orders->total_price->ViewValue ?></span>
		</span></td>
	<?php } ?>
	<?php if ($orders->payment_type_id->Visible) { // payment_type_id ?>
		<td data-name="payment_type_id" class="<?php echo $orders->payment_type_id->FooterCellClass() ?>"><span id="elf_orders_payment_type_id" class="orders_payment_type_id">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->delivery_type_id->Visible) { // delivery_type_id ?>
		<td data-name="delivery_type_id" class="<?php echo $orders->delivery_type_id->FooterCellClass() ?>"><span id="elf_orders_delivery_type_id" class="orders_delivery_type_id">
		&nbsp;
		</span></td>
	<?php } ?>
	<?php if ($orders->order_date_time->Visible) { // order_date_time ?>
		<td data-name="order_date_time" class="<?php echo $orders->order_date_time->FooterCellClass() ?>"><span id="elf_orders_order_date_time" class="orders_order_date_time">
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
