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
$licencas_list = new licencas_list();

// Run the page
$licencas_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$licencas_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$licencas->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var flicencaslist = currentForm = new ew.Form("flicencaslist", "list");
flicencaslist.formKeyCountName = '<?php echo $licencas_list->FormKeyCountName ?>';

// Form_CustomValidate event
flicencaslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
flicencaslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
flicencaslist.lists["x_jogo"] = <?php echo $licencas_list->jogo->Lookup->toClientList() ?>;
flicencaslist.lists["x_jogo"].options = <?php echo JsonEncode($licencas_list->jogo->lookupOptions()) ?>;
flicencaslist.lists["x_plataforma"] = <?php echo $licencas_list->plataforma->Lookup->toClientList() ?>;
flicencaslist.lists["x_plataforma"].options = <?php echo JsonEncode($licencas_list->plataforma->lookupOptions()) ?>;
flicencaslist.autoSuggests["x_plataforma"] = <?php echo json_encode(["data" => "ajax=autosuggest"]) ?>;
flicencaslist.lists["x_player"] = <?php echo $licencas_list->player->Lookup->toClientList() ?>;
flicencaslist.lists["x_player"].options = <?php echo JsonEncode($licencas_list->player->lookupOptions()) ?>;

// Form object for search
var flicencaslistsrch = currentSearchForm = new ew.Form("flicencaslistsrch");

