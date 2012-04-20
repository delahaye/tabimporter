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
 * Table tl_tabimporter_fields
 */
$GLOBALS['TL_DCA']['tl_tabimporter_fields'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_tabimporter_tables',
		'enableVersioning'            => true,
		'onload_callback'             => array
			(
			array('tl_tabimporter_fields','adjustPalette')
			)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'panelLayout'             => 'filter;sort,search,limit',
			'headerFields'            => array('title','abort','targetTable','sourceType'),
			'child_record_callback'   => array('tl_tabimporter_fields', 'listElements')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
				'button_callback'     => array('tl_tabimporter_fields', 'toggleIcon')
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('allowInsert','allowUpdate'),
		'default'                     => '{title_legend},fieldname,published;{insert_legend},allowInsert;{update_legend},allowUpdate'
	),

	'subpalettes' => array
	(
		'allowInsert'                 => 'typeInsert,fieldInsert,modeInsert',
		'allowUpdate'                 => 'typeUpdate,fieldUpdate,modeUpdate',

		'InsertfromfieldAddnew'       => 'typeInsert,fieldInsert,modeInsert',
		'InsertfromfieldFill'         => 'typeInsert,fieldInsert,modeInsert,fillCharInsert,fieldLengthInsert,expandSideInsert',
		'InsertfromfieldExpand'       => 'typeInsert,fieldInsert,modeInsert,expandStringInsert,expandSideInsert',
		'InsertfromfieldCrop'         => 'typeInsert,fieldInsert,modeInsert,fieldLengthInsert,expandSideInsert',
		'InsertfromfieldBool'         => 'typeInsert,fieldInsert,modeInsert',
		'InsertfromfieldDatestring'   => 'typeInsert,fieldInsert,modeInsert,dateFormatInsert',
		'InsertfromfieldTags'         => 'typeInsert,fieldInsert,modeInsert,tagTypeSourceInsert,sourceDelimiterInsert,tagTypeTargetInsert,targetDelimiterInsert',
		'Insertcountup'               => 'typeInsert,initialValue,start,step',
		'Insertfix'                   => 'typeInsert,fixInsert',
		'Insertsql'                   => 'typeInsert,sqlInsert',
		'Inserthook'                  => 'typeInsert,hookInsert',
		'Insertdate'                  => 'typeInsert,dateValInsert,timeValInsert',
		'Inserttstamp'                => 'typeInsert,tstampUpInsert',

		'UpdatefromfieldReplace'      => 'typeUpdate,fieldUpdate,modeUpdate',
		'UpdatefromfieldFill'         => 'typeUpdate,fieldUpdate,modeUpdate,fillCharUpdate,fieldLengthUpdate,expandSideUpdate',
		'UpdatefromfieldExpand'       => 'typeUpdate,fieldUpdate,modeUpdate,expandStringUpdate,expandSideUpdate',
		'UpdatefromfieldCrop'         => 'typeUpdate,fieldUpdate,modeUpdate,fieldLengthUpdate,expandSideUpdate',
		'UpdatefromfieldBool'         => 'typeUpdate,fieldUpdate,modeUpdate',
		'UpdatefromfieldDatestring'   => 'typeUpdate,fieldUpdate,modeUpdate,dateFormatUpdate',
		'UpdatefromfieldTags'         => 'typeUpdate,fieldUpdate,modeUpdate,tagMode,tagTypeSourceUpdate,sourceDelimiterUpdate,tagTypeTargetUpdate,targetDelimiterUpdate',
		'Updatefix'                   => 'typeUpdate,fixUpdate',
		'Updatesql'                   => 'typeUpdate,sqlUpdate',
		'Updatehook'                  => 'typeUpdate,hookUpdate',
		'Updatedate'                  => 'typeUpdate,dateValUpdate,timeValUpdate',
		'Updatetstamp'                => 'typeUpdate,tstampUpUpdate',

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
		'fieldname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fieldname'],
			'exclude'                 => true,
			'sorting'                 => true,
			'search'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_fields','getTargetFields')
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		),
		'allowInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['allowInsert'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'default'                 => true,
			'eval'                    => array('submitOnChange'=>true)
		),
		'allowUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['allowUpdate'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'default'                 => '1',
			'eval'                    => array('submitOnChange'=>true)
		),
		'typeInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['type'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('Insertfromfield','Insertfix','Insertdate','Inserttstamp','Insertcountup','Insertsql','Inserthook'),
			'default'                 => 'Insertfromfield',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'fieldInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['field'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_fields','getSourceFields'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'modeInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['mode'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('Addnew','Expand','Crop','Fill','Bool','Datestring','Tags'),
			'default'                 => 'Addnew',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50')
		),
		'fixInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fix'],
			'exclude'                 => true,
			'inputType'               => 'textarea'
		),
		'sqlInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['sql'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('decodeEntities'=>true)
		),
		'hookInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['hook'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_fields','getHooks'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'tagTypeSourceInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagTypeSource'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('delimited','serialized'),
			'default'                 => 'delimited',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'sourceDelimiterInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['sourceDelimiter'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'tagTypeTargetInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagTypeTarget'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('delimited','serialized'),
			'default'                 => 'delimited',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'targetDelimiterInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['targetDelimiter'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'typeUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['type'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('Updatefromfield','Updatefix','Updatedate','Updatetstamp','Updatesql','Updatehook'),
			'default'                 => 'Updatefromfield',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'fieldUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['field'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_fields','getSourceFields'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'modeUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['mode'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('Replace','Expand','Crop','Fill','Bool','Datestring','Tags'),
			'default'                 => 'Replace',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50')
		),
		'addDelimiter' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['addDelimiter'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255)
		),
		'tagMode' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagMode'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('Replace','Add','Delete'),
			'default'                 => 'Replace',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']
		),
		'tagTypeSourceUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagTypeSource'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('delimited','serialized'),
			'default'                 => 'delimited',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'sourceDelimiterUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['sourceDelimiter'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'tagTypeTargetUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tagTypeTarget'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('delimited','serialized'),
			'default'                 => 'delimited',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('tl_class'=>'w50')
		),
		'targetDelimiterUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['targetDelimiter'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
		),
		'fixUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fix'],
			'exclude'                 => true,
			'inputType'               => 'textarea'
		),
		'sqlUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['sql'],
			'exclude'                 => true,
			'inputType'               => 'textarea',
			'eval'                    => array('decodeEntities'=>true)
		),
		'hookUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['hook'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_tabimporter_fields','getHooks'),
			'eval'                    => array('tl_class'=>'w50')
		),
		'initialValue' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['initialValue'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('tabValue','ownValue'),
			'default'                 => 'tabValue',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50')
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>digit, 'tl_class'=>'w50')
		),
		'step' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['step'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>digit, 'tl_class'=>'w50')
		),
		'fillCharInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fillChar'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>1)
		),
		'expandStringInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['expandString'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255)
		),
		'expandSideInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['expandSide'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('leftSide','rightSide'),
			'default'                 => 'leftSide',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'fieldLengthInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fieldLength'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>digit)
		),
		'dateValInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['dateVal'],
			'default'                 => time(),
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'timeValInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['timeVal'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'time', 'mandatory'=>true, 'tl_class'=>'w50')
		),
		'dateFormatInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['dateFormat'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 'd.m.Y',
			'eval'                    => array('maxlength'=>255)
		),
		'fillCharUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fillChar'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>1)
		),
		'expandStringUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['expandString'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255)
		),
		'expandSideUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['expandSide'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options'                 => array('leftSide','rightSide'),
			'default'                 => 'leftSide',
			'reference'               => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'],
			'eval'                    => array('submitOnChange'=>true)
		),
		'fieldLengthUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['fieldLength'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>digit)
		),
		'dateValUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['dateVal'],
			'default'                 => time(),
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'date', 'mandatory'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard')
		),
		'timeValUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['timeVal'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'time', 'mandatory'=>true, 'tl_class'=>'w50')
		),
		'dateFormatUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['dateFormat'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 'd.m.Y',
			'eval'                    => array('maxlength'=>255)
		),
		'tstampUpInsert' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tstampUp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 0,
			'eval'                    => array('rgxp'=>digit)
		),
		'tstampUpUpdate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_tabimporter_fields']['tstampUp'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'default'                 => 0,
			'eval'                    => array('rgxp'=>digit)
		)

	)
);


