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
$usuarios_add = new usuarios_add();

// Run the page
$usuarios_add->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "add";
var fusuariosadd = currentForm = new ew.Form("fusuariosadd", "add");

// Validate form
fusuariosadd.validate = function() {
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
		<?php if ($usuarios_add->nome_completo->Required) { ?>
			elm = this.getElements("x" + infix + "_nome_completo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $usuarios->nome_completo->caption(), $usuarios->nome_completo->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($usuarios_add->usuario->Required) { ?>
			elm = this.getElements("x" + infix + "_usuario");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $usuarios->usuario->caption(), $usuarios->usuario->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($usuarios_add->senha->Required) { ?>
			elm = this.getElements("x" + infix + "_senha");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $usuarios->senha->caption(), $usuarios->senha->RequiredErrorMessage)) ?>");
		<?php } ?>
		<?php if ($usuarios_add->cargo->Required) { ?>
			elm = this.getElements("x" + infix + "_cargo");
			if (elm && !ew.isHidden(elm) && !ew.hasValue(elm))
				return this.onError(elm, "<?php echo JsEncode(str_replace("%s", $usuarios->cargo->caption(), $usuarios->cargo->RequiredErrorMessage)) ?>");
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
fusuariosadd.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusuariosadd.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusuariosadd.lists["x_cargo"] = <?php echo $usuarios_add->cargo->Lookup->toClientList() ?>;
fusuariosadd.lists["x_cargo"].options = <?php echo JsonEncode($usuarios_add->cargo->lookupOptions()) ?>;

// Form object for search
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php $usuarios_add->showPageHeader(); ?>
<?php
$usuarios_add->showMessage();
?>
<form name="fusuariosadd" id="fusuariosadd" class="<?php echo $usuarios_add->FormClassName ?>" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($usuarios_add->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $usuarios_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?php echo (int)$usuarios_add->IsModal ?>">
<!-- Fields to prevent google autofill -->
<input class="d-none" type="text" name="<?php echo Encrypt(Random()) ?>">
<input class="d-none" type="password" name="<?php echo Encrypt(Random()) ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($usuarios->nome_completo->Visible) { // nome_completo ?>
	<div id="r_nome_completo" class="form-group row">
		<label id="elh_usuarios_nome_completo" for="x_nome_completo" class="<?php echo $usuarios_add->LeftColumnClass ?>"><?php echo $usuarios->nome_completo->caption() ?><?php echo ($usuarios->nome_completo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $usuarios_add->RightColumnClass ?>"><div<?php echo $usuarios->nome_completo->cellAttributes() ?>>
<span id="el_usuarios_nome_completo">
<input type="text" data-table="usuarios" data-field="x_nome_completo" name="x_nome_completo" id="x_nome_completo" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($usuarios->nome_completo->getPlaceHolder()) ?>" value="<?php echo $usuarios->nome_completo->EditValue ?>"<?php echo $usuarios->nome_completo->editAttributes() ?>>
</span>
<?php echo $usuarios->nome_completo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
	<div id="r_usuario" class="form-group row">
		<label id="elh_usuarios_usuario" for="x_usuario" class="<?php echo $usuarios_add->LeftColumnClass ?>"><?php echo $usuarios->usuario->caption() ?><?php echo ($usuarios->usuario->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $usuarios_add->RightColumnClass ?>"><div<?php echo $usuarios->usuario->cellAttributes() ?>>
<span id="el_usuarios_usuario">
<input type="text" data-table="usuarios" data-field="x_usuario" name="x_usuario" id="x_usuario" size="30" maxlength="50" placeholder="<?php echo HtmlEncode($usuarios->usuario->getPlaceHolder()) ?>" value="<?php echo $usuarios->usuario->EditValue ?>"<?php echo $usuarios->usuario->editAttributes() ?>>
</span>
<?php echo $usuarios->usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->senha->Visible) { // senha ?>
	<div id="r_senha" class="form-group row">
		<label id="elh_usuarios_senha" for="x_senha" class="<?php echo $usuarios_add->LeftColumnClass ?>"><?php echo $usuarios->senha->caption() ?><?php echo ($usuarios->senha->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $usuarios_add->RightColumnClass ?>"><div<?php echo $usuarios->senha->cellAttributes() ?>>
<span id="el_usuarios_senha">
<input type="text" data-table="usuarios" data-field="x_senha" name="x_senha" id="x_senha" size="30" maxlength="100" placeholder="<?php echo HtmlEncode($usuarios->senha->getPlaceHolder()) ?>" value="<?php echo $usuarios->senha->EditValue ?>"<?php echo $usuarios->senha->editAttributes() ?>>
</span>
<?php echo $usuarios->senha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($usuarios->cargo->Visible) { // cargo ?>
	<div id="r_cargo" class="form-group row">
		<label id="elh_usuarios_cargo" for="x_cargo" class="<?php echo $usuarios_add->LeftColumnClass ?>"><?php echo $usuarios->cargo->caption() ?><?php echo ($usuarios->cargo->Required) ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
		<div class="<?php echo $usuarios_add->RightColumnClass ?>"><div<?php echo $usuarios->cargo->cellAttributes() ?>>
<span id="el_usuarios_cargo">
<div class="input-group">
	<select class="custom-select ew-custom-select" data-table="usuarios" data-field="x_cargo" data-value-separator="<?php echo $usuarios->cargo->displayValueSeparatorAttribute() ?>" id="x_cargo" name="x_cargo"<?php echo $usuarios->cargo->editAttributes() ?>>
		<?php echo $usuarios->cargo->selectOptionListHtml("x_cargo") ?>
	</select>
</div>
<?php echo $usuarios->cargo->Lookup->getParamTag("p_x_cargo") ?>
</span>
<?php echo $usuarios->cargo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$usuarios_add->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
	<div class="<?php echo $usuarios_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?php echo $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?php echo $usuarios_add->getReturnUrl() ?>"><?php echo $Language->phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$usuarios_add->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$usuarios_add->terminate();
?>