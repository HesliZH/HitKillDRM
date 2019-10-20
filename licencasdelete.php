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
$licencas_delete = new licencas_delete();

// Run the page
$licencas_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$licencas_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var flicencasdelete = currentForm = new ew.Form("flicencasdelete", "delete");

// Form_CustomValidate event
flicencasdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flicencasdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flicencasdelete.lists["x_jogo"] = <?php echo $licencas_delete->jogo->Lookup->toClientList() ?>;
flicencasdelete.lists["x_jogo"].options = <?php echo JsonEncode($licencas_delete->jogo->lookupOptions()) ?>;
flicencasdelete.lists["x_plataforma"] = <?php echo $licencas_delete->plataforma->Lookup->toClientList() ?>;
flicencasdelete.lists["x_plataforma"].options = <?php echo JsonEncode($licencas_delete->plataforma->lookupOptions()) ?>;
flicencasdelete.autoSuggests["x_plataforma"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
flicencasdelete.lists["x_player"] = <?php echo $licencas_delete->player->Lookup->toClientList() ?>;
flicencasdelete.lists["x_player"].options = <?php echo JsonEncode($licencas_delete->player->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $licencas_delete->showPageHeader(); ?>
<?php
$licencas_delete->showMessage();
?>
<form name="flicencasdelete" id="flicencasdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($licencas_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $licencas_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="licencas">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($licencas_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($licencas->codigo->Visible) { // codigo ?>
		<th class="<?php echo $licencas->codigo->headerCellClass() ?>"><span id="elh_licencas_codigo" class="licencas_codigo"><?php echo $licencas->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($licencas->jogo->Visible) { // jogo ?>
		<th class="<?php echo $licencas->jogo->headerCellClass() ?>"><span id="elh_licencas_jogo" class="licencas_jogo"><?php echo $licencas->jogo->caption() ?></span></th>
<?php } ?>
<?php if ($licencas->plataforma->Visible) { // plataforma ?>
		<th class="<?php echo $licencas->plataforma->headerCellClass() ?>"><span id="elh_licencas_plataforma" class="licencas_plataforma"><?php echo $licencas->plataforma->caption() ?></span></th>
<?php } ?>
<?php if ($licencas->codigo_liberacao->Visible) { // codigo_liberacao ?>
		<th class="<?php echo $licencas->codigo_liberacao->headerCellClass() ?>"><span id="elh_licencas_codigo_liberacao" class="licencas_codigo_liberacao"><?php echo $licencas->codigo_liberacao->caption() ?></span></th>
<?php } ?>
<?php if ($licencas->player->Visible) { // player ?>
		<th class="<?php echo $licencas->player->headerCellClass() ?>"><span id="elh_licencas_player" class="licencas_player"><?php echo $licencas->player->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$licencas_delete->RecCnt = 0;
$i = 0;
while (!$licencas_delete->Recordset->EOF) {
	$licencas_delete->RecCnt++;
	$licencas_delete->RowCnt++;

	// Set row properties
	$licencas->resetAttributes();
	$licencas->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$licencas_delete->loadRowValues($licencas_delete->Recordset);

	// Render row
	$licencas_delete->renderRow();
?>
	<tr<?php echo $licencas->rowAttributes() ?>>
<?php if ($licencas->codigo->Visible) { // codigo ?>
		<td<?php echo $licencas->codigo->cellAttributes() ?>>
<span id="el<?php echo $licencas_delete->RowCnt ?>_licencas_codigo" class="licencas_codigo">
<span<?php echo $licencas->codigo->viewAttributes() ?>>
<?php echo $licencas->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($licencas->jogo->Visible) { // jogo ?>
		<td<?php echo $licencas->jogo->cellAttributes() ?>>
<span id="el<?php echo $licencas_delete->RowCnt ?>_licencas_jogo" class="licencas_jogo">
<span<?php echo $licencas->jogo->viewAttributes() ?>>
<?php echo $licencas->jogo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($licencas->plataforma->Visible) { // plataforma ?>
		<td<?php echo $licencas->plataforma->cellAttributes() ?>>
<span id="el<?php echo $licencas_delete->RowCnt ?>_licencas_plataforma" class="licencas_plataforma">
<span<?php echo $licencas->plataforma->viewAttributes() ?>>
<?php echo $licencas->plataforma->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($licencas->codigo_liberacao->Visible) { // codigo_liberacao ?>
		<td<?php echo $licencas->codigo_liberacao->cellAttributes() ?>>
<span id="el<?php echo $licencas_delete->RowCnt ?>_licencas_codigo_liberacao" class="licencas_codigo_liberacao">
<span<?php echo $licencas->codigo_liberacao->viewAttributes() ?>>
<?php echo $licencas->codigo_liberacao->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($licencas->player->Visible) { // player ?>
		<td<?php echo $licencas->player->cellAttributes() ?>>
<span id="el<?php echo $licencas_delete->RowCnt ?>_licencas_player" class="licencas_player">
<span<?php echo $licencas->player->viewAttributes() ?>>
<?php echo $licencas->player->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$licencas_delete->Recordset->moveNext();
}
$licencas_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $licencas_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$licencas_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$licencas_delete->terminate();
?>