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
$estagios_desenvolvimento_list = new estagios_desenvolvimento_list();

// Run the page
$estagios_desenvolvimento_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estagios_desenvolvimento_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var festagios_desenvolvimentolist = currentForm = new ew.Form("festagios_desenvolvimentolist", "list");
festagios_desenvolvimentolist.formKeyCountName = '<?php echo $estagios_desenvolvimento_list->FormKeyCountName ?>';

// Form_CustomValidate event
festagios_desenvolvimentolist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
festagios_desenvolvimentolist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var festagios_desenvolvimentolistsrch = currentSearchForm = new ew.Form("festagios_desenvolvimentolistsrch");

// Filters
festagios_desenvolvimentolistsrch.filterList = <?php echo $estagios_desenvolvimento_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($estagios_desenvolvimento_list->TotalRecs > 0 && $estagios_desenvolvimento_list->ExportOptions->visible()) { ?>
<?php $estagios_desenvolvimento_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($estagios_desenvolvimento_list->ImportOptions->visible()) { ?>
<?php $estagios_desenvolvimento_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($estagios_desenvolvimento_list->SearchOptions->visible()) { ?>
<?php $estagios_desenvolvimento_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($estagios_desenvolvimento_list->FilterOptions->visible()) { ?>
<?php $estagios_desenvolvimento_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$estagios_desenvolvimento_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$estagios_desenvolvimento->isExport() && !$estagios_desenvolvimento->CurrentAction) { ?>
<form name="festagios_desenvolvimentolistsrch" id="festagios_desenvolvimentolistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($estagios_desenvolvimento_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="festagios_desenvolvimentolistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="estagios_desenvolvimento">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($estagios_desenvolvimento_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($estagios_desenvolvimento_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $estagios_desenvolvimento_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($estagios_desenvolvimento_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($estagios_desenvolvimento_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($estagios_desenvolvimento_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($estagios_desenvolvimento_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $estagios_desenvolvimento_list->showPageHeader(); ?>
<?php
$estagios_desenvolvimento_list->showMessage();
?>
<?php if ($estagios_desenvolvimento_list->TotalRecs > 0 || $estagios_desenvolvimento->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($estagios_desenvolvimento_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> estagios_desenvolvimento">
<form name="festagios_desenvolvimentolist" id="festagios_desenvolvimentolist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($estagios_desenvolvimento_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $estagios_desenvolvimento_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estagios_desenvolvimento">
<div id="gmp_estagios_desenvolvimento" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($estagios_desenvolvimento_list->TotalRecs > 0 || $estagios_desenvolvimento->isGridEdit()) { ?>
<table id="tbl_estagios_desenvolvimentolist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$estagios_desenvolvimento_list->RowType = ROWTYPE_HEADER;

// Render list options
$estagios_desenvolvimento_list->renderListOptions();

// Render list options (header, left)
$estagios_desenvolvimento_list->ListOptions->render("header", "left");
?>
<?php if ($estagios_desenvolvimento->codigo->Visible) { // codigo ?>
	<?php if ($estagios_desenvolvimento->sortUrl($estagios_desenvolvimento->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $estagios_desenvolvimento->codigo->headerCellClass() ?>"><div id="elh_estagios_desenvolvimento_codigo" class="estagios_desenvolvimento_codigo"><div class="ew-table-header-caption"><?php echo $estagios_desenvolvimento->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $estagios_desenvolvimento->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $estagios_desenvolvimento->SortUrl($estagios_desenvolvimento->codigo) ?>',1);"><div id="elh_estagios_desenvolvimento_codigo" class="estagios_desenvolvimento_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $estagios_desenvolvimento->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($estagios_desenvolvimento->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($estagios_desenvolvimento->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($estagios_desenvolvimento->descricao->Visible) { // descricao ?>
	<?php if ($estagios_desenvolvimento->sortUrl($estagios_desenvolvimento->descricao) == "") { ?>
		<th data-name="descricao" class="<?php echo $estagios_desenvolvimento->descricao->headerCellClass() ?>"><div id="elh_estagios_desenvolvimento_descricao" class="estagios_desenvolvimento_descricao"><div class="ew-table-header-caption"><?php echo $estagios_desenvolvimento->descricao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="descricao" class="<?php echo $estagios_desenvolvimento->descricao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $estagios_desenvolvimento->SortUrl($estagios_desenvolvimento->descricao) ?>',1);"><div id="elh_estagios_desenvolvimento_descricao" class="estagios_desenvolvimento_descricao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $estagios_desenvolvimento->descricao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($estagios_desenvolvimento->descricao->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($estagios_desenvolvimento->descricao->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$estagios_desenvolvimento_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($estagios_desenvolvimento->ExportAll && $estagios_desenvolvimento->isExport()) {
	$estagios_desenvolvimento_list->StopRec = $estagios_desenvolvimento_list->TotalRecs;
} else {

	// Set the last record to display
	if ($estagios_desenvolvimento_list->TotalRecs > $estagios_desenvolvimento_list->StartRec + $estagios_desenvolvimento_list->DisplayRecs - 1)
		$estagios_desenvolvimento_list->StopRec = $estagios_desenvolvimento_list->StartRec + $estagios_desenvolvimento_list->DisplayRecs - 1;
	else
		$estagios_desenvolvimento_list->StopRec = $estagios_desenvolvimento_list->TotalRecs;
}
$estagios_desenvolvimento_list->RecCnt = $estagios_desenvolvimento_list->StartRec - 1;
if ($estagios_desenvolvimento_list->Recordset && !$estagios_desenvolvimento_list->Recordset->EOF) {
	$estagios_desenvolvimento_list->Recordset->moveFirst();
	$selectLimit = $estagios_desenvolvimento_list->UseSelectLimit;
	if (!$selectLimit && $estagios_desenvolvimento_list->StartRec > 1)
		$estagios_desenvolvimento_list->Recordset->move($estagios_desenvolvimento_list->StartRec - 1);
} elseif (!$estagios_desenvolvimento->AllowAddDeleteRow && $estagios_desenvolvimento_list->StopRec == 0) {
	$estagios_desenvolvimento_list->StopRec = $estagios_desenvolvimento->GridAddRowCount;
}

// Initialize aggregate
$estagios_desenvolvimento->RowType = ROWTYPE_AGGREGATEINIT;
$estagios_desenvolvimento->resetAttributes();
$estagios_desenvolvimento_list->renderRow();
while ($estagios_desenvolvimento_list->RecCnt < $estagios_desenvolvimento_list->StopRec) {
	$estagios_desenvolvimento_list->RecCnt++;
	if ($estagios_desenvolvimento_list->RecCnt >= $estagios_desenvolvimento_list->StartRec) {
		$estagios_desenvolvimento_list->RowCnt++;

		// Set up key count
		$estagios_desenvolvimento_list->KeyCount = $estagios_desenvolvimento_list->RowIndex;

		// Init row class and style
		$estagios_desenvolvimento->resetAttributes();
		$estagios_desenvolvimento->CssClass = "";
		if ($estagios_desenvolvimento->isGridAdd()) {
		} else {
			$estagios_desenvolvimento_list->loadRowValues($estagios_desenvolvimento_list->Recordset); // Load row values
		}
		$estagios_desenvolvimento->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$estagios_desenvolvimento->RowAttrs = array_merge($estagios_desenvolvimento->RowAttrs, array('data-rowindex'=>$estagios_desenvolvimento_list->RowCnt, 'id'=>'r' . $estagios_desenvolvimento_list->RowCnt . '_estagios_desenvolvimento', 'data-rowtype'=>$estagios_desenvolvimento->RowType));

		// Render row
		$estagios_desenvolvimento_list->renderRow();

		// Render list options
		$estagios_desenvolvimento_list->renderListOptions();
?>
	<tr<?php echo $estagios_desenvolvimento->rowAttributes() ?>>
<?php

// Render list options (body, left)
$estagios_desenvolvimento_list->ListOptions->render("body", "left", $estagios_desenvolvimento_list->RowCnt);
?>
	<?php if ($estagios_desenvolvimento->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $estagios_desenvolvimento->codigo->cellAttributes() ?>>
<span id="el<?php echo $estagios_desenvolvimento_list->RowCnt ?>_estagios_desenvolvimento_codigo" class="estagios_desenvolvimento_codigo">
<span<?php echo $estagios_desenvolvimento->codigo->viewAttributes() ?>>
<?php echo $estagios_desenvolvimento->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estagios_desenvolvimento->descricao->Visible) { // descricao ?>
		<td data-name="descricao"<?php echo $estagios_desenvolvimento->descricao->cellAttributes() ?>>
<span id="el<?php echo $estagios_desenvolvimento_list->RowCnt ?>_estagios_desenvolvimento_descricao" class="estagios_desenvolvimento_descricao">
<span<?php echo $estagios_desenvolvimento->descricao->viewAttributes() ?>>
<?php echo $estagios_desenvolvimento->descricao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$estagios_desenvolvimento_list->ListOptions->render("body", "right", $estagios_desenvolvimento_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$estagios_desenvolvimento->isGridAdd())
		$estagios_desenvolvimento_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$estagios_desenvolvimento->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($estagios_desenvolvimento_list->Recordset)
	$estagios_desenvolvimento_list->Recordset->Close();
?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$estagios_desenvolvimento->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($estagios_desenvolvimento_list->Pager)) $estagios_desenvolvimento_list->Pager = new PrevNextPager($estagios_desenvolvimento_list->StartRec, $estagios_desenvolvimento_list->DisplayRecs, $estagios_desenvolvimento_list->TotalRecs, $estagios_desenvolvimento_list->AutoHidePager) ?>
<?php if ($estagios_desenvolvimento_list->Pager->RecordCount > 0 && $estagios_desenvolvimento_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($estagios_desenvolvimento_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $estagios_desenvolvimento_list->pageUrl() ?>start=<?php echo $estagios_desenvolvimento_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($estagios_desenvolvimento_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $estagios_desenvolvimento_list->pageUrl() ?>start=<?php echo $estagios_desenvolvimento_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $estagios_desenvolvimento_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($estagios_desenvolvimento_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $estagios_desenvolvimento_list->pageUrl() ?>start=<?php echo $estagios_desenvolvimento_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($estagios_desenvolvimento_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $estagios_desenvolvimento_list->pageUrl() ?>start=<?php echo $estagios_desenvolvimento_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $estagios_desenvolvimento_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($estagios_desenvolvimento_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $estagios_desenvolvimento_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $estagios_desenvolvimento_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $estagios_desenvolvimento_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $estagios_desenvolvimento_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($estagios_desenvolvimento_list->TotalRecs == 0 && !$estagios_desenvolvimento->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $estagios_desenvolvimento_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$estagios_desenvolvimento_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$estagios_desenvolvimento->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$estagios_desenvolvimento_list->terminate();
?>