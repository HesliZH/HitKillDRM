<?php
namespace PHPMaker2019\DRM;

// Session
if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(); // Init session data

// Output buffering
ob_start(); 

// Autoload
include_once "autoload.php";
?>
<?php

// Write header
WriteHeader(FALSE);

// Create page object
$controle_versoes_delete = new controle_versoes_delete();

// Run the page
$controle_versoes_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$controle_versoes_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fcontrole_versoesdelete = currentForm = new ew.Form("fcontrole_versoesdelete", "delete");

// Form_CustomValidate event
fcontrole_versoesdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcontrole_versoesdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcontrole_versoesdelete.lists["x_jogo"] = <?php echo $controle_versoes_delete->jogo->Lookup->toClientList() ?>;
fcontrole_versoesdelete.lists["x_jogo"].options = <?php echo JsonEncode($controle_versoes_delete->jogo->lookupOptions()) ?>;
fcontrole_versoesdelete.lists["x_estagio"] = <?php echo $controle_versoes_delete->estagio->Lookup->toClientList() ?>;
fcontrole_versoesdelete.lists["x_estagio"].options = <?php echo JsonEncode($controle_versoes_delete->estagio->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $controle_versoes_delete->showPageHeader(); ?>
<?php
$controle_versoes_delete->showMessage();
?>
<form name="fcontrole_versoesdelete" id="fcontrole_versoesdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($controle_versoes_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $controle_versoes_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="controle_versoes">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($controle_versoes_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($controle_versoes->codigo->Visible) { // codigo ?>
		<th class="<?php echo $controle_versoes->codigo->headerCellClass() ?>"><span id="elh_controle_versoes_codigo" class="controle_versoes_codigo"><?php echo $controle_versoes->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($controle_versoes->jogo->Visible) { // jogo ?>
		<th class="<?php echo $controle_versoes->jogo->headerCellClass() ?>"><span id="elh_controle_versoes_jogo" class="controle_versoes_jogo"><?php echo $controle_versoes->jogo->caption() ?></span></th>
<?php } ?>
<?php if ($controle_versoes->versao->Visible) { // versao ?>
		<th class="<?php echo $controle_versoes->versao->headerCellClass() ?>"><span id="elh_controle_versoes_versao" class="controle_versoes_versao"><?php echo $controle_versoes->versao->caption() ?></span></th>
<?php } ?>
<?php if ($controle_versoes->repositorio->Visible) { // repositorio ?>
		<th class="<?php echo $controle_versoes->repositorio->headerCellClass() ?>"><span id="elh_controle_versoes_repositorio" class="controle_versoes_repositorio"><?php echo $controle_versoes->repositorio->caption() ?></span></th>
<?php } ?>
<?php if ($controle_versoes->estagio->Visible) { // estagio ?>
		<th class="<?php echo $controle_versoes->estagio->headerCellClass() ?>"><span id="elh_controle_versoes_estagio" class="controle_versoes_estagio"><?php echo $controle_versoes->estagio->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$controle_versoes_delete->RecCnt = 0;
$i = 0;
while (!$controle_versoes_delete->Recordset->EOF) {
	$controle_versoes_delete->RecCnt++;
	$controle_versoes_delete->RowCnt++;

	// Set row properties
	$controle_versoes->resetAttributes();
	$controle_versoes->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$controle_versoes_delete->loadRowValues($controle_versoes_delete->Recordset);

	// Render row
	$controle_versoes_delete->renderRow();
?>
	<tr<?php echo $controle_versoes->rowAttributes() ?>>
<?php if ($controle_versoes->codigo->Visible) { // codigo ?>
		<td<?php echo $controle_versoes->codigo->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_delete->RowCnt ?>_controle_versoes_codigo" class="controle_versoes_codigo">
<span<?php echo $controle_versoes->codigo->viewAttributes() ?>>
<?php echo $controle_versoes->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($controle_versoes->jogo->Visible) { // jogo ?>
		<td<?php echo $controle_versoes->jogo->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_delete->RowCnt ?>_controle_versoes_jogo" class="controle_versoes_jogo">
<span<?php echo $controle_versoes->jogo->viewAttributes() ?>>
<?php echo $controle_versoes->jogo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($controle_versoes->versao->Visible) { // versao ?>
		<td<?php echo $controle_versoes->versao->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_delete->RowCnt ?>_controle_versoes_versao" class="controle_versoes_versao">
<span<?php echo $controle_versoes->versao->viewAttributes() ?>>
<?php echo $controle_versoes->versao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($controle_versoes->repositorio->Visible) { // repositorio ?>
		<td<?php echo $controle_versoes->repositorio->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_delete->RowCnt ?>_controle_versoes_repositorio" class="controle_versoes_repositorio">
<span<?php echo $controle_versoes->repositorio->viewAttributes() ?>>
<?php echo $controle_versoes->repositorio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($controle_versoes->estagio->Visible) { // estagio ?>
		<td<?php echo $controle_versoes->estagio->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_delete->RowCnt ?>_controle_versoes_estagio" class="controle_versoes_estagio">
<span<?php echo $controle_versoes->estagio->viewAttributes() ?>>
<?php echo $controle_versoes->estagio->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$controle_versoes_delete->Recordset->moveNext();
}
$controle_versoes_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $controle_versoes_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$controle_versoes_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$controle_versoes_delete->terminate();
?>