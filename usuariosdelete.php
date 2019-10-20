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
$usuarios_delete = new usuarios_delete();

// Run the page
$usuarios_delete->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "delete";
var fusuariosdelete = currentForm = new ew.Form("fusuariosdelete", "delete");

// Form_CustomValidate event
fusuariosdelete.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusuariosdelete.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusuariosdelete.lists["x_cargo"] = <?php echo $usuarios_delete->cargo->Lookup->toClientList() ?>;
fusuariosdelete.lists["x_cargo"].options = <?php echo JsonEncode($usuarios_delete->cargo->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $usuarios_delete->showPageHeader(); ?>
<?php
$usuarios_delete->showMessage();
?>
<form name="fusuariosdelete" id="fusuariosdelete" class="form-inline ew-form ew-delete-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($usuarios_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $usuarios_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($usuarios_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
	<thead>
	<tr class="ew-table-header">
<?php if ($usuarios->codigo->Visible) { // codigo ?>
		<th class="<?php echo $usuarios->codigo->headerCellClass() ?>"><span id="elh_usuarios_codigo" class="usuarios_codigo"><?php echo $usuarios->codigo->caption() ?></span></th>
<?php } ?>
<?php if ($usuarios->nome_completo->Visible) { // nome_completo ?>
		<th class="<?php echo $usuarios->nome_completo->headerCellClass() ?>"><span id="elh_usuarios_nome_completo" class="usuarios_nome_completo"><?php echo $usuarios->nome_completo->caption() ?></span></th>
<?php } ?>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
		<th class="<?php echo $usuarios->usuario->headerCellClass() ?>"><span id="elh_usuarios_usuario" class="usuarios_usuario"><?php echo $usuarios->usuario->caption() ?></span></th>
<?php } ?>
<?php if ($usuarios->senha->Visible) { // senha ?>
		<th class="<?php echo $usuarios->senha->headerCellClass() ?>"><span id="elh_usuarios_senha" class="usuarios_senha"><?php echo $usuarios->senha->caption() ?></span></th>
<?php } ?>
<?php if ($usuarios->cargo->Visible) { // cargo ?>
		<th class="<?php echo $usuarios->cargo->headerCellClass() ?>"><span id="elh_usuarios_cargo" class="usuarios_cargo"><?php echo $usuarios->cargo->caption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$usuarios_delete->RecCnt = 0;
$i = 0;
while (!$usuarios_delete->Recordset->EOF) {
	$usuarios_delete->RecCnt++;
	$usuarios_delete->RowCnt++;

	// Set row properties
	$usuarios->resetAttributes();
	$usuarios->RowType = ROWTYPE_VIEW; // View

	// Get the field contents
	$usuarios_delete->loadRowValues($usuarios_delete->Recordset);

	// Render row
	$usuarios_delete->renderRow();
?>
	<tr<?php echo $usuarios->rowAttributes() ?>>
<?php if ($usuarios->codigo->Visible) { // codigo ?>
		<td<?php echo $usuarios->codigo->cellAttributes() ?>>
<span id="el<?php echo $usuarios_delete->RowCnt ?>_usuarios_codigo" class="usuarios_codigo">
<span<?php echo $usuarios->codigo->viewAttributes() ?>>
<?php echo $usuarios->codigo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($usuarios->nome_completo->Visible) { // nome_completo ?>
		<td<?php echo $usuarios->nome_completo->cellAttributes() ?>>
<span id="el<?php echo $usuarios_delete->RowCnt ?>_usuarios_nome_completo" class="usuarios_nome_completo">
<span<?php echo $usuarios->nome_completo->viewAttributes() ?>>
<?php echo $usuarios->nome_completo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
		<td<?php echo $usuarios->usuario->cellAttributes() ?>>
<span id="el<?php echo $usuarios_delete->RowCnt ?>_usuarios_usuario" class="usuarios_usuario">
<span<?php echo $usuarios->usuario->viewAttributes() ?>>
<?php echo $usuarios->usuario->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($usuarios->senha->Visible) { // senha ?>
		<td<?php echo $usuarios->senha->cellAttributes() ?>>
<span id="el<?php echo $usuarios_delete->RowCnt ?>_usuarios_senha" class="usuarios_senha">
<span<?php echo $usuarios->senha->viewAttributes() ?>>
<?php echo $usuarios->senha->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($usuarios->cargo->Visible) { // cargo ?>
		<td<?php echo $usuarios->cargo->cellAttributes() ?>>
<span id="el<?php echo $usuarios_delete->RowCnt ?>_usuarios_cargo" class="usuarios_cargo">
<span<?php echo $usuarios->cargo->viewAttributes() ?>>
<?php echo $usuarios->cargo->getViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$usuarios_delete->Recordset->moveNext();
}
$usuarios_delete->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $usuarios_delete->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$usuarios_delete->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$usuarios_delete->terminate();
?>