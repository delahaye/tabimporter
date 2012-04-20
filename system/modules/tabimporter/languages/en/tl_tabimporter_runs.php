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
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['job']       = array('Job', 'Titel des Importjobs.');
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['begin']     = array('Beginn', 'Startzeit des Importjobs.');
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['end']       = array('Ende', 'Endzeit des Importjobs.');
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['user']      = array('Benutzer', 'Ausführender Benutzer.');
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['status']    = array('Status', 'Status des Importjobs.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['title_legend']   = 'Allgemeines';

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['references']['ok']     = 'Ok';
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['references']['error']  = 'Fehler';
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['references']['warn']   = 'Ok (Warnungen)';
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['references']['abort']  = 'Abbruch';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['show']       = array('Details des Importlaufs', 'Die Details des Importlaufs ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['edit']       = array('Log des Importlaufs', 'Log des Importlaufs ID %s');
$GLOBALS['TL_LANG']['tl_tabimporter_runs']['delete']     = array('Importlauf löschen', 'Importlauf ID %s löschen');

?>