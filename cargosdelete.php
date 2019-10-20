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
$cargos_delete = new cargos_delete();

// Run the page
$cargos_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cargos_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fcargosdelete = currentForm = new ew.Form("fcargosdelete", "delete");

// Form_CustomValidate event
fcargosdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcargosdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $cargos_delete->showPageHeader(); ?>
<?php
$cargos_delete->showMessage();
?>
<form name="fcargosdelete" id="fcargosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($cargos_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $cargos_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cargos">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($cargos_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($cargos->codigo->Visible) { // codigo ?>
		<th class="<?php echo $cargos->codigo->headerCellClass() ?>"><span id="elh_cargos_codigo" class="cargos_codigo"><?php echo $cargos->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($cargos->descricao->Visible) { // descricao ?>
		<th class="<?php echo $cargos->descricao->headerCellClass() ?>"><span id="elh_cargos_descricao" class="cargos_descricao"><?php echo $cargos->descricao->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$cargos_delete->RecCnt = 0;
$i = 0;
while (!$cargos_delete->Recordset->EOF) {
	$cargos_delete->RecCnt++;
	$cargos_delete->RowCnt++;

	// Set row properties
	$cargos->resetAttributes();
	$cargos->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$cargos_delete->loadRowValues($cargos_delete->Recordset);

	// Render row
	$cargos_delete->renderRow();
?>
	<tr<?php echo $cargos->rowAttributes() ?>>
<?php if ($cargos->codigo->Visible) { // codigo ?>
		<td<?php echo $cargos->codigo->cellAttributes() ?>>
<span id="el<?php echo $cargos_delete->RowCnt ?>_cargos_codigo" class="cargos_codigo">
<span<?php echo $cargos->codigo->viewAttributes() ?>>
<?php echo $cargos->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($cargos->descricao->Visible) { // descricao ?>
		<td<?php echo $cargos->descricao->cellAttributes() ?>>
<span id="el<?php echo $cargos_delete->RowCnt ?>_cargos_descricao" class="cargos_descricao">
<span<?php echo $cargos->descricao->viewAttributes() ?>>
<?php echo $cargos->descricao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$cargos_delete->Recordset->moveNext();
}
$cargos_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $cargos_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$cargos_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cargos_delete->terminate();
?>