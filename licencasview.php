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
$licencas_view = new licencas_view();

// Run the page
$licencas_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$licencas_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$licencas->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var flicencasview = currentForm = new ew.Form("flicencasview", "view");

// Form_CustomValidate event
flicencasview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flicencasview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flicencasview.lists["x_jogo"] = <?php echo $licencas_view->jogo->Lookup->toClientList() ?>;
flicencasview.lists["x_jogo"].options = <?php echo JsonEncode($licencas_view->jogo->lookupOptions()) ?>;
flicencasview.lists["x_plataforma"] = <?php echo $licencas_view->plataforma->Lookup->toClientList() ?>;
flicencasview.lists["x_plataforma"].options = <?php echo JsonEncode($licencas_view->plataforma->lookupOptions()) ?>;
flicencasview.autoSuggests["x_plataforma"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
flicencasview.lists["x_player"] = <?php echo $licencas_view->player->Lookup->toClientList() ?>;
flicencasview.lists["x_player"].options = <?php echo JsonEncode($licencas_view->player->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$licencas->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $licencas_view->ExportOptions->render("body") ?>
<?php $licencas_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $licencas_view->showPageHeader(); ?>
<?php
$licencas_view->showMessage();
?>
<form name="flicencasview" id="flicencasview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($licencas_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $licencas_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="licencas">
<input type="hidden" name="modal" value="<?php echo (int)$licencas_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($licencas->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $licencas_view->TableLeftColumnClass ?>"><span id="elh_licencas_codigo"><?php echo $licencas->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $licencas->codigo->cellAttributes() ?>>
<span id="el_licencas_codigo">
<span<?php echo $licencas->codigo->viewAttributes() ?>>
<?php echo $licencas->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($licencas->jogo->Visible) { // jogo ?>
	<tr id="r_jogo">
		<td class="<?php echo $licencas_view->TableLeftColumnClass ?>"><span id="elh_licencas_jogo"><?php echo $licencas->jogo->caption() ?></span></td>
		<td data-name="jogo"<?php echo $licencas->jogo->cellAttributes() ?>>
<span id="el_licencas_jogo">
<span<?php echo $licencas->jogo->viewAttributes() ?>>
<?php echo $licencas->jogo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($licencas->plataforma->Visible) { // plataforma ?>
	<tr id="r_plataforma">
		<td class="<?php echo $licencas_view->TableLeftColumnClass ?>"><span id="elh_licencas_plataforma"><?php echo $licencas->plataforma->caption() ?></span></td>
		<td data-name="plataforma"<?php echo $licencas->plataforma->cellAttributes() ?>>
<span id="el_licencas_plataforma">
<span<?php echo $licencas->plataforma->viewAttributes() ?>>
<?php echo $licencas->plataforma->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($licencas->codigo_liberacao->Visible) { // codigo_liberacao ?>
	<tr id="r_codigo_liberacao">
		<td class="<?php echo $licencas_view->TableLeftColumnClass ?>"><span id="elh_licencas_codigo_liberacao"><?php echo $licencas->codigo_liberacao->caption() ?></span></td>
		<td data-name="codigo_liberacao"<?php echo $licencas->codigo_liberacao->cellAttributes() ?>>
<span id="el_licencas_codigo_liberacao">
<span<?php echo $licencas->codigo_liberacao->viewAttributes() ?>>
<?php echo $licencas->codigo_liberacao->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($licencas->player->Visible) { // player ?>
	<tr id="r_player">
		<td class="<?php echo $licencas_view->TableLeftColumnClass ?>"><span id="elh_licencas_player"><?php echo $licencas->player->caption() ?></span></td>
		<td data-name="player"<?php echo $licencas->player->cellAttributes() ?>>
<span id="el_licencas_player">
<span<?php echo $licencas->player->viewAttributes() ?>>
<?php echo $licencas->player->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$licencas_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$licencas->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$licencas_view->terminate();
?>