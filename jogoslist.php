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
$jogos_list = new jogos_list();

// Run the page
$jogos_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$jogos_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$jogos->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fjogoslist = currentForm = new ew.Form("fjogoslist", "list");
fjogoslist.formKeyCountName = '<?php echo $jogos_list->FormKeyCountName ?>';

// Form_CustomValidate event
fjogoslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fjogoslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fjogoslist.lists["x_plataforma"] = <?php echo $jogos_list->plataforma->Lookup->toClientList() ?>;
fjogoslist.lists["x_plataforma"].options = <?php echo JsonEncode($jogos_list->plataforma->lookupOptions()) ?>;

// Form object for search
var fjogoslistsrch = currentSearchForm = new ew.Form("fjogoslistsrch");

// Filters
fjogoslistsrch.filterList = <?php echo $jogos_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$jogos->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($jogos_list->TotalRecs > 0 && $jogos_list->ExportOptions->visible()) { ?>
<?php $jogos_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($jogos_list->ImportOptions->visible()) { ?>
<?php $jogos_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($jogos_list->SearchOptions->visible()) { ?>
<?php $jogos_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($jogos_list->FilterOptions->visible()) { ?>
<?php $jogos_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$jogos_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$jogos->isExport() && !$jogos->CurrentAction) { ?>
<form name="fjogoslistsrch" id="fjogoslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($jogos_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fjogoslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="jogos">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($jogos_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($jogos_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $jogos_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($jogos_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($jogos_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($jogos_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($jogos_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $jogos_list->showPageHeader(); ?>
<?php
$jogos_list->showMessage();
?>
<?php if ($jogos_list->TotalRecs > 0 || $jogos->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($jogos_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> jogos">
<form name="fjogoslist" id="fjogoslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($jogos_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $jogos_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="jogos">
<div id="gmp_jogos" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($jogos_list->TotalRecs > 0 || $jogos->isGridEdit()) { ?>
<table id="tbl_jogoslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$jogos_list->RowType = ROWTYPE_HEADER;

// Render list options
$jogos_list->renderListOptions();

// Render list options (header, left)
$jogos_list->ListOptions->render("header", "left");
?>
<?php if ($jogos->codigo->Visible) { // codigo ?>
	<?php if ($jogos->sortUrl($jogos->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $jogos->codigo->headerCellClass() ?>"><div id="elh_jogos_codigo" class="jogos_codigo"><div class="ew-table-header-caption"><?php echo $jogos->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $jogos->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $jogos->SortUrl($jogos->codigo) ?>',1);"><div id="elh_jogos_codigo" class="jogos_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $jogos->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($jogos->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($jogos->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jogos->nome->Visible) { // nome ?>
	<?php if ($jogos->sortUrl($jogos->nome) == "") { ?>
		<th data-name="nome" class="<?php echo $jogos->nome->headerCellClass() ?>"><div id="elh_jogos_nome" class="jogos_nome"><div class="ew-table-header-caption"><?php echo $jogos->nome->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome" class="<?php echo $jogos->nome->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $jogos->SortUrl($jogos->nome) ?>',1);"><div id="elh_jogos_nome" class="jogos_nome">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $jogos->nome->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($jogos->nome->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($jogos->nome->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jogos->plataforma->Visible) { // plataforma ?>
	<?php if ($jogos->sortUrl($jogos->plataforma) == "") { ?>
		<th data-name="plataforma" class="<?php echo $jogos->plataforma->headerCellClass() ?>"><div id="elh_jogos_plataforma" class="jogos_plataforma"><div class="ew-table-header-caption"><?php echo $jogos->plataforma->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="plataforma" class="<?php echo $jogos->plataforma->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $jogos->SortUrl($jogos->plataforma) ?>',1);"><div id="elh_jogos_plataforma" class="jogos_plataforma">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $jogos->plataforma->caption() ?></span><span class="ew-table-header-sort"><?php if ($jogos->plataforma->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($jogos->plataforma->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($jogos->versao->Visible) { // versao ?>
	<?php if ($jogos->sortUrl($jogos->versao) == "") { ?>
		<th data-name="versao" class="<?php echo $jogos->versao->headerCellClass() ?>"><div id="elh_jogos_versao" class="jogos_versao"><div class="ew-table-header-caption"><?php echo $jogos->versao->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="versao" class="<?php echo $jogos->versao->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $jogos->SortUrl($jogos->versao) ?>',1);"><div id="elh_jogos_versao" class="jogos_versao">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $jogos->versao->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($jogos->versao->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($jogos->versao->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$jogos_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($jogos->ExportAll && $jogos->isExport()) {
	$jogos_list->StopRec = $jogos_list->TotalRecs;
} else {

	// Set the last record to display
	if ($jogos_list->TotalRecs > $jogos_list->StartRec + $jogos_list->DisplayRecs - 1)
		$jogos_list->StopRec = $jogos_list->StartRec + $jogos_list->DisplayRecs - 1;
	else
		$jogos_list->StopRec = $jogos_list->TotalRecs;
}
$jogos_list->RecCnt = $jogos_list->StartRec - 1;
if ($jogos_list->Recordset && !$jogos_list->Recordset->EOF) {
	$jogos_list->Recordset->moveFirst();
	$selectLimit = $jogos_list->UseSelectLimit;
	if (!$selectLimit && $jogos_list->StartRec > 1)
		$jogos_list->Recordset->move($jogos_list->StartRec - 1);
} elseif (!$jogos->AllowAddDeleteRow && $jogos_list->StopRec == 0) {
	$jogos_list->StopRec = $jogos->GridAddRowCount;
}

// Initialize aggregate
$jogos->RowType = ROWTYPE_AGGREGATEINIT;
$jogos->resetAttributes();
$jogos_list->renderRow();
while ($jogos_list->RecCnt < $jogos_list->StopRec) {
	$jogos_list->RecCnt++;
	if ($jogos_list->RecCnt >= $jogos_list->StartRec) {
		$jogos_list->RowCnt++;

		// Set up key count
		$jogos_list->KeyCount = $jogos_list->RowIndex;

		// Init row class and style
		$jogos->resetAttributes();
		$jogos->CssClass = "";
		if ($jogos->isGridAdd()) {
		} else {
			$jogos_list->loadRowValues($jogos_list->Recordset); // Load row values
		}
		$jogos->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$jogos->RowAttrs = array_merge($jogos->RowAttrs, array('data-rowindex'=>$jogos_list->RowCnt, 'id'=>'r' . $jogos_list->RowCnt . '_jogos', 'data-rowtype'=>$jogos->RowType));

		// Render row
		$jogos_list->renderRow();

		// Render list options
		$jogos_list->renderListOptions();
?>
	<tr<?php echo $jogos->rowAttributes() ?>>
<?php

// Render list options (body, left)
$jogos_list->ListOptions->render("body", "left", $jogos_list->RowCnt);
?>
	<?php if ($jogos->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $jogos->codigo->cellAttributes() ?>>
<span id="el<?php echo $jogos_list->RowCnt ?>_jogos_codigo" class="jogos_codigo">
<span<?php echo $jogos->codigo->viewAttributes() ?>>
<?php echo $jogos->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jogos->nome->Visible) { // nome ?>
		<td data-name="nome"<?php echo $jogos->nome->cellAttributes() ?>>
<span id="el<?php echo $jogos_list->RowCnt ?>_jogos_nome" class="jogos_nome">
<span<?php echo $jogos->nome->viewAttributes() ?>>
<?php echo $jogos->nome->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jogos->plataforma->Visible) { // plataforma ?>
		<td data-name="plataforma"<?php echo $jogos->plataforma->cellAttributes() ?>>
<span id="el<?php echo $jogos_list->RowCnt ?>_jogos_plataforma" class="jogos_plataforma">
<span<?php echo $jogos->plataforma->viewAttributes() ?>>
<?php echo $jogos->plataforma->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($jogos->versao->Visible) { // versao ?>
		<td data-name="versao"<?php echo $jogos->versao->cellAttributes() ?>>
<span id="el<?php echo $jogos_list->RowCnt ?>_jogos_versao" class="jogos_versao">
<span<?php echo $jogos->versao->viewAttributes() ?>>
<?php echo $jogos->versao->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$jogos_list->ListOptions->render("body", "right", $jogos_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$jogos->isGridAdd())
		$jogos_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$jogos->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($jogos_list->Recordset)
	$jogos_list->Recordset->Close();
?>
<?php if (!$jogos->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$jogos->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($jogos_list->Pager)) $jogos_list->Pager = new PrevNextPager($jogos_list->StartRec, $jogos_list->DisplayRecs, $jogos_list->TotalRecs, $jogos_list->AutoHidePager) ?>
<?php if ($jogos_list->Pager->RecordCount > 0 && $jogos_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($jogos_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $jogos_list->pageUrl() ?>start=<?php echo $jogos_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($jogos_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $jogos_list->pageUrl() ?>start=<?php echo $jogos_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $jogos_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($jogos_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $jogos_list->pageUrl() ?>start=<?php echo $jogos_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($jogos_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $jogos_list->pageUrl() ?>start=<?php echo $jogos_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $jogos_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($jogos_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $jogos_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $jogos_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $jogos_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $jogos_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($jogos_list->TotalRecs == 0 && !$jogos->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $jogos_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$jogos_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$jogos->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$jogos_list->terminate();
?>