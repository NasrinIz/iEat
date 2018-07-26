<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "sub_menusinfo.php" ?>
<?php include_once "employeesinfo.php" ?>
<?php include_once "menusinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$sub_menus_add = NULL; // Initialize page object first

class csub_menus_add extends csub_menus {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{C824E0A7-8646-4A04-889E-F8CBDC0FFFC2}';

	// Table name
	var $TableName = 'sub_menus';

	// Page object name
	var $PageObjName = 'sub_menus_add';

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

		// Table object (sub_menus)
		if (!isset($GLOBALS["sub_menus"]) || get_class($GLOBALS["sub_menus"]) == "csub_menus") {
			$GLOBALS["sub_menus"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["sub_menus"];
		}

		// Table object (employees)
		if (!isset($GLOBALS['employees'])) $GLOBALS['employees'] = new cemployees();

		// Table object (menus)
		if (!isset($GLOBALS['menus'])) $GLOBALS['menus'] = new cmenus();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'sub_menus', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("sub_menuslist.php"));
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
		$this->MenuID->SetVisibility();
		$this->Name->SetVisibility();
		$this->Picture->SetVisibility();
		$this->Price->SetVisibility();
		$this->Description->SetVisibility();

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
		global $EW_EXPORT, $sub_menus;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($sub_menus);
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
					if ($pageName == "sub_menusview.php")
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

		// Set up master/detail parameters
		$this->SetupMasterParms();