/**
 * Class tl_tabimporter_fields
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class tl_tabimporter_fields extends Backend
{

	/**
	 * Import the back end user and the tabimporter object
	 */
	public function __construct()
	{
		parent::__construct();

		$this->import('BackendUser', 'User');
		$this->Tabimporter = new Tabimporter;
	}

	/**
	 * Adjust the palette on changes
	 * @param object
	 */
	public function adjustPalette(DataContainer $dc)
	{
		$objData = $this->Database->prepare("SELECT allowInsert,allowUpdate,initialValue,typeInsert,modeInsert,typeUpdate,modeUpdate FROM tl_tabimporter_fields WHERE id=?")
			->limit(1)
			->execute($dc->id);

		if($objData->allowInsert)
		{
			if($objData->typeInsert == 'Insertfromfield')
			{
				if(in_array($objData->modeInsert,array('Tags','Fill','Expand','Crop','Datestring')))
				{
					$GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['allowInsert'] = $GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['Insertfromfield'.$objData->modeInsert];
					if($objData->initialValue != 'ownValue')
					{
						$GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['allowInsert'] = str_replace(',start,step',',step',$GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['allowInsert']);
					}
				}
			}
			else
			{
				$GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['allowInsert'] = $GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes'][$objData->typeInsert];
			}
		}
		else
		{
//			unset($GLOBALS['TL_DCA']['tl_tabimporter_fields']['palettes']['__selector__']);
		}

		if($objData->typeUpdate == 'Updatefromfield')
		{
			if(in_array($objData->modeUpdate,array('Tags','Fill','Expand','Crop','Datestring')))
			{
				$GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['allowUpdate'] = $GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['Updatefromfield'.$objData->modeUpdate];
			}
		}
		else
		{
			$GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes']['allowUpdate'] = $GLOBALS['TL_DCA']['tl_tabimporter_fields']['subpalettes'][$objData->typeUpdate];
		}
	}

	/**
	 * List the elements
	 * @param array
	 * @return string
	 */
	public function listElements($arrRow)
	{
		// get the data from the table definition
		$objData = $this->Database->prepare("SELECT allowInsert, allowUpdate FROM tl_tabimporter_tables WHERE id=?")
			->limit(1)
			->execute($arrRow['pid']);

		$key = $arrRow['published'] ? 'published' : 'unpublished';

		$return = '<div class="cte_type ' . $key . '"><strong>' . $arrRow['fieldname'] . '</strong></div>';
		$return .= ($objData->allowInsert ? '<div>'.$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['new'].': ' . ($arrRow['allowInsert'] ? ($arrRow['typeInsert']=='Insertfromfield' ? ($arrRow['fieldInsert'] ? $GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['field'].' "'.$arrRow['fieldInsert'].'", '.$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'][$arrRow['modeInsert']] : '-' ) : $GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'][$arrRow['typeInsert']]) : '-' ) . '</div>' : '');
		$return .= ($objData->allowUpdate ? '<div>'.$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['update'].': ' . ($arrRow['allowUpdate'] ? ($arrRow['typeUpdate']=='Updatefromfield' ? ($arrRow['fieldUpdate'] ? $GLOBALS['TL_LANG']['tl_tabimporter_fields']['references']['field'].' "'.$arrRow['fieldUpdate'].'", '.$GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'][$arrRow['modeUpdate']] : '-' ) : $GLOBALS['TL_LANG']['tl_tabimporter_fields']['references'][$arrRow['typeUpdate']]) : '-' ) . '</div>' : '');
		$return .= "\n";

		return $return;
	}


	/**
	 * Get possible target fields
	 * @param array
	 * @return array
	 */
	public function getTargetFields($arrRow)
	{
		return $this->Tabimporter->getTargetFields($arrRow->activeRecord->pid);
	}

	/**
	 * Get possible source fields
	 * @param array
	 * @return array
	 */
	public function getSourceFields($arrRow)
	{
		return $this->Tabimporter->getSourceFields($arrRow->activeRecord->pid);
	}

	/**
	 * Get registered hooks
	 * @param array
	 * @return array
	 */
	public function getHooks($arrRow)
	{
		return $this->Tabimporter->getHooks();
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_tabimporter_fields::published', 'alexf'))
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
		if (!$this->User->isAdmin && !$this->User->hasAccess('tl_tabimporter_fields::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish GM Element ID "'.$intId.'"', 'tl_tabimporter_fields toggleVisibility', TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$this->createInitialVersion('tl_tabimporter_fields', $intId);
	
		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_tabimporter_fields']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_tabimporter_fields']['fields']['published']['save_callback'] as $callback)
			{
				$this->import($callback[0]);
				$blnVisible = $this->$callback[0]->$callback[1]($blnVisible, $this);
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_tabimporter_fields SET tstamp=". time() .", published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
					   ->execute($intId);

		$this->createNewVersion('tl_tabimporter_fields', $intId);
	}

}

?>