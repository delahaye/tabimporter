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
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['title']         = array('Titel', 'Bezeichnung für den Importjob.');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['keepVersions']  = array('Backup-Versionen', 'Anzahl der gesicherten Tabellenstände vor Ausführung des Jobs.');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['lastrun']       = array('Letzter Lauf', 'Letzter Lauf des Importjobs.');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['token']         = array('Token für Cronjob', 'Um den Importjob via Cron aufzurufen, verwenden Sie das Format http://{IHRE-DOMAIN}/tabimporter.php?token={TOKEN}. Der Token wird automatisch errechnet, wenn der Job gespeichert wird.');

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['new']          = array('Neuer Importjob', 'Konfiguration für einen neuen Importjob erstellen.');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['restore']      = array('Wiederherstellen', 'Einen gesichtern Stand diverser Tabellen wiederherstellen.');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['howto']        = array('Hilfe', 'Kurze Anleitung zu Import-Jobs.');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['show']         = array('Details des Importjobs', 'Die Details des Importjobs ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['edit']         = array('Schritte des Importjobs', 'Importjob ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['editheader']   = array('Einstellungen des Importjobs', 'Einstellungen des Importjobs ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['copy']         = array('Importjob duplizieren', 'Importjob ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['delete']       = array('Importjob löschen', 'Importjob ID %s löschen');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['tables']       = array('Tabellendefinitionen des Importjobs', 'Tabellendefinitionen des Importjobs ID %s');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['runjob']       = array('Importjob ausführen', 'Importjob ID %s ausführen');
$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['runs']         = array('History', 'History des Importjobs ID %s ansehen');

?>