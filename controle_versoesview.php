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
$controle_versoes_view = new controle_versoes_view();

// Run the page
$controle_versoes_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$controle_versoes_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$controle_versoes->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fcontrole_versoesview = currentForm = new ew.Form("fcontrole_versoesview", "view");

// Form_CustomValidate event
fcontrole_versoesview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcontrole_versoesview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcontrole_versoesview.lists["x_jogo"] = <?php echo $controle_versoes_view->jogo->Lookup->toClientList() ?>;
fcontrole_versoesview.lists["x_jogo"].options = <?php echo JsonEncode($controle_versoes_view->jogo->lookupOptions()) ?>;
fcontrole_versoesview.lists["x_estagio"] = <?php echo $controle_versoes_view->estagio->Lookup->toClientList() ?>;
fcontrole_versoesview.lists["x_estagio"].options = <?php echo JsonEncode($controle_versoes_view->estagio->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$controle_versoes->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $controle_versoes_view->ExportOptions->render("body") ?>
<?php $controle_versoes_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $controle_versoes_view->showPageHeader(); ?>
<?php
$controle_versoes_view->showMessage();
?>
<form name="fcontrole_versoesview" id="fcontrole_versoesview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($controle_versoes_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $controle_versoes_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="controle_versoes">
<input type="hidden" name="modal" value="<?php echo (int)$controle_versoes_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($controle_versoes->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $controle_versoes_view->TableLeftColumnClass ?>"><span id="elh_controle_versoes_codigo"><?php echo $controle_versoes->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $controle_versoes->codigo->cellAttributes() ?>>
<span id="el_controle_versoes_codigo">
<span<?php echo $controle_versoes->codigo->viewAttributes() ?>>
<?php echo $controle_versoes->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($controle_versoes->jogo->Visible) { // jogo ?>
	<tr id="r_jogo">
		<td class="<?php echo $controle_versoes_view->TableLeftColumnClass ?>"><span id="elh_controle_versoes_jogo"><?php echo $controle_versoes->jogo->caption() ?></span></td>
		<td data-name="jogo"<?php echo $controle_versoes->jogo->cellAttributes() ?>>
<span id="el_controle_versoes_jogo">
<span<?php echo $controle_versoes->jogo->viewAttributes() ?>>
<?php echo $controle_versoes->jogo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($controle_versoes->versao->Visible) { // versao ?>
	<tr id="r_versao">
		<td class="<?php echo $controle_versoes_view->TableLeftColumnClass ?>"><span id="elh_controle_versoes_versao"><?php echo $controle_versoes->versao->caption() ?></span></td>
		<td data-name="versao"<?php echo $controle_versoes->versao->cellAttributes() ?>>
<span id="el_controle_versoes_versao">
<span<?php echo $controle_versoes->versao->viewAttributes() ?>>
<?php echo $controle_versoes->versao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($controle_versoes->repositorio->Visible) { // repositorio ?>
	<tr id="r_repositorio">
		<td class="<?php echo $controle_versoes_view->TableLeftColumnClass ?>"><span id="elh_controle_versoes_repositorio"><?php echo $controle_versoes->repositorio->caption() ?></span></td>
		<td data-name="repositorio"<?php echo $controle_versoes->repositorio->cellAttributes() ?>>
<span id="el_controle_versoes_repositorio">
<span<?php echo $controle_versoes->repositorio->viewAttributes() ?>>
<?php echo $controle_versoes->repositorio->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($controle_versoes->estagio->Visible) { // estagio ?>
	<tr id="r_estagio">
		<td class="<?php echo $controle_versoes_view->TableLeftColumnClass ?>"><span id="elh_controle_versoes_estagio"><?php echo $controle_versoes->estagio->caption() ?></span></td>
		<td data-name="estagio"<?php echo $controle_versoes->estagio->cellAttributes() ?>>
<span id="el_controle_versoes_estagio">
<span<?php echo $controle_versoes->estagio->viewAttributes() ?>>
<?php echo $controle_versoes->estagio->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$controle_versoes_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$controle_versoes->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$controle_versoes_view->terminate();
?>