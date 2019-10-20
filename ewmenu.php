<?php
namespace PHPMaker2019\DRM;

// Menu Language
if ($Language && $Language->LanguageFolder == $LANGUAGE_FOLDER)
	$MenuLanguage = &$Language;
else
	$MenuLanguage = new Language();

// Navbar menu
$topMenu = new Menu("navbar", TRUE, TRUE);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", TRUE, FALSE);
$sideMenu->addMenuItem(1, "mi_players", $MenuLanguage->MenuPhrase("1", "MenuText"), "playerslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}players'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(2, "mi_licencas", $MenuLanguage->MenuPhrase("2", "MenuText"), "licencaslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}licencas'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(3, "mi_cargos", $MenuLanguage->MenuPhrase("3", "MenuText"), "cargoslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}cargos'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(4, "mi_plataformas", $MenuLanguage->MenuPhrase("4", "MenuText"), "plataformaslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}plataformas'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(5, "mi_usuarios", $MenuLanguage->MenuPhrase("5", "MenuText"), "usuarioslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}usuarios'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(6, "mi_jogos", $MenuLanguage->MenuPhrase("6", "MenuText"), "jogoslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}jogos'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(7, "mi_controle_versoes", $MenuLanguage->MenuPhrase("7", "MenuText"), "controle_versoeslist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}controle_versoes'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(8, "mi_estagios_desenvolvimento", $MenuLanguage->MenuPhrase("8", "MenuText"), "estagios_desenvolvimentolist.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}estagios_desenvolvimento'), FALSE, FALSE, "", "", FALSE);
$sideMenu->addMenuItem(9, "mi_Relatorio_de_projetos_pendentes", $MenuLanguage->MenuPhrase("9", "MenuText"), "Relatorio_de_projetos_pendentesreport.php", -1, "", IsLoggedIn() || AllowListMenu('{D25E8543-1442-438F-944C-0B1439EAA2B1}Relatório de projetos pendentes'), FALSE, FALSE, "", "", FALSE);
echo $sideMenu->toScript();
?>