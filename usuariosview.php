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
$usuarios_view = new usuarios_view();

// Run the page
$usuarios_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$usuarios->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fusuariosview = currentForm = new ew.Form("fusuariosview", "view");

// Form_CustomValidate event
fusuariosview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusuariosview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusuariosview.lists["x_cargo"] = <?php echo $usuarios_view->cargo->Lookup->toClientList() ?>;
fusuariosview.lists["x_cargo"].options = <?php echo JsonEncode($usuarios_view->cargo->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$usuarios->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $usuarios_view->ExportOptions->render("body") ?>
<?php $usuarios_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $usuarios_view->showPageHeader(); ?>
<?php
$usuarios_view->showMessage();
?>
<form name="fusuariosview" id="fusuariosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($usuarios_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $usuarios_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="modal" value="<?php echo (int)$usuarios_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($usuarios->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $usuarios_view->TableLeftColumnClass ?>"><span id="elh_usuarios_codigo"><?php echo $usuarios->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $usuarios->codigo->cellAttributes() ?>>
<span id="el_usuarios_codigo">
<span<?php echo $usuarios->codigo->viewAttributes() ?>>
<?php echo $usuarios->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($usuarios->nome_completo->Visible) { // nome_completo ?>
	<tr id="r_nome_completo">
		<td class="<?php echo $usuarios_view->TableLeftColumnClass ?>"><span id="elh_usuarios_nome_completo"><?php echo $usuarios->nome_completo->caption() ?></span></td>
		<td data-name="nome_completo"<?php echo $usuarios->nome_completo->cellAttributes() ?>>
<span id="el_usuarios_nome_completo">
<span<?php echo $usuarios->nome_completo->viewAttributes() ?>>
<?php echo $usuarios->nome_completo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
	<tr id="r_usuario">
		<td class="<?php echo $usuarios_view->TableLeftColumnClass ?>"><span id="elh_usuarios_usuario"><?php echo $usuarios->usuario->caption() ?></span></td>
		<td data-name="usuario"<?php echo $usuarios->usuario->cellAttributes() ?>>
<span id="el_usuarios_usuario">
<span<?php echo $usuarios->usuario->viewAttributes() ?>>
<?php echo $usuarios->usuario->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($usuarios->senha->Visible) { // senha ?>
	<tr id="r_senha">
		<td class="<?php echo $usuarios_view->TableLeftColumnClass ?>"><span id="elh_usuarios_senha"><?php echo $usuarios->senha->caption() ?></span></td>
		<td data-name="senha"<?php echo $usuarios->senha->cellAttributes() ?>>
<span id="el_usuarios_senha">
<span<?php echo $usuarios->senha->viewAttributes() ?>>
<?php echo $usuarios->senha->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($usuarios->cargo->Visible) { // cargo ?>
	<tr id="r_cargo">
		<td class="<?php echo $usuarios_view->TableLeftColumnClass ?>"><span id="elh_usuarios_cargo"><?php echo $usuarios->cargo->caption() ?></span></td>
		<td data-name="cargo"<?php echo $usuarios->cargo->cellAttributes() ?>>
<span id="el_usuarios_cargo">
<span<?php echo $usuarios->cargo->viewAttributes() ?>>
<?php echo $usuarios->cargo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$usuarios_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$usuarios->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$usuarios_view->terminate();
?>