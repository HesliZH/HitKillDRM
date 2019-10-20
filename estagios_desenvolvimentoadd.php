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
$estagios_desenvolvimento_add = new estagios_desenvolvimento_add();

// Run the page
$estagios_desenvolvimento_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estagios_desenvolvimento_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var festagios_desenvolvimentoadd = currentForm = new ew.Form("festagios_desenvolvimentoadd", "add");

// Validate form
festagios_desenvolvimentoadd.validate = function() {
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
		<?php if ($estagios_desenvolvimento_add->descricao->Required) { ?>
			elm = this.getElements("x" + infix + "_descricao");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $estagios_desenvolvimento->descricao->caption(), $estagios_desenvolvimento->descricao->RequiredErrorMessage)) ?>");
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
festagios_desenvolvimentoadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
festagios_desenvolvimentoadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $estagios_desenvolvimento_add->showPageHeader(); ?>
<?php
$estagios_desenvolvimento_add->showMessage();
?>
<form name="festagios_desenvolvimentoadd" id="festagios_desenvolvimentoadd" class="<?php echo $estagios_desenvolvimento_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($estagios_desenvolvimento_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $estagios_desenvolvimento_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estagios_desenvolvimento">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$estagios_desenvolvimento_add->IsModal ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($estagios_desenvolvimento->descricao->Visible) { // descricao ?>
	<div id="r_descricao" class="form-group row">
		<label id="elh_estagios_desenvolvimento_descricao" for="x_descricao" class="<?php echo $estagios_desenvolvimento_add->LeftColumnClass ?>"><?php echo $estagios_desenvolvimento->descricao->caption() ?><?php echo ($estagios_desenvolvimento->descricao->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $estagios_desenvolvimento_add->RightColumnClass ?>"><div<?php echo $estagios_desenvolvimento->descricao->cellAttributes() ?>>
<span id="el_estagios_desenvolvimento_descricao">
<input type="text" data-table="estagios_desenvolvimento" data-field="x_descricao" name="x_descricao" id="x_descricao" size="30" maxlength="20" placeholder="<?php echo HtmlEncode($estagios_desenvolvimento->descricao->getPlaceHolder()) ?>" value="<?php echo $estagios_desenvolvimento->descricao->EditValue ?>"<?php echo $estagios_desenvolvimento->descricao->editAttributes() ?>>
</span>
<?php echo $estagios_desenvolvimento->descricao->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$estagios_desenvolvimento_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $estagios_desenvolvimento_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $estagios_desenvolvimento_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$estagios_desenvolvimento_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estagios_desenvolvimento_add->terminate();
?>