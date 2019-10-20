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
$cargos_view = new cargos_view();

// Run the page
$cargos_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cargos_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$cargos->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fcargosview = currentForm = new ew.Form("fcargosview", "view");

// Form_CustomValidate event
fcargosview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcargosview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$cargos->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $cargos_view->ExportOptions->render("body") ?>
<?php $cargos_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $cargos_view->showPageHeader(); ?>
<?php
$cargos_view->showMessage();
?>
<form name="fcargosview" id="fcargosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($cargos_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $cargos_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cargos">
<input type="hidden" name="modal" value="<?php echo (int)$cargos_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($cargos->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $cargos_view->TableLeftColumnClass ?>"><span id="elh_cargos_codigo"><?php echo $cargos->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $cargos->codigo->cellAttributes() ?>>
<span id="el_cargos_codigo">
<span<?php echo $cargos->codigo->viewAttributes() ?>>
<?php echo $cargos->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cargos->descricao->Visible) { // descricao ?>
	<tr id="r_descricao">
		<td class="<?php echo $cargos_view->TableLeftColumnClass ?>"><span id="elh_cargos_descricao"><?php echo $cargos->descricao->caption() ?></span></td>
		<td data-name="descricao"<?php echo $cargos->descricao->cellAttributes() ?>>
<span id="el_cargos_descricao">
<span<?php echo $cargos->descricao->viewAttributes() ?>>
<?php echo $cargos->descricao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$cargos_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$cargos->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cargos_view->terminate();
?>