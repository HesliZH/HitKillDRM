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
$plataformas_delete = new plataformas_delete();

// Run the page
$plataformas_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$plataformas_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fplataformasdelete = currentForm = new ew.Form("fplataformasdelete", "delete");

// Form_CustomValidate event
fplataformasdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplataformasdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $plataformas_delete->showPageHeader(); ?>
<?php
$plataformas_delete->showMessage();
?>
<form name="fplataformasdelete" id="fplataformasdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($plataformas_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $plataformas_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="plataformas">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($plataformas_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($plataformas->codigo->Visible) { // codigo ?>
		<th class="<?php echo $plataformas->codigo->headerCellClass() ?>"><span id="elh_plataformas_codigo" class="plataformas_codigo"><?php echo $plataformas->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($plataformas->descricao->Visible) { // descricao ?>
		<th class="<?php echo $plataformas->descricao->headerCellClass() ?>"><span id="elh_plataformas_descricao" class="plataformas_descricao"><?php echo $plataformas->descricao->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$plataformas_delete->RecCnt = 0;
$i = 0;
while (!$plataformas_delete->Recordset->EOF) {
	$plataformas_delete->RecCnt++;
	$plataformas_delete->RowCnt++;

	// Set row properties
	$plataformas->resetAttributes();
	$plataformas->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$plataformas_delete->loadRowValues($plataformas_delete->Recordset);

	// Render row
	$plataformas_delete->renderRow();
?>
	<tr<?php echo $plataformas->rowAttributes() ?>>
<?php if ($plataformas->codigo->Visible) { // codigo ?>
		<td<?php echo $plataformas->codigo->cellAttributes() ?>>
<span id="el<?php echo $plataformas_delete->RowCnt ?>_plataformas_codigo" class="plataformas_codigo">
<span<?php echo $plataformas->codigo->viewAttributes() ?>>
<?php echo $plataformas->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($plataformas->descricao->Visible) { // descricao ?>
		<td<?php echo $plataformas->descricao->cellAttributes() ?>>
<span id="el<?php echo $plataformas_delete->RowCnt ?>_plataformas_descricao" class="plataformas_descricao">
<span<?php echo $plataformas->descricao->viewAttributes() ?>>
<?php echo $plataformas->descricao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$plataformas_delete->Recordset->moveNext();
}
$plataformas_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $plataformas_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$plataformas_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$plataformas_delete->terminate();
?>