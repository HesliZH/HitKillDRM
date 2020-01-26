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
$controle_versoes_list = new controle_versoes_list();

// Run the page
$controle_versoes_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$controle_versoes_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$controle_versoes->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fcontrole_versoeslist = currentForm = new ew.Form("fcontrole_versoeslist", "list");
fcontrole_versoeslist.formKeyCountName = '<?php echo $controle_versoes_list->FormKeyCountName ?>';

// Form_CustomValidate event
fcontrole_versoeslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcontrole_versoeslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fcontrole_versoeslist.lists["x_jogo"] = <?php echo $controle_versoes_list->jogo->Lookup->toClientList() ?>;
fcontrole_versoeslist.lists["x_jogo"].options = <?php echo JsonEncode($controle_versoes_list->jogo->lookupOptions()) ?>;
fcontrole_versoeslist.lists["x_estagio"] = <?php echo $controle_versoes_list->estagio->Lookup->toClientList() ?>;
fcontrole_versoeslist.lists["x_estagio"].options = <?php echo JsonEncode($controle_versoes_list->estagio->lookupOptions()) ?>;

// Form object for search
var fcontrole_versoeslistsrch = currentSearchForm = new ew.Form("fcontrole_versoeslistsrch");

// Filters
fcontrole_versoeslistsrch.filterList = <?php echo $controle_versoes_list->getFilterList() ?>;
</script>
<style type="text/css">
.ew-table-preview-row { /* main table preview row color */
	background-color: #FFFFFF; /* preview row color */
}
.ew-table-preview-row .ew-grid {
	display: table;
}
</style>
<div id="ew-preview" class="d-none"><!-- preview -->
	<div class="ew-nav-tabs"><!-- .ew-nav-tabs -->
		<ul class="nav nav-tabs"></ul>
		<div class="tab-content"><!-- .tab-content -->
			<div class="tab-pane fade active show"></div>
		</div><!-- /.tab-content -->
	</div><!-- /.ew-nav-tabs -->
