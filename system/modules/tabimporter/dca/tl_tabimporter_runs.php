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
 * Table tl_tabimporter_runs
 */
$GLOBALS['TL_DCA']['tl_tabimporter_runs'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_tabimporter_jobs',
		'ctable'                      => array('tl_tabimporter_runsteps'),
		'switchToEdit'                => false,
		'closed'                      => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'flag'                    => 5,
			'fields'                  => array('begin'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_tabimporter_runs', 'listRuns')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['edit'],
				'href'                => 'table=tl_tabimporter_runsteps',
				'icon'                => 'system/modules/tabimporter/html/icon_runsteps.png'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},job,begin,end,status,user'
	),

	// Fields
	'fields' => array
	(
		'job' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['job'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'begin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['begin'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'end' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['end'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'user' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['user'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name'
		),
		'status' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['status'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'                 => array('ok','error','abort'),
			'default'                 => 'ok',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_runs']['references']
		)
	)
);


/**
 * Class tl_tabimporter_runs
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class tl_tabimporter_runs extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
		$this->tabImporter = new tabImporter;
	}

	/**
	 * List recorded runs
	 * @param array
	 * @return string
	 */
	public function listRuns($arrRow)
	{
		switch($arrRow['status'])
		{
			case 'ok':
				$strColor = '#008000';
				break;
			case 'error':
				$strColor = '#ff8000';
				break;
			case 'warn':
				$strColor = '#c0c000';
				break;
			case 'abort':
				$strColor = '#f80000';
				break;
		}

		return '<div><span style="font-weight:bold;color:'.$strColor.';">'.$GLOBALS['TL_LANG']['tl_tabimporter_runs']['references'][$arrRow['status']].'</span>: '.date($GLOBALS['TL_CONFIG']['datimFormat'],$arrRow['begin']).'</div>' . "\n";
	}

	/**
	 * Return the edit header button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || count(preg_grep('/^tl_tabimporter_runs::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

}

?>