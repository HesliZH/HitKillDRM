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
$players_list = new players_list();

// Run the page
$players_list->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$players_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$players->isExport()) { ?>
<script>

// Form object
currentPageID = ew.PAGE_ID = "list";
var fplayerslist = currentForm = new ew.Form("fplayerslist", "list");
fplayerslist.formKeyCountName = '<?php echo $players_list->FormKeyCountName ?>';

// Form_CustomValidate event
fplayerslist.Form_CustomValidate = function(fobj) { // DO NOT CHANGE THIS LINE!

	// Your custom validation code here, return false if invalid.
	return true;
}

// Use JavaScript validation or not
fplayerslist.validateRequired = <?php echo json_encode(CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

var fplayerslistsrch = currentSearchForm = new ew.Form("fplayerslistsrch");

// Filters
fplayerslistsrch.filterList = <?php echo $players_list->getFilterList() ?>;
</script>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if (!$players->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($players_list->TotalRecs > 0 && $players_list->ExportOptions->visible()) { ?>
<?php $players_list->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($players_list->ImportOptions->visible()) { ?>
<?php $players_list->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($players_list->SearchOptions->visible()) { ?>
<?php $players_list->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($players_list->FilterOptions->visible()) { ?>
<?php $players_list->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$players_list->renderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if (!$players->isExport() && !$players->CurrentAction) { ?>
<form name="fplayerslistsrch" id="fplayerslistsrch" class="form-inline ew-form ew-ext-search-form" action="<?php echo CurrentPageName() ?>">
<?php $searchPanelClass = ($players_list->SearchWhere <> "") ? " show" : " show"; ?>
<div id="fplayerslistsrch-search-panel" class="ew-search-panel collapse<?php echo $searchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="players">
	<div class="ew-basic-search">
<div id="xsr_1" class="ew-row d-sm-flex">
	<div class="ew-quick-search input-group">
		<input type="text" name="<?php echo TABLE_BASIC_SEARCH ?>" id="<?php echo TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo HtmlEncode($players_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo HtmlEncode($Language->phrase("Search")) ?>">
		<input type="hidden" name="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo HtmlEncode($players_list->BasicSearch->getType()) ?>">
		<div class="input-group-append">
			<button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?php echo $Language->phrase("SearchBtn") ?></button>
			<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?php echo $players_list->BasicSearch->getTypeNameShort() ?></span></button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item<?php if ($players_list->BasicSearch->getType() == "") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this)"><?php echo $Language->phrase("QuickSearchAuto") ?></a>
				<a class="dropdown-item<?php if ($players_list->BasicSearch->getType() == "=") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'=')"><?php echo $Language->phrase("QuickSearchExact") ?></a>
				<a class="dropdown-item<?php if ($players_list->BasicSearch->getType() == "AND") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'AND')"><?php echo $Language->phrase("QuickSearchAll") ?></a>
				<a class="dropdown-item<?php if ($players_list->BasicSearch->getType() == "OR") echo " active"; ?>" href="javascript:void(0);" onclick="ew.setSearchType(this,'OR')"><?php echo $Language->phrase("QuickSearchAny") ?></a>
			</div>
		</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $players_list->showPageHeader(); ?>
<?php
$players_list->showMessage();
?>
<?php if ($players_list->TotalRecs > 0 || $players->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($players_list->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> players">
<form name="fplayerslist" id="fplayerslist" class="form-inline ew-form ew-list-form" action="<?php echo CurrentPageName() ?>" method="post">
<?php if ($players_list->CheckToken) { ?>
<input type="hidden" name="<?php echo TOKEN_NAME ?>" value="<?php echo $players_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="players">
<div id="gmp_players" class="<?php if (IsResponsiveLayout()) { ?>table-responsive <?php } ?>card-body ew-grid-middle-panel">
<?php if ($players_list->TotalRecs > 0 || $players->isGridEdit()) { ?>
<table id="tbl_playerslist" class="table ew-table"><!-- .ew-table ##-->
<thead>
	<tr class="ew-table-header">
<?php

// Header row
$players_list->RowType = ROWTYPE_HEADER;

// Render list options
$players_list->renderListOptions();

// Render list options (header, left)
$players_list->ListOptions->render("header", "left");
?>
<?php if ($players->codigo->Visible) { // codigo ?>
	<?php if ($players->sortUrl($players->codigo) == "") { ?>
		<th data-name="codigo" class="<?php echo $players->codigo->headerCellClass() ?>"><div id="elh_players_codigo" class="players_codigo"><div class="ew-table-header-caption"><?php echo $players->codigo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo" class="<?php echo $players->codigo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $players->SortUrl($players->codigo) ?>',1);"><div id="elh_players_codigo" class="players_codigo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $players->codigo->caption() ?></span><span class="ew-table-header-sort"><?php if ($players->codigo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($players->codigo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($players->nome_completo->Visible) { // nome_completo ?>
	<?php if ($players->sortUrl($players->nome_completo) == "") { ?>
		<th data-name="nome_completo" class="<?php echo $players->nome_completo->headerCellClass() ?>"><div id="elh_players_nome_completo" class="players_nome_completo"><div class="ew-table-header-caption"><?php echo $players->nome_completo->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nome_completo" class="<?php echo $players->nome_completo->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $players->SortUrl($players->nome_completo) ?>',1);"><div id="elh_players_nome_completo" class="players_nome_completo">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $players->nome_completo->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($players->nome_completo->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($players->nome_completo->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($players->usuario->Visible) { // usuario ?>
	<?php if ($players->sortUrl($players->usuario) == "") { ?>
		<th data-name="usuario" class="<?php echo $players->usuario->headerCellClass() ?>"><div id="elh_players_usuario" class="players_usuario"><div class="ew-table-header-caption"><?php echo $players->usuario->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="usuario" class="<?php echo $players->usuario->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $players->SortUrl($players->usuario) ?>',1);"><div id="elh_players_usuario" class="players_usuario">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $players->usuario->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($players->usuario->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($players->usuario->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($players->senha->Visible) { // senha ?>
	<?php if ($players->sortUrl($players->senha) == "") { ?>
		<th data-name="senha" class="<?php echo $players->senha->headerCellClass() ?>"><div id="elh_players_senha" class="players_senha"><div class="ew-table-header-caption"><?php echo $players->senha->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="senha" class="<?php echo $players->senha->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $players->SortUrl($players->senha) ?>',1);"><div id="elh_players_senha" class="players_senha">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $players->senha->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($players->senha->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($players->senha->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($players->nickname->Visible) { // nickname ?>
	<?php if ($players->sortUrl($players->nickname) == "") { ?>
		<th data-name="nickname" class="<?php echo $players->nickname->headerCellClass() ?>"><div id="elh_players_nickname" class="players_nickname"><div class="ew-table-header-caption"><?php echo $players->nickname->caption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nickname" class="<?php echo $players->nickname->headerCellClass() ?>"><div class="ew-pointer" onclick="ew.sort(event,'<?php echo $players->SortUrl($players->nickname) ?>',1);"><div id="elh_players_nickname" class="players_nickname">
			<div class="ew-table-header-btn"><span class="ew-table-header-caption"><?php echo $players->nickname->caption() ?><?php echo $Language->phrase("SrchLegend") ?></span><span class="ew-table-header-sort"><?php if ($players->nickname->getSort() == "ASC") { ?><i class="fa fa-sort-up"></i><?php } elseif ($players->nickname->getSort() == "DESC") { ?><i class="fa fa-sort-down"></i><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$players_list->ListOptions->render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($players->ExportAll && $players->isExport()) {
	$players_list->StopRec = $players_list->TotalRecs;
} else {

	// Set the last record to display
	if ($players_list->TotalRecs > $players_list->StartRec + $players_list->DisplayRecs - 1)
		$players_list->StopRec = $players_list->StartRec + $players_list->DisplayRecs - 1;
	else
		$players_list->StopRec = $players_list->TotalRecs;
}
$players_list->RecCnt = $players_list->StartRec - 1;
if ($players_list->Recordset && !$players_list->Recordset->EOF) {
	$players_list->Recordset->moveFirst();
	$selectLimit = $players_list->UseSelectLimit;
	if (!$selectLimit && $players_list->StartRec > 1)
		$players_list->Recordset->move($players_list->StartRec - 1);
} elseif (!$players->AllowAddDeleteRow && $players_list->StopRec == 0) {
	$players_list->StopRec = $players->GridAddRowCount;
}

// Initialize aggregate
$players->RowType = ROWTYPE_AGGREGATEINIT;
$players->resetAttributes();
$players_list->renderRow();
while ($players_list->RecCnt < $players_list->StopRec) {
	$players_list->RecCnt++;
	if ($players_list->RecCnt >= $players_list->StartRec) {
		$players_list->RowCnt++;

		// Set up key count
		$players_list->KeyCount = $players_list->RowIndex;

		// Init row class and style
		$players->resetAttributes();
		$players->CssClass = "";
		if ($players->isGridAdd()) {
		} else {
			$players_list->loadRowValues($players_list->Recordset); // Load row values
		}
		$players->RowType = ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$players->RowAttrs = array_merge($players->RowAttrs, array('data-rowindex'=>$players_list->RowCnt, 'id'=>'r' . $players_list->RowCnt . '_players', 'data-rowtype'=>$players->RowType));

		// Render row
		$players_list->renderRow();

		// Render list options
		$players_list->renderListOptions();
?>
	<tr<?php echo $players->rowAttributes() ?>>
<?php

// Render list options (body, left)
$players_list->ListOptions->render("body", "left", $players_list->RowCnt);
?>
	<?php if ($players->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $players->codigo->cellAttributes() ?>>
<span id="el<?php echo $players_list->RowCnt ?>_players_codigo" class="players_codigo">
<span<?php echo $players->codigo->viewAttributes() ?>>
<?php echo $players->codigo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($players->nome_completo->Visible) { // nome_completo ?>
		<td data-name="nome_completo"<?php echo $players->nome_completo->cellAttributes() ?>>
<span id="el<?php echo $players_list->RowCnt ?>_players_nome_completo" class="players_nome_completo">
<span<?php echo $players->nome_completo->viewAttributes() ?>>
<?php echo $players->nome_completo->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($players->usuario->Visible) { // usuario ?>
		<td data-name="usuario"<?php echo $players->usuario->cellAttributes() ?>>
<span id="el<?php echo $players_list->RowCnt ?>_players_usuario" class="players_usuario">
<span<?php echo $players->usuario->viewAttributes() ?>>
<?php echo $players->usuario->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($players->senha->Visible) { // senha ?>
		<td data-name="senha"<?php echo $players->senha->cellAttributes() ?>>
<span id="el<?php echo $players_list->RowCnt ?>_players_senha" class="players_senha">
<span<?php echo $players->senha->viewAttributes() ?>>
<?php echo $players->senha->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($players->nickname->Visible) { // nickname ?>
		<td data-name="nickname"<?php echo $players->nickname->cellAttributes() ?>>
<span id="el<?php echo $players_list->RowCnt ?>_players_nickname" class="players_nickname">
<span<?php echo $players->nickname->viewAttributes() ?>>
<?php echo $players->nickname->getViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$players_list->ListOptions->render("body", "right", $players_list->RowCnt);
?>
	</tr>
<?php
	}
	if (!$players->isGridAdd())
		$players_list->Recordset->moveNext();
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
<?php if (!$players->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
</form><!-- /.ew-list-form -->
<?php

// Close recordset
if ($players_list->Recordset)
	$players_list->Recordset->Close();
?>
<?php if (!$players->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$players->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?php echo CurrentPageName() ?>">
<?php if (!isset($players_list->Pager)) $players_list->Pager = new PrevNextPager($players_list->StartRec, $players_list->DisplayRecs, $players_list->TotalRecs, $players_list->AutoHidePager) ?>
<?php if ($players_list->Pager->RecordCount > 0 && $players_list->Pager->Visible) { ?>
<div class="ew-pager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ew-prev-next"><div class="input-group input-group-sm">
<div class="input-group-prepend">
<!-- first page button -->
	<?php if ($players_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerFirst") ?>" href="<?php echo $players_list->pageUrl() ?>start=<?php echo $players_list->Pager->FirstButton->Start ?>"><i class="icon-first ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerFirst") ?>"><i class="icon-first ew-icon"></i></a>
	<?php } ?>
<!-- previous page button -->
	<?php if ($players_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerPrevious") ?>" href="<?php echo $players_list->pageUrl() ?>start=<?php echo $players_list->Pager->PrevButton->Start ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerPrevious") ?>"><i class="icon-prev ew-icon"></i></a>
	<?php } ?>
</div>
<!-- current page number -->
	<input class="form-control" type="text" name="<?php echo TABLE_PAGE_NO ?>" value="<?php echo $players_list->Pager->CurrentPage ?>">
<div class="input-group-append">
<!-- next page button -->
	<?php if ($players_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerNext") ?>" href="<?php echo $players_list->pageUrl() ?>start=<?php echo $players_list->Pager->NextButton->Start ?>"><i class="icon-next ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerNext") ?>"><i class="icon-next ew-icon"></i></a>
	<?php } ?>
<!-- last page button -->
	<?php if ($players_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default" title="<?php echo $Language->phrase("PagerLast") ?>" href="<?php echo $players_list->pageUrl() ?>start=<?php echo $players_list->Pager->LastButton->Start ?>"><i class="icon-last ew-icon"></i></a>
	<?php } else { ?>
	<a class="btn btn-default disabled" title="<?php echo $Language->phrase("PagerLast") ?>"><i class="icon-last ew-icon"></i></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $players_list->Pager->PageCount ?></span>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if ($players_list->Pager->RecordCount > 0) { ?>
<div class="ew-pager ew-rec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $players_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $players_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $players_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $players_list->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($players_list->TotalRecs == 0 && !$players->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $players_list->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$players_list->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$players->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$players_list->terminate();
?>