</div><!-- /preview -->
<script src="phpjs/ewpreview.js"></script>
<script>
ew.PREVIEW_PLACEMENT = ew.CSS_FLIP ? "right" : "left";
ew.PREVIEW_SINGLE_ROW = false;
ew.PREVIEW_OVERLAY = false;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$controle_versoes->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($controle_versoes_list->TotalRecs > 0 && $controle_versoes_list->ExportOptions->visible()) { ?>
<?php $controle_versoes_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($controle_versoes_list->ImportOptions->visible()) { ?>
<?php $controle_versoes_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($controle_versoes_list->SearchOptions->visible()) { ?>
<?php $controle_versoes_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($controle_versoes_list->FilterOptions->visible()) { ?>
<?php $controle_versoes_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$controle_versoes_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$controle_versoes->isExport() && !$controle_versoes->CurrentAction) { ?>
<form name="fcontrole_versoeslistsrch" id="fcontrole_versoeslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($controle_versoes_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fcontrole_versoeslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="controle_versoes">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($controle_versoes_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($controle_versoes_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $controle_versoes_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($controle_versoes_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($controle_versoes_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($controle_versoes_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($controle_versoes_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $controle_versoes_list->showPageHeader(); ?>
<?php
$controle_versoes_list->showMessage();
?>
<?php if ($controle_versoes_list->TotalRecs > 0 || $controle_versoes->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($controle_versoes_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> controle_versoes">
<form name="fcontrole_versoeslist" id="fcontrole_versoeslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($controle_versoes_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $controle_versoes_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="controle_versoes">
<div id="gmp_controle_versoes" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($controle_versoes_list->TotalRecs > 0 || $controle_versoes->isGridEdit()) { ?>
<table id="tbl_controle_versoeslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$controle_versoes_list->RowType = ROWTYPE_HEADER;

// Render list options
$controle_versoes_list->renderListOptions();

// Render list options (header, left)
$controle_versoes_list->ListOptions->render("header", "left");
?>
<?php if ($controle_versoes->codigo->Visible) { // codigo ?>
	<?php if ($controle_versoes->sortUrl($controle_versoes->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $controle_versoes->codigo->headerCellClass() ?>"><div id="elh_controle_versoes_codigo" class="controle_versoes_codigo"><div class="ew-table-header-caption"><?php echo $controle_versoes->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $controle_versoes->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $controle_versoes->SortUrl($controle_versoes->codigo) ?>',1);"><div id="elh_controle_versoes_codigo" class="controle_versoes_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $controle_versoes->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($controle_versoes->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($controle_versoes->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($controle_versoes->jogo->Visible) { // jogo ?>
	<?php if ($controle_versoes->sortUrl($controle_versoes->jogo) == "") { ?>
		<th data-name="jogo" class="<?php echo $controle_versoes->jogo->headerCellClass() ?>"><div id="elh_controle_versoes_jogo" class="controle_versoes_jogo"><div class="ew-table-header-caption"><?php echo $controle_versoes->jogo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jogo" class="<?php echo $controle_versoes->jogo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $controle_versoes->SortUrl($controle_versoes->jogo) ?>',1);"><div id="elh_controle_versoes_jogo" class="controle_versoes_jogo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $controle_versoes->jogo->caption() ?></span><span class="ew-table-header-sort"><?php if ($controle_versoes->jogo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($controle_versoes->jogo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($controle_versoes->versao->Visible) { // versao ?>
	<?php if ($controle_versoes->sortUrl($controle_versoes->versao) == "") { ?>
		<th data-name="versao" class="<?php echo $controle_versoes->versao->headerCellClass() ?>"><div id="elh_controle_versoes_versao" class="controle_versoes_versao"><div class="ew-table-header-caption"><?php echo $controle_versoes->versao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="versao" class="<?php echo $controle_versoes->versao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $controle_versoes->SortUrl($controle_versoes->versao) ?>',1);"><div id="elh_controle_versoes_versao" class="controle_versoes_versao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $controle_versoes->versao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($controle_versoes->versao->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($controle_versoes->versao->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($controle_versoes->repositorio->Visible) { // repositorio ?>
	<?php if ($controle_versoes->sortUrl($controle_versoes->repositorio) == "") { ?>
		<th data-name="repositorio" class="<?php echo $controle_versoes->repositorio->headerCellClass() ?>"><div id="elh_controle_versoes_repositorio" class="controle_versoes_repositorio"><div class="ew-table-header-caption"><?php echo $controle_versoes->repositorio->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="repositorio" class="<?php echo $controle_versoes->repositorio->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $controle_versoes->SortUrl($controle_versoes->repositorio) ?>',1);"><div id="elh_controle_versoes_repositorio" class="controle_versoes_repositorio">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $controle_versoes->repositorio->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($controle_versoes->repositorio->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($controle_versoes->repositorio->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($controle_versoes->estagio->Visible) { // estagio ?>
	<?php if ($controle_versoes->sortUrl($controle_versoes->estagio) == "") { ?>
		<th data-name="estagio" class="<?php echo $controle_versoes->estagio->headerCellClass() ?>"><div id="elh_controle_versoes_estagio" class="controle_versoes_estagio"><div class="ew-table-header-caption"><?php echo $controle_versoes->estagio->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estagio" class="<?php echo $controle_versoes->estagio->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $controle_versoes->SortUrl($controle_versoes->estagio) ?>',1);"><div id="elh_controle_versoes_estagio" class="controle_versoes_estagio">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $controle_versoes->estagio->caption() ?></span><span class="ew-table-header-sort"><?php if ($controle_versoes->estagio->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($controle_versoes->estagio->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$controle_versoes_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($controle_versoes->ExportAll && $controle_versoes->isExport()) {
	$controle_versoes_list->StopRec = $controle_versoes_list->TotalRecs;
} else {

	// Set the last record to display
	if ($controle_versoes_list->TotalRecs > $controle_versoes_list->StartRec + $controle_versoes_list->DisplayRecs - 1)
		$controle_versoes_list->StopRec = $controle_versoes_list->StartRec + $controle_versoes_list->DisplayRecs - 1;
	else
		$controle_versoes_list->StopRec = $controle_versoes_list->TotalRecs;
}
$controle_versoes_list->RecCnt = $controle_versoes_list->StartRec - 1;
if ($controle_versoes_list->Recordset && !$controle_versoes_list->Recordset->EOF) {
	$controle_versoes_list->Recordset->moveFirst();
	$selectLimit = $controle_versoes_list->UseSelectLimit;
	if (!$selectLimit && $controle_versoes_list->StartRec > 1)
		$controle_versoes_list->Recordset->move($controle_versoes_list->StartRec - 1);
} elseif (!$controle_versoes->AllowAddDeleteRow && $controle_versoes_list->StopRec == 0) {
	$controle_versoes_list->StopRec = $controle_versoes->GridAddRowCount;
}

// Initialize aggregate
$controle_versoes->RowType = ROWTYPE_AGGREGATEINIT;
$controle_versoes->resetAttributes();
$controle_versoes_list->renderRow();
while ($controle_versoes_list->RecCnt < $controle_versoes_list->StopRec) {
	$controle_versoes_list->RecCnt++;
	if ($controle_versoes_list->RecCnt >= $controle_versoes_list->StartRec) {
		$controle_versoes_list->RowCnt++;

		// Set up key count
		$controle_versoes_list->KeyCount = $controle_versoes_list->RowIndex;

		// Init row class and style
		$controle_versoes->resetAttributes();
		$controle_versoes->CssClass = "";
		if ($controle_versoes->isGridAdd()) {
		} else {
			$controle_versoes_list->loadRowValues($controle_versoes_list->Recordset); // Load row values
		}
		$controle_versoes->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$controle_versoes->RowAttrs = array_merge($controle_versoes->RowAttrs, array('data-rowindex'=>$controle_versoes_list->RowCnt, 'id'=>'r' . $controle_versoes_list->RowCnt . '_controle_versoes', 'data-rowtype'=>$controle_versoes->RowType));

		// Render row
		$controle_versoes_list->renderRow();

		// Render list options
		$controle_versoes_list->renderListOptions();
?>
	<tr<?php echo $controle_versoes->rowAttributes() ?>>
<?php

// Render list options (body, left)
$controle_versoes_list->ListOptions->render("body", "left", $controle_versoes_list->RowCnt);
?>
	<?php if ($controle_versoes->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $controle_versoes->codigo->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_list->RowCnt ?>_controle_versoes_codigo" class="controle_versoes_codigo">
<span<?php echo $controle_versoes->codigo->viewAttributes() ?>>
<?php echo $controle_versoes->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($controle_versoes->jogo->Visible) { // jogo ?>
		<td data-name="jogo"<?php echo $controle_versoes->jogo->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_list->RowCnt ?>_controle_versoes_jogo" class="controle_versoes_jogo">
<span<?php echo $controle_versoes->jogo->viewAttributes() ?>>
<?php echo $controle_versoes->jogo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($controle_versoes->versao->Visible) { // versao ?>
		<td data-name="versao"<?php echo $controle_versoes->versao->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_list->RowCnt ?>_controle_versoes_versao" class="controle_versoes_versao">
<span<?php echo $controle_versoes->versao->viewAttributes() ?>>
<?php echo $controle_versoes->versao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($controle_versoes->repositorio->Visible) { // repositorio ?>
		<td data-name="repositorio"<?php echo $controle_versoes->repositorio->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_list->RowCnt ?>_controle_versoes_repositorio" class="controle_versoes_repositorio">
<span<?php echo $controle_versoes->repositorio->viewAttributes() ?>>
<?php echo $controle_versoes->repositorio->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($controle_versoes->estagio->Visible) { // estagio ?>
		<td data-name="estagio"<?php echo $controle_versoes->estagio->cellAttributes() ?>>
<span id="el<?php echo $controle_versoes_list->RowCnt ?>_controle_versoes_estagio" class="controle_versoes_estagio">
<span<?php echo $controle_versoes->estagio->viewAttributes() ?>>
<?php echo $controle_versoes->estagio->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$controle_versoes_list->ListOptions->render("body", "right", $controle_versoes_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$controle_versoes->isGridAdd())
		$controle_versoes_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$controle_versoes->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($controle_versoes_list->Recordset)
	$controle_versoes_list->Recordset->Close();
?>
<?php if (!$controle_versoes->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$controle_versoes->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($controle_versoes_list->Pager)) $controle_versoes_list->Pager = new PrevNextPager($controle_versoes_list->StartRec, $controle_versoes_list->DisplayRecs, $controle_versoes_list->TotalRecs, $controle_versoes_list->AutoHidePager) ?>
<?php if ($controle_versoes_list->Pager->RecordCount > 0 && $controle_versoes_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($controle_versoes_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $controle_versoes_list->pageUrl() ?>start=<?php echo $controle_versoes_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($controle_versoes_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $controle_versoes_list->pageUrl() ?>start=<?php echo $controle_versoes_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $controle_versoes_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($controle_versoes_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $controle_versoes_list->pageUrl() ?>start=<?php echo $controle_versoes_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($controle_versoes_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $controle_versoes_list->pageUrl() ?>start=<?php echo $controle_versoes_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $controle_versoes_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($controle_versoes_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $controle_versoes_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $controle_versoes_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $controle_versoes_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $controle_versoes_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($controle_versoes_list->TotalRecs == 0 && !$controle_versoes->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $controle_versoes_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$controle_versoes_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$controle_versoes->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$controle_versoes_list->terminate();
?>