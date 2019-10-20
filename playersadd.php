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
$players_add = new players_add();

// Run the page
$players_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$players_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fplayersadd = currentForm = new ew.Form("fplayersadd", "add");

// Validate form
fplayersadd.validate = function() {
	if (!this.validateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.getForm(), $fobj = $(fobj);
	if ($fobj.find("#confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.formKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		<?php if ($players_add->nome_completo->Required) { ?>
			elm = this.getElements("x" + infix + "_nome_completo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $players->nome_completo->caption(), $players->nome_completo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($players_add->usuario->Required) { ?>
			elm = this.getElements("x" + infix + "_usuario");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $players->usuario->caption(), $players->usuario->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($players_add->senha->Required) { ?>
			elm = this.getElements("x" + infix + "_senha");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $players->senha->caption(), $players->senha->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($players_add->nickname->Required) { ?>
			elm = this.getElements("x" + infix + "_nickname");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $players->nickname->caption(), $players->nickname->RequiredErrorMessage)) ?>");
		<?php } ?>

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ew.forms[val])
			if (!ew.forms[val].validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fplayersadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplayersadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $players_add->showPageHeader(); ?>
<?php
$players_add->showMessage();
?>
<form name="fplayersadd" id="fplayersadd" class="<?php echo $players_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($players_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $players_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="players">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$players_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($players->nome_completo->Visible) { // nome_completo ?>
	<div id="r_nome_completo" class="form-group row">
		<label id="elh_players_nome_completo" for="x_nome_completo" class="<?php echo $players_add->LeftColumnClass ?>"><?php echo $players->nome_completo->caption() ?><?php echo ($players->nome_completo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $players_add->RightColumnClass ?>"><div<?php echo $players->nome_completo->cellAttributes() ?>>
<span id="el_players_nome_completo">
<input type="text" data-table="players" data-field="x_nome_completo" name="x_nome_completo" id="x_nome_completo" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($players->nome_completo->getPlaceHolder()) ?>" value="<?php echo $players->nome_completo->EditValue ?>"<?php echo $players->nome_completo->editAttributes() ?>>
</span>
<?php echo $players->nome_completo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($players->usuario->Visible) { // usuario ?>
	<div id="r_usuario" class="form-group row">
		<label id="elh_players_usuario" for="x_usuario" class="<?php echo $players_add->LeftColumnClass ?>"><?php echo $players->usuario->caption() ?><?php echo ($players->usuario->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $players_add->RightColumnClass ?>"><div<?php echo $players->usuario->cellAttributes() ?>>
<span id="el_players_usuario">
<input type="text" data-table="players" data-field="x_usuario" name="x_usuario" id="x_usuario" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($players->usuario->getPlaceHolder()) ?>" value="<?php echo $players->usuario->EditValue ?>"<?php echo $players->usuario->editAttributes() ?>>
</span>
<?php echo $players->usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($players->senha->Visible) { // senha ?>
	<div id="r_senha" class="form-group row">
		<label id="elh_players_senha" for="x_senha" class="<?php echo $players_add->LeftColumnClass ?>"><?php echo $players->senha->caption() ?><?php echo ($players->senha->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $players_add->RightColumnClass ?>"><div<?php echo $players->senha->cellAttributes() ?>>
<span id="el_players_senha">
<input type="text" data-table="players" data-field="x_senha" name="x_senha" id="x_senha" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($players->senha->getPlaceHolder()) ?>" value="<?php echo $players->senha->EditValue ?>"<?php echo $players->senha->editAttributes() ?>>
</span>
<?php echo $players->senha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($players->nickname->Visible) { // nickname ?>
	<div id="r_nickname" class="form-group row">
		<label id="elh_players_nickname" for="x_nickname" class="<?php echo $players_add->LeftColumnClass ?>"><?php echo $players->nickname->caption() ?><?php echo ($players->nickname->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $players_add->RightColumnClass ?>"><div<?php echo $players->nickname->cellAttributes() ?>>
<span id="el_players_nickname">
<input type="text" data-table="players" data-field="x_nickname" name="x_nickname" id="x_nickname" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($players->nickname->getPlaceHolder()) ?>" value="<?php echo $players->nickname->EditValue ?>"<?php echo $players->nickname->editAttributes() ?>>
</span>
<?php echo $players->nickname->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$players_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $players_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $players_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$players_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$players_add->terminate();
?>