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
$estagios_desenvolvimento_view = new estagios_desenvolvimento_view();

// Run the page
$estagios_desenvolvimento_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estagios_desenvolvimento_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var festagios_desenvolvimentoview = currentForm = new ew.Form("festagios_desenvolvimentoview", "view");

// Form_CustomValidate event
festagios_desenvolvimentoview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
festagios_desenvolvimentoview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $estagios_desenvolvimento_view->ExportOptions->render("body") ?>
<?php $estagios_desenvolvimento_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $estagios_desenvolvimento_view->showPageHeader(); ?>
<?php
$estagios_desenvolvimento_view->showMessage();
?>
<form name="festagios_desenvolvimentoview" id="festagios_desenvolvimentoview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($estagios_desenvolvimento_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $estagios_desenvolvimento_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estagios_desenvolvimento">
<input type="hidden" name="modal" value="<?php echo (int)$estagios_desenvolvimento_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($estagios_desenvolvimento->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $estagios_desenvolvimento_view->TableLeftColumnClass ?>"><span id="elh_estagios_desenvolvimento_codigo"><?php echo $estagios_desenvolvimento->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $estagios_desenvolvimento->codigo->cellAttributes() ?>>
<span id="el_estagios_desenvolvimento_codigo">
<span<?php echo $estagios_desenvolvimento->codigo->viewAttributes() ?>>
<?php echo $estagios_desenvolvimento->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estagios_desenvolvimento->descricao->Visible) { // descricao ?>
	<tr id="r_descricao">
		<td class="<?php echo $estagios_desenvolvimento_view->TableLeftColumnClass ?>"><span id="elh_estagios_desenvolvimento_descricao"><?php echo $estagios_desenvolvimento->descricao->caption() ?></span></td>
		<td data-name="descricao"<?php echo $estagios_desenvolvimento->descricao->cellAttributes() ?>>
<span id="el_estagios_desenvolvimento_descricao">
<span<?php echo $estagios_desenvolvimento->descricao->viewAttributes() ?>>
<?php echo $estagios_desenvolvimento->descricao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$estagios_desenvolvimento_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$estagios_desenvolvimento_view->terminate();
?>