// Filters
flicencaslistsrch.filterList = <?php echo $licencas_list->getFilterList() ?>;
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
<?php if (!$licencas->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($licencas_list->TotalRecs > 0 && $licencas_list->ExportOptions->visible()) { ?>
<?php $licencas_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($licencas_list->ImportOptions->visible()) { ?>
<?php $licencas_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($licencas_list->SearchOptions->visible()) { ?>
<?php $licencas_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($licencas_list->FilterOptions->visible()) { ?>
<?php $licencas_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$licencas_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$licencas->isExport() && !$licencas->CurrentAction) { ?>
<form name="flicencaslistsrch" id="flicencaslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($licencas_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="flicencaslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="licencas">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($licencas_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($licencas_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $licencas_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($licencas_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($licencas_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($licencas_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($licencas_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $licencas_list->showPageHeader(); ?>
<?php
$licencas_list->showMessage();
?>
<?php if ($licencas_list->TotalRecs > 0 || $licencas->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($licencas_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> licencas">
<form name="flicencaslist" id="flicencaslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($licencas_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $licencas_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="licencas">
<div id="gmp_licencas" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($licencas_list->TotalRecs > 0 || $licencas->isGridEdit()) { ?>
<table id="tbl_licencaslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$licencas_list->RowType = ROWTYPE_HEADER;

// Render list options
$licencas_list->renderListOptions();

// Render list options (header, left)
$licencas_list->ListOptions->render("header", "left");
?>
<?php if ($licencas->codigo->Visible) { // codigo ?>
	<?php if ($licencas->sortUrl($licencas->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $licencas->codigo->headerCellClass() ?>"><div id="elh_licencas_codigo" class="licencas_codigo"><div class="ew-table-header-caption"><?php echo $licencas->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $licencas->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $licencas->SortUrl($licencas->codigo) ?>',1);"><div id="elh_licencas_codigo" class="licencas_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $licencas->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($licencas->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($licencas->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($licencas->jogo->Visible) { // jogo ?>
	<?php if ($licencas->sortUrl($licencas->jogo) == "") { ?>
		<th data-name="jogo" class="<?php echo $licencas->jogo->headerCellClass() ?>"><div id="elh_licencas_jogo" class="licencas_jogo"><div class="ew-table-header-caption"><?php echo $licencas->jogo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="jogo" class="<?php echo $licencas->jogo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $licencas->SortUrl($licencas->jogo) ?>',1);"><div id="elh_licencas_jogo" class="licencas_jogo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $licencas->jogo->caption() ?></span><span class="ew-table-header-sort"><?php if ($licencas->jogo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($licencas->jogo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($licencas->plataforma->Visible) { // plataforma ?>
	<?php if ($licencas->sortUrl($licencas->plataforma) == "") { ?>
		<th data-name="plataforma" class="<?php echo $licencas->plataforma->headerCellClass() ?>"><div id="elh_licencas_plataforma" class="licencas_plataforma"><div class="ew-table-header-caption"><?php echo $licencas->plataforma->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="plataforma" class="<?php echo $licencas->plataforma->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $licencas->SortUrl($licencas->plataforma) ?>',1);"><div id="elh_licencas_plataforma" class="licencas_plataforma">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $licencas->plataforma->caption() ?></span><span class="ew-table-header-sort"><?php if ($licencas->plataforma->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($licencas->plataforma->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($licencas->codigo_liberacao->Visible) { // codigo_liberacao ?>
	<?php if ($licencas->sortUrl($licencas->codigo_liberacao) == "") { ?>
		<th data-name="codigo_liberacao" class="<?php echo $licencas->codigo_liberacao->headerCellClass() ?>"><div id="elh_licencas_codigo_liberacao" class="licencas_codigo_liberacao"><div class="ew-table-header-caption"><?php echo $licencas->codigo_liberacao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo_liberacao" class="<?php echo $licencas->codigo_liberacao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $licencas->SortUrl($licencas->codigo_liberacao) ?>',1);"><div id="elh_licencas_codigo_liberacao" class="licencas_codigo_liberacao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $licencas->codigo_liberacao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($licencas->codigo_liberacao->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($licencas->codigo_liberacao->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($licencas->player->Visible) { // player ?>
	<?php if ($licencas->sortUrl($licencas->player) == "") { ?>
		<th data-name="player" class="<?php echo $licencas->player->headerCellClass() ?>"><div id="elh_licencas_player" class="licencas_player"><div class="ew-table-header-caption"><?php echo $licencas->player->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="player" class="<?php echo $licencas->player->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $licencas->SortUrl($licencas->player) ?>',1);"><div id="elh_licencas_player" class="licencas_player">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $licencas->player->caption() ?></span><span class="ew-table-header-sort"><?php if ($licencas->player->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($licencas->player->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$licencas_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($licencas->ExportAll && $licencas->isExport()) {
	$licencas_list->StopRec = $licencas_list->TotalRecs;
} else {

	// Set the last record to display
	if ($licencas_list->TotalRecs > $licencas_list->StartRec + $licencas_list->DisplayRecs - 1)
		$licencas_list->StopRec = $licencas_list->StartRec + $licencas_list->DisplayRecs - 1;
	else
		$licencas_list->StopRec = $licencas_list->TotalRecs;
}
$licencas_list->RecCnt = $licencas_list->StartRec - 1;
if ($licencas_list->Recordset && !$licencas_list->Recordset->EOF) {
	$licencas_list->Recordset->moveFirst();
	$selectLimit = $licencas_list->UseSelectLimit;
	if (!$selectLimit && $licencas_list->StartRec > 1)
		$licencas_list->Recordset->move($licencas_list->StartRec - 1);
} elseif (!$licencas->AllowAddDeleteRow && $licencas_list->StopRec == 0) {
	$licencas_list->StopRec = $licencas->GridAddRowCount;
}

// Initialize aggregate
$licencas->RowType = ROWTYPE_AGGREGATEINIT;
$licencas->resetAttributes();
$licencas_list->renderRow();
while ($licencas_list->RecCnt < $licencas_list->StopRec) {
	$licencas_list->RecCnt++;
	if ($licencas_list->RecCnt >= $licencas_list->StartRec) {
		$licencas_list->RowCnt++;

		// Set up key count
		$licencas_list->KeyCount = $licencas_list->RowIndex;

		// Init row class and style
		$licencas->resetAttributes();
		$licencas->CssClass = "";
		if ($licencas->isGridAdd()) {
		} else {
			$licencas_list->loadRowValues($licencas_list->Recordset); // Load row values
		}
		$licencas->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$licencas->RowAttrs = array_merge($licencas->RowAttrs, array('data-rowindex'=>$licencas_list->RowCnt, 'id'=>'r' . $licencas_list->RowCnt . '_licencas', 'data-rowtype'=>$licencas->RowType));

		// Render row
		$licencas_list->renderRow();

		// Render list options
		$licencas_list->renderListOptions();
?>
	<tr<?php echo $licencas->rowAttributes() ?>>
<?php

// Render list options (body, left)
$licencas_list->ListOptions->render("body", "left", $licencas_list->RowCnt);
?>
	<?php if ($licencas->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $licencas->codigo->cellAttributes() ?>>
<span id="el<?php echo $licencas_list->RowCnt ?>_licencas_codigo" class="licencas_codigo">
<span<?php echo $licencas->codigo->viewAttributes() ?>>
<?php echo $licencas->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($licencas->jogo->Visible) { // jogo ?>
		<td data-name="jogo"<?php echo $licencas->jogo->cellAttributes() ?>>
<span id="el<?php echo $licencas_list->RowCnt ?>_licencas_jogo" class="licencas_jogo">
<span<?php echo $licencas->jogo->viewAttributes() ?>>
<?php echo $licencas->jogo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($licencas->plataforma->Visible) { // plataforma ?>
		<td data-name="plataforma"<?php echo $licencas->plataforma->cellAttributes() ?>>
<span id="el<?php echo $licencas_list->RowCnt ?>_licencas_plataforma" class="licencas_plataforma">
<span<?php echo $licencas->plataforma->viewAttributes() ?>>
<?php echo $licencas->plataforma->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($licencas->codigo_liberacao->Visible) { // codigo_liberacao ?>
		<td data-name="codigo_liberacao"<?php echo $licencas->codigo_liberacao->cellAttributes() ?>>
<span id="el<?php echo $licencas_list->RowCnt ?>_licencas_codigo_liberacao" class="licencas_codigo_liberacao">
<span<?php echo $licencas->codigo_liberacao->viewAttributes() ?>>
<?php echo $licencas->codigo_liberacao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($licencas->player->Visible) { // player ?>
		<td data-name="player"<?php echo $licencas->player->cellAttributes() ?>>
<span id="el<?php echo $licencas_list->RowCnt ?>_licencas_player" class="licencas_player">
<span<?php echo $licencas->player->viewAttributes() ?>>
<?php echo $licencas->player->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$licencas_list->ListOptions->render("body", "right", $licencas_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$licencas->isGridAdd())
		$licencas_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$licencas->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($licencas_list->Recordset)
	$licencas_list->Recordset->Close();
?>
<?php if (!$licencas->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$licencas->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($licencas_list->Pager)) $licencas_list->Pager = new PrevNextPager($licencas_list->StartRec, $licencas_list->DisplayRecs, $licencas_list->TotalRecs, $licencas_list->AutoHidePager) ?>
<?php if ($licencas_list->Pager->RecordCount > 0 && $licencas_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($licencas_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $licencas_list->pageUrl() ?>start=<?php echo $licencas_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($licencas_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $licencas_list->pageUrl() ?>start=<?php echo $licencas_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $licencas_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($licencas_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $licencas_list->pageUrl() ?>start=<?php echo $licencas_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($licencas_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $licencas_list->pageUrl() ?>start=<?php echo $licencas_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $licencas_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($licencas_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $licencas_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $licencas_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $licencas_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $licencas_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($licencas_list->TotalRecs == 0 && !$licencas->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $licencas_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$licencas_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$licencas->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$licencas_list->terminate();
?>