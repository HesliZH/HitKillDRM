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
$jogos_view = new jogos_view();

// Run the page
$jogos_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$jogos_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$jogos->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fjogosview = currentForm = new ew.Form("fjogosview", "view");

// Form_CustomValidate event
fjogosview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fjogosview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fjogosview.lists["x_plataforma"] = <?php echo $jogos_view->plataforma->Lookup->toClientList() ?>;
fjogosview.lists["x_plataforma"].options = <?php echo JsonEncode($jogos_view->plataforma->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$jogos->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $jogos_view->ExportOptions->render("body") ?>
<?php $jogos_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $jogos_view->showPageHeader(); ?>
<?php
$jogos_view->showMessage();
?>
<form name="fjogosview" id="fjogosview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($jogos_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $jogos_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="jogos">
<input type="hidden" name="modal" value="<?php echo (int)$jogos_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($jogos->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $jogos_view->TableLeftColumnClass ?>"><span id="elh_jogos_codigo"><?php echo $jogos->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $jogos->codigo->cellAttributes() ?>>
<span id="el_jogos_codigo">
<span<?php echo $jogos->codigo->viewAttributes() ?>>
<?php echo $jogos->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($jogos->nome->Visible) { // nome ?>
	<tr id="r_nome">
		<td class="<?php echo $jogos_view->TableLeftColumnClass ?>"><span id="elh_jogos_nome"><?php echo $jogos->nome->caption() ?></span></td>
		<td data-name="nome"<?php echo $jogos->nome->cellAttributes() ?>>
<span id="el_jogos_nome">
<span<?php echo $jogos->nome->viewAttributes() ?>>
<?php echo $jogos->nome->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($jogos->plataforma->Visible) { // plataforma ?>
	<tr id="r_plataforma">
		<td class="<?php echo $jogos_view->TableLeftColumnClass ?>"><span id="elh_jogos_plataforma"><?php echo $jogos->plataforma->caption() ?></span></td>
		<td data-name="plataforma"<?php echo $jogos->plataforma->cellAttributes() ?>>
<span id="el_jogos_plataforma">
<span<?php echo $jogos->plataforma->viewAttributes() ?>>
<?php echo $jogos->plataforma->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($jogos->versao->Visible) { // versao ?>
	<tr id="r_versao">
		<td class="<?php echo $jogos_view->TableLeftColumnClass ?>"><span id="elh_jogos_versao"><?php echo $jogos->versao->caption() ?></span></td>
		<td data-name="versao"<?php echo $jogos->versao->cellAttributes() ?>>
<span id="el_jogos_versao">
<span<?php echo $jogos->versao->viewAttributes() ?>>
<?php echo $jogos->versao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$jogos_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$jogos->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$jogos_view->terminate();
?>