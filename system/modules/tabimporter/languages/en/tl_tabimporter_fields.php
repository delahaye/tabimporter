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
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fieldname']       = array('Zieltabellen-Feld', 'Feld in der Zieltabelle');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['published']       = array('Aktiv', 'Das Feld wird beim Import berücksichtigt.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['type']            = array('Datenermittlung', 'Legt fest, wie die Daten für das Feld ermittelt werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['field']           = array('Datenquellen-Feld', 'Feld in der Datenquelle');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['mode']            = array('Modus', 'Modus des Datenupdates');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['addDelimiter']    = array('Zusätzliche Zeichen vor/nach dem Wert aus der Quelle', 'Die Zeichenkette wird vor bzw. nach dem Wert eingefügt.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagMode']         = array('Tag-Behandlung', 'Legt fest, wie die Tags verwendet werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagTypeSource']   = array('Tag-Typ in der Datenquelle', 'Art der Tag-Speicherung in der Datenquelle.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagTypeTarget']   = array('Tag-Typ in der Zieltabelle', 'Art der Tag-Speicherung in der Zieltabelle.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['sourceDelimiter'] = array('Trennzeichen in der Datenquelle', 'Trennzeichen, falls nicht serialisiert wird.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['targetDelimiter'] = array('Trennzeichen in der Zieltabelle', 'Trennzeichen, falls nicht serialisiert wird.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['initialValue']    = array('Startwert-Ermittlung', 'Der Startwert kann automatisch ermittelt werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['start']           = array('Startwert', 'Erster Wert, nur ganze Zahl.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['step']            = array('Schrittweite', 'Wert wird jeweils addiert. Nur ganze Zahl.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fix']             = array('Fixer Wert', 'Jeder Datensatz erhält den gleichen Inhalt.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['sql']             = array('Wert aus SQL-Abfrage', 'Der zu ermittelnde Feldwert `tabimport_value` wird per SQL berechnet. Die Feldwerte des aktuellen Datensatzes der Datenquelle können mit ##feldname## genutzt werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['hook']            = array('Registrierte Hooks', 'Es können neue, für den spezillen Import angepasste Hooks registriert werden.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['allowInsert']     = array('Neue Datensätze anlegen', 'Nicht vorhandene Datensätze werden angelegt.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['allowUpdate']     = array('Datensätze updaten', 'Vorhandene Datensätze werden aktualisiert.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fillChar']        = array('Zeichen', 'Zeichen, mit dem aufgefüllt werden soll.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fieldLength']     = array('Ziel-Feldlänge', 'Gewünschte Zeichenanzahl.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['expandSide']      = array('Seite', 'Richtung, in die der gewählte Modus angewandt wird.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['expandString']    = array('Ergänzender Wert', 'Text, der angehangen oder vorangestellt wird.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['dateVal']         = array('Datum', 'Aus diesem Datum wird ein Timestamp ermittelt.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['timeVal']         = array('Zeit', 'Zeitangabe für den Timestamp.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['dateFormat']      = array('Format', 'Geliefertes Datums-Format.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tstampUp']        = array('Hinzuzurechende Sekunden', 'Dem aktuellen Zeitstempel kann eine bestimmte Anzahl von Sekunden hinzugerechnet werden.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['title_legend']   = 'Allgemeines';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['update_legend']  = 'Konfiguration für Updates von Datensätzen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['insert_legend']  = 'Konfiguration für neu eingefügte Datensätze';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['field']           = 'Feld';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['new']             = 'Anlage';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['update']          = 'Update';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Insertfromfield'] = 'aus Feld in der Datenquelle';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Insertfix']       = 'fester Wert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Insertsql']       = 'via SQL ermittelter Wert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Inserthook']      = 'via Hook-Funktion ermittelter Wert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Insertcountup']   = 'automatische Hochzählung';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Insertdate']      = 'fixes Datum';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Updatefromfield'] = 'aus Feld in der Datenquelle';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Updatefix']       = 'fester Wert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Updatesql']       = 'via SQL ermittelter Wert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Updatehook']      = 'via Hook-Funktion ermittelter Wert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Updatedate']      = 'fixes Datum';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['initialValue']    = 'Startwert-Ermittlung';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['ownValue']        = 'eigener Startwert';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['tabValue']        = 'höchster Wert aus der Zieltabelle plus Schrittweite';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Addnew']          = 'Wert 1:1 einfügen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Replace']         = 'Wert 1:1 ersetzen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Bool']            = 'ja/nein-Angabe';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Fill']            = 'auf feste Länge auffüllen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Crop']            = 'auf maximale Länge beschneiden';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Expand']          = 'Wert anhängen oder voranstellen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Tags']            = 'Tags, Serialisierungen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Add']             = 'In der Quelle vorhandene Tags hinzufügen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Delete']          = 'In der Quelle vorhandene Tags entfernen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['delimited']       = 'mit Trennzeichen';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['serialized']      = 'serialisiertes Feld';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['leftSide']        = 'linke Seite';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['rightSide']       = 'rechte Seite';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Datestring']      = 'Zeitstempel aus Datum ermitteln';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Updatetstamp']    = 'aktueller Zeitstempel';
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['Inserttstamp']    = 'aktueller Zeitstempel';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['new']        = array('Neue Feld-Konfiguration', 'Konfiguration für ein neues Feld erstellen.');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['show']       = array('Konfigurationsdetails', 'Die Details der Konfiguration ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['edit']       = array('Feld-Konfiguration bearbeiten', 'Konfiguration ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['copy']       = array('Konfiguration duplizieren', 'Konfiguration ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['cut']        = array('Konfiguration verschieben', 'Konfiguration ID %s verschieben');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['delete']     = array('Konfiguration löschen', 'Konfiguration ID %s löschen');
$GLOBALS['TL_LANG']['tl_tabimporter_fields']['toggle']     = array('Konfiguration aktivieren', 'Konfiguration ID %s aktivieren');

?>