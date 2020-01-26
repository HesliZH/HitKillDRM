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
$Relatorio_de_projetos_por_responsavel_report = new Relatorio_de_projetos_por_responsavel_report();

// Run the page
$Relatorio_de_projetos_por_responsavel_report->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$Relatorio_de_projetos_por_responsavel_report->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$Relatorio_de_projetos_por_responsavel->isExport()) { ?>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php
$Relatorio_de_projetos_por_responsavel_report->DefaultFilter = "";
$Relatorio_de_projetos_por_responsavel_report->ReportFilter = $Relatorio_de_projetos_por_responsavel_report->DefaultFilter;
if (!$Security->canReport()) {
	if ($Relatorio_de_projetos_por_responsavel_report->ReportFilter <> "") $Relatorio_de_projetos_por_responsavel_report->ReportFilter .= " AND ";
	$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= "(0=1)";
}
if ($Relatorio_de_projetos_por_responsavel_report->DbDetailFilter <> "") {
	if ($Relatorio_de_projetos_por_responsavel_report->ReportFilter <> "") $Relatorio_de_projetos_por_responsavel_report->ReportFilter .= " AND ";
	$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= "(" . $Relatorio_de_projetos_por_responsavel_report->DbDetailFilter . ")";
}
$ReportConn = &$Relatorio_de_projetos_por_responsavel_report->getConnection();

// Set up filter and load group level SQL
$Relatorio_de_projetos_por_responsavel->CurrentFilter = $Relatorio_de_projetos_por_responsavel_report->ReportFilter;
$Relatorio_de_projetos_por_responsavel_report->ReportSql = $Relatorio_de_projetos_por_responsavel->getGroupSql();

// Load recordset
$Relatorio_de_projetos_por_responsavel_report->Recordset = $ReportConn->Execute($Relatorio_de_projetos_por_responsavel_report->ReportSql);
$Relatorio_de_projetos_por_responsavel_report->RecordExists = !$Relatorio_de_projetos_por_responsavel_report->Recordset->EOF;
?>
<?php if (!$Relatorio_de_projetos_por_responsavel->isExport()) { ?>
<?php if ($Relatorio_de_projetos_por_responsavel_report->RecordExists) { ?>
<div class="ew-view-export-options"><?php $Relatorio_de_projetos_por_responsavel_report->ExportOptions->render("body") ?></div>
<?php } ?>
<?php } ?>
<?php $Relatorio_de_projetos_por_responsavel_report->showPageHeader(); ?>
<table class="ew-report-table">
<?php

// Get First Row
if ($Relatorio_de_projetos_por_responsavel_report->RecordExists) {
	$Relatorio_de_projetos_por_responsavel->responsavel->setDbValue($Relatorio_de_projetos_por_responsavel_report->Recordset->fields('responsavel'));
	$Relatorio_de_projetos_por_responsavel_report->ReportGroups[0] = $Relatorio_de_projetos_por_responsavel->responsavel->DbValue;
}
$Relatorio_de_projetos_por_responsavel_report->RecCnt = 0;
$Relatorio_de_projetos_por_responsavel_report->ReportCounts[0] = 0;
$Relatorio_de_projetos_por_responsavel_report->checkLevelBreak();
while (!$Relatorio_de_projetos_por_responsavel_report->Recordset->EOF) {

	// Render for view
	$Relatorio_de_projetos_por_responsavel->RowType = ROWTYPE_VIEW;
	$Relatorio_de_projetos_por_responsavel->resetAttributes();
	$Relatorio_de_projetos_por_responsavel_report->renderRow();

	// Show group headers
	if ($Relatorio_de_projetos_por_responsavel_report->LevelBreak[1]) { // Reset counter and aggregation
?>
	<tr><td class="ew-group-field"><?php echo $Relatorio_de_projetos_por_responsavel->responsavel->caption() ?></td>
	<td colspan="2" class="ew-group-name">
<span<?php echo $Relatorio_de_projetos_por_responsavel->responsavel->viewAttributes() ?>>
<?php echo $Relatorio_de_projetos_por_responsavel->responsavel->getViewValue() ?></span>
</td></tr>
<?php
	}

	// Get detail records
	$Relatorio_de_projetos_por_responsavel_report->ReportFilter = $Relatorio_de_projetos_por_responsavel_report->DefaultFilter;
	if ($Relatorio_de_projetos_por_responsavel_report->ReportFilter <> "") $Relatorio_de_projetos_por_responsavel_report->ReportFilter .= " AND ";
	if ($Relatorio_de_projetos_por_responsavel->responsavel->CurrentValue == NULL) {
		$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= "(\"responsavel\" IS NULL)";
	} else {
		$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= "(\"responsavel\" = " . QuotedValue($Relatorio_de_projetos_por_responsavel->responsavel->CurrentValue, DATATYPE_NUMBER, $Relatorio_de_projetos_por_responsavel_report->Dbid) . ")";
	}
	if ($Relatorio_de_projetos_por_responsavel_report->DbDetailFilter <> "") {
		if ($Relatorio_de_projetos_por_responsavel_report->ReportFilter <> "")
			$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= " AND ";
		$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= "(" . $Relatorio_de_projetos_por_responsavel_report->DbDetailFilter . ")";
	}
	if (!$Security->canReport()) {
		if ($Relatorio_de_projetos_por_responsavel_report->ReportFilter <> "")
			$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= " AND ";
		$Relatorio_de_projetos_por_responsavel_report->ReportFilter .= "(0=1)";
	}

	// Set up detail SQL
	$Relatorio_de_projetos_por_responsavel->CurrentFilter = $Relatorio_de_projetos_por_responsavel_report->ReportFilter;
	$Relatorio_de_projetos_por_responsavel_report->ReportSql = $Relatorio_de_projetos_por_responsavel->getDetailSql();

	// Load detail records
	$Relatorio_de_projetos_por_responsavel_report->DetailRecordset = $ReportConn->execute($Relatorio_de_projetos_por_responsavel_report->ReportSql);
	$Relatorio_de_projetos_por_responsavel_report->DtlRecordCount = $Relatorio_de_projetos_por_responsavel_report->DetailRecordset->RecordCount();

	// Initialize aggregates
	if (!$Relatorio_de_projetos_por_responsavel_report->DetailRecordset->EOF) {
		$Relatorio_de_projetos_por_responsavel_report->RecCnt++;
	}
	if ($Relatorio_de_projetos_por_responsavel_report->RecCnt == 1) {
		$Relatorio_de_projetos_por_responsavel_report->ReportCounts[0] = 0;
	}
	for ($i = 1; $i <= 1; $i++) {
		if ($Relatorio_de_projetos_por_responsavel_report->LevelBreak[$i]) { // Reset counter and aggregation
			$Relatorio_de_projetos_por_responsavel_report->ReportCounts[$i] = 0;
		}
	}
	$Relatorio_de_projetos_por_responsavel_report->ReportCounts[0] += $Relatorio_de_projetos_por_responsavel_report->DtlRecordCount;
	$Relatorio_de_projetos_por_responsavel_report->ReportCounts[1] += $Relatorio_de_projetos_por_responsavel_report->DtlRecordCount;
	if ($Relatorio_de_projetos_por_responsavel_report->RecordExists) {
?>
	<tr>
		<td><div class="ew-group-indent"></div></td>
		<td class="ew-group-header"><?php echo $Relatorio_de_projetos_por_responsavel->nome->caption() ?></td>
		<td class="ew-group-header"><?php echo $Relatorio_de_projetos_por_responsavel->plataforma->caption() ?></td>
	</tr>
<?php
	}
	while (!$Relatorio_de_projetos_por_responsavel_report->DetailRecordset->EOF) {
		$Relatorio_de_projetos_por_responsavel_report->RowCnt++;
		$Relatorio_de_projetos_por_responsavel->nome->setDbValue($Relatorio_de_projetos_por_responsavel_report->DetailRecordset->fields('nome'));
		$Relatorio_de_projetos_por_responsavel->plataforma->setDbValue($Relatorio_de_projetos_por_responsavel_report->DetailRecordset->fields('plataforma'));

		// Render for view
		$Relatorio_de_projetos_por_responsavel->RowType = ROWTYPE_VIEW;
		$Relatorio_de_projetos_por_responsavel->resetAttributes();
		$Relatorio_de_projetos_por_responsavel_report->renderRow();
?>
	<tr>
		<td><div class="ew-group-indent"></div></td>
		<td<?php echo $Relatorio_de_projetos_por_responsavel->nome->cellAttributes() ?>>
<span<?php echo $Relatorio_de_projetos_por_responsavel->nome->viewAttributes() ?>>
<?php echo $Relatorio_de_projetos_por_responsavel->nome->getViewValue() ?></span>
</td>
		<td<?php echo $Relatorio_de_projetos_por_responsavel->plataforma->cellAttributes() ?>>
<span<?php echo $Relatorio_de_projetos_por_responsavel->plataforma->viewAttributes() ?>>
<?php echo $Relatorio_de_projetos_por_responsavel->plataforma->getViewValue() ?></span>
</td>
	</tr>
<?php
		$Relatorio_de_projetos_por_responsavel_report->DetailRecordset->moveNext();
	}
	$Relatorio_de_projetos_por_responsavel_report->DetailRecordset->close();

	// Save old group data
	$Relatorio_de_projetos_por_responsavel_report->ReportGroups[0] = $Relatorio_de_projetos_por_responsavel->responsavel->CurrentValue;

	// Get next record
	$Relatorio_de_projetos_por_responsavel_report->Recordset->moveNext();
	if ($Relatorio_de_projetos_por_responsavel_report->Recordset->EOF) {
		$Relatorio_de_projetos_por_responsavel_report->RecCnt = 0; // EOF, force all level breaks
	} else {
		$Relatorio_de_projetos_por_responsavel->responsavel->setDbValue($Relatorio_de_projetos_por_responsavel_report->Recordset->fields('responsavel'));
	}
	$Relatorio_de_projetos_por_responsavel_report->checkLevelBreak();

	// Show footers
	if ($Relatorio_de_projetos_por_responsavel_report->LevelBreak[1]) {
		$Relatorio_de_projetos_por_responsavel->responsavel->CurrentValue = $Relatorio_de_projetos_por_responsavel_report->ReportGroups[0];

		// Render row for view
		$Relatorio_de_projetos_por_responsavel->RowType = ROWTYPE_VIEW;
		$Relatorio_de_projetos_por_responsavel->resetAttributes();
		$Relatorio_de_projetos_por_responsavel_report->renderRow();
		$Relatorio_de_projetos_por_responsavel->responsavel->CurrentValue = $Relatorio_de_projetos_por_responsavel->responsavel->DbValue;
?>
<?php
}
}

// Close recordset
$Relatorio_de_projetos_por_responsavel_report->Recordset->close();
?>
<?php if ($Relatorio_de_projetos_por_responsavel_report->RecordExists) { ?>
	<tr><td colspan="3">&nbsp;<br></td></tr>
	<tr><td colspan="3" class="ew-grand-summary"><?php echo $Language->Phrase("RptGrandTotal") ?>&nbsp;(<?php echo FormatNumber($Relatorio_de_projetos_por_responsavel_report->ReportCounts[0], 0) ?>&nbsp;<?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
<?php if ($Relatorio_de_projetos_por_responsavel_report->RecordExists) { ?>
	<tr><td colspan=3>&nbsp;<br></td></tr>
<?php } else { ?>
	<tr><td><?php echo $Language->phrase("NoRecord") ?></td></tr>
<?php } ?>
</table>
<?php
$Relatorio_de_projetos_por_responsavel_report->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$Relatorio_de_projetos_por_responsavel->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$Relatorio_de_projetos_por_responsavel_report->terminate();
?>