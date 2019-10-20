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
$controle_versoes_add = new controle_versoes_add();

// Run the page
$controle_versoes_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$controle_versoes_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fcontrole_versoesadd = currentForm = new ew.Form("fcontrole_versoesadd", "add");

// Validate form
fcontrole_versoesadd.validate = function() {
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
		<?php if ($controle_versoes_add->jogo->Required) { ?>
			elm = this.getElements("x" + infix + "_jogo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $controle_versoes->jogo->caption(), $controle_versoes->jogo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($controle_versoes_add->versao->Required) { ?>
			elm = this.getElements("x" + infix + "_versao");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $controle_versoes->versao->caption(), $controle_versoes->versao->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($controle_versoes_add->repositorio->Required) { ?>
			elm = this.getElements("x" + infix + "_repositorio");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $controle_versoes->repositorio->caption(), $controle_versoes->repositorio->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($controle_versoes_add->estagio->Required) { ?>
			elm = this.getElements("x" + infix + "_estagio");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $controle_versoes->estagio->caption(), $controle_versoes->estagio->RequiredErrorMessage)) ?>");
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
fcontrole_versoesadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcontrole_versoesadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcontrole_versoesadd.lists["x_jogo"] = <?php echo $controle_versoes_add->jogo->Lookup->toClientList() ?>;
fcontrole_versoesadd.lists["x_jogo"].options = <?php echo JsonEncode($controle_versoes_add->jogo->lookupOptions()) ?>;
fcontrole_versoesadd.lists["x_estagio"] = <?php echo $controle_versoes_add->estagio->Lookup->toClientList() ?>;
fcontrole_versoesadd.lists["x_estagio"].options = <?php echo JsonEncode($controle_versoes_add->estagio->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $controle_versoes_add->showPageHeader(); ?>
<?php
$controle_versoes_add->showMessage();
?>
<form name="fcontrole_versoesadd" id="fcontrole_versoesadd" class="<?php echo $controle_versoes_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($controle_versoes_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $controle_versoes_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="controle_versoes">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$controle_versoes_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($controle_versoes->jogo->Visible) { // jogo ?>
	<div id="r_jogo" class="form-group row">
		<label id="elh_controle_versoes_jogo" for="x_jogo" class="<?php echo $controle_versoes_add->LeftColumnClass ?>"><?php echo $controle_versoes->jogo->caption() ?><?php echo ($controle_versoes->jogo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $controle_versoes_add->RightColumnClass ?>"><div<?php echo $controle_versoes->jogo->cellAttributes() ?>>
<span id="el_controle_versoes_jogo">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="controle_versoes" data-field="x_jogo" data-value-separator="<?php echo $controle_versoes->jogo->displayValueSeparatorAttribute() ?>" id="x_jogo" name="x_jogo"<?php echo $controle_versoes->jogo->editAttributes() ?>>
		<?php echo $controle_versoes->jogo->selectOptionListHtml("x_jogo") ?>
	</select>
</div>
<?php echo $controle_versoes->jogo->Lookup->getParamTag("p_x_jogo") ?>
</span>
<?php echo $controle_versoes->jogo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($controle_versoes->versao->Visible) { // versao ?>
	<div id="r_versao" class="form-group row">
		<label id="elh_controle_versoes_versao" for="x_versao" class="<?php echo $controle_versoes_add->LeftColumnClass ?>"><?php echo $controle_versoes->versao->caption() ?><?php echo ($controle_versoes->versao->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $controle_versoes_add->RightColumnClass ?>"><div<?php echo $controle_versoes->versao->cellAttributes() ?>>
<span id="el_controle_versoes_versao">
<input type="text" data-table="controle_versoes" data-field="x_versao" name="x_versao" id="x_versao" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($controle_versoes->versao->getPlaceHolder()) ?>" value="<?php echo $controle_versoes->versao->EditValue ?>"<?php echo $controle_versoes->versao->editAttributes() ?>>
</span>
<?php echo $controle_versoes->versao->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($controle_versoes->repositorio->Visible) { // repositorio ?>
	<div id="r_repositorio" class="form-group row">
		<label id="elh_controle_versoes_repositorio" for="x_repositorio" class="<?php echo $controle_versoes_add->LeftColumnClass ?>"><?php echo $controle_versoes->repositorio->caption() ?><?php echo ($controle_versoes->repositorio->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $controle_versoes_add->RightColumnClass ?>"><div<?php echo $controle_versoes->repositorio->cellAttributes() ?>>
<span id="el_controle_versoes_repositorio">
<input type="text" data-table="controle_versoes" data-field="x_repositorio" name="x_repositorio" id="x_repositorio" size="30" maxlength="150" placeholder="<?php echo HtmlEncode($controle_versoes->repositorio->getPlaceHolder()) ?>" value="<?php echo $controle_versoes->repositorio->EditValue ?>"<?php echo $controle_versoes->repositorio->editAttributes() ?>>
</span>
<?php echo $controle_versoes->repositorio->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($controle_versoes->estagio->Visible) { // estagio ?>
	<div id="r_estagio" class="form-group row">
		<label id="elh_controle_versoes_estagio" for="x_estagio" class="<?php echo $controle_versoes_add->LeftColumnClass ?>"><?php echo $controle_versoes->estagio->caption() ?><?php echo ($controle_versoes->estagio->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $controle_versoes_add->RightColumnClass ?>"><div<?php echo $controle_versoes->estagio->cellAttributes() ?>>
<span id="el_controle_versoes_estagio">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="controle_versoes" data-field="x_estagio" data-value-separator="<?php echo $controle_versoes->estagio->displayValueSeparatorAttribute() ?>" id="x_estagio" name="x_estagio"<?php echo $controle_versoes->estagio->editAttributes() ?>>
		<?php echo $controle_versoes->estagio->selectOptionListHtml("x_estagio") ?>
	</select>
</div>
<?php echo $controle_versoes->estagio->Lookup->getParamTag("p_x_estagio") ?>
</span>
<?php echo $controle_versoes->estagio->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$controle_versoes_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $controle_versoes_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $controle_versoes_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$controle_versoes_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$controle_versoes_add->terminate();
?>