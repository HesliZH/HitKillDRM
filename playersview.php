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
$players_view = new players_view();

// Run the page
$players_view->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$players_view->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$players->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "view";
var fplayersview = currentForm = new ew.Form("fplayersview", "view");

// Form_CustomValidate event
fplayersview.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplayersview.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$players->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $players_view->ExportOptions->render("body") ?>
<?php $players_view->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $players_view->showPageHeader(); ?>
<?php
$players_view->showMessage();
?>
<form name="fplayersview" id="fplayersview" class="form-inline ew-form ew-view-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($players_view->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $players_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="players">
<input type="hidden" name="modal" value="<?php echo (int)$players_view->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($players->codigo->Visible) { // codigo ?>
	<tr id="r_codigo">
		<td class="<?php echo $players_view->TableLeftColumnClass ?>"><span id="elh_players_codigo"><?php echo $players->codigo->caption() ?></span></td>
		<td data-name="codigo"<?php echo $players->codigo->cellAttributes() ?>>
<span id="el_players_codigo">
<span<?php echo $players->codigo->viewAttributes() ?>>
<?php echo $players->codigo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($players->nome_completo->Visible) { // nome_completo ?>
	<tr id="r_nome_completo">
		<td class="<?php echo $players_view->TableLeftColumnClass ?>"><span id="elh_players_nome_completo"><?php echo $players->nome_completo->caption() ?></span></td>
		<td data-name="nome_completo"<?php echo $players->nome_completo->cellAttributes() ?>>
<span id="el_players_nome_completo">
<span<?php echo $players->nome_completo->viewAttributes() ?>>
<?php echo $players->nome_completo->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($players->usuario->Visible) { // usuario ?>
	<tr id="r_usuario">
		<td class="<?php echo $players_view->TableLeftColumnClass ?>"><span id="elh_players_usuario"><?php echo $players->usuario->caption() ?></span></td>
		<td data-name="usuario"<?php echo $players->usuario->cellAttributes() ?>>
<span id="el_players_usuario">
<span<?php echo $players->usuario->viewAttributes() ?>>
<?php echo $players->usuario->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($players->senha->Visible) { // senha ?>
	<tr id="r_senha">
		<td class="<?php echo $players_view->TableLeftColumnClass ?>"><span id="elh_players_senha"><?php echo $players->senha->caption() ?></span></td>
		<td data-name="senha"<?php echo $players->senha->cellAttributes() ?>>
<span id="el_players_senha">
<span<?php echo $players->senha->viewAttributes() ?>>
<?php echo $players->senha->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($players->nickname->Visible) { // nickname ?>
	<tr id="r_nickname">
		<td class="<?php echo $players_view->TableLeftColumnClass ?>"><span id="elh_players_nickname"><?php echo $players->nickname->caption() ?></span></td>
		<td data-name="nickname"<?php echo $players->nickname->cellAttributes() ?>>
<span id="el_players_nickname">
<span<?php echo $players->nickname->viewAttributes() ?>>
<?php echo $players->nickname->getViewValue() ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<?php
$players_view->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$players->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$players_view->terminate();
?>