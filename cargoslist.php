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
$cargos_list = new cargos_list();

// Run the page
$cargos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cargos_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$cargos->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fcargoslist = currentForm = new ew.Form("fcargoslist", "list");
fcargoslist.formKeyCountName = '<?php echo $cargos_list->FormKeyCountName ?>';

// Form_CustomValidate event
fcargoslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fcargoslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fcargoslistsrch = currentSearchForm = new ew.Form("fcargoslistsrch");

// Filters
fcargoslistsrch.filterList = <?php echo $cargos_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$cargos->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($cargos_list->TotalRecs > 0 && $cargos_list->ExportOptions->visible()) { ?>
<?php $cargos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($cargos_list->ImportOptions->visible()) { ?>
<?php $cargos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($cargos_list->SearchOptions->visible()) { ?>
<?php $cargos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($cargos_list->FilterOptions->visible()) { ?>
<?php $cargos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$cargos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$cargos->isExport() && !$cargos->CurrentAction) { ?>
<form name="fcargoslistsrch" id="fcargoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($cargos_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fcargoslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cargos">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($cargos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($cargos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $cargos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($cargos_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($cargos_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($cargos_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($cargos_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $cargos_list->showPageHeader(); ?>
<?php
$cargos_list->showMessage();
?>
<?php if ($cargos_list->TotalRecs > 0 || $cargos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($cargos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> cargos">
<form name="fcargoslist" id="fcargoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($cargos_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $cargos_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cargos">
<div id="gmp_cargos" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($cargos_list->TotalRecs > 0 || $cargos->isGridEdit()) { ?>
<table id="tbl_cargoslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$cargos_list->RowType = ROWTYPE_HEADER;

// Render list options
$cargos_list->renderListOptions();

// Render list options (header, left)
$cargos_list->ListOptions->render("header", "left");
?>
<?php if ($cargos->codigo->Visible) { // codigo ?>
	<?php if ($cargos->sortUrl($cargos->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $cargos->codigo->headerCellClass() ?>"><div id="elh_cargos_codigo" class="cargos_codigo"><div class="ew-table-header-caption"><?php echo $cargos->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $cargos->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $cargos->SortUrl($cargos->codigo) ?>',1);"><div id="elh_cargos_codigo" class="cargos_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $cargos->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($cargos->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($cargos->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($cargos->descricao->Visible) { // descricao ?>
	<?php if ($cargos->sortUrl($cargos->descricao) == "") { ?>
		<th data-name="descricao" class="<?php echo $cargos->descricao->headerCellClass() ?>"><div id="elh_cargos_descricao" class="cargos_descricao"><div class="ew-table-header-caption"><?php echo $cargos->descricao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descricao" class="<?php echo $cargos->descricao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $cargos->SortUrl($cargos->descricao) ?>',1);"><div id="elh_cargos_descricao" class="cargos_descricao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $cargos->descricao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($cargos->descricao->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($cargos->descricao->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$cargos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cargos->ExportAll && $cargos->isExport()) {
	$cargos_list->StopRec = $cargos_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cargos_list->TotalRecs > $cargos_list->StartRec + $cargos_list->DisplayRecs - 1)
		$cargos_list->StopRec = $cargos_list->StartRec + $cargos_list->DisplayRecs - 1;
	else
		$cargos_list->StopRec = $cargos_list->TotalRecs;
}
$cargos_list->RecCnt = $cargos_list->StartRec - 1;
if ($cargos_list->Recordset && !$cargos_list->Recordset->EOF) {
	$cargos_list->Recordset->moveFirst();
	$selectLimit = $cargos_list->UseSelectLimit;
	if (!$selectLimit && $cargos_list->StartRec > 1)
		$cargos_list->Recordset->move($cargos_list->StartRec - 1);
} elseif (!$cargos->AllowAddDeleteRow && $cargos_list->StopRec == 0) {
	$cargos_list->StopRec = $cargos->GridAddRowCount;
}

// Initialize aggregate
$cargos->RowType = ROWTYPE_AGGREGATEINIT;
$cargos->resetAttributes();
$cargos_list->renderRow();
while ($cargos_list->RecCnt < $cargos_list->StopRec) {
	$cargos_list->RecCnt++;
	if ($cargos_list->RecCnt >= $cargos_list->StartRec) {
		$cargos_list->RowCnt++;

		// Set up key count
		$cargos_list->KeyCount = $cargos_list->RowIndex;

		// Init row class and style
		$cargos->resetAttributes();
		$cargos->CssClass = "";
		if ($cargos->isGridAdd()) {
		} else {
			$cargos_list->loadRowValues($cargos_list->Recordset); // Load row values
		}
		$cargos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$cargos->RowAttrs = array_merge($cargos->RowAttrs, array('data-rowindex'=>$cargos_list->RowCnt, 'id'=>'r' . $cargos_list->RowCnt . '_cargos', 'data-rowtype'=>$cargos->RowType));

		// Render row
		$cargos_list->renderRow();

		// Render list options
		$cargos_list->renderListOptions();
?>
	<tr<?php echo $cargos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$cargos_list->ListOptions->render("body", "left", $cargos_list->RowCnt);
?>
	<?php if ($cargos->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $cargos->codigo->cellAttributes() ?>>
<span id="el<?php echo $cargos_list->RowCnt ?>_cargos_codigo" class="cargos_codigo">
<span<?php echo $cargos->codigo->viewAttributes() ?>>
<?php echo $cargos->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($cargos->descricao->Visible) { // descricao ?>
		<td data-name="descricao"<?php echo $cargos->descricao->cellAttributes() ?>>
<span id="el<?php echo $cargos_list->RowCnt ?>_cargos_descricao" class="cargos_descricao">
<span<?php echo $cargos->descricao->viewAttributes() ?>>
<?php echo $cargos->descricao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cargos_list->ListOptions->render("body", "right", $cargos_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$cargos->isGridAdd())
		$cargos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$cargos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($cargos_list->Recordset)
	$cargos_list->Recordset->Close();
?>
<?php if (!$cargos->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$cargos->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($cargos_list->Pager)) $cargos_list->Pager = new PrevNextPager($cargos_list->StartRec, $cargos_list->DisplayRecs, $cargos_list->TotalRecs, $cargos_list->AutoHidePager) ?>
<?php if ($cargos_list->Pager->RecordCount > 0 && $cargos_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($cargos_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $cargos_list->pageUrl() ?>start=<?php echo $cargos_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($cargos_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $cargos_list->pageUrl() ?>start=<?php echo $cargos_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $cargos_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($cargos_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $cargos_list->pageUrl() ?>start=<?php echo $cargos_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($cargos_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $cargos_list->pageUrl() ?>start=<?php echo $cargos_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cargos_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($cargos_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cargos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cargos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cargos_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $cargos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($cargos_list->TotalRecs == 0 && !$cargos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $cargos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$cargos_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$cargos->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$cargos_list->terminate();
?>