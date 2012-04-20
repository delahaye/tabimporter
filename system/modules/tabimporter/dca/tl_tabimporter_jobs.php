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
 * Table tl_tabimporter_jobs
 */
$GLOBALS['TL_DCA']['tl_tabimporter_jobs'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_tabimporter_steps','tl_tabimporter_tables','tl_tabimporter_runs'),
		'switchToEdit'                => true,
		'onsubmit_callback'           => array(
			array('tl_tabimporter_jobs','setToken')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'filter,search,limit',
		),
		'global_operations' => array
		(
			'restore' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['restore'],
				'href'                => 'key=restore',
				'class'               => 'header_restore',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="r"'
			),
			'howto' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['howto'],
				'href'                => 'key=howto',
				'class'               => 'header_howto',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="h"'
			)
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['edit'],
				'href'                => 'table=tl_tabimporter_steps',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_tabimporter_jobs', 'editHeader'),
				'attributes'          => 'class="edit-header"'
			),
			'tables' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['tables'],
				'href'                => 'table=tl_tabimporter_tables',
				'icon'                => 'system/modules/tabimporter/html/icon_tables.png'
			),
			'runs' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['runs'],
				'href'                => 'table=tl_tabimporter_runs',
				'icon'                => 'system/modules/tabimporter/html/icon_runs.png'
			),
			'runjob' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['runjob'],
				'href'                => 'key=runjob',
				'icon'                => 'system/modules/tabimporter/html/icon_jobs.png'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => 'title,keepVersions,token'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'keepVersions' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['keepVersions'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'default'                 => '3',
			'options'                 => array('1','2','3','4','5','10','20','50','100')
		),
		'token' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['token'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'alwaysSave'=>true)
		),
		'lastrun' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_jobs']['lastrun'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		)
	)
);


/**
 * Class tl_tabimporter_jobs
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class tl_tabimporter_jobs extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_tabimporter_jobs::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

	/**
	 * Set the cron token
	 * @param object
	 */
	public function setToken(DataContainer $dc)
	{
		$this->Database->prepare("UPDATE tl_tabimporter_jobs SET token=? WHERE id=?")
			->execute(md5($dc->id.$GLOBALS['TL_CONFIG']['encryptionKey']),$dc->id);
	}

}

?>