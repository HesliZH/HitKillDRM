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
$Relatorio_de_projetos_pendentes_report = new Relatorio_de_projetos_pendentes_report();

// Run the page
$Relatorio_de_projetos_pendentes_report->run();

// Setup login status
SetupLoginStatus();
SetClientVar("login", LoginStatus());

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$Relatorio_de_projetos_pendentes_report->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if (!$Relatorio_de_projetos_pendentes->isExport()) { ?>
<script>

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php
$Relatorio_de_projetos_pendentes_report->RecCnt = 1; // No grouping
if ($Relatorio_de_projetos_pendentes_report->DbDetailFilter <> "") {
	if ($Relatorio_de_projetos_pendentes_report->ReportFilter <> "") $Relatorio_de_projetos_pendentes_report->ReportFilter .= " AND ";
	$Relatorio_de_projetos_pendentes_report->ReportFilter .= "(" . $Relatorio_de_projetos_pendentes_report->DbDetailFilter . ")";
}
$ReportConn = &$Relatorio_de_projetos_pendentes_report->getConnection();

// Set up detail SQL
$Relatorio_de_projetos_pendentes->CurrentFilter = $Relatorio_de_projetos_pendentes_report->ReportFilter;
$Relatorio_de_projetos_pendentes_report->ReportSql = $Relatorio_de_projetos_pendentes->getDetailSql();

// Load recordset
$Relatorio_de_projetos_pendentes_report->Recordset = $ReportConn->Execute($Relatorio_de_projetos_pendentes_report->ReportSql);
$Relatorio_de_projetos_pendentes_report->RecordExists = !$Relatorio_de_projetos_pendentes_report->Recordset->EOF;
?>
<?php if (!$Relatorio_de_projetos_pendentes->isExport()) { ?>
<?php if ($Relatorio_de_projetos_pendentes_report->RecordExists) { ?>
<div class="ew-view-export-options"><?php $Relatorio_de_projetos_pendentes_report->ExportOptions->render("body") ?></div>
<?php } ?>
<?php } ?>
<?php $Relatorio_de_projetos_pendentes_report->showPageHeader(); ?>
<table class="ew-report-table">
<?php

	// Get detail records
	$Relatorio_de_projetos_pendentes_report->ReportFilter = $Relatorio_de_projetos_pendentes_report->DefaultFilter;
	if ($Relatorio_de_projetos_pendentes_report->DbDetailFilter <> "") {
		if ($Relatorio_de_projetos_pendentes_report->ReportFilter <> "")
			$Relatorio_de_projetos_pendentes_report->ReportFilter .= " AND ";
		$Relatorio_de_projetos_pendentes_report->ReportFilter .= "(" . $Relatorio_de_projetos_pendentes_report->DbDetailFilter . ")";
	}
	if (!$Security->canReport()) {
		if ($Relatorio_de_projetos_pendentes_report->ReportFilter <> "")
			$Relatorio_de_projetos_pendentes_report->ReportFilter .= " AND ";
		$Relatorio_de_projetos_pendentes_report->ReportFilter .= "(0=1)";
	}

	// Set up detail SQL
	$Relatorio_de_projetos_pendentes->CurrentFilter = $Relatorio_de_projetos_pendentes_report->ReportFilter;
	$Relatorio_de_projetos_pendentes_report->ReportSql = $Relatorio_de_projetos_pendentes->getDetailSql();

	// Load detail records
	$Relatorio_de_projetos_pendentes_report->DetailRecordset = $ReportConn->execute($Relatorio_de_projetos_pendentes_report->ReportSql);
	$Relatorio_de_projetos_pendentes_report->DtlRecordCount = $Relatorio_de_projetos_pendentes_report->DetailRecordset->RecordCount();

	// Initialize aggregates
	if (!$Relatorio_de_projetos_pendentes_report->DetailRecordset->EOF) {
		$Relatorio_de_projetos_pendentes_report->RecCnt++;
	}
	if ($Relatorio_de_projetos_pendentes_report->RecCnt == 1) {
		$Relatorio_de_projetos_pendentes_report->ReportCounts[0] = 0;
	}
	$Relatorio_de_projetos_pendentes_report->ReportCounts[0] += $Relatorio_de_projetos_pendentes_report->DtlRecordCount;
	if ($Relatorio_de_projetos_pendentes_report->RecordExists) {
?>
	<tr>
		<td class="ew-group-header"><?php echo $Relatorio_de_projetos_pendentes->codigo->caption() ?></td>
		<td class="ew-group-header"><?php echo $Relatorio_de_projetos_pendentes->jogo->caption() ?></td>
		<td class="ew-group-header"><?php echo $Relatorio_de_projetos_pendentes->estagio->caption() ?></td>
	</tr>
<?php
	}
	while (!$Relatorio_de_projetos_pendentes_report->DetailRecordset->EOF) {
		$Relatorio_de_projetos_pendentes_report->RowCnt++;
		$Relatorio_de_projetos_pendentes->codigo->setDbValue($Relatorio_de_projetos_pendentes_report->DetailRecordset->fields('codigo'));
		$Relatorio_de_projetos_pendentes->jogo->setDbValue($Relatorio_de_projetos_pendentes_report->DetailRecordset->fields('jogo'));
		$Relatorio_de_projetos_pendentes->estagio->setDbValue($Relatorio_de_projetos_pendentes_report->DetailRecordset->fields('estagio'));

		// Render for view
		$Relatorio_de_projetos_pendentes->RowType = ROWTYPE_VIEW;
		$Relatorio_de_projetos_pendentes->resetAttributes();
		$Relatorio_de_projetos_pendentes_report->renderRow();
?>
	<tr>
		<td<?php echo $Relatorio_de_projetos_pendentes->codigo->cellAttributes() ?>>
<span<?php echo $Relatorio_de_projetos_pendentes->codigo->viewAttributes() ?>>
<?php echo $Relatorio_de_projetos_pendentes->codigo->getViewValue() ?></span>
</td>
		<td<?php echo $Relatorio_de_projetos_pendentes->jogo->cellAttributes() ?>>
<span<?php echo $Relatorio_de_projetos_pendentes->jogo->viewAttributes() ?>>
<?php echo $Relatorio_de_projetos_pendentes->jogo->getViewValue() ?></span>
</td>
		<td<?php echo $Relatorio_de_projetos_pendentes->estagio->cellAttributes() ?>>
<span<?php echo $Relatorio_de_projetos_pendentes->estagio->viewAttributes() ?>>
<?php echo $Relatorio_de_projetos_pendentes->estagio->getViewValue() ?></span>
</td>
	</tr>
<?php
		$Relatorio_de_projetos_pendentes_report->DetailRecordset->moveNext();
	}
	$Relatorio_de_projetos_pendentes_report->DetailRecordset->close();
?>
<?php if ($Relatorio_de_projetos_pendentes_report->RecordExists) { ?>
	<tr><td colspan="3">&nbsp;<br></td></tr>
	<tr><td colspan="3" class="ew-grand-summary"><?php echo $Language->Phrase("RptGrandTotal") ?>&nbsp;(<?php echo FormatNumber($Relatorio_de_projetos_pendentes_report->ReportCounts[0], 0) ?>&nbsp;<?php echo $Language->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
<?php if ($Relatorio_de_projetos_pendentes_report->RecordExists) { ?>
	<tr><td colspan=3>&nbsp;<br></td></tr>
<?php } else { ?>
	<tr><td><?php echo $Language->phrase("NoRecord") ?></td></tr>
<?php } ?>
</table>
<?php
$Relatorio_de_projetos_pendentes_report->showPageFooter();
if (DEBUG_ENABLED)
	echo GetDebugMessage();
?>
<?php if (!$Relatorio_de_projetos_pendentes->isExport()) { ?>
<script>

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$Relatorio_de_projetos_pendentes_report->terminate();
?>