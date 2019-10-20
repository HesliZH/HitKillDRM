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
$jogos_add = new jogos_add();

// Run the page
$jogos_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$jogos_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fjogosadd = currentForm = new ew.Form("fjogosadd", "add");

// Validate form
fjogosadd.validate = function() {
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
		<?php if ($jogos_add->nome->Required) { ?>
			elm = this.getElements("x" + infix + "_nome");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->nome->caption(), $jogos->nome->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($jogos_add->plataforma->Required) { ?>
			elm = this.getElements("x" + infix + "_plataforma");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $jogos->plataforma->caption(), $jogos->plataforma->RequiredErrorMessage)) ?>");
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
fjogosadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fjogosadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fjogosadd.lists["x_plataforma"] = <?php echo $jogos_add->plataforma->Lookup->toClientList() ?>;
fjogosadd.lists["x_plataforma"].options = <?php echo JsonEncode($jogos_add->plataforma->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $jogos_add->showPageHeader(); ?>
<?php
$jogos_add->showMessage();
?>
<form name="fjogosadd" id="fjogosadd" class="<?php echo $jogos_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($jogos_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $jogos_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="jogos">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$jogos_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($jogos->nome->Visible) { // nome ?>
	<div id="r_nome" class="form-group row">
		<label id="elh_jogos_nome" for="x_nome" class="<?php echo $jogos_add->LeftColumnClass ?>"><?php echo $jogos->nome->caption() ?><?php echo ($jogos->nome->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_add->RightColumnClass ?>"><div<?php echo $jogos->nome->cellAttributes() ?>>
<span id="el_jogos_nome">
<input type="text" data-table="jogos" data-field="x_nome" name="x_nome" id="x_nome" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($jogos->nome->getPlaceHolder()) ?>" value="<?php echo $jogos->nome->EditValue ?>"<?php echo $jogos->nome->editAttributes() ?>>
</span>
<?php echo $jogos->nome->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($jogos->plataforma->Visible) { // plataforma ?>
	<div id="r_plataforma" class="form-group row">
		<label id="elh_jogos_plataforma" for="x_plataforma" class="<?php echo $jogos_add->LeftColumnClass ?>"><?php echo $jogos->plataforma->caption() ?><?php echo ($jogos->plataforma->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $jogos_add->RightColumnClass ?>"><div<?php echo $jogos->plataforma->cellAttributes() ?>>
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
</div><!-- /page* -->
<?php if (!$jogos_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $jogos_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $jogos_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$jogos_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$jogos_add->terminate();
?>