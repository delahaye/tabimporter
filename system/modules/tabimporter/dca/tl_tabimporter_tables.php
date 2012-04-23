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
 * Table tl_tabimporter_tables
 */
$GLOBALS['TL_DCA']['tl_tabimporter_tables'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_tabimporter_jobs',
		'ctable'                      => array('tl_tabimporter_fields'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'onsubmit_callback'           => array(
			array('tl_tabimporter_tables','presetFields')
			)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'flag'                    => 1,
			'fields'                  => array('title'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;search,limit',
			'child_record_callback'   => array('tl_tabimporter_tables', 'listTables')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['edit'],
				'href'                => 'table=tl_tabimporter_fields',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['editheader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_tabimporter_tables', 'editHeader'),
				'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('sourceType','deleteOnKey'),
		'default'                     => '{title_legend},title,abortOnError;{target_legend:show},targetTable,fieldsTarget;{source_legend:show},sourceType,fieldsSource;{update_legend:show},uniqueTarget,uniqueSource,deleteOnStart,deleteOnKey,allowInsert,allowUpdate',
		'csv'                         => '{title_legend},title,abortOnError;{target_legend:show},targetTable,fieldsTarget;{source_legend:show},sourceType,sourceFile,fieldDelimiter,fieldCount,hasFieldnames,fieldsSource;{update_legend:show},uniqueTarget,uniqueSource,deleteOnStart,deleteOnKey,allowInsert,allowUpdate',
		'db'                          => '{title_legend},title,abortOnError;{target_legend:show},targetTable,fieldsTarget;{source_legend:show},sourceType,sourceTable,useTmpTable,fieldsSource;{update_legend:show},uniqueTarget,uniqueSource,deleteOnStart,deleteOnKey,allowInsert,allowUpdate'
	),

	// Palettes
	'subpalettes' => array
	(
		'deleteOnKey'                 => 'deleteKeyField,deleteKeyValue'
	),

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255)
		),
		'abortOnError' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['abortOnError'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox'
		),
		'targetTable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['targetTable'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_tables','getTables')
		),
		'fieldsTarget' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldsTarget'],
			'inputType'               => 'textarea',
			'search'                  => true,
			'eval'                    => array('disabled'=>true)
		),
		'sourceType' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['sourceType'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'options'                 => array('csv','db'),
			'default'                 => 'csv',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'sourceTable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['sourceTable'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_tables','getTables')
		),
		'useTmpTable' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['useTmpTable'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox'
		),
		'sourceFile' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['sourceFile'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'extensions'=>'csv,txt', 'tl_class'=>'clr', 'mandatory'=>true)
		),
		'fieldCount' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldCount'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('disabled'=>true, 'tl_class'=>'w50')
		),
		'hasFieldnames' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['hasFieldnames'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'fieldDelimiter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldDelimiter'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('comma','semicolon','tab'),
			'default'                 => 'semicolon',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'fieldsSource' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['fieldsSource'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('disabled'=>true)
		),
		'uniqueTarget' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['uniqueTarget'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_tables','getTargetFields'),
			'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true)
		),
		'uniqueSource' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['uniqueSource'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_tables','getSourceFields'),
			'eval'                    => array('tl_class'=>'w50', 'includeBlankOption'=>true)
		),
		'deleteOnStart' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteOnStart'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'options'                 => array('missing','existent'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['references'],
			'eval'                    => array('multiple'=>true, 'tl_class'=>'clr')
		),
		'deleteOnKey' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteOnKey'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true)
		),
		'deleteKeyField' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteKeyField'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_tables','getTargetFields'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'deleteKeyValue' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['deleteKeyValue'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255)
		),
		'allowUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['allowUpdate'],
			'exclude'                 => true,
			'filter'                  => true,
			'default'                 => true,
			'inputType'               => 'checkbox'
		),
		'allowInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_tables']['allowInsert'],
			'exclude'                 => true,
			'filter'                  => true,
			'default'                 => true,
			'inputType'               => 'checkbox'
		)
	)
);


