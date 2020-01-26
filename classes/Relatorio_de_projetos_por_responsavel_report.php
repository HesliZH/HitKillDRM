<?php
namespace PHPMaker2019\DRM;

/**
 * Table class for Relatório de projetos por responsável
 */
class Relatorio_de_projetos_por_responsavel extends DbTableBase
{
	protected $SqlGroupSelect = "";
	protected $SqlGroupWhere = "";
	protected $SqlGroupGroupBy = "";
	protected $SqlGroupHaving = "";
	protected $SqlGroupOrderBy = "";
	protected $SqlDetailSelect = "";
	protected $SqlDetailWhere = "";
	protected $SqlDetailGroupBy = "";
	protected $SqlDetailHaving = "";
	protected $SqlDetailOrderBy = "";

	// Export
	public $ExportDoc;

	// Fields
	public $codigo;
	public $nome;
	public $plataforma;
	public $versao;
	public $responsavel;

	// Constructor
	public function __construct()
	{
		global $Language, $CurrentLanguage;

		// Language object
		if (!isset($Language))
			$Language = new Language();
		$this->TableVar = 'Relatorio_de_projetos_por_responsavel';
		$this->TableName = 'Relatório de projetos por responsável';
		$this->TableType = 'REPORT';

		// Update Table
		$this->UpdateTable = "\"jogos\"";
		$this->Dbid = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
		$this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->UserIDAllowSecurity = 0; // User ID Allow

		// codigo
		$this->codigo = new DbField('Relatorio_de_projetos_por_responsavel', 'Relatório de projetos por responsável', 'x_codigo', 'codigo', '"codigo"', 'CAST("codigo" AS varchar(255))', 3, -1, FALSE, '"codigo"', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->codigo->IsAutoIncrement = TRUE; // Autoincrement field
		$this->codigo->IsPrimaryKey = TRUE; // Primary key field
		$this->codigo->Nullable = FALSE; // NOT NULL field
		$this->codigo->Sortable = TRUE; // Allow sort
		$this->codigo->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->codigo->SourceTableVar = 'jogos';
		$this->fields['codigo'] = &$this->codigo;

		// nome
		$this->nome = new DbField('Relatorio_de_projetos_por_responsavel', 'Relatório de projetos por responsável', 'x_nome', 'nome', '"nome"', '"nome"', 200, -1, FALSE, '"nome"', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nome->Sortable = TRUE; // Allow sort
		$this->nome->SourceTableVar = 'jogos';
		$this->fields['nome'] = &$this->nome;

		// plataforma
		$this->plataforma = new DbField('Relatorio_de_projetos_por_responsavel', 'Relatório de projetos por responsável', 'x_plataforma', 'plataforma', '"plataforma"', 'CAST("plataforma" AS varchar(255))', 3, -1, FALSE, '"plataforma"', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->plataforma->Required = TRUE; // Required field
		$this->plataforma->Sortable = TRUE; // Allow sort
		$this->plataforma->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->plataforma->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		switch ($CurrentLanguage) {
			case "en":
				$this->plataforma->Lookup = new Lookup('plataforma', 'plataformas', FALSE, 'codigo', ["descricao","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->plataforma->Lookup = new Lookup('plataforma', 'plataformas', FALSE, 'codigo', ["descricao","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->plataforma->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->plataforma->SourceTableVar = 'jogos';
		$this->fields['plataforma'] = &$this->plataforma;

		// versao
		$this->versao = new DbField('Relatorio_de_projetos_por_responsavel', 'Relatório de projetos por responsável', 'x_versao', 'versao', '"versao"', '"versao"', 200, -1, FALSE, '"versao"', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->versao->Sortable = TRUE; // Allow sort
		$this->versao->SourceTableVar = 'jogos';
		$this->fields['versao'] = &$this->versao;

		// responsavel
		$this->responsavel = new DbField('Relatorio_de_projetos_por_responsavel', 'Relatório de projetos por responsável', 'x_responsavel', 'responsavel', '"responsavel"', 'CAST("responsavel" AS varchar(255))', 3, -1, FALSE, '"responsavel"', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->responsavel->Sortable = TRUE; // Allow sort
		$this->responsavel->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->responsavel->PleaseSelectText = $Language->phrase("PleaseSelect"); // PleaseSelect text
		switch ($CurrentLanguage) {
			case "en":
				$this->responsavel->Lookup = new Lookup('responsavel', 'usuarios', FALSE, 'codigo', ["nome_completo","","",""], [], [], [], [], [], [], '', '');
				break;
			default:
				$this->responsavel->Lookup = new Lookup('responsavel', 'usuarios', FALSE, 'codigo', ["nome_completo","","",""], [], [], [], [], [], [], '', '');
				break;
		}
		$this->responsavel->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
		$this->responsavel->SourceTableVar = 'jogos';
		$this->fields['responsavel'] = &$this->responsavel;
	}

	// Field Visibility
	public function getFieldVisibility($fldParm)
	{
		global $Security;
		return $this->$fldParm->Visible; // Returns original value
	}

	// Report group level SQL
	public function getSqlGroupSelect() // Select
	{
		return ($this->SqlGroupSelect <> "") ? $this->SqlGroupSelect : "SELECT DISTINCT \"responsavel\" FROM \"jogos\"";
	}
	public function sqlGroupSelect() // For backward compatibility
	{
		return $this->getSqlGroupSelect();
	}
	public function setSqlGroupSelect($v)
	{
		$this->SqlGroupSelect = $v;
	}
	public function getSqlGroupWhere() // Where
	{
		return ($this->SqlGroupWhere <> "") ? $this->SqlGroupWhere : "";
	}
	public function sqlGroupWhere() // For backward compatibility
	{
		return $this->getSqlGroupWhere();
	}
	public function setSqlGroupWhere($v)
	{
		$this->SqlGroupWhere = $v;
	}
	public function getSqlGroupGroupBy() // Group By
	{
		return ($this->SqlGroupGroupBy <> "") ? $this->SqlGroupGroupBy : "";
	}
	public function sqlGroupGroupBy() // For backward compatibility
	{
		return $this->getSqlGroupGroupBy();
	}
	public function setSqlGroupGroupBy($v)
	{
		$this->SqlGroupGroupBy = $v;
	}
	public function getSqlGroupHaving() // Having
	{
		return ($this->SqlGroupHaving <> "") ? $this->SqlGroupHaving : "";
	}
	public function sqlGroupHaving() // For backward compatibility
	{
		return $this->getSqlGroupHaving();
	}
	public function setSqlGroupHaving($v)
	{
		$this->SqlGroupHaving = $v;
	}
	public function getSqlGroupOrderBy() // Order By
	{
		return ($this->SqlGroupOrderBy <> "") ? $this->SqlGroupOrderBy : "\"responsavel\" ASC";
	}
	public function sqlGroupOrderBy() // For backward compatibility
	{
		return $this->getSqlGroupOrderBy();
	}
	public function setSqlGroupOrderBy($v)
	{
		$this->SqlGroupOrderBy = $v;
	}

	// Report detail level SQL
	public function getSqlDetailSelect() // Select
	{
		return ($this->SqlDetailSelect <> "") ? $this->SqlDetailSelect : "SELECT * FROM \"jogos\"";
	}
	public function sqlDetailSelect() // For backward compatibility
	{
		return $this->getSqlDetailSelect();
	}
	public function setSqlDetailSelect($v)
	{
		$this->SqlDetailSelect = $v;
	}
	public function getSqlDetailWhere() // Where
	{
		return ($this->SqlDetailWhere <> "") ? $this->SqlDetailWhere : "";
	}
	public function sqlDetailWhere() // For backward compatibility
	{
		return $this->getSqlDetailWhere();
	}
	public function setSqlDetailWhere($v)
	{
		$this->SqlDetailWhere = $v;
	}
	public function getSqlDetailGroupBy() // Group By
	{
		return ($this->SqlDetailGroupBy <> "") ? $this->SqlDetailGroupBy : "";
	}
	public function sqlDetailGroupBy() // For backward compatibility
	{
		return $this->getSqlDetailGroupBy();
	}
	public function setSqlDetailGroupBy($v)
	{
		$this->SqlDetailGroupBy = $v;
	}
	public function getSqlDetailHaving() // Having
	{
		return ($this->SqlDetailHaving <> "") ? $this->SqlDetailHaving : "";
	}
	public function sqlDetailHaving() // For backward compatibility
	{
		return $this->getSqlDetailHaving();
	}
	public function setSqlDetailHaving($v)
	{
		$this->SqlDetailHaving = $v;
	}
	public function getSqlDetailOrderBy() // Order By
	{
		return ($this->SqlDetailOrderBy <> "") ? $this->SqlDetailOrderBy : "";
	}
	public function sqlDetailOrderBy() // For backward compatibility
	{
		return $this->getSqlDetailOrderBy();
	}
	public function setSqlDetailOrderBy($v)
	{
		$this->SqlDetailOrderBy = $v;
	}

	// Apply User ID filters
	public function applyUserIDFilters($filter)
	{
		return $filter;
	}

	// Check if User ID security allows view all
	public function userIDAllow($id = "")
	{
		$allow = USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Report group SQL
	public function getGroupSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = "";
		return BuildSelectSql($this->getSqlGroupSelect(), $this->getSqlGroupWhere(),
			 $this->getSqlGroupGroupBy(), $this->getSqlGroupHaving(),
			 $this->getSqlGroupOrderBy(), $filter, $sort);
	}

	// Report detail SQL
	public function getDetailSql()
	{
		$filter = $this->CurrentFilter;
		$filter = $this->applyUserIDFilters($filter);
		$sort = "";
		return BuildSelectSql($this->getSqlDetailSelect(), $this->getSqlDetailWhere(),
			$this->getSqlDetailGroupBy(), $this->getSqlDetailHaving(),
			$this->getSqlDetailOrderBy(), $filter, $sort);
	}

	// Return page URL
	public function getReturnUrl()
	{
		$name = PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ServerVar("HTTP_REFERER") <> "" && ReferPageName() <> CurrentPageName() && ReferPageName() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "Relatorio_de_projetos_por_responsavelreport.php";
		}
	}
	public function setReturnUrl($v)
	{
		$_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	public function getModalCaption($pageName)
	{
		global $Language;
		if ($pageName == "")
			return $Language->phrase("View");
		elseif ($pageName == "")
			return $Language->phrase("Edit");
		elseif ($pageName == "")
			return $Language->phrase("Add");
		else
			return "";
	}

	// List URL
	public function getListUrl()
	{
		return "Relatorio_de_projetos_por_responsavelreport.php";
	}

	// View URL
	public function getViewUrl($parm = "")
	{
		if ($parm <> "")
			$url = $this->keyUrl("", $this->getUrlParm($parm));
		else
			$url = $this->keyUrl("", $this->getUrlParm(TABLE_SHOW_DETAIL . "="));
		return $this->addMasterUrl($url);
	}

	// Add URL
	public function getAddUrl($parm = "")
	{
		if ($parm <> "")
			$url = "?" . $this->getUrlParm($parm);
		else
			$url = "";
		return $this->addMasterUrl($url);
	}

	// Edit URL
	public function getEditUrl($parm = "")
	{
		$url = $this->keyUrl("", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline edit URL
	public function getInlineEditUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
		return $this->addMasterUrl($url);
	}

	// Copy URL
	public function getCopyUrl($parm = "")
	{
		$url = $this->keyUrl("", $this->getUrlParm($parm));
		return $this->addMasterUrl($url);
	}

	// Inline copy URL
	public function getInlineCopyUrl()
	{
		$url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
		return $this->addMasterUrl($url);
	}

	// Delete URL
	public function getDeleteUrl()
	{
		return $this->keyUrl("", $this->getUrlParm());
	}

	// Add master url
	public function addMasterUrl($url)
	{
		return $url;
	}
	public function keyToJson($htmlEncode = FALSE)
	{
		$json = "";
		$json .= "codigo:" . JsonEncode($this->codigo->CurrentValue, "number");
		$json = "{" . $json . "}";
		if ($htmlEncode)
			$json = HtmlEncode($json);
		return $json;
	}

	// Add key value to URL
	public function keyUrl($url, $parm = "")
	{
		$url = $url . "?";
		if ($parm <> "")
			$url .= $parm . "&";
		if ($this->codigo->CurrentValue != NULL) {
			$url .= "codigo=" . urlencode($this->codigo->CurrentValue);
		} else {
			return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
		}
		return $url;
	}

	// Sort URL
	public function sortUrl(&$fld)
	{
		if ($this->CurrentAction || $this->isExport() ||
			in_array($fld->Type, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->reverseSort());
			return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
		} else {
			return "";
		}
	}

	// Get record keys from Post/Get/Session
	public function getRecordKeys()
	{
		global $COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (Param("key_m") !== NULL) {
			$arKeys = Param("key_m");
			$cnt = count($arKeys);
		} else {
			if (Param("codigo") !== NULL)
				$arKeys[] = Param("codigo");
			elseif (IsApi() && Key(0) !== NULL)
				$arKeys[] = Key(0);
			elseif (IsApi() && Route(2) !== NULL)
				$arKeys[] = Route(2);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get filter from record keys
	public function getFilterFromRecordKeys()
	{
		$arKeys = $this->getRecordKeys();
		$keyFilter = "";
		foreach ($arKeys as $key) {
			if ($keyFilter <> "") $keyFilter .= " OR ";
			$this->codigo->CurrentValue = $key;
			$keyFilter .= "(" . $this->getRecordFilter() . ")";
		}
		return $keyFilter;
	}

	// Load rows based on filter
	public function &loadRs($filter)
	{

		// Set up filter (WHERE Clause)
		$sql = $this->getSql($filter);
		$conn = &$this->getConnection();
		$rs = $conn->execute($sql);
		return $rs;
	}

	// Get file data
	public function getFileData($fldparm, $key, $resize, $width = THUMBNAIL_DEFAULT_WIDTH, $height = THUMBNAIL_DEFAULT_HEIGHT)
	{

		// No binary fields
		return FALSE;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>);

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
<?php
namespace PHPMaker2019\DRM;

/**
 * Page class
 */
class Relatorio_de_projetos_por_responsavel_report extends Relatorio_de_projetos_por_responsavel
{

	// Page ID
	public $PageID = "report";

	// Project ID
	public $ProjectID = "{D25E8543-1442-438F-944C-0B1439EAA2B1}";

	// Table name
	public $TableName = 'Relatório de projetos por responsável';

	// Page object name
	public $PageObjName = "Relatorio_de_projetos_por_responsavel_report";

	// Page URLs
	public $AddUrl;
	public $EditUrl;
	public $CopyUrl;
	public $DeleteUrl;
	public $ViewUrl;
	public $ListUrl;
	public $CancelUrl;

	// Export URLs
	public $ExportPrintUrl;
	public $ExportHtmlUrl;
	public $ExportExcelUrl;
	public $ExportWordUrl;
	public $ExportXmlUrl;
	public $ExportCsvUrl;
	public $ExportPdfUrl;

	// Custom export
	public $ExportExcelCustom = FALSE;
	public $ExportWordCustom = FALSE;
	public $ExportPdfCustom = FALSE;
	public $ExportEmailCustom = FALSE;

	// Update URLs
	public $InlineAddUrl;
	public $InlineCopyUrl;
	public $InlineEditUrl;
	public $GridAddUrl;
	public $GridEditUrl;
	public $MultiDeleteUrl;
	public $MultiUpdateUrl;

	// Page headings
	public $Heading = "";
	public $Subheading = "";
	public $PageHeader;
	public $PageFooter;

	// Token
	public $Token = "";
	public $TokenTimeout = 0;
	public $CheckToken = CHECK_TOKEN;

	// Messages
	private $_message = "";
	private $_failureMessage = "";
	private $_successMessage = "";
	private $_warningMessage = "";

	// Page URL
	private $_pageUrl = "";

	// Page heading
	public function pageHeading()
	{
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "tableCaption"))
			return $this->tableCaption();
		return "";
	}

	// Page subheading
	public function pageSubheading()
	{
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		return "";
	}

	// Page name
	public function pageName()
	{
		return CurrentPageName();
	}

	// Page URL
	public function pageUrl()
	{
		if ($this->_pageUrl == "") {
			$this->_pageUrl = CurrentPageName() . "?";
		}
		return $this->_pageUrl;
	}

	// Get message
	public function getMessage()
	{
		return isset($_SESSION[SESSION_MESSAGE]) ? $_SESSION[SESSION_MESSAGE] : $this->_message;
	}

	// Set message
	public function setMessage($v)
	{
		AddMessage($this->_message, $v);
		$_SESSION[SESSION_MESSAGE] = $this->_message;
	}

	// Get failure message
	public function getFailureMessage()
	{
		return isset($_SESSION[SESSION_FAILURE_MESSAGE]) ? $_SESSION[SESSION_FAILURE_MESSAGE] : $this->_failureMessage;
	}

	// Set failure message
	public function setFailureMessage($v)
	{
		AddMessage($this->_failureMessage, $v);
		$_SESSION[SESSION_FAILURE_MESSAGE] = $this->_failureMessage;
	}

	// Get success message
	public function getSuccessMessage()
	{
		return isset($_SESSION[SESSION_SUCCESS_MESSAGE]) ? $_SESSION[SESSION_SUCCESS_MESSAGE] : $this->_successMessage;
	}

	// Set success message
	public function setSuccessMessage($v)
	{
		AddMessage($this->_successMessage, $v);
		$_SESSION[SESSION_SUCCESS_MESSAGE] = $this->_successMessage;
	}

	// Get warning message
	public function getWarningMessage()
	{
		return isset($_SESSION[SESSION_WARNING_MESSAGE]) ? $_SESSION[SESSION_WARNING_MESSAGE] : $this->_warningMessage;
	}

	// Set warning message
	public function setWarningMessage($v)
	{
		AddMessage($this->_warningMessage, $v);
		$_SESSION[SESSION_WARNING_MESSAGE] = $this->_warningMessage;
	}

	// Clear message
	public function clearMessage()
	{
		$this->_message = "";
		$_SESSION[SESSION_MESSAGE] = "";
	}

	// Clear failure message
	public function clearFailureMessage()
	{
		$this->_failureMessage = "";
		$_SESSION[SESSION_FAILURE_MESSAGE] = "";
	}

	// Clear success message
	public function clearSuccessMessage()
	{
		$this->_successMessage = "";
		$_SESSION[SESSION_SUCCESS_MESSAGE] = "";
	}

	// Clear warning message
	public function clearWarningMessage()
	{
		$this->_warningMessage = "";
		$_SESSION[SESSION_WARNING_MESSAGE] = "";
	}

	// Clear messages
	public function clearMessages()
	{
		$this->clearMessage();
		$this->clearFailureMessage();
		$this->clearSuccessMessage();
		$this->clearWarningMessage();
	}

	// Show message
	public function showMessage()
	{
		$hidden = FALSE;
		$html = "";

		// Message
		$message = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($message, "");
		if ($message <> "") { // Message in Session, display
			if (!$hidden)
				$message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $message;
			$html .= '<div class="alert alert-info alert-dismissible ew-info"><i class="icon fa fa-info"></i>' . $message . '</div>';
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($warningMessage, "warning");
		if ($warningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$warningMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $warningMessage;
			$html .= '<div class="alert alert-warning alert-dismissible ew-warning"><i class="icon fa fa-warning"></i>' . $warningMessage . '</div>';
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($successMessage, "success");
		if ($successMessage <> "") { // Message in Session, display
			if (!$hidden)
				$successMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $successMessage;
			$html .= '<div class="alert alert-success alert-dismissible ew-success"><i class="icon fa fa-check"></i>' . $successMessage . '</div>';
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$errorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($errorMessage, "failure");
		if ($errorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$errorMessage = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $errorMessage;
			$html .= '<div class="alert alert-danger alert-dismissible ew-error"><i class="icon fa fa-ban"></i>' . $errorMessage . '</div>';
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo '<div class="ew-message-dialog' . (($hidden) ? ' d-none' : "") . '">' . $html . '</div>';
	}

	// Get message as array
	public function getMessages()
	{
		$ar = array();

		// Message
		$message = $this->getMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($message, "");

		if ($message <> "") { // Message in Session, display
			$ar["message"] = $message;
			$_SESSION[SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$warningMessage = $this->getWarningMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($warningMessage, "warning");

		if ($warningMessage <> "") { // Message in Session, display
			$ar["warningMessage"] = $warningMessage;
			$_SESSION[SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$successMessage = $this->getSuccessMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($successMessage, "success");

		if ($successMessage <> "") { // Message in Session, display
			$ar["successMessage"] = $successMessage;
			$_SESSION[SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$failureMessage = $this->getFailureMessage();

		//if (method_exists($this, "Message_Showing"))
		//	$this->Message_Showing($failureMessage, "failure");

		if ($failureMessage <> "") { // Message in Session, display
			$ar["failureMessage"] = $failureMessage;
			$_SESSION[SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		return $ar;
	}

	// Show Page Header
	public function showPageHeader()
	{
		$header = $this->PageHeader;
		$this->Page_DataRendering($header);
		if ($header <> "") { // Header exists, display
			echo '<p id="ew-page-header">' . $header . '</p>';
		}
	}

	// Show Page Footer
	public function showPageFooter()
	{
		$footer = $this->PageFooter;
		$this->Page_DataRendered($footer);
		if ($footer <> "") { // Footer exists, display
			echo '<p id="ew-page-footer">' . $footer . '</p>';
		}
	}

	// Validate page request
	protected function isPageRequest()
	{
		return TRUE;
	}

	// Valid Post
	protected function validPost()
	{
		if (!$this->CheckToken || !IsPost() || IsApi())
			return TRUE;
		if (Post(TOKEN_NAME) === NULL)
			return FALSE;
		$fn = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
		if (is_callable($fn))
			return $fn(Post(TOKEN_NAME), $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	public function createToken()
	{
		global $CurrentToken;
		$fn = PROJECT_NAMESPACE . CREATE_TOKEN_FUNC; // Always create token, required by API file/lookup request
		if ($this->Token == "" && is_callable($fn)) // Create token
			$this->Token = $fn();
		$CurrentToken = $this->Token; // Save to global variable
	}

	// Constructor
	public function __construct()
	{
		global $Language, $COMPOSITE_KEY_SEPARATOR;
		global $UserTable, $UserTableConn;

		// Initialize
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = SessionTimeoutTime();

		// Language object
		if (!isset($Language))
			$Language = new Language();

		// Parent constuctor
		parent::__construct();

		// Table object (Relatorio_de_projetos_por_responsavel)
		if (!isset($GLOBALS["Relatorio_de_projetos_por_responsavel"]) || get_class($GLOBALS["Relatorio_de_projetos_por_responsavel"]) == PROJECT_NAMESPACE . "Relatorio_de_projetos_por_responsavel") {
			$GLOBALS["Relatorio_de_projetos_por_responsavel"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["Relatorio_de_projetos_por_responsavel"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->pageUrl() . "export=print";
		$this->ExportExcelUrl = $this->pageUrl() . "export=excel";
		$this->ExportWordUrl = $this->pageUrl() . "export=word";
		$this->CancelUrl = $this->pageUrl() . "action=cancel";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios']))
			$GLOBALS['usuarios'] = new usuarios();

		// Page ID
		if (!defined(PROJECT_NAMESPACE . "PAGE_ID"))
			define(PROJECT_NAMESPACE . "PAGE_ID", 'report');

		// Table name (for backward compatibility)
		if (!defined(PROJECT_NAMESPACE . "TABLE_NAME"))
			define(PROJECT_NAMESPACE . "TABLE_NAME", 'Relatório de projetos por responsável');

		// Start timer
		if (!isset($GLOBALS["DebugTimer"]))
			$GLOBALS["DebugTimer"] = new Timer();

		// Debug message
		LoadDebugMessage();

		// Open connection
		if (!isset($GLOBALS["Conn"]))
			$GLOBALS["Conn"] = &$this->getConnection();

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new usuarios();
			$UserTableConn = Conn($UserTable->Dbid);
		}

		// Export options
		$this->ExportOptions = new ListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ew-export-option";
	}

	// Terminate page
	public function terminate($url = "")
	{
		global $ExportFileName, $TempImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EXPORT_REPORT;
		if ($this->isExport() && array_key_exists($this->Export, $EXPORT_REPORT)) {
			$content = ob_get_clean(); // ob_get_contents() and ob_end_clean()
			$fn = $EXPORT_REPORT[$this->Export];
			$this->$fn($content);
		}
		if (!IsApi())
			$this->Page_Redirecting($url);

		// Close connection
		CloseConnections();

		// Return for API
		if (IsApi()) {
			$res = $url === TRUE;
			if (!$res) // Show error
				WriteJson(array_merge(["success" => FALSE], $this->getMessages()));
			return;
		}

		// Go to URL if specified
		if ($url <> "") {
			if (!DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			SaveDebugMessage();
			AddHeader("Location", $url);
		}
		exit();
	}
	public $ExportOptions; // Export options
	public $RecCnt = 0;
	public $RowCnt = 0; // For custom view tag
	public $ReportSql = "";
	public $ReportFilter = "";
	public $DefaultFilter = "";
	public $DbMasterFilter = "";
	public $DbDetailFilter = "";
	public $MasterRecordExists;
	public $Command;
	public $DtlRecordCount;
	public $ReportGroups;
	public $ReportCounts;
	public $LevelBreak;
	public $ReportTotals;
	public $ReportMaxs;
	public $ReportMins;
	public $DetailRecordset;
	public $RecordExists;

	//
	// Page run
	//

	public function run()
	{
		global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $RequestSecurity, $CurrentForm;

		// Init Session data for API request if token found
		if (IsApi() && session_status() !== PHP_SESSION_ACTIVE) {
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Param(TOKEN_NAME) !== NULL && $func(Param(TOKEN_NAME), SessionTimeoutTime()))
				session_start();
		}

		// User profile
		$UserProfile = new UserProfile();

		// Security
		$Security = new AdvancedSecurity();
		$validRequest = FALSE;

		// Check security for API request
		If (IsApi()) {

			// Check token first
			$func = PROJECT_NAMESPACE . CHECK_TOKEN_FUNC;
			if (is_callable($func) && Post(TOKEN_NAME) !== NULL)
				$validRequest = $func(Post(TOKEN_NAME), SessionTimeoutTime());
			elseif (is_array($RequestSecurity) && @$RequestSecurity["username"] <> "") // Login user for API request
				$Security->loginUser(@$RequestSecurity["username"], @$RequestSecurity["userid"], @$RequestSecurity["parentuserid"], @$RequestSecurity["userlevelid"]);
		}
		if (!$validRequest) {
			if (!$Security->isLoggedIn())
				$Security->autoLogin();
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loading();
			$Security->loadCurrentUserLevel($this->ProjectID . $this->TableName);
			if ($Security->isLoggedIn())
				$Security->TablePermission_Loaded();
			if (!$Security->canReport()) {
				$Security->saveLastUrl();
				$this->setFailureMessage(DeniedMessage()); // Set no permission
				$this->terminate(GetUrl("index.php"));
				return;
			}
		}

		// Get export parameters
		$custom = "";
		if (Param("export") !== NULL) {
			$this->Export = Param("export");
			$custom = Param("custom", "");
		}
		$ExportFileName = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->isExport() && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$CustomExportType = $this->CustomExport;
		$ExportType = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined(PROJECT_NAMESPACE . "USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined(PROJECT_NAMESPACE . "USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = Param("action"); // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->validPost()) {
			Write($Language->phrase("InvalidPostRequest"));
			$this->terminate();
		}

		// Create Token
		$this->createToken();
		$this->ReportGroups = &InitArray(2, NULL);
		$this->ReportCounts = &InitArray(2, 0);
		$this->LevelBreak = &InitArray(2, FALSE);
		$this->ReportTotals = &Init2DArray(2, 3, 0);
		$this->ReportMaxs = &Init2DArray(2, 3, 0);
		$this->ReportMins = &Init2DArray(2, 3, 0);

		// Set up Breadcrumb
		$this->setupBreadcrumb();
	}

	// Check level break
	public function checkLevelBreak()
	{
		$this->LevelBreak[1] = FALSE;
		if ($this->RecCnt == 0) { // Start Or End of Recordset
			$this->LevelBreak[1] = TRUE;
		} else {
			if (!CompareValue($this->responsavel->CurrentValue, $this->ReportGroups[0])) {
				$this->LevelBreak[1] = TRUE;
			}
		}
	}

	// Render row values based on field settings
	public function renderRow()
	{
		global $Security, $Language, $CurrentLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// codigo
		// nome
		// plataforma
		// versao
		// responsavel

		if ($this->RowType == ROWTYPE_VIEW) { // View row

			// codigo
			$this->codigo->ViewValue = $this->codigo->CurrentValue;
			$this->codigo->ViewCustomAttributes = "";

			// nome
			$this->nome->ViewValue = $this->nome->CurrentValue;
			$this->nome->ViewCustomAttributes = "";

			// plataforma
			$curVal = strval($this->plataforma->CurrentValue);
			if ($curVal <> "") {
				$this->plataforma->ViewValue = $this->plataforma->lookupCacheOption($curVal);
				if ($this->plataforma->ViewValue === NULL) { // Lookup from database
					$filterWrk = "\"codigo\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->plataforma->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->plataforma->ViewValue = $this->plataforma->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->plataforma->ViewValue = $this->plataforma->CurrentValue;
					}
				}
			} else {
				$this->plataforma->ViewValue = NULL;
			}
			$this->plataforma->ViewCustomAttributes = "";

			// versao
			$this->versao->ViewValue = $this->versao->CurrentValue;
			$this->versao->ViewCustomAttributes = "";

			// responsavel
			$curVal = strval($this->responsavel->CurrentValue);
			if ($curVal <> "") {
				$this->responsavel->ViewValue = $this->responsavel->lookupCacheOption($curVal);
				if ($this->responsavel->ViewValue === NULL) { // Lookup from database
					$filterWrk = "\"codigo\"" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
					$sqlWrk = $this->responsavel->Lookup->getSql(FALSE, $filterWrk, '', $this);
					$rswrk = Conn()->execute($sqlWrk);
					if ($rswrk && !$rswrk->EOF) { // Lookup values found
						$arwrk = array();
						$arwrk[1] = $rswrk->fields('df');
						$this->responsavel->ViewValue = $this->responsavel->displayValue($arwrk);
						$rswrk->Close();
					} else {
						$this->responsavel->ViewValue = $this->responsavel->CurrentValue;
					}
				}
			} else {
				$this->responsavel->ViewValue = NULL;
			}
			$this->responsavel->ViewCustomAttributes = "";

			// nome
			$this->nome->LinkCustomAttributes = "";
			$this->nome->HrefValue = "";
			$this->nome->TooltipValue = "";

			// plataforma
			$this->plataforma->LinkCustomAttributes = "";
			$this->plataforma->HrefValue = "";
			$this->plataforma->TooltipValue = "";

			// responsavel
			$this->responsavel->LinkCustomAttributes = "";
			$this->responsavel->HrefValue = "";
			$this->responsavel->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	protected function setupBreadcrumb()
	{
		global $Breadcrumb, $Language;
		$Breadcrumb = new Breadcrumb();
		$url = substr(CurrentUrl(), strrpos(CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->add("report", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup options
	public function setupLookupOptions($fld)
	{
		if ($fld->Lookup !== NULL && $fld->Lookup->Options === NULL) {

			// No need to check any more
			$fld->Lookup->Options = [];

			// Set up lookup SQL
			switch ($fld->FieldVar) {
				default:
					$lookupFilter = "";
					break;
			}

			// Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
			$sql = $fld->Lookup->getSql(FALSE, "", $lookupFilter, $this);

			// Set up lookup cache
			if ($fld->UseLookupCache && $sql <> "" && count($fld->Lookup->ParentFields) == 0 && count($fld->Lookup->Options) == 0) {
				$conn = &$this->getConnection();
				$totalCnt = $this->getRecordCount($sql);
				if ($totalCnt > $fld->LookupCacheCount) // Total count > cache count, do not cache
					return;
				$rs = $conn->execute($sql);
				$ar = [];
				while ($rs && !$rs->EOF) {
					$row = &$rs->fields;

					// Format the field values
					switch ($fld->FieldVar) {
						case "x_plataforma":
							break;
						case "x_responsavel":
							break;
					}
					$ar[strval($row[0])] = $row;
					$rs->moveNext();
				}
				if ($rs)
					$rs->close();
				$fld->Lookup->Options = $ar;
			}
		}
	}

	// Export to Word
	public function exportReportWord($html)
	{
		global $ExportFileName;
		$doc = new \DOMDocument();
		$html = preg_replace('/<meta\b(?:[^"\'>]|"[^"]*"|\'[^\']*\')*>/i', "", $html); // Remove meta tags
		@$doc->loadHTML('<?xml encoding="uft-8">' . ConvertToUtf8($html)); // Convert to utf-8
		$tables = $doc->getElementsByTagName("table");
		$phpword = new \PhpOffice\PhpWord\PhpWord();
		$section = $phpword->createSection(array("orientation" => $this->ExportWordPageOrientation));
		$cellwidth = $this->ExportWordColumnWidth;
		foreach ($tables as $table) {
			if ($table->getAttribute("class") == "ew-report-table") {
				$styleTable = array("borderSize" => 0, "borderColor" => "FFFFFF", "cellMargin" => 10); // Customize table cell styles here
				$phpword->addTableStyle("ewPHPWord", $styleTable);
				$tbl = $section->addTable("ewPHPWord");
				$rows = $table->getElementsByTagName("tr");
				$rowcnt = $rows->length;
				for ($i = 0; $i < $rowcnt; $i++) {
					$row = $rows->item($i);
					if (!($row->parentNode->tagName == "table" && $row->parentNode->getAttribute("class") == "ew-table-header-btn")) {
						$cells = $row->childNodes;
						$cellcnt = $cells->length;
						$tbl->addRow(0);
						for ($j = 0; $j < $cellcnt; $j++) {
							$cell = $cells->item($j);
							if ($cell->nodeType <> XML_ELEMENT_NODE || $cell->tagName <> "td")
								continue;
							$k = 1;
							if ($cell->hasAttribute("colspan"))
								$k = (int)$cell->getAttribute("colspan");
							$images = $cell->getElementsByTagName("img");
							if ($images->length > 0) { // Images
								foreach ($images as $image) {
									$fn = $image->getAttribute("src");
									$path = parse_url($fn, PHP_URL_PATH);
									$ext = pathinfo($path, PATHINFO_EXTENSION);
									if (SameText($ext, "php")) { // Image by script
										$fn = FullUrl($fn);
										$data = file_get_contents($fn);
										$fn = TempImage($data);
									}
									if (!file_exists($fn) || is_dir($fn))
										continue;
									$size = @getimagesize($fn);
									$style = array();
									$maxImageWidth = ExportWord2::$MaxImageWidth;
									if ($maxImageWidth > 0 && @$size[0] > $maxImageWidth) {
										$style["width"] = $maxImageWidth;
										$style["height"] = $maxImageWidth / $size[0] * $size[1];
									}
									$tbl->addCell($cellwidth)->addImage($fn, $style);
								}
							} else { // Text
								$text = htmlspecialchars(trim($cell->textContent), ENT_NOQUOTES);
								if ($row->parentNode->tagName == "thead") { // Caption
									$tbl->addCell($cellwidth, array("gridSpan" => $k, "bgColor" => "E4E4E4"))->addText($text, array("bold" => TRUE)); // Customize table header cell styles here
								} else {
									$tbl->addCell($cellwidth, array("gridSpan" => $k))->addText($text);
								}
							}
						}
					}
				}
			}
		}
		if (!DEBUG_ENABLED && ob_get_length())
			ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
		header('Content-Disposition: attachment; filename=' . $ExportFileName . '.docx');
		header('Cache-Control: max-age=0');
		header('Set-Cookie: fileDownload=true; path=/');
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpword, 'Word2007');
		@$objWriter->save('php://output');
		DeleteTempImages();
		exit();
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
}
?>