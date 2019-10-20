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
$plataformas_list = new plataformas_list();

// Run the page
$plataformas_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$plataformas_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$plataformas->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fplataformaslist = currentForm = new ew.Form("fplataformaslist", "list");
fplataformaslist.formKeyCountName = '<?php echo $plataformas_list->FormKeyCountName ?>';

// Form_CustomValidate event
fplataformaslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplataformaslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fplataformaslistsrch = currentSearchForm = new ew.Form("fplataformaslistsrch");

// Filters
fplataformaslistsrch.filterList = <?php echo $plataformas_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$plataformas->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($plataformas_list->TotalRecs > 0 && $plataformas_list->ExportOptions->visible()) { ?>
<?php $plataformas_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($plataformas_list->ImportOptions->visible()) { ?>
<?php $plataformas_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($plataformas_list->SearchOptions->visible()) { ?>
<?php $plataformas_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($plataformas_list->FilterOptions->visible()) { ?>
<?php $plataformas_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$plataformas_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$plataformas->isExport() && !$plataformas->CurrentAction) { ?>
<form name="fplataformaslistsrch" id="fplataformaslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($plataformas_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fplataformaslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="plataformas">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($plataformas_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($plataformas_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $plataformas_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($plataformas_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($plataformas_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($plataformas_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($plataformas_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $plataformas_list->showPageHeader(); ?>
<?php
$plataformas_list->showMessage();
?>
<?php if ($plataformas_list->TotalRecs > 0 || $plataformas->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($plataformas_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> plataformas">
<form name="fplataformaslist" id="fplataformaslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($plataformas_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $plataformas_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="plataformas">
<div id="gmp_plataformas" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($plataformas_list->TotalRecs > 0 || $plataformas->isGridEdit()) { ?>
<table id="tbl_plataformaslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$plataformas_list->RowType = ROWTYPE_HEADER;

// Render list options
$plataformas_list->renderListOptions();

// Render list options (header, left)
$plataformas_list->ListOptions->render("header", "left");
?>
<?php if ($plataformas->codigo->Visible) { // codigo ?>
	<?php if ($plataformas->sortUrl($plataformas->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $plataformas->codigo->headerCellClass() ?>"><div id="elh_plataformas_codigo" class="plataformas_codigo"><div class="ew-table-header-caption"><?php echo $plataformas->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $plataformas->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $plataformas->SortUrl($plataformas->codigo) ?>',1);"><div id="elh_plataformas_codigo" class="plataformas_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $plataformas->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($plataformas->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($plataformas->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($plataformas->descricao->Visible) { // descricao ?>
	<?php if ($plataformas->sortUrl($plataformas->descricao) == "") { ?>
		<th data-name="descricao" class="<?php echo $plataformas->descricao->headerCellClass() ?>"><div id="elh_plataformas_descricao" class="plataformas_descricao"><div class="ew-table-header-caption"><?php echo $plataformas->descricao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descricao" class="<?php echo $plataformas->descricao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $plataformas->SortUrl($plataformas->descricao) ?>',1);"><div id="elh_plataformas_descricao" class="plataformas_descricao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $plataformas->descricao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($plataformas->descricao->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($plataformas->descricao->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$plataformas_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($plataformas->ExportAll && $plataformas->isExport()) {
	$plataformas_list->StopRec = $plataformas_list->TotalRecs;
} else {

	// Set the last record to display
	if ($plataformas_list->TotalRecs > $plataformas_list->StartRec + $plataformas_list->DisplayRecs - 1)
		$plataformas_list->StopRec = $plataformas_list->StartRec + $plataformas_list->DisplayRecs - 1;
	else
		$plataformas_list->StopRec = $plataformas_list->TotalRecs;
}
$plataformas_list->RecCnt = $plataformas_list->StartRec - 1;
if ($plataformas_list->Recordset && !$plataformas_list->Recordset->EOF) {
	$plataformas_list->Recordset->moveFirst();
	$selectLimit = $plataformas_list->UseSelectLimit;
	if (!$selectLimit && $plataformas_list->StartRec > 1)
		$plataformas_list->Recordset->move($plataformas_list->StartRec - 1);
} elseif (!$plataformas->AllowAddDeleteRow && $plataformas_list->StopRec == 0) {
	$plataformas_list->StopRec = $plataformas->GridAddRowCount;
}

// Initialize aggregate
$plataformas->RowType = ROWTYPE_AGGREGATEINIT;
$plataformas->resetAttributes();
$plataformas_list->renderRow();
while ($plataformas_list->RecCnt < $plataformas_list->StopRec) {
	$plataformas_list->RecCnt++;
	if ($plataformas_list->RecCnt >= $plataformas_list->StartRec) {
		$plataformas_list->RowCnt++;

		// Set up key count
		$plataformas_list->KeyCount = $plataformas_list->RowIndex;

		// Init row class and style
		$plataformas->resetAttributes();
		$plataformas->CssClass = "";
		if ($plataformas->isGridAdd()) {
		} else {
			$plataformas_list->loadRowValues($plataformas_list->Recordset); // Load row values
		}
		$plataformas->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$plataformas->RowAttrs = array_merge($plataformas->RowAttrs, array('data-rowindex'=>$plataformas_list->RowCnt, 'id'=>'r' . $plataformas_list->RowCnt . '_plataformas', 'data-rowtype'=>$plataformas->RowType));

		// Render row
		$plataformas_list->renderRow();

		// Render list options
		$plataformas_list->renderListOptions();
?>
	<tr<?php echo $plataformas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$plataformas_list->ListOptions->render("body", "left", $plataformas_list->RowCnt);
?>
	<?php if ($plataformas->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $plataformas->codigo->cellAttributes() ?>>
<span id="el<?php echo $plataformas_list->RowCnt ?>_plataformas_codigo" class="plataformas_codigo">
<span<?php echo $plataformas->codigo->viewAttributes() ?>>
<?php echo $plataformas->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($plataformas->descricao->Visible) { // descricao ?>
		<td data-name="descricao"<?php echo $plataformas->descricao->cellAttributes() ?>>
<span id="el<?php echo $plataformas_list->RowCnt ?>_plataformas_descricao" class="plataformas_descricao">
<span<?php echo $plataformas->descricao->viewAttributes() ?>>
<?php echo $plataformas->descricao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$plataformas_list->ListOptions->render("body", "right", $plataformas_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$plataformas->isGridAdd())
		$plataformas_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$plataformas->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($plataformas_list->Recordset)
	$plataformas_list->Recordset->Close();
?>
<?php if (!$plataformas->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$plataformas->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($plataformas_list->Pager)) $plataformas_list->Pager = new PrevNextPager($plataformas_list->StartRec, $plataformas_list->DisplayRecs, $plataformas_list->TotalRecs, $plataformas_list->AutoHidePager) ?>
<?php if ($plataformas_list->Pager->RecordCount > 0 && $plataformas_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($plataformas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $plataformas_list->pageUrl() ?>start=<?php echo $plataformas_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($plataformas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $plataformas_list->pageUrl() ?>start=<?php echo $plataformas_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $plataformas_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($plataformas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $plataformas_list->pageUrl() ?>start=<?php echo $plataformas_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($plataformas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $plataformas_list->pageUrl() ?>start=<?php echo $plataformas_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $plataformas_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($plataformas_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $plataformas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $plataformas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $plataformas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $plataformas_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($plataformas_list->TotalRecs == 0 && !$plataformas->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $plataformas_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$plataformas_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$plataformas->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$plataformas_list->terminate();
?>