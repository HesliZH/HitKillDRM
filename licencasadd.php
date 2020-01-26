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
$licencas_add = new licencas_add();

// Run the page
$licencas_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$licencas_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var flicencasadd = currentForm = new ew.Form("flicencasadd", "add");

// Validate form
flicencasadd.validate = function() {
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
		<?php if ($licencas_add->jogo->Required) { ?>
			elm = this.getElements("x" + infix + "_jogo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $licencas->jogo->caption(), $licencas->jogo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($licencas_add->plataforma->Required) { ?>
			elm = this.getElements("x" + infix + "_plataforma");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $licencas->plataforma->caption(), $licencas->plataforma->RequiredErrorMessage)) ?>");
		<?php } ?>
			elm = this.getElements("x" + infix + "_plataforma");
			if (elm && !ew.checkInteger(elm.value))
				return this.onError(elm, "<?php echo JsEncode($licencas->plataforma->errorMessage()) ?>");
		<?php if ($licencas_add->codigo_liberacao->Required) { ?>
			elm = this.getElements("x" + infix + "_codigo_liberacao");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $licencas->codigo_liberacao->caption(), $licencas->codigo_liberacao->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($licencas_add->player->Required) { ?>
			elm = this.getElements("x" + infix + "_player");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $licencas->player->caption(), $licencas->player->RequiredErrorMessage)) ?>");
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
flicencasadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flicencasadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flicencasadd.lists["x_jogo"] = <?php echo $licencas_add->jogo->Lookup->toClientList() ?>;
flicencasadd.lists["x_jogo"].options = <?php echo JsonEncode($licencas_add->jogo->lookupOptions()) ?>;
flicencasadd.lists["x_plataforma"] = <?php echo $licencas_add->plataforma->Lookup->toClientList() ?>;
flicencasadd.lists["x_plataforma"].options = <?php echo JsonEncode($licencas_add->plataforma->lookupOptions()) ?>;
flicencasadd.autoSuggests["x_plataforma"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
flicencasadd.lists["x_player"] = <?php echo $licencas_add->player->Lookup->toClientList() ?>;
flicencasadd.lists["x_player"].options = <?php echo JsonEncode($licencas_add->player->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $licencas_add->showPageHeader(); ?>
<?php
$licencas_add->showMessage();
?>
<form name="flicencasadd" id="flicencasadd" class="<?php echo $licencas_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($licencas_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $licencas_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="licencas">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$licencas_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($licencas->jogo->Visible) { // jogo ?>
	<div id="r_jogo" class="form-group row">
		<label id="elh_licencas_jogo" for="x_jogo" class="<?php echo $licencas_add->LeftColumnClass ?>"><?php echo $licencas->jogo->caption() ?><?php echo ($licencas->jogo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $licencas_add->RightColumnClass ?>"><div<?php echo $licencas->jogo->cellAttributes() ?>>
<span id="el_licencas_jogo">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="licencas" data-field="x_jogo" data-value-separator="<?php echo $licencas->jogo->displayValueSeparatorAttribute() ?>" id="x_jogo" name="x_jogo"<?php echo $licencas->jogo->editAttributes() ?>>
		<?php echo $licencas->jogo->selectOptionListHtml("x_jogo") ?>
	</select>
</div>
<?php echo $licencas->jogo->Lookup->getParamTag("p_x_jogo") ?>
</span>
<?php echo $licencas->jogo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($licencas->plataforma->Visible) { // plataforma ?>
	<div id="r_plataforma" class="form-group row">
		<label id="elh_licencas_plataforma" class="<?php echo $licencas_add->LeftColumnClass ?>"><?php echo $licencas->plataforma->caption() ?><?php echo ($licencas->plataforma->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $licencas_add->RightColumnClass ?>"><div<?php echo $licencas->plataforma->cellAttributes() ?>>
<span id="el_licencas_plataforma">
<?php
$wrkonchange = "" . trim(@$licencas->plataforma->EditAttrs["onchange"]);
if (trim($wrkonchange) <> "") $wrkonchange = " onchange=\"" . JsEncode($wrkonchange) . "\"";
$licencas->plataforma->EditAttrs["onchange"] = "";
?>
<span id="as_x_plataforma" class="text-nowrap" style="z-index: 8970">
	<input type="text" class="form-control" name="sv_x_plataforma" id="sv_x_plataforma" value="<?php echo RemoveHtml($licencas->plataforma->EditValue) ?>" size="30" placeholder="<?php echo HtmlEncode($licencas->plataforma->getPlaceHolder()) ?>" data-placeholder="<?php echo HtmlEncode($licencas->plataforma->getPlaceHolder()) ?>"<?php echo $licencas->plataforma->editAttributes() ?>>
</span>
<input type="hidden" data-table="licencas" data-field="x_plataforma" data-value-separator="<?php echo $licencas->plataforma->displayValueSeparatorAttribute() ?>" name="x_plataforma" id="x_plataforma" value="<?php echo HtmlEncode($licencas->plataforma->CurrentValue) ?>"<?php echo $wrkonchange ?>>
<script>
flicencasadd.createAutoSuggest({"id":"x_plataforma","forceSelect":false});
</script>
<?php echo $licencas->plataforma->Lookup->getParamTag("p_x_plataforma") ?>
</span>
<?php echo $licencas->plataforma->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($licencas->codigo_liberacao->Visible) { // codigo_liberacao ?>
	<div id="r_codigo_liberacao" class="form-group row">
		<label id="elh_licencas_codigo_liberacao" for="x_codigo_liberacao" class="<?php echo $licencas_add->LeftColumnClass ?>"><?php echo $licencas->codigo_liberacao->caption() ?><?php echo ($licencas->codigo_liberacao->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $licencas_add->RightColumnClass ?>"><div<?php echo $licencas->codigo_liberacao->cellAttributes() ?>>
<span id="el_licencas_codigo_liberacao">
<input type="text" data-table="licencas" data-field="x_codigo_liberacao" name="x_codigo_liberacao" id="x_codigo_liberacao" size="30" maxlength="200" placeholder="<?php echo HtmlEncode($licencas->codigo_liberacao->getPlaceHolder()) ?>" value="<?php echo $licencas->codigo_liberacao->EditValue ?>"<?php echo $licencas->codigo_liberacao->editAttributes() ?>>
</span>
<?php echo $licencas->codigo_liberacao->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($licencas->player->Visible) { // player ?>
	<div id="r_player" class="form-group row">
		<label id="elh_licencas_player" for="x_player" class="<?php echo $licencas_add->LeftColumnClass ?>"><?php echo $licencas->player->caption() ?><?php echo ($licencas->player->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $licencas_add->RightColumnClass ?>"><div<?php echo $licencas->player->cellAttributes() ?>>
<span id="el_licencas_player">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="licencas" data-field="x_player" data-value-separator="<?php echo $licencas->player->displayValueSeparatorAttribute() ?>" id="x_player" name="x_player"<?php echo $licencas->player->editAttributes() ?>>
		<?php echo $licencas->player->selectOptionListHtml("x_player") ?>
	</select>
</div>
<?php echo $licencas->player->Lookup->getParamTag("p_x_player") ?>
</span>
<?php echo $licencas->player->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$licencas_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $licencas_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $licencas_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$licencas_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$licencas_add->terminate();
?>