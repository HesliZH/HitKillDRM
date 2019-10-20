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
$players_delete = new players_delete();

// Run the page
$players_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$players_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fplayersdelete = currentForm = new ew.Form("fplayersdelete", "delete");

// Form_CustomValidate event
fplayersdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplayersdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $players_delete->showPageHeader(); ?>
<?php
$players_delete->showMessage();
?>
<form name="fplayersdelete" id="fplayersdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($players_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $players_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="players">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($players_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($players->codigo->Visible) { // codigo ?>
		<th class="<?php echo $players->codigo->headerCellClass() ?>"><span id="elh_players_codigo" class="players_codigo"><?php echo $players->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($players->nome_completo->Visible) { // nome_completo ?>
		<th class="<?php echo $players->nome_completo->headerCellClass() ?>"><span id="elh_players_nome_completo" class="players_nome_completo"><?php echo $players->nome_completo->caption() ?></span></th>
<?php } ?>
<?php if ($players->usuario->Visible) { // usuario ?>
		<th class="<?php echo $players->usuario->headerCellClass() ?>"><span id="elh_players_usuario" class="players_usuario"><?php echo $players->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($players->senha->Visible) { // senha ?>
		<th class="<?php echo $players->senha->headerCellClass() ?>"><span id="elh_players_senha" class="players_senha"><?php echo $players->senha->caption() ?></span></th>
<?php } ?>
<?php if ($players->nickname->Visible) { // nickname ?>
		<th class="<?php echo $players->nickname->headerCellClass() ?>"><span id="elh_players_nickname" class="players_nickname"><?php echo $players->nickname->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$players_delete->RecCnt = 0;
$i = 0;
while (!$players_delete->Recordset->EOF) {
	$players_delete->RecCnt++;
	$players_delete->RowCnt++;

	// Set row properties
	$players->resetAttributes();
	$players->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$players_delete->loadRowValues($players_delete->Recordset);

	// Render row
	$players_delete->renderRow();
?>
	<tr<?php echo $players->rowAttributes() ?>>
<?php if ($players->codigo->Visible) { // codigo ?>
		<td<?php echo $players->codigo->cellAttributes() ?>>
<span id="el<?php echo $players_delete->RowCnt ?>_players_codigo" class="players_codigo">
<span<?php echo $players->codigo->viewAttributes() ?>>
<?php echo $players->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($players->nome_completo->Visible) { // nome_completo ?>
		<td<?php echo $players->nome_completo->cellAttributes() ?>>
<span id="el<?php echo $players_delete->RowCnt ?>_players_nome_completo" class="players_nome_completo">
<span<?php echo $players->nome_completo->viewAttributes() ?>>
<?php echo $players->nome_completo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($players->usuario->Visible) { // usuario ?>
		<td<?php echo $players->usuario->cellAttributes() ?>>
<span id="el<?php echo $players_delete->RowCnt ?>_players_usuario" class="players_usuario">
<span<?php echo $players->usuario->viewAttributes() ?>>
<?php echo $players->usuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($players->senha->Visible) { // senha ?>
		<td<?php echo $players->senha->cellAttributes() ?>>
<span id="el<?php echo $players_delete->RowCnt ?>_players_senha" class="players_senha">
<span<?php echo $players->senha->viewAttributes() ?>>
<?php echo $players->senha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($players->nickname->Visible) { // nickname ?>
		<td<?php echo $players->nickname->cellAttributes() ?>>
<span id="el<?php echo $players_delete->RowCnt ?>_players_nickname" class="players_nickname">
<span<?php echo $players->nickname->viewAttributes() ?>>
<?php echo $players->nickname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$players_delete->Recordset->moveNext();
}
$players_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $players_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$players_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$players_delete->terminate();
?>