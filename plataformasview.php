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
$plataformas_view = new plataformas_view();

// Run the page
$plataformas_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$plataformas_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$plataformas->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fplataformasview = currentForm = new ew.Form("fplataformasview", "view");

// Form_CustomValidate event
fplataformasview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplataformasview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$plataformas->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $plataformas_view->ExportOptions->render("body") ?>
<?php $plataformas_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $plataformas_view->showPageHeader(); ?>
<?php
$plataformas_view->showMessage();
?>
<form name="fplataformasview" id="fplataformasview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($plataformas_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $plataformas_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="plataformas">
<input type="hidden" name="modal" value="<?php echo (int)$plataformas_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($plataformas->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $plataformas_view->TableLeftColumnClass ?>"><span id="elh_plataformas_codigo"><?php echo $plataformas->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $plataformas->codigo->cellAttributes() ?>>
<span id="el_plataformas_codigo">
<span<?php echo $plataformas->codigo->viewAttributes() ?>>
<?php echo $plataformas->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($plataformas->descricao->Visible) { // descricao ?>
	<tr id="r_descricao">
		<td class="<?php echo $plataformas_view->TableLeftColumnClass ?>"><span id="elh_plataformas_descricao"><?php echo $plataformas->descricao->caption() ?></span></td>
		<td data-name="descricao"<?php echo $plataformas->descricao->cellAttributes() ?>>
<span id="el_plataformas_descricao">
<span<?php echo $plataformas->descricao->viewAttributes() ?>>
<?php echo $plataformas->descricao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$plataformas_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$plataformas->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$plataformas_view->terminate();
?>