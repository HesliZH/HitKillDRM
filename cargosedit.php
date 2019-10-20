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
$cargos_edit = new cargos_edit();

// Run the page
$cargos_edit->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cargos_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "edit";
var fcargosedit = currentForm = new ew.Form("fcargosedit", "edit");

// Validate form
fcargosedit.validate = function() {
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
		<?php if ($cargos_edit->codigo->Required) { ?>
			elm = this.getElements("x" + infix + "_codigo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $cargos->codigo->caption(), $cargos->codigo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($cargos_edit->descricao->Required) { ?>
			elm = this.getElements("x" + infix + "_descricao");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $cargos->descricao->caption(), $cargos->descricao->RequiredErrorMessage)) ?>");
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
fcargosedit.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcargosedit.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $cargos_edit->showPageHeader(); ?>
<?php
$cargos_edit->showMessage();
?>
<form name="fcargosedit" id="fcargosedit" class="<?php echo $cargos_edit->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($cargos_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $cargos_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cargos">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?php echo (int)$cargos_edit->IsModal ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($cargos->codigo->Visible) { // codigo ?>
	<div id="r_codigo" class="form-group row">
		<label id="elh_cargos_codigo" class="<?php echo $cargos_edit->LeftColumnClass ?>"><?php echo $cargos->codigo->caption() ?><?php echo ($cargos->codigo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $cargos_edit->RightColumnClass ?>"><div<?php echo $cargos->codigo->cellAttributes() ?>>
<span id="el_cargos_codigo">
<span<?php echo $cargos->codigo->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?php echo RemoveHtml($cargos->codigo->EditValue) ?>"></span>
</span>
<input type="hidden" data-table="cargos" data-field="x_codigo" name="x_codigo" id="x_codigo" value="<?php echo HtmlEncode($cargos->codigo->CurrentValue) ?>">
<?php echo $cargos->codigo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cargos->descricao->Visible) { // descricao ?>
	<div id="r_descricao" class="form-group row">
		<label id="elh_cargos_descricao" for="x_descricao" class="<?php echo $cargos_edit->LeftColumnClass ?>"><?php echo $cargos->descricao->caption() ?><?php echo ($cargos->descricao->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $cargos_edit->RightColumnClass ?>"><div<?php echo $cargos->descricao->cellAttributes() ?>>
<span id="el_cargos_descricao">
<input type="text" data-table="cargos" data-field="x_descricao" name="x_descricao" id="x_descricao" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($cargos->descricao->getPlaceHolder()) ?>" value="<?php echo $cargos->descricao->EditValue ?>"<?php echo $cargos->descricao->editAttributes() ?>>
</span>
<?php echo $cargos->descricao->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$cargos_edit->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $cargos_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $cargos_edit->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$cargos_edit->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cargos_edit->terminate();
?>