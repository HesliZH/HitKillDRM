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
echo $sideMenu->toScript();
?>