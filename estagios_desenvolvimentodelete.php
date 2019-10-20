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
$estagios_desenvolvimento_delete = new estagios_desenvolvimento_delete();

// Run the page
$estagios_desenvolvimento_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estagios_desenvolvimento_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var festagios_desenvolvimentodelete = currentForm = new ew.Form("festagios_desenvolvimentodelete", "delete");

// Form_CustomValidate event
festagios_desenvolvimentodelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
festagios_desenvolvimentodelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $estagios_desenvolvimento_delete->showPageHeader(); ?>
<?php
$estagios_desenvolvimento_delete->showMessage();
?>
<form name="festagios_desenvolvimentodelete" id="festagios_desenvolvimentodelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($estagios_desenvolvimento_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $estagios_desenvolvimento_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estagios_desenvolvimento">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($estagios_desenvolvimento_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($estagios_desenvolvimento->codigo->Visible) { // codigo ?>
		<th class="<?php echo $estagios_desenvolvimento->codigo->headerCellClass() ?>"><span id="elh_estagios_desenvolvimento_codigo" class="estagios_desenvolvimento_codigo"><?php echo $estagios_desenvolvimento->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($estagios_desenvolvimento->descricao->Visible) { // descricao ?>
		<th class="<?php echo $estagios_desenvolvimento->descricao->headerCellClass() ?>"><span id="elh_estagios_desenvolvimento_descricao" class="estagios_desenvolvimento_descricao"><?php echo $estagios_desenvolvimento->descricao->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$estagios_desenvolvimento_delete->RecCnt = 0;
$i = 0;
while (!$estagios_desenvolvimento_delete->Recordset->EOF) {
	$estagios_desenvolvimento_delete->RecCnt++;
	$estagios_desenvolvimento_delete->RowCnt++;

	// Set row properties
	$estagios_desenvolvimento->resetAttributes();
	$estagios_desenvolvimento->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$estagios_desenvolvimento_delete->loadRowValues($estagios_desenvolvimento_delete->Recordset);

	// Render row
	$estagios_desenvolvimento_delete->renderRow();
?>
	<tr<?php echo $estagios_desenvolvimento->rowAttributes() ?>>
<?php if ($estagios_desenvolvimento->codigo->Visible) { // codigo ?>
		<td<?php echo $estagios_desenvolvimento->codigo->cellAttributes() ?>>
<span id="el<?php echo $estagios_desenvolvimento_delete->RowCnt ?>_estagios_desenvolvimento_codigo" class="estagios_desenvolvimento_codigo">
<span<?php echo $estagios_desenvolvimento->codigo->viewAttributes() ?>>
<?php echo $estagios_desenvolvimento->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($estagios_desenvolvimento->descricao->Visible) { // descricao ?>
		<td<?php echo $estagios_desenvolvimento->descricao->cellAttributes() ?>>
<span id="el<?php echo $estagios_desenvolvimento_delete->RowCnt ?>_estagios_desenvolvimento_descricao" class="estagios_desenvolvimento_descricao">
<span<?php echo $estagios_desenvolvimento->descricao->viewAttributes() ?>>
<?php echo $estagios_desenvolvimento->descricao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$estagios_desenvolvimento_delete->Recordset->moveNext();
}
$estagios_desenvolvimento_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $estagios_desenvolvimento_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$estagios_desenvolvimento_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estagios_desenvolvimento_delete->terminate();
?>