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
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['title']          = array('Titel', 'Bezeichnung für den Tabellenimport.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['abortOnError']   = array('(Teil-)Abbruch bei Fehlerzeilen', 'Dieser Tabellenimport wird verworfen, wenn sich ein Datensatz nicht anlegen oder aktualisieren lässt. Standardmäßig wird nur die betroffene Zeile ignoriert.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['targetTable']    = array('Ziel-Tabelle', 'Contao-Tabelle, in die importiert werden soll.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldsTarget']   = array('Felder in der Ziel-Tabelle - rein informativ', 'Diese Felder sind in der Ziel-Tabelle vorhanden. Das Feld wird automatisch belegt, Änderungen werden verworfen.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['sourceType']     = array('Datenquelle', 'Typ der verwendeten Datenquelle.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['sourceTable']    = array('Quell-Tabelle', 'Tabelle mit den zu importierenden Daten.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['useTmpTable']    = array('Nutze temporäre Tabellenversion', 'Statt der originalen Quell-Tabelle kann die - in einem vorhergehenden Schritt ggf. bereits veränderte - temporäre Tabellenversion als Quelle genutzt werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['sourceFile']     = array('Import-Datei', 'CSV-Datei, aus der importiert werden soll.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldCount']     = array('Felder', 'Anzahl der gefundenen Felder. Das Feld wird automatisch belegt, Änderungen werden verworfen.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['hasFieldnames']  = array('Erste Zeile enthält Feldnamen', 'Die erste Zeile wird dann nicht mit importiert.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldDelimiter'] = array('Trennzeichen', 'Trennzeichen in der Importdatei.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldsSource']   = array('Felder in der Quelle - rein informativ', 'In der Datenquelle gefundene Feldnamen. Das Feld wird automatisch belegt, Änderungen werden verworfen.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['uniqueTarget']   = array('Schlüsselfeld der Zieltabelle', 'Die Schlüsselfelder verknüpfen die Quelle und das Ziel eindeutig, z.B. über eine Artikelnummer.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['uniqueSource']   = array('Schlüsselfeld der Datenquelle', 'Die Schlüsselfelder verknüpfen die Quelle und das Ziel eindeutig, z.B. über eine Artikelnummer.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteOnStart']  = array('Daten vor dem Import löschen', 'Datensätze, die vor dem eigentlichen Import gelöscht werden sollen. Beide Auswahlen = Tabelle wird geleert.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteOnKey']    = array('nach Lösch-Kennzeichen löschen', 'Vor dem Import bestimmte Datensätze löschen.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteKeyField'] = array('Spalte mit Lösch-Kennzeichen', 'Feld der Datenquelle.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteKeyValue'] = array('Vergleichswert', 'Wenn das Feld in der Datenquelle diesen Wert besitzt, wird der Datensatz gelöscht.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['allowInsert']    = array('Neue Datensätze anlegen', 'In der Quelldatei neu vorhandene Datensätze werden angelegt.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['allowUpdate']    = array('Updates möglich', 'Die Update-Regeln der Feld-Konfigurationen werden abgearbeitet.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['title_legend']   = 'Allgemeines';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['target_legend']  = 'Zieltabelle';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['source_legend']  = 'Datenquelle';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['update_legend']  = 'Updates';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['semicolon']  = 'Semikolon ;';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['comma']      = 'Komma ,';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['tab']        = 'Tabulator';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['csv']        = 'CSV-Datei';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['db']         = 'Datenbank-Tabelle';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['missing']    = 'alle Datensätze, die in der Quelldatei nicht mehr vorhanden sind';
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references']['existent']   = 'alle Datensätze der Quelldatei';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['new']        = array('Neuer Tabellenimport', 'Konfiguration für einen neuen Tabellenimport erstellen.');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['show']       = array('Details des Tabellenimports', 'Die Details des Tabellenimports ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['edit']       = array('Feldkonfigurationen des Tabellenimports', 'Tabellenimport ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['editheader'] = array('Einstellungen des Tabellenimports', 'Einstellungen des Tabellenimports ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['copy']       = array('Tabellenimport duplizieren', 'Tabellenimport ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_tabimporter_tables']['delete']     = array('Tabellenimport löschen', 'Tabellenimport ID %s löschen');

?>