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
$jogos_delete = new jogos_delete();

// Run the page
$jogos_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$jogos_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fjogosdelete = currentForm = new ew.Form("fjogosdelete", "delete");

// Form_CustomValidate event
fjogosdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fjogosdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fjogosdelete.lists["x_plataforma"] = <?php echo $jogos_delete->plataforma->Lookup->toClientList() ?>;
fjogosdelete.lists["x_plataforma"].options = <?php echo JsonEncode($jogos_delete->plataforma->lookupOptions()) ?>;
fjogosdelete.lists["x_responsavel"] = <?php echo $jogos_delete->responsavel->Lookup->toClientList() ?>;
fjogosdelete.lists["x_responsavel"].options = <?php echo JsonEncode($jogos_delete->responsavel->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $jogos_delete->showPageHeader(); ?>
<?php
$jogos_delete->showMessage();
?>
<form name="fjogosdelete" id="fjogosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($jogos_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $jogos_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="jogos">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($jogos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($jogos->codigo->Visible) { // codigo ?>
		<th class="<?php echo $jogos->codigo->headerCellClass() ?>"><span id="elh_jogos_codigo" class="jogos_codigo"><?php echo $jogos->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($jogos->nome->Visible) { // nome ?>
		<th class="<?php echo $jogos->nome->headerCellClass() ?>"><span id="elh_jogos_nome" class="jogos_nome"><?php echo $jogos->nome->caption() ?></span></th>
<?php } ?>
<?php if ($jogos->plataforma->Visible) { // plataforma ?>
		<th class="<?php echo $jogos->plataforma->headerCellClass() ?>"><span id="elh_jogos_plataforma" class="jogos_plataforma"><?php echo $jogos->plataforma->caption() ?></span></th>
<?php } ?>
<?php if ($jogos->versao->Visible) { // versao ?>
		<th class="<?php echo $jogos->versao->headerCellClass() ?>"><span id="elh_jogos_versao" class="jogos_versao"><?php echo $jogos->versao->caption() ?></span></th>
<?php } ?>
<?php if ($jogos->responsavel->Visible) { // responsavel ?>
		<th class="<?php echo $jogos->responsavel->headerCellClass() ?>"><span id="elh_jogos_responsavel" class="jogos_responsavel"><?php echo $jogos->responsavel->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$jogos_delete->RecCnt = 0;
$i = 0;
while (!$jogos_delete->Recordset->EOF) {
	$jogos_delete->RecCnt++;
	$jogos_delete->RowCnt++;

	// Set row properties
	$jogos->resetAttributes();
	$jogos->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$jogos_delete->loadRowValues($jogos_delete->Recordset);

	// Render row
	$jogos_delete->renderRow();
?>
	<tr<?php echo $jogos->rowAttributes() ?>>
<?php if ($jogos->codigo->Visible) { // codigo ?>
		<td<?php echo $jogos->codigo->cellAttributes() ?>>
<span id="el<?php echo $jogos_delete->RowCnt ?>_jogos_codigo" class="jogos_codigo">
<span<?php echo $jogos->codigo->viewAttributes() ?>>
<?php echo $jogos->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($jogos->nome->Visible) { // nome ?>
		<td<?php echo $jogos->nome->cellAttributes() ?>>
<span id="el<?php echo $jogos_delete->RowCnt ?>_jogos_nome" class="jogos_nome">
<span<?php echo $jogos->nome->viewAttributes() ?>>
<?php echo $jogos->nome->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($jogos->plataforma->Visible) { // plataforma ?>
		<td<?php echo $jogos->plataforma->cellAttributes() ?>>
<span id="el<?php echo $jogos_delete->RowCnt ?>_jogos_plataforma" class="jogos_plataforma">
<span<?php echo $jogos->plataforma->viewAttributes() ?>>
<?php echo $jogos->plataforma->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($jogos->versao->Visible) { // versao ?>
		<td<?php echo $jogos->versao->cellAttributes() ?>>
<span id="el<?php echo $jogos_delete->RowCnt ?>_jogos_versao" class="jogos_versao">
<span<?php echo $jogos->versao->viewAttributes() ?>>
<?php echo $jogos->versao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($jogos->responsavel->Visible) { // responsavel ?>
		<td<?php echo $jogos->responsavel->cellAttributes() ?>>
<span id="el<?php echo $jogos_delete->RowCnt ?>_jogos_responsavel" class="jogos_responsavel">
<span<?php echo $jogos->responsavel->viewAttributes() ?>>
<?php echo $jogos->responsavel->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$jogos_delete->Recordset->moveNext();
}
$jogos_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $jogos_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$jogos_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$jogos_delete->terminate();
?>