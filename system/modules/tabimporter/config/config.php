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
 * Add back end modules
 */

array_insert($GLOBALS['BE_MOD']['content'], sizeof($GLOBALS['BE_MOD']['content']), array('tabimporter' => array
(
	'tables' 	=> array('tl_tabimporter_jobs','tl_tabimporter_steps','tl_tabimporter_tables', 'tl_tabimporter_fields','tl_tabimporter_runs', 'tl_tabimporter_runsteps'),
	'icon'   	=> 'system/modules/tabimporter/html/icon_jobs.png',
	'runjob' 	=> array('ModuleTabimporter', 'compile'),
	'restore' 	=> array('ModuleTabimporterRestore', 'compile'),
	'howto' 	=> array('ModuleTabimporterHowto', 'compile')
)
));

if (TL_MODE == 'BE')
{
	$GLOBALS['TL_CSS'][] = 'system/modules/tabimporter/html/be.css'; 
}

$GLOBALS['tl_tabimporter']['sqlSteps'] = array
(
	'update' 	=> 0,
	'insert' 	=> 0,
	'maxtime' 	=> 30
);

$GLOBALS['tl_tabimporter']['sourceTypes'] = array
(
	'db' => array(
		'needsExactRowmatch' => false,
		'getDataOnStepbegin' => false
		),
	'csv' => array(
		'needsExactRowmatch' => true,
		'getDataOnStepbegin' => true
		)
);



?>