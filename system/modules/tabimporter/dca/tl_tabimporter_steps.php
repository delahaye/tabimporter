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
 * Table tl_tabimporter_steps
 */
$GLOBALS['TL_DCA']['tl_tabimporter_steps'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_tabimporter_jobs'
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'flag'                    => 1,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_tabimporter_steps', 'listSteps')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_tabimporter_steps', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('action'),
		'default'                     => '{title_legend},title,published;{steps_legend},abortOnError,action',
		'tableimport'                 => '{title_legend},title,published;{steps_legend},abortOnError,action,tableimport',
		'sql'                         => '{title_legend},title,published;{steps_legend},abortOnError,action,sqlData',
		'hook'                        => '{title_legend},title,published;{steps_legend},abortOnError,action,hook'
	),

	// Fields
	'fields' => array
	(
		'sorting' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['MSC']['sorting'],
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 1,
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'abortOnError' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['abortOnError'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox'
		),
		'action' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['action'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options'                 => array('tableimport','sql','hook'),
			'default'                 => 'tableimport',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['references'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'tableimport' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['tableimport'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_steps','getTableimports'),
			'wizard' => array
			(
				array('tl_tabimporter_steps', 'editTableimport')
			)
		),
		'sqlData' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['sqlData'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('decodeEntities'=>true)
		),
		'hook' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_steps']['hook'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_steps','getHooks')
		)

	)
);


/**
 * Class tl_tabimporter_steps
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class tl_tabimporter_steps extends Backend
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
	 * List steps
	 * @param array
	 * @return string
	 */
	public function listSteps($arrRow)
	{
		if($arrRow['tableimport'])
		{
			$objData = $this->Database->prepare("SELECT title FROM tl_tabimporter_tables WHERE id=?")
				->limit(1)
				->execute($arrRow['tableimport']);
		}

		$key = $arrRow['published'] ? 'published' : 'unpublished';

		$return = '<div class="cte_type ' . $key . '"><strong>' . $arrRow['title'] . '</strong></div>';
		$return .= ($arrRow['action']=='tableimport' ? '<div>' . $GLOBALS['TL_LANG']['tl_tabimporter_steps']['references'][$arrRow['action']].': '.$objData->title.' ('.$arrRow['tableimport'].')'.'</div>' : '');
		$return .= ($arrRow['action']=='sql' ? '<div>' . $GLOBALS['TL_LANG']['tl_tabimporter_steps']['references'][$arrRow['action']].'</div>' : '');
		$return .= ($arrRow['action']=='hook' ? '<div>' . $GLOBALS['TL_LANG']['tl_tabimporter_steps']['references'][$arrRow['action']].': '.$arrRow['hook'].'</div>' : '');
		$return .= ($arrRow['abortOnError'] ? '<div>' . $GLOBALS['TL_LANG']['tl_tabimporter_steps']['abortOnError'][0] . '</div>' : '');
		$return .= "\n";

		return $return;
	}

	/**
	 * Get possible hooks
	 */
	public function getHooks($arrRow)
	{
		return $this->tabImporter->getHooks();
	}

	/**
	 * Get possible table configurstions
	 * @param object
	 * @return array
	 */
	public function getTableimports($objRow)
	{
		$return = array();

		$objTables = $this->Database->prepare("SELECT id,title FROM tl_tabimporter_tables WHERE pid=? ORDER BY title")
			->execute($objRow->activeRecord->pid);
		
		while($objTables->next())
		{
			$return[$objTables->id] = $objTables->title;
		}

		return $return;
	}

	/**
	 * Return the edit tableimporter wizard
	 * @param object
	 * @return string
	 */
	public function editTableimport(DataContainer $dc)
	{
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=tabimporter&amp;table=tl_tabimporter_fields&amp;id=' . $dc->value . '" title="'.sprintf(specialchars($GLOBALS['TL_LANG']['tl_content']['editalias'][1]), $dc->value).'" style="padding-left:3px;">' . $this->generateImage('alias.gif', $GLOBALS['TL_LANG']['tl_content']['editalias'][0], 'style="vertical-align:top;"') . '</a>';
	}

	/**
	 * Return the "toggle visibility" button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen($this->Input->get('tid')))
		{
			$this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_tabimporter_steps::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}		

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
	}


	/**
	 * Disable/enable an element
	 * @param integer
	 * @param boolean
	 */
	public function toggleVisibility($intId, $blnVisible)
	{
		// Check permissions to publish
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_tabimporter_steps::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish Job step ID "'.$intId.'"', 'tl_tabimporter_steps toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_tabimporter_steps', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_tabimporter_steps']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_tabimporter_steps']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_tabimporter_steps SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_tabimporter_steps', $intId);
	}

}

?>