/**
 * Class tl_tabimporter_tables
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class tl_tabimporter_tables extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
		$this->tabImporter = new Tabimporter;
	}

	/**
	 * List table configurations
	 * @param array
	 * @return string
	 */
	public function listTables($arrRow)
	{
		return '<div><strong>' . $arrRow['title'] . '</strong></div>' . "\n";
	}


	/**
	 * Get table names
	 * @param array
	 * @return array
	 */
	public function getTables($arrRow)
	{
		return $this->Database->listTables();
	}

	/**
	 * Get target fields
	 * @param object
	 * @return array
	 */
	public function getTargetFields(DataContainer $dc)
	{
		return $this->tabImporter->getTargetFields($dc->id);
	}

	/**
	 * Get source fields
	 * @param object
	 * @return array
	 */
	public function getSourceFields(DataContainer $dc)
	{
		return $this->tabImporter->getSourceFields($dc->id);
	}

	/**
	 * Preset field configurations
	 * @param object
	 */
	public function presetFields(DataContainer $dc)
	{
		$this->import('String');

		$strTargetFields = '';
		$strSourceFields = '';
		$arrNewFields = array();

		$arrTargetFields = $this->getTargetFields($dc);
		$arrSourceFields = $this->getSourceFields($dc);

		// get new or added fields
		foreach($arrTargetFields as $fld)
		{
			$objData = $this->Database->prepare("SELECT * FROM tl_tabimporter_fields WHERE (pid=? AND fieldname=?)")
				->limit(1)
				->execute($dc->id, $fld);
			
			if($objData->numRows<1)
			{
				$arrNewFields[] = $fld;
			}

			$strTargetFields .= ($strTargetFields ? '
' : '') . $fld;
		}

		$objData = $this->Database->prepare("SELECT * FROM tl_tabimporter_tables WHERE id=?")
			->limit(1)
			->execute($dc->id);

		// write source fields
		if($objData->sourceType=='db' || ($objData->sourceType=='csv' && $objData->hasFieldnames))
		{
			$strSourceFields = implode('
',$arrSourceFields);
		}
		
		$this->Database->prepare("UPDATE tl_tabimporter_tables SET fieldsTarget=?, fieldsSource=?, fieldCount=? WHERE id=?")
			->execute($strTargetFields,$strSourceFields,sizeof($arrSourceFields),$dc->id);

		// preset the fields table
		if($this->Input->post('save') || $this->Input->post('saveNclose') || $this->Input->post('saveNcreate') || $this->Input->post('saveNback'))
		{
			// add new fields to field configuration
			if(sizeOf($arrNewFields)>0)
			{
				$objTmp = $this->Database->prepare("SELECT sorting FROM tl_tabimporter_fields WHERE pid=? ORDER BY sorting DESC")
					->limit(1)
					->execute($dc->id);
				$nextSorting = ($objTmp->numRows<1 ? 0 : ($objTmp->sorting));
	
				foreach($arrNewFields as $fld) {
					$nextSorting += 128;
					$this->Database->prepare("INSERT INTO tl_tabimporter_fields (pid,sorting,tstamp,published,fieldname,allowInsert,typeInsert,modeInsert,fieldInsert,allowUpdate,typeUpdate,modeUpdate,fieldUpdate) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)")
						->execute($dc->id, $nextSorting, time(), (in_array($fld,$arrSourceFields) ? '1' : '0'), $fld, 1, 'Insertfromfield', 'Addnew', (in_array($fld,$arrSourceFields) ? $fld : ''), 1, 'Updatefromfield', 'Replace', (in_array($fld,$arrSourceFields) ? $fld : ''));
				}	
			}

			// disable deleted fields from field configuration
			$objTmp = $this->Database->prepare("SELECT id,fieldname FROM tl_tabimporter_fields WHERE pid=?")
				->execute($dc->id);
		
			while($objTmp->next())
			{
				if(!in_array($objTmp->fieldname,$arrTargetFields))
				{
					$this->Database->prepare("UPDATE tl_tabimporter_fields SET published=?,allowInsert=?,allowUpdate=? WHERE id=?")
						->limit(1)
						->execute('','','',$objTmp->id);
				}
			}
		}
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
		return ($this->User->isAdmin || count(preg_grep('/^tl_tabimporter_tables::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ' : '';
	}

}

?>