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
$jogos_edit = new jogos_edit();

// Run the page
$jogos_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$jogos_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fjogosedit = currentForm = new ew.Form("fjogosedit", "edit");

// Validate form
fjogosedit.validate = function() {
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
		<?php if ($jogos_edit->codigo->Required) { ?>
			elm = this.getElements("x" + infix + "_codigo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->codigo->caption(), $jogos->codigo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($jogos_edit->nome->Required) { ?>
			elm = this.getElements("x" + infix + "_nome");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->nome->caption(), $jogos->nome->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($jogos_edit->plataforma->Required) { ?>
			elm = this.getElements("x" + infix + "_plataforma");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->plataforma->caption(), $jogos->plataforma->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($jogos_edit->versao->Required) { ?>
			elm = this.getElements("x" + infix + "_versao");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->versao->caption(), $jogos->versao->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($jogos_edit->responsavel->Required) { ?>
			elm = this.getElements("x" + infix + "_responsavel");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->responsavel->caption(), $jogos->responsavel->RequiredErrorMessage)) ?>");
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
fjogosedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fjogosedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fjogosedit.lists["x_plataforma"] = <?php echo $jogos_edit->plataforma->Lookup->toClientList() ?>;
fjogosedit.lists["x_plataforma"].options = <?php echo JsonEncode($jogos_edit->plataforma->lookupOptions()) ?>;
fjogosedit.lists["x_responsavel"] = <?php echo $jogos_edit->responsavel->Lookup->toClientList() ?>;
fjogosedit.lists["x_responsavel"].options = <?php echo JsonEncode($jogos_edit->responsavel->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $jogos_edit->showPageHeader(); ?>
<?php
$jogos_edit->showMessage();
?>
<form name="fjogosedit" id="fjogosedit" class="<?php echo $jogos_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($jogos_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $jogos_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="jogos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$jogos_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($jogos->codigo->Visible) { // codigo ?>
	<div id="r_codigo" class="form-group row">
		<label id="elh_jogos_codigo" class="<?php echo $jogos_edit->LeftColumnClass ?>"><?php echo $jogos->codigo->caption() ?><?php echo ($jogos->codigo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_edit->RightColumnClass ?>"><div<?php echo $jogos->codigo->cellAttributes() ?>>
<span id="el_jogos_codigo">
<span<?php echo $jogos->codigo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($jogos->codigo->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="jogos" data-field="x_codigo" name="x_codigo" id="x_codigo" value="<?php echo HtmlEncode($jogos->codigo->CurrentValue) ?>">
<?php echo $jogos->codigo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($jogos->nome->Visible) { // nome ?>
	<div id="r_nome" class="form-group row">
		<label id="elh_jogos_nome" for="x_nome" class="<?php echo $jogos_edit->LeftColumnClass ?>"><?php echo $jogos->nome->caption() ?><?php echo ($jogos->nome->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_edit->RightColumnClass ?>"><div<?php echo $jogos->nome->cellAttributes() ?>>
<span id="el_jogos_nome">
<input type="text" data-table="jogos" data-field="x_nome" name="x_nome" id="x_nome" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($jogos->nome->getPlaceHolder()) ?>" value="<?php echo $jogos->nome->EditValue ?>"<?php echo $jogos->nome->editAttributes() ?>>
</span>
<?php echo $jogos->nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($jogos->plataforma->Visible) { // plataforma ?>
	<div id="r_plataforma" class="form-group row">
		<label id="elh_jogos_plataforma" for="x_plataforma" class="<?php echo $jogos_edit->LeftColumnClass ?>"><?php echo $jogos->plataforma->caption() ?><?php echo ($jogos->plataforma->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_edit->RightColumnClass ?>"><div<?php echo $jogos->plataforma->cellAttributes() ?>>
<span id="el_jogos_plataforma">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="jogos" data-field="x_plataforma" data-value-separator="<?php echo $jogos->plataforma->displayValueSeparatorAttribute() ?>" id="x_plataforma" name="x_plataforma"<?php echo $jogos->plataforma->editAttributes() ?>>
		<?php echo $jogos->plataforma->selectOptionListHtml("x_plataforma") ?>
	</select>
</div>
<?php echo $jogos->plataforma->Lookup->getParamTag("p_x_plataforma") ?>
</span>
<?php echo $jogos->plataforma->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($jogos->versao->Visible) { // versao ?>
	<div id="r_versao" class="form-group row">
		<label id="elh_jogos_versao" for="x_versao" class="<?php echo $jogos_edit->LeftColumnClass ?>"><?php echo $jogos->versao->caption() ?><?php echo ($jogos->versao->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_edit->RightColumnClass ?>"><div<?php echo $jogos->versao->cellAttributes() ?>>
<span id="el_jogos_versao">
<input type="text" data-table="jogos" data-field="x_versao" name="x_versao" id="x_versao" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($jogos->versao->getPlaceHolder()) ?>" value="<?php echo $jogos->versao->EditValue ?>"<?php echo $jogos->versao->editAttributes() ?>>
</span>
<?php echo $jogos->versao->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($jogos->responsavel->Visible) { // responsavel ?>
	<div id="r_responsavel" class="form-group row">
		<label id="elh_jogos_responsavel" for="x_responsavel" class="<?php echo $jogos_edit->LeftColumnClass ?>"><?php echo $jogos->responsavel->caption() ?><?php echo ($jogos->responsavel->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_edit->RightColumnClass ?>"><div<?php echo $jogos->responsavel->cellAttributes() ?>>
<span id="el_jogos_responsavel">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="jogos" data-field="x_responsavel" data-value-separator="<?php echo $jogos->responsavel->displayValueSeparatorAttribute() ?>" id="x_responsavel" name="x_responsavel"<?php echo $jogos->responsavel->editAttributes() ?>>
		<?php echo $jogos->responsavel->selectOptionListHtml("x_responsavel") ?>
	</select>
</div>
<?php echo $jogos->responsavel->Lookup->getParamTag("p_x_responsavel") ?>
</span>
<?php echo $jogos->responsavel->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$jogos_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $jogos_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $jogos_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$jogos_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$jogos_edit->terminate();
?>