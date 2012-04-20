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
 * Table tl_tabimporter_runsteps
 */
$GLOBALS['TL_DCA']['tl_tabimporter_runsteps'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_tabimporter_runs',
		'closed'                      => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'flag'                    => 5,
			'fields'                  => array('id'),
			'panelLayout'             => 'filter;search,limit',
			'headerFields'            => array('job','begin','end','status','user'),
			'child_record_callback'   => array('tl_tabimporter_runsteps', 'listElements')
		),
		'operations' => array
		(
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_runsteps']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},step,title,status,details'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sorting'                 => true,
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runsteps']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'step' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runsteps']['step'],
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runsteps']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'                 => array('ok','error','abort'),
			'default'                 => 'ok',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_runsteps']['references']
		),
		'details' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runsteps']['details'],
			'exclude'                 => true,
			'inputType'               => 'textarea'
		)
	)
);


/**
 * Class tl_tabimporter_runsteps
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class tl_tabimporter_runsteps extends Backend
{

	/**
	 * Import the back end user and the tabimporter object
	 */
	public function __construct()
	{
		parent::__construct();

		$this->import('BackendUser', 'User');
		$this->tabImporter = new tabImporter;
	}


	/**
	 * List the elements
	 * @param array
	 * @return string
	 */
	public function listElements($arrRow)
	{
		return '<div class="tl_tabimporter_'.$arrRow['status'].'">'.$arrRow['title'].' '.date($GLOBALS['TL_CONFIG']['dateFormat'],$arrRow['tstamp']).' '.date('H:i:s',$arrRow['tstamp']).'</div>' . "\n";
	}
}

?>