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
$usuarios_list = new usuarios_list();

// Run the page
$usuarios_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$usuarios_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$usuarios->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fusuarioslist = currentForm = new ew.Form("fusuarioslist", "list");
fusuarioslist.formKeyCountName = '<?php echo $usuarios_list->FormKeyCountName ?>';

// Form_CustomValidate event
fusuarioslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fusuarioslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fusuarioslist.lists["x_cargo"] = <?php echo $usuarios_list->cargo->Lookup->toClientList() ?>;
fusuarioslist.lists["x_cargo"].options = <?php echo JsonEncode($usuarios_list->cargo->lookupOptions()) ?>;

// Form object for search
var fusuarioslistsrch = currentSearchForm = new ew.Form("fusuarioslistsrch");

// Filters
fusuarioslistsrch.filterList = <?php echo $usuarios_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$usuarios->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($usuarios_list->TotalRecs > 0 && $usuarios_list->ExportOptions->visible()) { ?>
<?php $usuarios_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($usuarios_list->ImportOptions->visible()) { ?>
<?php $usuarios_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($usuarios_list->SearchOptions->visible()) { ?>
<?php $usuarios_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($usuarios_list->FilterOptions->visible()) { ?>
<?php $usuarios_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$usuarios_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$usuarios->isExport() && !$usuarios->CurrentAction) { ?>
<form name="fusuarioslistsrch" id="fusuarioslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($usuarios_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fusuarioslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="usuarios">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($usuarios_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($usuarios_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $usuarios_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($usuarios_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($usuarios_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($usuarios_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($usuarios_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $usuarios_list->showPageHeader(); ?>
<?php
$usuarios_list->showMessage();
?>
<?php if ($usuarios_list->TotalRecs > 0 || $usuarios->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($usuarios_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> usuarios">
<form name="fusuarioslist" id="fusuarioslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($usuarios_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $usuarios_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="usuarios">
<div id="gmp_usuarios" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($usuarios_list->TotalRecs > 0 || $usuarios->isGridEdit()) { ?>
<table id="tbl_usuarioslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$usuarios_list->RowType = ROWTYPE_HEADER;

// Render list options
$usuarios_list->renderListOptions();

// Render list options (header, left)
$usuarios_list->ListOptions->render("header", "left");
?>
<?php if ($usuarios->codigo->Visible) { // codigo ?>
	<?php if ($usuarios->sortUrl($usuarios->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $usuarios->codigo->headerCellClass() ?>"><div id="elh_usuarios_codigo" class="usuarios_codigo"><div class="ew-table-header-caption"><?php echo $usuarios->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $usuarios->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $usuarios->SortUrl($usuarios->codigo) ?>',1);"><div id="elh_usuarios_codigo" class="usuarios_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $usuarios->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($usuarios->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($usuarios->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($usuarios->nome_completo->Visible) { // nome_completo ?>
	<?php if ($usuarios->sortUrl($usuarios->nome_completo) == "") { ?>
		<th data-name="nome_completo" class="<?php echo $usuarios->nome_completo->headerCellClass() ?>"><div id="elh_usuarios_nome_completo" class="usuarios_nome_completo"><div class="ew-table-header-caption"><?php echo $usuarios->nome_completo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome_completo" class="<?php echo $usuarios->nome_completo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $usuarios->SortUrl($usuarios->nome_completo) ?>',1);"><div id="elh_usuarios_nome_completo" class="usuarios_nome_completo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $usuarios->nome_completo->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($usuarios->nome_completo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($usuarios->nome_completo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($usuarios->usuario->Visible) { // usuario ?>
	<?php if ($usuarios->sortUrl($usuarios->usuario) == "") { ?>
		<th data-name="usuario" class="<?php echo $usuarios->usuario->headerCellClass() ?>"><div id="elh_usuarios_usuario" class="usuarios_usuario"><div class="ew-table-header-caption"><?php echo $usuarios->usuario->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="usuario" class="<?php echo $usuarios->usuario->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $usuarios->SortUrl($usuarios->usuario) ?>',1);"><div id="elh_usuarios_usuario" class="usuarios_usuario">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $usuarios->usuario->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($usuarios->usuario->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($usuarios->usuario->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($usuarios->senha->Visible) { // senha ?>
	<?php if ($usuarios->sortUrl($usuarios->senha) == "") { ?>
		<th data-name="senha" class="<?php echo $usuarios->senha->headerCellClass() ?>"><div id="elh_usuarios_senha" class="usuarios_senha"><div class="ew-table-header-caption"><?php echo $usuarios->senha->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="senha" class="<?php echo $usuarios->senha->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $usuarios->SortUrl($usuarios->senha) ?>',1);"><div id="elh_usuarios_senha" class="usuarios_senha">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $usuarios->senha->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($usuarios->senha->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($usuarios->senha->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($usuarios->cargo->Visible) { // cargo ?>
	<?php if ($usuarios->sortUrl($usuarios->cargo) == "") { ?>
		<th data-name="cargo" class="<?php echo $usuarios->cargo->headerCellClass() ?>"><div id="elh_usuarios_cargo" class="usuarios_cargo"><div class="ew-table-header-caption"><?php echo $usuarios->cargo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="cargo" class="<?php echo $usuarios->cargo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $usuarios->SortUrl($usuarios->cargo) ?>',1);"><div id="elh_usuarios_cargo" class="usuarios_cargo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $usuarios->cargo->caption() ?></span><span class="ew-table-header-sort"><?php if ($usuarios->cargo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($usuarios->cargo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$usuarios_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($usuarios->ExportAll && $usuarios->isExport()) {
	$usuarios_list->StopRec = $usuarios_list->TotalRecs;
} else {

	// Set the last record to display
	if ($usuarios_list->TotalRecs > $usuarios_list->StartRec + $usuarios_list->DisplayRecs - 1)
		$usuarios_list->StopRec = $usuarios_list->StartRec + $usuarios_list->DisplayRecs - 1;
	else
		$usuarios_list->StopRec = $usuarios_list->TotalRecs;
}
$usuarios_list->RecCnt = $usuarios_list->StartRec - 1;
if ($usuarios_list->Recordset && !$usuarios_list->Recordset->EOF) {
	$usuarios_list->Recordset->moveFirst();
	$selectLimit = $usuarios_list->UseSelectLimit;
	if (!$selectLimit && $usuarios_list->StartRec > 1)
		$usuarios_list->Recordset->move($usuarios_list->StartRec - 1);
} elseif (!$usuarios->AllowAddDeleteRow && $usuarios_list->StopRec == 0) {
	$usuarios_list->StopRec = $usuarios->GridAddRowCount;
}

// Initialize aggregate
$usuarios->RowType = ROWTYPE_AGGREGATEINIT;
$usuarios->resetAttributes();
$usuarios_list->renderRow();
while ($usuarios_list->RecCnt < $usuarios_list->StopRec) {
	$usuarios_list->RecCnt++;
	if ($usuarios_list->RecCnt >= $usuarios_list->StartRec) {
		$usuarios_list->RowCnt++;

		// Set up key count
		$usuarios_list->KeyCount = $usuarios_list->RowIndex;

		// Init row class and style
		$usuarios->resetAttributes();
		$usuarios->CssClass = "";
		if ($usuarios->isGridAdd()) {
		} else {
			$usuarios_list->loadRowValues($usuarios_list->Recordset); // Load row values
		}
		$usuarios->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$usuarios->RowAttrs = array_merge($usuarios->RowAttrs, array('data-rowindex'=>$usuarios_list->RowCnt, 'id'=>'r' . $usuarios_list->RowCnt . '_usuarios', 'data-rowtype'=>$usuarios->RowType));

		// Render row
		$usuarios_list->renderRow();

		// Render list options
		$usuarios_list->renderListOptions();
?>
	<tr<?php echo $usuarios->rowAttributes() ?>>
<?php

// Render list options (body, left)
$usuarios_list->ListOptions->render("body", "left", $usuarios_list->RowCnt);
?>
	<?php if ($usuarios->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $usuarios->codigo->cellAttributes() ?>>
<span id="el<?php echo $usuarios_list->RowCnt ?>_usuarios_codigo" class="usuarios_codigo">
<span<?php echo $usuarios->codigo->viewAttributes() ?>>
<?php echo $usuarios->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($usuarios->nome_completo->Visible) { // nome_completo ?>
		<td data-name="nome_completo"<?php echo $usuarios->nome_completo->cellAttributes() ?>>
<span id="el<?php echo $usuarios_list->RowCnt ?>_usuarios_nome_completo" class="usuarios_nome_completo">
<span<?php echo $usuarios->nome_completo->viewAttributes() ?>>
<?php echo $usuarios->nome_completo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($usuarios->usuario->Visible) { // usuario ?>
		<td data-name="usuario"<?php echo $usuarios->usuario->cellAttributes() ?>>
<span id="el<?php echo $usuarios_list->RowCnt ?>_usuarios_usuario" class="usuarios_usuario">
<span<?php echo $usuarios->usuario->viewAttributes() ?>>
<?php echo $usuarios->usuario->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($usuarios->senha->Visible) { // senha ?>
		<td data-name="senha"<?php echo $usuarios->senha->cellAttributes() ?>>
<span id="el<?php echo $usuarios_list->RowCnt ?>_usuarios_senha" class="usuarios_senha">
<span<?php echo $usuarios->senha->viewAttributes() ?>>
<?php echo $usuarios->senha->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($usuarios->cargo->Visible) { // cargo ?>
		<td data-name="cargo"<?php echo $usuarios->cargo->cellAttributes() ?>>
<span id="el<?php echo $usuarios_list->RowCnt ?>_usuarios_cargo" class="usuarios_cargo">
<span<?php echo $usuarios->cargo->viewAttributes() ?>>
<?php echo $usuarios->cargo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$usuarios_list->ListOptions->render("body", "right", $usuarios_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$usuarios->isGridAdd())
		$usuarios_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$usuarios->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($usuarios_list->Recordset)
	$usuarios_list->Recordset->Close();
?>
<?php if (!$usuarios->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$usuarios->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($usuarios_list->Pager)) $usuarios_list->Pager = new PrevNextPager($usuarios_list->StartRec, $usuarios_list->DisplayRecs, $usuarios_list->TotalRecs, $usuarios_list->AutoHidePager) ?>
<?php if ($usuarios_list->Pager->RecordCount > 0 && $usuarios_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($usuarios_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $usuarios_list->pageUrl() ?>start=<?php echo $usuarios_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($usuarios_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $usuarios_list->pageUrl() ?>start=<?php echo $usuarios_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $usuarios_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($usuarios_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $usuarios_list->pageUrl() ?>start=<?php echo $usuarios_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($usuarios_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $usuarios_list->pageUrl() ?>start=<?php echo $usuarios_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $usuarios_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($usuarios_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $usuarios_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $usuarios_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $usuarios_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $usuarios_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($usuarios_list->TotalRecs == 0 && !$usuarios->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $usuarios_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$usuarios_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$usuarios->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$usuarios_list->terminate();
?>