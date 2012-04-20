<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 * @license    LGPL
 * @filesource
 */

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['title']        = array('Titel', 'Bezeichnung für den Importschritt.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['published']    = array('Aktiv', 'Der Importschritt kann genutzt werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['abortOnError'] = array('Abbruch bei Fehlern', 'Der Importjob wird verworfen, wenn dieser Schritt wegen Fehlern abgebrochen wird.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['action']       = array('Aktion', 'Legen Sie die Art des Importschritts fest.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['tableimport']  = array('Tabellenimport', 'Für den Importschritt zu nutzender Tabellenimport.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['sqlData']          = array('SQL', 'SQL-Abfrage für den Importschritt.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['hook']         = array('Hook-Script', 'Es können neue, für den speziellen Import angepasste Hooks registriert werden.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['title_legend'] = 'Allgemeines';
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['steps_legend'] = 'Ablauf des Importschritts';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['references']['tableimport'] = 'Definierten Tabellenimport ausführen';
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['references']['sql']         = 'SQL-Abfrage ausführen';
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['references']['hook']        = 'Hook-Funktion ausführen';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['new']          = array('Neuer Importschritt', 'Konfiguration für einen neuen Importschritt erstellen.');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['show']         = array('Details des Importschritts', 'Die Details des Importschritts ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['edit']         = array('Schritte des Importschritts', 'Importschritt ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['editheader']   = array('Einstellungen des Importschritts', 'Einstellungen des Importschritts ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['copy']         = array('Importschritt duplizieren', 'Importschritt ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_tabimporter_steps']['delete']       = array('Importschritt löschen', 'Importschritt ID %s löschen');

?>