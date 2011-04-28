<?php
// Header for FAB theme
//
// webtrees: Web based Family History software
// Copyright (C) 2010 webtrees development team.
//
// Derived from PhpGedView
// Modifications Copyright (c) 2010 Greg Roach
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//
// @package webtrees
// @subpackage Themes
// @version $Id$

if (!defined('WT_WEBTREES')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

// Definitions to simplify logic on pages with right-to-left languages
// TODO: merge this into the trunk?
if ($TEXT_DIRECTION=='ltr') {
	define ('WT_CSS_ALIGN',         'left');
	define ('WT_CSS_REVERSE_ALIGN', 'right');
} else {
	define ('WT_CSS_ALIGN',         'right');
	define ('WT_CSS_REVERSE_ALIGN', 'left');
}

echo
	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
	'<html xmlns="http://www.w3.org/1999/xhtml" ', WT_I18N::html_markup(), '>',
	'<head>',
	'<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />',
	'<title>', htmlspecialchars($title), '</title>',
	'<link type="image/x-icon" rel="shortcut icon" href="favicon.ico" />';
	
if (!empty($LINK_CANONICAL)) {
	echo '<link rel="canonical" href="', $LINK_CANONICAL, '" />';
}
if (!empty($META_DESCRIPTION)) {
	echo '<meta name="description" content="', htmlspecialchars($META_DESCRIPTION), '" />';
}
echo '<meta name="robots" content="', $META_ROBOTS, '" />';
if (!empty($META_GENERATOR)) {
	echo '<meta name="generator" content="', $META_GENERATOR, '" />';
}
	
echo
	$javascript,
	'<link type="text/css" rel="stylesheet" href="js/jquery/css/jquery-ui.custom.css" />',
	'<link type="text/css" rel="stylesheet" href="', $stylesheet, '" />';

if ($TEXT_DIRECTION=='rtl') {
	echo '<link type="text/css" rel="stylesheet" href="', WT_THEME_DIR, 'jquery/jquery-ui_theme_rtl.css" />';
}

if (file_exists(WT_THEME_DIR.$BROWSERTYPE.'.css')) {
	echo '<link type="text/css" rel="stylesheet" href="',  WT_THEME_DIR, $BROWSERTYPE, '.css" />';
}

if (WT_USE_LIGHTBOX) {
	if ($TEXT_DIRECTION=='rtl') {
		echo
			'<link type="text/css" rel="stylesheet" href="', WT_MODULES_DIR, 'lightbox/css/clearbox_music_RTL.css" />',
			'<link type="text/css" rel="stylesheet" href="', WT_MODULES_DIR, 'lightbox/css/album_page_RTL_ff.css" />';
	} else {
		echo
			'<link type="text/css" rel="stylesheet" href="', WT_MODULES_DIR, 'lightbox/css/clearbox_music.css" />',
			'<link type="text/css" rel="stylesheet" href="', WT_MODULES_DIR, 'lightbox/css/album_page.css" />';
	}
}

echo
	'<link type="text/css" rel="stylesheet" href="', WT_THEME_DIR, 'modules.css" />',
	'</head>',
	'<body id="body">';

if ($view!='simple') { // Use "simple" headers for popup windows
	echo '<div id="header" class="block">';
	// Print the user links
	if ($SEARCH_SPIDER) {
		// Search engines get a reduced menu
		$menu_items=array(
			WT_MenuBar::getGedcomMenu(),
			WT_MenuBar::getListsMenu(),
			WT_MenuBar::getCalendarMenu()
		);
	} else {
		// Options for real users
		echo '<div style="float:', WT_CSS_REVERSE_ALIGN, ';"><ul class="makeMenu">';
		if (WT_USER_ID) {
			echo '<li><a href="edituser.php" class="link">', getUserFullName(WT_USER_ID), '</a></li> <li>', logout_link(), '</li>';
			if (WT_USER_CAN_ACCEPT && exists_pending_change()) {
				echo ' <li><a href="javascript:;" onclick="window.open(\'edit_changes.php\',\'_blank\',\'width=600,height=500,resizable=1,scrollbars=1\'); return false;" style="color:red;">', WT_I18N::translate('Pending changes'), '</a></li>';
			}
		} else {
			echo '<li>', login_link(), '</li> ';
		}
		echo WT_MenuBar::getFavoritesMenu()->getMenuAsList();
		$language_menu=WT_MenuBar::getLanguageMenu();
		if ($language_menu) {
			echo $language_menu->getMenuAsList();
		}
		global $ALLOW_THEME_DROPDOWN;
		if ($ALLOW_THEME_DROPDOWN && get_site_setting('ALLOW_USER_THEMES')) {
			echo WT_MenuBar::getThemeMenu()->getMenuAsList();
		}
		echo
			'<li><form style="display:inline;" action="search.php" method="get">',
			'<input type="hidden" name="action" value="general" />',
			'<input type="hidden" name="topsearch" value="yes" />',
			'<input type="text" name="query" size="20" value="', WT_I18N::translate('Search'), '" onfocus="if (this.value==\'', WT_I18N::translate('Search'), '\') this.value=\'\'; focusHandler();" onblur="if (this.value==\'\') this.value=\'', WT_I18N::translate('Search'), '\';" />',
			'</form></li>',
			'</ul></div>';
		$menu_items=array(
			WT_MenuBar::getGedcomMenu(),
			WT_MenuBar::getMyPageMenu(),
			WT_MenuBar::getChartsMenu(),
			WT_MenuBar::getListsMenu(),
			WT_MenuBar::getCalendarMenu(),
			WT_MenuBar::getReportsMenu(),
			WT_MenuBar::getSearchMenu(),
		);
		foreach (WT_MenuBar::getModuleMenus() as $menu) {
			$menu_items[]=$menu;
		}
		$menu_items[]=WT_MenuBar::getHelpMenu();

		echo
			'<div style="float:', WT_CSS_ALIGN, '; clear:', WT_CSS_ALIGN, '; font-size:175%;">',
			htmlspecialchars($GEDCOM_TITLE),
			'</div>';
	}
	// Print the menu bar
	echo '<div id="topMenu"><ul class="makeMenu">';
	foreach ($menu_items as $menu) {
		if ($menu) {
			echo $menu->getMenuAsList();
		}
	}
	unset($menu_items, $menu);
	echo '</ul></div></div>';
}
echo '<div id="content">';