		// Set up current action
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["SubMenuID"] != "") {
				$this->SubMenuID->setQueryStringValue($_GET["SubMenuID"]);
				$this->setKey("SubMenuID", $this->SubMenuID->CurrentValue); // Set up key
			} else {
				$this->setKey("SubMenuID", ""); // Clear key
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
					$this->Page_Terminate("sub_menuslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "sub_menuslist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "sub_menusview.php")
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
		$this->Picture->Upload->Index = $objForm->Index;
		$this->Picture->Upload->UploadFile();
		$this->Picture->CurrentValue = $this->Picture->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->SubMenuID->CurrentValue = NULL;
		$this->SubMenuID->OldValue = $this->SubMenuID->CurrentValue;
		$this->MenuID->CurrentValue = NULL;
		$this->MenuID->OldValue = $this->MenuID->CurrentValue;
		$this->Name->CurrentValue = NULL;
		$this->Name->OldValue = $this->Name->CurrentValue;
		$this->Picture->Upload->DbValue = NULL;
		$this->Picture->OldValue = $this->Picture->Upload->DbValue;
		$this->Picture->CurrentValue = NULL; // Clear file related field
		$this->Price->CurrentValue = NULL;
		$this->Price->OldValue = $this->Price->CurrentValue;
		$this->Description->CurrentValue = NULL;
		$this->Description->OldValue = $this->Description->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->MenuID->FldIsDetailKey) {
			$this->MenuID->setFormValue($objForm->GetValue("x_MenuID"));
		}
		if (!$this->Name->FldIsDetailKey) {
			$this->Name->setFormValue($objForm->GetValue("x_Name"));
		}
		if (!$this->Price->FldIsDetailKey) {
			$this->Price->setFormValue($objForm->GetValue("x_Price"));
		}
		if (!$this->Description->FldIsDetailKey) {
			$this->Description->setFormValue($objForm->GetValue("x_Description"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->MenuID->CurrentValue = $this->MenuID->FormValue;
		$this->Name->CurrentValue = $this->Name->FormValue;
		$this->Price->CurrentValue = $this->Price->FormValue;
		$this->Description->CurrentValue = $this->Description->FormValue;
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
		$this->SubMenuID->setDbValue($row['SubMenuID']);
		$this->MenuID->setDbValue($row['MenuID']);
		$this->Name->setDbValue($row['Name']);
		$this->Picture->Upload->DbValue = $row['Picture'];
		$this->Picture->setDbValue($this->Picture->Upload->DbValue);
		$this->Price->setDbValue($row['Price']);
		$this->Description->setDbValue($row['Description']);
	}

	// Return a row with default values
	function NewRow() {
		$this->LoadDefaultValues();
		$row = array();
		$row['SubMenuID'] = $this->SubMenuID->CurrentValue;
		$row['MenuID'] = $this->MenuID->CurrentValue;
		$row['Name'] = $this->Name->CurrentValue;
		$row['Picture'] = $this->Picture->Upload->DbValue;
		$row['Price'] = $this->Price->CurrentValue;
		$row['Description'] = $this->Description->CurrentValue;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->SubMenuID->DbValue = $row['SubMenuID'];
		$this->MenuID->DbValue = $row['MenuID'];
		$this->Name->DbValue = $row['Name'];
		$this->Picture->Upload->DbValue = $row['Picture'];
		$this->Price->DbValue = $row['Price'];
		$this->Description->DbValue = $row['Description'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("SubMenuID")) <> "")
			$this->SubMenuID->CurrentValue = $this->getKey("SubMenuID"); // SubMenuID
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

		if ($this->Price->FormValue == $this->Price->CurrentValue && is_numeric(ew_StrToFloat($this->Price->CurrentValue)))
			$this->Price->CurrentValue = ew_StrToFloat($this->Price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// SubMenuID
		// MenuID
		// Name
		// Picture
		// Price
		// Description

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// MenuID
		if (strval($this->MenuID->CurrentValue) <> "") {
			$sFilterWrk = "`MenuID`" . ew_SearchString("=", $this->MenuID->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `MenuID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `menus`";
		$sWhereWrk = "";
		$this->MenuID->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->MenuID, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->MenuID->ViewValue = $this->MenuID->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->MenuID->ViewValue = $this->MenuID->CurrentValue;
			}
		} else {
			$this->MenuID->ViewValue = NULL;
		}
		$this->MenuID->ViewCustomAttributes = "";

		// Name
		$this->Name->ViewValue = $this->Name->CurrentValue;
		$this->Name->ViewCustomAttributes = "";

		// Picture
		if (!ew_Empty($this->Picture->Upload->DbValue)) {
			$this->Picture->ImageWidth = 100;
			$this->Picture->ImageHeight = 100;
			$this->Picture->ImageAlt = $this->Picture->FldAlt();
			$this->Picture->ViewValue = $this->Picture->Upload->DbValue;
		} else {
			$this->Picture->ViewValue = "";
		}
		$this->Picture->ViewCustomAttributes = "";

		// Price
		$this->Price->ViewValue = $this->Price->CurrentValue;
		$this->Price->ViewValue = ew_FormatCurrency($this->Price->ViewValue, 0, -2, -2, -2);
		$this->Price->ViewCustomAttributes = "";

		// Description
		$this->Description->ViewValue = $this->Description->CurrentValue;
		$this->Description->ViewCustomAttributes = "";

			// MenuID
			$this->MenuID->LinkCustomAttributes = "";
			$this->MenuID->HrefValue = "";
			$this->MenuID->TooltipValue = "";

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";
			$this->Name->TooltipValue = "";

			// Picture
			$this->Picture->LinkCustomAttributes = "";
			if (!ew_Empty($this->Picture->Upload->DbValue)) {
				$this->Picture->HrefValue = ew_GetFileUploadUrl($this->Picture, $this->Picture->Upload->DbValue); // Add prefix/suffix
				$this->Picture->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Picture->HrefValue = ew_FullUrl($this->Picture->HrefValue, "href");
			} else {
				$this->Picture->HrefValue = "";
			}
			$this->Picture->HrefValue2 = $this->Picture->UploadPath . $this->Picture->Upload->DbValue;
			$this->Picture->TooltipValue = "";
			if ($this->Picture->UseColorbox) {
				if (ew_Empty($this->Picture->TooltipValue))
					$this->Picture->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->Picture->LinkAttrs["data-rel"] = "sub_menus_x_Picture";
				ew_AppendClass($this->Picture->LinkAttrs["class"], "ewLightbox");
			}

			// Price
			$this->Price->LinkCustomAttributes = "";
			$this->Price->HrefValue = "";
			$this->Price->TooltipValue = "";

			// Description
			$this->Description->LinkCustomAttributes = "";
			$this->Description->HrefValue = "";
			$this->Description->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// MenuID
			$this->MenuID->EditAttrs["class"] = "form-control";
			$this->MenuID->EditCustomAttributes = "";
			if ($this->MenuID->getSessionValue() <> "") {
				$this->MenuID->CurrentValue = $this->MenuID->getSessionValue();
			if (strval($this->MenuID->CurrentValue) <> "") {
				$sFilterWrk = "`MenuID`" . ew_SearchString("=", $this->MenuID->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `MenuID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `menus`";
			$sWhereWrk = "";
			$this->MenuID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->MenuID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->MenuID->ViewValue = $this->MenuID->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->MenuID->ViewValue = $this->MenuID->CurrentValue;
				}
			} else {
				$this->MenuID->ViewValue = NULL;
			}
			$this->MenuID->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->MenuID->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`MenuID`" . ew_SearchString("=", $this->MenuID->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `MenuID`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `menus`";
			$sWhereWrk = "";
			$this->MenuID->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->MenuID, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Name`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->MenuID->EditValue = $arwrk;
			}

			// Name
			$this->Name->EditAttrs["class"] = "form-control";
			$this->Name->EditCustomAttributes = "";
			$this->Name->EditValue = ew_HtmlEncode($this->Name->CurrentValue);
			$this->Name->PlaceHolder = ew_RemoveHtml($this->Name->FldCaption());

			// Picture
			$this->Picture->EditAttrs["class"] = "form-control";
			$this->Picture->EditCustomAttributes = "";
			if (!ew_Empty($this->Picture->Upload->DbValue)) {
				$this->Picture->ImageWidth = 100;
				$this->Picture->ImageHeight = 100;
				$this->Picture->ImageAlt = $this->Picture->FldAlt();
				$this->Picture->EditValue = $this->Picture->Upload->DbValue;
			} else {
				$this->Picture->EditValue = "";
			}
			if (!ew_Empty($this->Picture->CurrentValue))
					$this->Picture->Upload->FileName = $this->Picture->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->Picture);

			// Price
			$this->Price->EditAttrs["class"] = "form-control";
			$this->Price->EditCustomAttributes = "";
			$this->Price->EditValue = ew_HtmlEncode($this->Price->CurrentValue);
			$this->Price->PlaceHolder = ew_RemoveHtml($this->Price->FldCaption());
			if (strval($this->Price->EditValue) <> "" && is_numeric($this->Price->EditValue)) $this->Price->EditValue = ew_FormatNumber($this->Price->EditValue, -2, -2, -2, -2);

			// Description
			$this->Description->EditAttrs["class"] = "form-control";
			$this->Description->EditCustomAttributes = "";
			$this->Description->EditValue = ew_HtmlEncode($this->Description->CurrentValue);
			$this->Description->PlaceHolder = ew_RemoveHtml($this->Description->FldCaption());

			// Add refer script
			// MenuID

			$this->MenuID->LinkCustomAttributes = "";
			$this->MenuID->HrefValue = "";

			// Name
			$this->Name->LinkCustomAttributes = "";
			$this->Name->HrefValue = "";

			// Picture
			$this->Picture->LinkCustomAttributes = "";
			if (!ew_Empty($this->Picture->Upload->DbValue)) {
				$this->Picture->HrefValue = ew_GetFileUploadUrl($this->Picture, $this->Picture->Upload->DbValue); // Add prefix/suffix
				$this->Picture->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->Picture->HrefValue = ew_FullUrl($this->Picture->HrefValue, "href");
			} else {
				$this->Picture->HrefValue = "";
			}
			$this->Picture->HrefValue2 = $this->Picture->UploadPath . $this->Picture->Upload->DbValue;

			// Price
			$this->Price->LinkCustomAttributes = "";
			$this->Price->HrefValue = "";

			// Description
			$this->Description->LinkCustomAttributes = "";
			$this->Description->HrefValue = "";
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
		if (!$this->MenuID->FldIsDetailKey && !is_null($this->MenuID->FormValue) && $this->MenuID->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->MenuID->FldCaption(), $this->MenuID->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->Price->FormValue)) {
			ew_AddMessage($gsFormError, $this->Price->FldErrMsg());
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

		// MenuID
		$this->MenuID->SetDbValueDef($rsnew, $this->MenuID->CurrentValue, 0, FALSE);

		// Name
		$this->Name->SetDbValueDef($rsnew, $this->Name->CurrentValue, NULL, FALSE);

		// Picture
		if ($this->Picture->Visible && !$this->Picture->Upload->KeepFile) {
			$this->Picture->Upload->DbValue = ""; // No need to delete old file
			if ($this->Picture->Upload->FileName == "") {
				$rsnew['Picture'] = NULL;
			} else {
				$rsnew['Picture'] = $this->Picture->Upload->FileName;
			}
		}

		// Price
		$this->Price->SetDbValueDef($rsnew, $this->Price->CurrentValue, NULL, FALSE);

		// Description
		$this->Description->SetDbValueDef($rsnew, $this->Description->CurrentValue, NULL, FALSE);
		if ($this->Picture->Visible && !$this->Picture->Upload->KeepFile) {
			$OldFiles = ew_Empty($this->Picture->Upload->DbValue) ? array() : array($this->Picture->Upload->DbValue);
			if (!ew_Empty($this->Picture->Upload->FileName)) {
				$NewFiles = array($this->Picture->Upload->FileName);
				$NewFileCount = count($NewFiles);
				for ($i = 0; $i < $NewFileCount; $i++) {
					$fldvar = ($this->Picture->Upload->Index < 0) ? $this->Picture->FldVar : substr($this->Picture->FldVar, 0, 1) . $this->Picture->Upload->Index . substr($this->Picture->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->Picture->TblVar) . $file)) {
							$file1 = ew_UploadFileNameEx($this->Picture->PhysicalUploadPath(), $file); // Get new file name
							if ($file1 <> $file) { // Rename temp file
								while (file_exists(ew_UploadTempPath($fldvar, $this->Picture->TblVar) . $file1) || file_exists($this->Picture->PhysicalUploadPath() . $file1)) // Make sure no file name clash
									$file1 = ew_UniqueFilename($this->Picture->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
								rename(ew_UploadTempPath($fldvar, $this->Picture->TblVar) . $file, ew_UploadTempPath($fldvar, $this->Picture->TblVar) . $file1);
								$NewFiles[$i] = $file1;
							}
						}
					}
				}
				$this->Picture->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
				$this->Picture->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$this->Picture->SetDbValueDef($rsnew, $this->Picture->Upload->FileName, NULL, FALSE);
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if ($this->Picture->Visible && !$this->Picture->Upload->KeepFile) {
					$OldFiles = ew_Empty($this->Picture->Upload->DbValue) ? array() : array($this->Picture->Upload->DbValue);
					if (!ew_Empty($this->Picture->Upload->FileName)) {
						$NewFiles = array($this->Picture->Upload->FileName);
						$NewFiles2 = array($rsnew['Picture']);
						$NewFileCount = count($NewFiles);
						for ($i = 0; $i < $NewFileCount; $i++) {
							$fldvar = ($this->Picture->Upload->Index < 0) ? $this->Picture->FldVar : substr($this->Picture->FldVar, 0, 1) . $this->Picture->Upload->Index . substr($this->Picture->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->Picture->TblVar) . $NewFiles[$i];
								if (file_exists($file)) {
									if (@$NewFiles2[$i] <> "") // Use correct file name
										$NewFiles[$i] = $NewFiles2[$i];
									if (!$this->Picture->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
										$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
										return FALSE;
									}
								}
							}
						}
					} else {
						$NewFiles = array();
					}
				}
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

		// Picture
		ew_CleanUploadTempPath($this->Picture, $this->Picture->Upload->Index);
		return $AddRow;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "menus") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_MenuID"] <> "") {
					$GLOBALS["menus"]->MenuID->setQueryStringValue($_GET["fk_MenuID"]);
					$this->MenuID->setQueryStringValue($GLOBALS["menus"]->MenuID->QueryStringValue);
					$this->MenuID->setSessionValue($this->MenuID->QueryStringValue);
					if (!is_numeric($GLOBALS["menus"]->MenuID->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "menus") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_MenuID"] <> "") {
					$GLOBALS["menus"]->MenuID->setFormValue($_POST["fk_MenuID"]);
					$this->MenuID->setFormValue($GLOBALS["menus"]->MenuID->FormValue);
					$this->MenuID->setSessionValue($this->MenuID->FormValue);
					if (!is_numeric($GLOBALS["menus"]->MenuID->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "menus") {
				if ($this->MenuID->CurrentValue == "") $this->MenuID->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("sub_menuslist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_MenuID":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `MenuID` AS `LinkFld`, `Name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `menus`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`MenuID` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->MenuID, $sWhereWrk); // Call Lookup Selecting
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
if (!isset($sub_menus_add)) $sub_menus_add = new csub_menus_add();

// Page init
$sub_menus_add->Page_Init();

// Page main
$sub_menus_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sub_menus_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fsub_menusadd = new ew_Form("fsub_menusadd", "add");

// Validate form
fsub_menusadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_MenuID");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sub_menus->MenuID->FldCaption(), $sub_menus->MenuID->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($sub_menus->Price->FldErrMsg()) ?>");

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
fsub_menusadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fsub_menusadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fsub_menusadd.Lists["x_MenuID"] = {"LinkField":"x_MenuID","Ajax":true,"AutoFill":false,"DisplayFields":["x_Name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"menus"};
fsub_menusadd.Lists["x_MenuID"].Data = "<?php echo $sub_menus_add->MenuID->LookupFilterQuery(FALSE, "add") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $sub_menus_add->ShowPageHeader(); ?>
<?php
$sub_menus_add->ShowMessage();
?>
<form name="fsub_menusadd" id="fsub_menusadd" class="<?php echo $sub_menus_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($sub_menus_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $sub_menus_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="sub_menus">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($sub_menus_add->IsModal) ?>">
<?php if ($sub_menus->getCurrentMasterTable() == "menus") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="menus">
<input type="hidden" name="fk_MenuID" value="<?php echo $sub_menus->MenuID->getSessionValue() ?>">
<?php } ?>
<div class="ewAddDiv"><!-- page* -->
<?php if ($sub_menus->MenuID->Visible) { // MenuID ?>
	<div id="r_MenuID" class="form-group">
		<label id="elh_sub_menus_MenuID" for="x_MenuID" class="<?php echo $sub_menus_add->LeftColumnClass ?>"><?php echo $sub_menus->MenuID->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $sub_menus_add->RightColumnClass ?>"><div<?php echo $sub_menus->MenuID->CellAttributes() ?>>
<?php if ($sub_menus->MenuID->getSessionValue() <> "") { ?>
<span id="el_sub_menus_MenuID">
<span<?php echo $sub_menus->MenuID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sub_menus->MenuID->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_MenuID" name="x_MenuID" value="<?php echo ew_HtmlEncode($sub_menus->MenuID->CurrentValue) ?>">
<?php } else { ?>
<span id="el_sub_menus_MenuID">
<select data-table="sub_menus" data-field="x_MenuID" data-value-separator="<?php echo $sub_menus->MenuID->DisplayValueSeparatorAttribute() ?>" id="x_MenuID" name="x_MenuID"<?php echo $sub_menus->MenuID->EditAttributes() ?>>
<?php echo $sub_menus->MenuID->SelectOptionListHtml("x_MenuID") ?>
</select>
</span>
<?php } ?>
<?php echo $sub_menus->MenuID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sub_menus->Name->Visible) { // Name ?>
	<div id="r_Name" class="form-group">
		<label id="elh_sub_menus_Name" for="x_Name" class="<?php echo $sub_menus_add->LeftColumnClass ?>"><?php echo $sub_menus->Name->FldCaption() ?></label>
		<div class="<?php echo $sub_menus_add->RightColumnClass ?>"><div<?php echo $sub_menus->Name->CellAttributes() ?>>
<span id="el_sub_menus_Name">
<input type="text" data-table="sub_menus" data-field="x_Name" name="x_Name" id="x_Name" size="30" maxlength="60" placeholder="<?php echo ew_HtmlEncode($sub_menus->Name->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Name->EditValue ?>"<?php echo $sub_menus->Name->EditAttributes() ?>>
</span>
<?php echo $sub_menus->Name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sub_menus->Picture->Visible) { // Picture ?>
	<div id="r_Picture" class="form-group">
		<label id="elh_sub_menus_Picture" class="<?php echo $sub_menus_add->LeftColumnClass ?>"><?php echo $sub_menus->Picture->FldCaption() ?></label>
		<div class="<?php echo $sub_menus_add->RightColumnClass ?>"><div<?php echo $sub_menus->Picture->CellAttributes() ?>>
<span id="el_sub_menus_Picture">
<div id="fd_x_Picture">
<span title="<?php echo $sub_menus->Picture->FldTitle() ? $sub_menus->Picture->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($sub_menus->Picture->ReadOnly || $sub_menus->Picture->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="sub_menus" data-field="x_Picture" name="x_Picture" id="x_Picture"<?php echo $sub_menus->Picture->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_Picture" id= "fn_x_Picture" value="<?php echo $sub_menus->Picture->Upload->FileName ?>">
<input type="hidden" name="fa_x_Picture" id= "fa_x_Picture" value="0">
<input type="hidden" name="fs_x_Picture" id= "fs_x_Picture" value="60">
<input type="hidden" name="fx_x_Picture" id= "fx_x_Picture" value="<?php echo $sub_menus->Picture->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Picture" id= "fm_x_Picture" value="<?php echo $sub_menus->Picture->UploadMaxFileSize ?>">
</div>
<table id="ft_x_Picture" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $sub_menus->Picture->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sub_menus->Price->Visible) { // Price ?>
	<div id="r_Price" class="form-group">
		<label id="elh_sub_menus_Price" for="x_Price" class="<?php echo $sub_menus_add->LeftColumnClass ?>"><?php echo $sub_menus->Price->FldCaption() ?></label>
		<div class="<?php echo $sub_menus_add->RightColumnClass ?>"><div<?php echo $sub_menus->Price->CellAttributes() ?>>
<span id="el_sub_menus_Price">
<input type="text" data-table="sub_menus" data-field="x_Price" name="x_Price" id="x_Price" size="30" placeholder="<?php echo ew_HtmlEncode($sub_menus->Price->getPlaceHolder()) ?>" value="<?php echo $sub_menus->Price->EditValue ?>"<?php echo $sub_menus->Price->EditAttributes() ?>>
</span>
<?php echo $sub_menus->Price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sub_menus->Description->Visible) { // Description ?>
	<div id="r_Description" class="form-group">
		<label id="elh_sub_menus_Description" for="x_Description" class="<?php echo $sub_menus_add->LeftColumnClass ?>"><?php echo $sub_menus->Description->FldCaption() ?></label>
		<div class="<?php echo $sub_menus_add->RightColumnClass ?>"><div<?php echo $sub_menus->Description->CellAttributes() ?>>
<span id="el_sub_menus_Description">
<textarea data-table="sub_menus" data-field="x_Description" name="x_Description" id="x_Description" cols="50" rows="7" placeholder="<?php echo ew_HtmlEncode($sub_menus->Description->getPlaceHolder()) ?>"<?php echo $sub_menus->Description->EditAttributes() ?>><?php echo $sub_menus->Description->EditValue ?></textarea>
</span>
<?php echo $sub_menus->Description->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$sub_menus_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $sub_menus_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $sub_menus_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fsub_menusadd.Init();
</script>
<?php
$sub_menus_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$sub_menus_add->Page_Terminate();
?>
