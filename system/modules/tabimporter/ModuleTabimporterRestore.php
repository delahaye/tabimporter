<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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
 * Class ModuleTabimporterRestore
 *
 * Restore original tables.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class ModuleTabimporterRestore extends BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_tabimporter_restore';


	/**
	 * Generate module
	 * @throws Exception
	 */
	protected function compile()
	{
		$this->import('BackendUser', 'User');
		$this->loadLanguageFile('tl_tabimporter');

		$this->Template = new BackendTemplate($this->strTemplate);

		$this->Template->href = $this->getReferer(true);
		$this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBT']);
		$this->Template->action = ampersand($this->Environment->request);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];

		$this->Template->restoretitle = $GLOBALS['TL_LANG']['tl_tabimporter']['restore_title'];
		$this->Template->description = $GLOBALS['TL_LANG']['tl_tabimporter']['restore_description'];
		$this->Template->submit = $GLOBALS['TL_LANG']['tl_tabimporter']['restore_submit'];
		$this->Template->nothing = $GLOBALS['TL_LANG']['tl_tabimporter']['restore_nothing'];
		$this->Template->tablename = $GLOBALS['TL_LANG']['tl_tabimporter']['restore_tablename'].' ';
		$this->Template->keepCurrent = $GLOBALS['TL_LANG']['tl_tabimporter']['restore_keep'];

		if($this->Input->post('FORM_SUBMIT')=='tl_tabimporter_restore')
		{
			$messageOk = '';
			$messageFail = '';
			$messageFatal = '';
			$messageFailTabs = '';
			$messageFatalTabs = '';

			$arrTab = $this->Database->listTables();
			sort($arrTab);
			foreach($arrTab as $k=>$v)
			{
				if(strpos($v,$strTable.'_tabimport_')!==false)
				{
					$arrTmp = explode('_tabimport_',$v);
					$strOriginal = $arrTmp[0];

					// original table is to be restored from this version
					if($this->Input->post($strOriginal)==$v)
					{
						// rename original to backup version
						$tmp = explode(' ',microtime());
						$strBackup = $strOriginal."_tabimport_".date('Ymd_Hi_s',time()).'_'.str_pad(round($tmp[0]*1000,0),3,'0',STR_PAD_LEFT);
						if($this->Database->tableExists($strOriginal))
						{
							$this->Database->execute("RENAME TABLE ".$strOriginal." TO ".$strBackup);
						}

						// rename version to original
						if($this->Database->execute("RENAME TABLE ".$v." TO ".$strOriginal))
						{
							$arrTmp2 = explode('_',$arrTmp[1]);
							$tmpTstamp = new Date($arrTmp2[0].$arrTmp2[1].$arrTmp2[2],'YmdHis');
							$strVersion = date((strpos($GLOBALS['TL_CONFIG']['datimFormat'],':s')!==false ? $GLOBALS['TL_CONFIG']['datimFormat'] : $GLOBALS['TL_CONFIG']['datimFormat'].':s'),$tmpTstamp->tstamp).' '.round($arrTmp2[3],0).'ms';

							$messageOk .= ($messageOk ? '' : $GLOBALS['TL_LANG']['tl_tabimporter']['restore_tables_ok'].'<ul>').'<li>´'.$strOriginal.'´: '.$strVersion.'</li>';
						}
						else
						{
							// error
							$messageFailTabs .= ($messageFail ? ', ' : '') . '´'.$strOriginal.'´';
							
							//  restore original table
							if($this->Database->tableExists($strBackup))
							{
								if(!$this->Database->execute("RENAME TABLE ".$strBackup." TO ".$strOriginal))
								{
									// original lost - f**k
									$messageFatalTabs .= ($messageFatal ? ', ' : '') . '´'.$strOriginal.'´';
								}
							}
						}
					}
				}
			}
			$messageOk .= ($messageOk ? '</ul>' : '');
			$messageFail .= ($messageFailTabs ? sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['restore_tables_error'],$messageFailTabs) : '');
			$messageFatal .= ($messageFatalTabs ? sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['restore_tables_fatal'],$messageFatalTabs) : '');
			
			$_SESSION['tl_tabimporter']['messages'] = array
			(
				'ok' => $messageOk,
				'fail' => $messageFail,
				'fatal' => $messageFatal
			);
			
			$this->reload();
		}

		$this->Template->messageOk = $_SESSION['tl_tabimporter']['messages']['ok'];
		$this->Template->messageFail = $_SESSION['tl_tabimporter']['messages']['fail'];
		$this->Template->messageFatal = $_SESSION['tl_tabimporter']['messages']['fatal'];

		$_SESSION['tl_tabimporter']['messages'] = false;

		// get the backup tables
		$arrTables = array();
		$strCurrent = '';

		$arrTab = $this->Database->listTables();
		sort($arrTab);
		foreach($arrTab as $k=>$v)
		{
			if(strpos($v,$strTable.'_tabimport_')!==false)
			{
				$arrTmp = explode('_tabimport_',$v);
				$strOriginal = $arrTmp[0];

				if($strOriginal != $strCurrent)
				{
					if($strCurrent && is_array($arrTables[$strCurrent]))
					{
						krsort($arrTables[$strCurrent]);
					}
					$arrTables[$strOriginal] = array();
					$strCurrent = $strOriginal;
				}

				$arrTmp2 = explode('_',$arrTmp[1]);
				$tmpTstamp = new Date($arrTmp2[0].$arrTmp2[1].$arrTmp2[2],'YmdHis');
				$arrTables[$strCurrent][$v] = date((strpos($GLOBALS['TL_CONFIG']['datimFormat'],':s')!==false ? $GLOBALS['TL_CONFIG']['datimFormat'] : $GLOBALS['TL_CONFIG']['datimFormat'].':s'),$tmpTstamp->tstamp).' '.round($arrTmp2[3],0).'ms';
				
				unset($arrTab[$k]);
			}
		}
		if($strCurrent && is_array($arrTables[$strCurrent]))
		{
			krsort($arrTables[$strCurrent]);
		}
		
		$this->Template->tables = $arrTables;
		

		// parse template
		return $this->Template->parse();
	}
}

?>