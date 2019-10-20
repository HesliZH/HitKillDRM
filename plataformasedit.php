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
$plataformas_edit = new plataformas_edit();

// Run the page
$plataformas_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$plataformas_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fplataformasedit = currentForm = new ew.Form("fplataformasedit", "edit");

// Validate form
fplataformasedit.validate = function() {
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
		<?php if ($plataformas_edit->codigo->Required) { ?>
			elm = this.getElements("x" + infix + "_codigo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $plataformas->codigo->caption(), $plataformas->codigo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($plataformas_edit->descricao->Required) { ?>
			elm = this.getElements("x" + infix + "_descricao");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $plataformas->descricao->caption(), $plataformas->descricao->RequiredErrorMessage)) ?>");
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
fplataformasedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplataformasedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $plataformas_edit->showPageHeader(); ?>
<?php
$plataformas_edit->showMessage();
?>
<form name="fplataformasedit" id="fplataformasedit" class="<?php echo $plataformas_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($plataformas_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $plataformas_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="plataformas">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$plataformas_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($plataformas->codigo->Visible) { // codigo ?>
	<div id="r_codigo" class="form-group row">
		<label id="elh_plataformas_codigo" class="<?php echo $plataformas_edit->LeftColumnClass ?>"><?php echo $plataformas->codigo->caption() ?><?php echo ($plataformas->codigo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $plataformas_edit->RightColumnClass ?>"><div<?php echo $plataformas->codigo->cellAttributes() ?>>
<span id="el_plataformas_codigo">
<span<?php echo $plataformas->codigo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($plataformas->codigo->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="plataformas" data-field="x_codigo" name="x_codigo" id="x_codigo" value="<?php echo HtmlEncode($plataformas->codigo->CurrentValue) ?>">
<?php echo $plataformas->codigo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($plataformas->descricao->Visible) { // descricao ?>
	<div id="r_descricao" class="form-group row">
		<label id="elh_plataformas_descricao" for="x_descricao" class="<?php echo $plataformas_edit->LeftColumnClass ?>"><?php echo $plataformas->descricao->caption() ?><?php echo ($plataformas->descricao->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $plataformas_edit->RightColumnClass ?>"><div<?php echo $plataformas->descricao->cellAttributes() ?>>
<span id="el_plataformas_descricao">
<input type="text" data-table="plataformas" data-field="x_descricao" name="x_descricao" id="x_descricao" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($plataformas->descricao->getPlaceHolder()) ?>" value="<?php echo $plataformas->descricao->EditValue ?>"<?php echo $plataformas->descricao->editAttributes() ?>>
</span>
<?php echo $plataformas->descricao->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$plataformas_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $plataformas_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $plataformas_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$plataformas_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$plataformas_edit->terminate();
?>