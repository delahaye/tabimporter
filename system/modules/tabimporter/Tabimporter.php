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
 * Class Tabimporter
 *
 * Provides methods used for tble imports.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class Tabimporter extends Backend
{

	/**
	 * Import classes
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		$this->import('Database');
		$this->import('Input');
		$this->import('Environment');
		$this->import('String');
	}


	/**
	 * execute import job in backend
	 */
	public function runJob()
	{
		$objTemplate = new BackendTemplate('be_tabimporter_job');

		// abort, if no job found
		if(!$this->Input->get('id') || !$arrJob=$this->getJobdata($this->Input->get('id')))
		{
			$objTemplate->jobtitle = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['jobtitle'],$this->Input->get('id'));
			$objTemplate->errorMessage = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['errorMessageNotFound'],$this->Input->get('id'));
			$objTemplate->jobstart = '';

			return $objTemplate->parse();
		}

		$objTemplate->jobid = $arrJob['id'];
		$objTemplate->jobtitle = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['jobtitle'],$arrJob['id']);
		$objTemplate->loading = $GLOBALS['TL_LANG']['tl_tabimporter']['loading'];
		$objTemplate->complete = $GLOBALS['TL_LANG']['tl_tabimporter']['complete'];
		$objTemplate->jobstart = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['jobstart'],$arrJob['title']);
		$objTemplate->jobstartSubmit = $GLOBALS['TL_LANG']['tl_tabimporter']['jobstartSubmit'];
		$objTemplate->jobendSubmit = $GLOBALS['TL_LANG']['tl_tabimporter']['jobendSubmit'];

		// simulation
		if($this->Input->get('sim'))
		{
			$strSim = '&sim=1';
			$objTemplate->jobSim = $GLOBALS['TL_LANG']['tl_tabimporter']['jobSim'];
		}
		
		// confirm the run first
		if($this->Input->get('act')!= 'import')
		{
			return $objTemplate->parse();
		}

		// make sure we start with the init step
		if(!$this->Input->get('step'))
		{
			$this->Input->setGet('step','init');
		}

		// walk thru steps
		switch($this->Input->get('step'))
		{
			case 'init':
				// run init step
				$this->runInit($arrJob['id'], $this->Input->get('sim'));

				// next step if no abortion
				if(!$_SESSION['tl_tabimporter']['abortError'])
				{
					// perform first step
					if(count($_SESSION['tl_tabimporter']['jobSteps'])>0)
					{
						$intNextStep = $_SESSION['tl_tabimporter']['jobSteps'][0];
					}
					// no steps defined
					else
					{
						$intNextStep=0;
					}
				}

				break;

			case 'steps':
				// run step
				$this->runStep($this->Input->get('stepid'));

				// next step if no abortion
				if(!$_SESSION['tl_tabimporter']['abortError'])
				{
					if($_SESSION['tl_tabimporter']['nextStepFirstline']>0)
					{
						$intNextStep=$this->Input->get('stepid');
						$strFirstLine = '&firstline='.$_SESSION['tl_tabimporter']['nextStepFirstline'];
					}
					else
					{
						unset($_SESSION['tl_tabimporter']['arrTableimport']);
						unset($_SESSION['tl_tabimporter']['arrAllData']);

						$arrNext = array_diff($_SESSION['tl_tabimporter']['jobSteps'], $_SESSION['tl_tabimporter']['doneSteps']);
						$arrNextKey = array_keys($arrNext);

						// go to next step
						if(count($arrNext)>0)
						{
							$intNextStep = $arrNext[$arrNextKey[0]];
						}
						// no next step defined
						else
						{
							$intNextStep=0;
						}
					}
				}

				break;

			case 'final':
				// run finalisation step
				$this->runFinal();

				break;

		}

		$objTemplate->tablename = 'tl_tabimporter_runsteps';
		$objTemplate->runid = $_SESSION['tl_tabimporter']['runId'];

		// set error message
		if($_SESSION['tl_tabimporter']['abortError'])
		{
			$objTemplate->isRunning = false;
			$objTemplate->isComplete = true;
			$objTemplate->errorMessage = $GLOBALS['TL_LANG']['tl_tabimporter']['errorMessage'];
			$objTemplate->content = $_SESSION['tl_tabimporter']['jobLog'];

			// Add log entry
			if(!$this->Input->get('sim'))
			{
				$this->log('Importjob "' . specialchars($arrJob['title']) . '" manually failed.', 'Tabimporter runJob()', TL_ERROR);
			}

			return $objTemplate->parse();
		}

		// there is a next step
		if($intNextStep>0)
		{
			$objTemplate->isRunning = true;
			$objTemplate->nextLink = 'contao/main.php?do=tabimporter&key=runjob&act=import&id='.$arrJob['id'].'&step=steps&stepid='.$intNextStep.$strFirstLine.$strSim;
		}
		// this is the last step before finalisation
		elseif($this->Input->get('step')!='final')
		{
			$objTemplate->isRunning = true;
			$objTemplate->nextLink = 'contao/main.php?do=tabimporter&key=runjob&act=import&id='.$arrJob['id'].'&step=final'.$strSim;
		}
		else
		{
			// job is completed
			$objTemplate->isComplete = true;
			$objTemplate->execTime = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['execTime'],(time()-$_SESSION['tl_tabimporter']['runBegin']));
		}
		
		$objTemplate->content = $_SESSION['tl_tabimporter']['jobLog'];

		// Add log entry
		if(!$this->Input->get('sim'))
		{
			$this->log('Importjob "' . specialchars($arrJob['title']) . '" manually succeeded.', 'Tabimporter runJob()', TL_GENERAL);
		}

		return $objTemplate->parse();
	}


	/**
	 * execute init step of job
	 */
	public function runInit($jobId, $jobSim=false)
	{
		// get job data
		if(!$arrJob = $this->getJobdata($jobId))
		{
			// abort without job
			$this->updateStatus(false, 1, 
				$GLOBALS['TL_LANG']['tl_tabimporter']['init'],
				'', 
				sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['jobfound_fail'],$jobId),
				''
				);
			
			return;
		}

		// begin job tracking
		$arrTracking = $this->startJobTracking($arrJob);

		unset($_SESSION['tl_tabimporter']);
		$_SESSION['tl_tabimporter'] = array
		(
			'jobId' => $arrJob['id'],
			'runId' => $arrTracking['runId'],
			'runBegin' => $arrTracking['begin'],
			'runBeginMs' => $arrTracking['beginMs'],
			'sqlSteps' => $GLOBALS['tl_tabimporter']['sqlSteps'],
			'arrJob' => serialize($arrJob),
			'jobSim' => $jobSim,
			'currentStepName' => false,
			'abortError' => false,
			'nextStepFirstline' => 0,
			'currentLine' => 0,
			'countOperations' => 0,
			'countErrors' => 0,
			'countWarnings' => 0,
			'countUp' => array(),
			'jobSteps' => array(),
			'doneSteps' => array(),
			'targetTables' => '',
			'jobLog' => ''
		);

		if(!$_SESSION['tl_tabimporter']['runId'])
		{
			// abort without tracking
			$this->updateStatus(false, 1, 
				$GLOBALS['TL_LANG']['tl_tabimporter']['init'],
				'', 
				sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['jobtracking_fail'],$arrJob['id']),
				''
				);

			return;
		}

		// get job steps
		$objSteps = $this->Database->prepare("SELECT * FROM tl_tabimporter_steps WHERE (pid=? AND published=?) ORDER BY sorting")
			->executeUncached($jobId,1);

		// get target tables and step ids
		while($objSteps->next())
		{
			$_SESSION['tl_tabimporter']['jobSteps'][] = $objSteps->id;

			if($objSteps->action == 'tableimport' && $objSteps->tableimport)
			{
				$objTableimport = $this->Database->prepare("SELECT targetTable FROM tl_tabimporter_tables WHERE id=?")
					->limit(1)
					->executeUncached($objSteps->tableimport);

				$_SESSION['tl_tabimporter']['targetTables'][] = $objTableimport->targetTable;
			}
		}
		$objSteps->reset();

		$_SESSION['tl_tabimporter']['targetTables']= array_unique($_SESSION['tl_tabimporter']['targetTables']);

		// backup target tables
		foreach($_SESSION['tl_tabimporter']['targetTables'] as $strTable)
		{
			$this->updateStatus($this->createWorkingTable($strTable), 1, 
				$GLOBALS['TL_LANG']['tl_tabimporter']['init'],
				sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['backup_ok'],$strTable), 
				sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['backup_fail'],$strTable),
				''
				);

			// abort if status is set so
			if($_SESSION['tl_tabimporter']['abortError'])
			{
				return;
			}
		}

		return;
	}


	/**
	 * execute specified step of job
	 */
	public function runStep($intStep, $line=false)
	{
		$arrJob = unserialize($_SESSION['tl_tabimporter']['arrJob']);

		// get job step
		$objSteps = $this->Database->prepare("SELECT * FROM tl_tabimporter_steps WHERE (pid=? AND id=?)")
			->limit(1)
			->executeUncached($arrJob['id'], $intStep);

		if(!$objSteps->numRows || $objSteps->error)
		{
			$this->updateStatus(false, 1, 
				$GLOBALS['TL_LANG']['tl_tabimporter']['steps'],
				'', 
				sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['stepfound_fail'],$intStep,$arrJob['id']),
				''
				);
			
			// abort without step
			return;
		}

		// perform step action
		switch($objSteps->action)
		{

			// new value from source value
			case 'tableimport':
				
				if($_SESSION['tl_tabimporter']['arrTableimport'])
				{
					$arrTableimport = deserialize($_SESSION['tl_tabimporter']['arrTableimport']);
				}
				else
				{
					// clipboard for auto-countup-fields like sortings
					$_SESSION['tl_tabimporter']['countUp'] = array();

					$objTableimport = $this->Database->prepare("SELECT * FROM tl_tabimporter_tables WHERE id=?")
						->limit(1)
						->executeUncached($objSteps->tableimport);

					$arrTableimport = $objTableimport->fetchAssoc();

					$arrTableimport['deleteOnStart'] = unserialize($arrTableimport['deleteOnStart']);
					$arrTableimport['fieldDef'] = $this->Database->listFields($arrTableimport['targetTable'], true);		

					// use temporary tables as source?
					if($arrTableimport['useTmpTable'])
					{
						$arrTableimport['sourceTable'] = $arrTableimport['sourceTable'].'_tabimport';
					}
					
					// config for the source type
					$arrTableimport['needsExactRowmatch'] = $GLOBALS['tl_tabimporter']['sourceTypes'][$arrTableimport['sourceType']]['needsExactRowmatch'];
					$arrTableimport['getDataOnStepbegin'] = $GLOBALS['tl_tabimporter']['sourceTypes'][$arrTableimport['sourceType']]['getDataOnStepbegin'];

					// classes for the source type, eg csv
					$strClassname = 'TabimporterSource_'.$arrTableimport['sourceType'];
					$arrSourceConfig = $this->import($strClassname);
					$this->TabimporterSource = new $strClassname();

					// get source data if needed at this point, like csv
					if($arrTableimport['getDataOnStepbegin'])
					{
						$_SESSION['tl_tabimporter']['arrAllData'] = $this->TabimporterSource->getAllData($arrTableimport);
					}

					// get existent keys if needed
					if($arrTableimport['uniqueSource'] 
						&& $arrTableimport['uniqueTarget'] 
						&& ($arrTableimport['allowUpdate'] 
							|| (is_array($arrTableimport['deleteOnStart'])
								&& in_array('missing',$arrTableimport['deleteOnStart']))))
					{
						$arrTableimport['existentKeysSource'] = $this->TabimporterSource->getExistentKeysSource($arrTableimport);

						if($arrTableimport['existentKeysSource'])
						{
							$arrTableimport['existentKeysTarget'] = $this->getExistentKeysTarget($arrTableimport);
						}
	
						$this->updateStatus(($arrTableimport['existentKeysSource'] ? true : false), 0, 
							$objSteps->title,
							sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['update_existent_ok'],$arrTableimport['targetTable']), 
							sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['update_existent_fail'],$arrTableimport['targetTable']),
							sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['update_existent_detail'],count($arrTableimport['existentKeysSource']),$arrTableimport['uniqueTarget'],(is_array($arrTableimport['existentKeysSource']) ? implode(', ',$arrTableimport['existentKeysSource']):''))
							);
	
						// abort if status is set so
						if($_SESSION['tl_tabimporter']['abortError'])
						{
							return;
						}
					}

					// delete data before import
					if(is_array($arrTableimport['deleteOnStart']))
					{
						// delete all data in target table
						if(in_array('missing',$arrTableimport['deleteOnStart']) && in_array('existent',$arrTableimport['deleteOnStart']))
						{
							$arrCheck = $this->performSQL("TRUNCATE TABLE ".$arrTableimport['targetTable']."_tabimport");
							$this->updateStatus($arrCheck['result'], $objSteps->abortOnError, 
								$objSteps->title,
								sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['truncate_ok'],$arrTableimport['targetTable']), 
								sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['truncate_fail'],$arrTableimport['targetTable']),
								$arrCheck['details']
								);
	
							// abort if status is set so
							if($_SESSION['tl_tabimporter']['abortError'])
							{
								return;
							}
						}
						// delete data missing in target, but existing in the source table
						elseif(in_array('missing',$arrTableimport['deleteOnStart']) && is_array($arrTableimport['existentKeysSource']) && is_array($arrTableimport['existentKeysTarget']))
						{
							$arrToDelete=array_diff($arrTableimport['existentKeysSource'],$arrTableimport['existentKeysTarget']);
							if(count($arrToDelete>0))
							{
								$arrCheck = $this->performSQL("DELETE FROM ".$arrTableimport['targetTable']."_tabimport WHERE ".$arrTableimport['deleteKeyField']." IN ('".implode('\',\'',$arrToDelete)."')",array(),false);
								$this->updateStatus($arrCheck['result'], $objSteps->abortOnError, 
									$objSteps->title,
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['missing_ok'],$arrTableimport['targetTable']), 
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['missing_fail'],$arrTableimport['targetTable']),
									str_replace('?',$arrTableimport['deleteKeyValue'],$arrCheck['details'])
									);
							}
							else
							{
								$this->updateStatus(true, $objSteps->abortOnError, 
									$objSteps->title,
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['missing_ok'],$arrTableimport['targetTable']), 
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['missing_fail'],$arrTableimport['targetTable']),
									str_replace('?',$arrTableimport['deleteKeyValue'],$GLOBALS['TL_LANG']['tl_tabimporter']['no_hit'])
									);
							}
	
							// abort if status is set so
							if($_SESSION['tl_tabimporter']['abortError'])
							{
								return;
							}
						}
						// delete data already existing in target table
						elseif(in_array('existent',$arrTableimport['deleteOnStart']) && is_array($arrTableimport['existentKeysSource']) && is_array($arrTableimport['existentKeysTarget']))
						{
							$arrNotExistent=array_diff($arrTableimport['existentKeysSource'],$arrTableimport['existentKeysTarget']);
							$arrToDelete=array_diff($arrTableimport['existentKeysTarget'],$arrNotExistent);
							if(count($arrToDelete>0))
							{
								$arrCheck = $this->performSQL("DELETE FROM ".$arrTableimport['targetTable']."_tabimport WHERE ".$arrTableimport['deleteKeyField']." IN ('".implode('\',\'',$arrToDelete)."')",array(),false);
								$this->updateStatus($arrCheck['result'], $objSteps->abortOnError, 
									$objSteps->title,
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['existent_ok'],$arrTableimport['targetTable']), 
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['existent_ok'],$arrTableimport['targetTable']),
									str_replace('?',$arrTableimport['deleteKeyValue'],$arrCheck['details'])
									);
							}
							else
							{
								$this->updateStatus(true, $objSteps->abortOnError, 
									$objSteps->title,
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['existent_ok'],$arrTableimport['targetTable']), 
									sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['existent_fail'],$arrTableimport['targetTable']),
									str_replace('?',$arrTableimport['deleteKeyValue'],$GLOBALS['TL_LANG']['tl_tabimporter']['no_hit'])
									);
							}
	
							// abort if status is set so
							if($_SESSION['tl_tabimporter']['abortError'])
							{
								return;
							}
						}
					}

					// delete specified data before import only if not all data was deleted
					if($arrTableimport['deleteOnKey'] 
						&& $arrTableimport['deleteKeyField'] 
						&& (!is_array($arrTableimport['deleteOnStart']) || (is_array($arrTableimport['deleteOnStart']) && !in_array('existent',$arrTableimport['deleteOnStart'])))
						)
					{
						$arrCheck = $this->performSQL("DELETE FROM ".$arrTableimport['targetTable']."_tabimport WHERE ".$arrTableimport['deleteKeyField']."=?",array(),$arrTableimport['deleteKeyValue']);
	
						$this->updateStatus($arrCheck['result'], $objSteps->abortOnError, 
							$objSteps->title,
							sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['specified_ok'],$arrTableimport['targetTable']), 
							sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['specified_fail'],$arrTableimport['targetTable']),
							str_replace('?',$arrTableimport['deleteKeyValue'],$arrCheck['details'])
							);
	
						// abort if status is set so
						if($_SESSION['tl_tabimporter']['abortError'])
						{
							return;
						}
					}

					if($arrTableimport['existentKeysTarget'])
					{
						$arrTableimport['existentKeysTarget'] = $this->getExistentKeysTarget($arrTableimport);
						$objKeys = $this->Database->prepare("SELECT ".$arrTableimport['uniqueTarget']." FROM ".$arrTableimport['targetTable']."_tabimport WHERE ".$arrTableimport['uniqueTarget']." IN ('".implode('\',\'',$arrTableimport['existentKeysSource'])."')")
							->executeUncached();

						$arrTableimport['existentKeysTarget'] = $objKeys->fetchEach($arrTableimport['uniqueTarget']);
					}

					$_SESSION['tl_tabimporter']['arrTableimport'] = serialize($arrTableimport);		
				}

				// updates
				if($arrTableimport['allowUpdate'] && $arrTableimport['existentKeysSource'])
				{
					$arrCheck = $this->performDataManipulations($arrTableimport,'update');
					$blnCheck = ($objSteps->abortOnError || $arrCheck['abort']) ? 1 : 0;
					$this->updateStatus($arrCheck['result'], $blnCheck, 
						$objSteps->title,
						sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['updates_ok'],$arrTableimport['targetTable'],$_SESSION['tl_tabimporter']['currentLine']), 
						sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['updates_fail'],$arrTableimport['targetTable'],$_SESSION['tl_tabimporter']['currentLine']),
						$arrCheck['details']
						);

					// abort if status is set so
					if($_SESSION['tl_tabimporter']['abortError'])
					{
						return;
					}
				}

				// new sets
				if($arrTableimport['allowInsert'])
				{
					$arrCheck = $this->performDataManipulations($arrTableimport,'insert');
					$blnCheck = ($objSteps->abortOnError || $arrCheck['abort']) ? 1 : 0;
					$this->updateStatus($arrCheck['result'], $blnCheck, 
						$objSteps->title,
						sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['inserts_ok'],$arrTableimport['targetTable'],$_SESSION['tl_tabimporter']['currentLine']), 
						sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['inserts_fail'],$arrTableimport['targetTable'],$_SESSION['tl_tabimporter']['currentLine']),
						$arrCheck['details']
						);

					// abort if status is set so
					if($_SESSION['tl_tabimporter']['abortError'])
					{
						return;
					}
				}

				break;

			// perform sql query
			case 'sql':
				$arrCheck = $this->performSQL($objSteps->sqlData);
				$this->updateStatus($arrCheck['result'], $objSteps->abortOnError, 
					$objSteps->title,
					$GLOBALS['TL_LANG']['tl_tabimporter']['sql_ok'], 
					$GLOBALS['TL_LANG']['tl_tabimporter']['sql_fail'],
					$arrCheck['details']
					);

				// abort if status is set so
				if($_SESSION['tl_tabimporter']['abortError'])
				{
					return;
				}
				break;

			// perform hook
			case 'hook':
				$arrCheck = $this->performHook($objSteps);
				$this->updateStatus($arrCheck['result'], $objSteps->abortOnError, 
					$objSteps->title,
					sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['hook_ok'],$objSteps->hook), 
					sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['hook_fail'],$objSteps->hook),
					$arrCheck['details']
					);

				// abort if status is set so
				if($_SESSION['tl_tabimporter']['abortError'])
				{
					return;
				}

				break;
		}

		// save status for next step
		$_SESSION['tl_tabimporter']['doneSteps'][] = $intStep;
//		unset($_SESSION['tl_tabimporter']['arrTableimport']);

		return;
	}


	/**
	 * execute final step of job
	 */
	public function runFinal()
	{
		$arrJob = unserialize($_SESSION['tl_tabimporter']['arrJob']);

		// replace target tables
		if(is_array($_SESSION['tl_tabimporter']['targetTables']))
		{
			foreach($_SESSION['tl_tabimporter']['targetTables'] as $strTable)
			{
				$this->updateStatus($this->replaceByWorkingTable($strTable,$_SESSION['tl_tabimporter']['runBegin'],$_SESSION['tl_tabimporter']['runBeginMs'], $arrJob['keepVersions']), 1, 
					$GLOBALS['TL_LANG']['tl_tabimporter']['final'],
					sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['new_ok'],$strTable), 
					sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['new_fail'],$strTable),
					''
					);

				// abort if status is set so
				if($_SESSION['tl_tabimporter']['abortError'])
				{
					return;
				}
			}
		}

		// job end
		$this->endJobTracking();

		// return status
		return;
	}


	/**
	 * get job data
	 */
	public function getJobdata($id)
	{
		// get job data
		$objJob = $this->Database->prepare("SELECT * FROM tl_tabimporter_jobs WHERE id=?")
			->executeUncached($id);

		// job not found
		if(!$objJob->numRows)
		{
			return false;
		}
		
		return $objJob->fetchAssoc();
	}


	/**
	 * get target fields
	 */
	public function getTargetFields($id)
	{
		$return = array();

		$objData = $this->Database->prepare("SELECT targetTable FROM tl_tabimporter_tables WHERE id=?")
			->limit(1)
			->executeUncached($id);

		if($objData->targetTable)
		{
			foreach($this->Database->listFields($objData->targetTable, true) as $fld)
			{
				if($fld['type'] != 'index')
				{
					$return[] = $fld['name'];
				}
			}
		}

		return $return;
	}


	/**
	 * get source fields
	 */
	public function getSourceFields($id)
	{
		$return = array();

		$objData = $this->Database->prepare("SELECT sourceType, sourceTable, sourceFile, fieldDelimiter, hasFieldnames FROM tl_tabimporter_tables WHERE id=?")
			->limit(1)
			->executeUncached($id);

		if($objData->sourceType=='db')
		{
			if($objData->sourceTable)
			{
				foreach($this->Database->listFields($objData->sourceTable, true) as $fld)
				{
					if($fld['type'] != 'index')
					{
						$return[] = $fld['name'];
					}
				}
			}
			return $return;
		}

		if(!$objData->sourceFile)
		{
			return $return;
		}
		
		$objDatei = new File($objData->sourceFile);

		if($objDatei)
		{
			$arrInhalte =$objDatei->getContentAsArray();
			
			switch($objData->fieldDelimiter)
			{
				case 'semicolon':
					$strDelimiter = ';';
					break;
				case 'comma':
					$strDelimiter = ',';
					break;
				case 'tab':
					$strDelimiter = '\t';
					break;
				default:
					$strDelimiter = ';';
					break;
			}

			$arrSourceFields = $this->String->splitCsv($arrInhalte[0], $strDelimiter);
			
			if($objData->hasFieldnames)
			{
				$return = $arrSourceFields;
			}
			else
			{
				for($i=0; $i<sizeof($arrSourceFields);$i++)
				{
					$return[] = 'field_'.$i;
				}
			}
		}

		return $return;
	}


	/**
	 * get available hooks
	 */
	public function getHooks()
	{
		$return = array();

		if(is_array($GLOBALS['TL_HOOKS']['tabimporter']))
		{
			foreach($GLOBALS['TL_HOOKS']['tabimporter'] as $k=>$v)
			{
				$return[$k] = 
				(
					$GLOBALS['TL_LANG']['MSC']['tabimporter_hook'][$k] ? 
					$GLOBALS['TL_LANG']['MSC']['tabimporter_hook'][$k] : 
					$k
				);
			}
		}

		return $return;
	}


	/**
	 * begin the job tracking
	 */
	public function startJobTracking($arrJob)
	{
		$intBegin = time();
		$tmp = explode(' ',microtime());
		$intBeginMs = str_pad(round($tmp[0]*1000,0),3,'0',STR_PAD_LEFT);

		$objTrack = $this->Database->prepare("INSERT INTO tl_tabimporter_runs %s")
			->set(array(
				'tstamp' => time(),
				'pid' => $arrJob['id'],
				'job' => ($this->Input->get('sim') ? $GLOBALS['TL_LANG']['tl_tabimporter']['jobSimLog'].' ' : '').$arrJob['title'].' (#'.$arrJob['id'].')',
				'begin' => $intBegin,
				'end' => $intBegin,
				'user' => ($this->User->id ? $this->User->id : 0),
				'status' => 'abort'
				))
			->executeUncached();

		return array
			(
				'runId' => $objTrack->insertId,
				'begin' => $intBegin,
				'beginMs' => $intBeginMs
			);
	}


	/**
	 * end the job tracking
	 */
	public function endJobTracking()
	{
		$objTrack = $this->Database->prepare("SELECT id FROM tl_tabimporter_runsteps WHERE (pid=? AND status=?)")
			->executeUncached($_SESSION['tl_tabimporter']['runId'],'error');
		
		if($objTrack->numRows)
		{
			// min 1 step has errors
			$this->Database->prepare("UPDATE tl_tabimporter_runs SET status=? WHERE id=?")
				->executeUncached('error',$_SESSION['tl_tabimporter']['runId']);

			return;
		}

		$objTrack = $this->Database->prepare("SELECT id FROM tl_tabimporter_runsteps WHERE (pid=? AND status=?)")
			->executeUncached($_SESSION['tl_tabimporter']['runId'],'warn');
		
		if($objTrack->numRows)
		{
			// min 1 step has warnings
			$this->Database->prepare("UPDATE tl_tabimporter_runs SET status=? WHERE id=?")
				->executeUncached('warn',$_SESSION['tl_tabimporter']['runId']);

			return;
		}

		// all worked fine
		$this->Database->prepare("UPDATE tl_tabimporter_runs SET status=?, end=? WHERE id=?")
			->executeUncached('ok',time(),$_SESSION['tl_tabimporter']['runId']);

		$this->Database->prepare("UPDATE tl_tabimporter_jobs SET status=?, lastrun=? WHERE id=?")
			->executeUncached('',time(),$_SESSION['tl_tabimporter']['jobId']);

		return;
	}


	/**
	 * back up a target table in a working table
	 */
	public function createWorkingTable($strTable)
	{
		// drop temporary table if exists
		if(!$this->Database->executeUncached("DROP TABLE IF EXISTS ".$strTable."_tabimport"))
		{
			return false;
		}

		// create temporary table and fill it from the original
		if(!$this->Database->executeUncached("CREATE TABLE IF NOT EXISTS ".$strTable."_tabimport LIKE ".$strTable))
		{
			return false;
		}
		if(!$this->Database->executeUncached("INSERT INTO ".$strTable."_tabimport SELECT * FROM ".$strTable))
		{
			return false;
		}

		return true;
	}


	/**
	 * replace a target table by a working table
	 */
	public function replaceByWorkingTable($strTable, $runBegin, $runBeginMs, $keepVersions)
	{
		if(!$this->Database->tableExists($strTable.'_tabimport'))
		{
			return false;
		}
		
		// only drop the working table on simulation
		if($_SESSION['tl_tabimporter']['jobSim'])
		{
			$this->Database->executeUncached("DROP TABLE IF EXISTS ".$strTable."_tabimport");

			return true;
		}
		
		// keep 1 version min
		$keepVersions = ($keepVersions <1 ? 1 : $keepVersions);

		// create a backup table and fill it from the original
		$strDate = date('Ymd_Hi_s',$runBegin).'_'.$runBeginMs;
		
		$this->Database->executeUncached("DROP TABLE IF EXISTS ".$strTable."_tabimport_".$strDate);
		$this->Database->executeUncached("CREATE TABLE IF NOT EXISTS ".$strTable."_tabimport_".$strDate." LIKE ".$strTable);
		$this->Database->executeUncached("INSERT INTO ".$strTable."_tabimport_".$strDate." SELECT * FROM ".$strTable);

		// get the backup tables and keep only the defined number
		$arrTables = $this->Database->listTables();
		foreach($arrTables as $k=>$v)
		{
			if(strpos($v,$strTable.'_tabimport_')===false)
			{
				unset($arrTables[$k]);
			}
		}
		rsort($arrTables);
		foreach($arrTables as $k=>$v)
		{
			if($k > ($keepVersions-1))
			{
				$this->Database->executeUncached("DROP TABLE IF EXISTS ".$v);
			}
		}

		// drop original table
		$this->Database->executeUncached("DROP TABLE IF EXISTS ".$strTable);

		// replace by temporary table
		$this->Database->executeUncached("RENAME TABLE ".$strTable."_tabimport TO ".$strTable);

		return true;
		
	}


	/**
	 * get keys of the target
	 */
	public function getExistentKeysTarget($arrTableimport)
	{
		if($_SESSION['tl_tabimporter']['existentKeysTarget'])
		{
			$arrKeys = $_SESSION['tl_tabimporter']['existentKeysTarget'];
		}
		else
		{
			$objKeys = $this->Database->prepare("SELECT ".$arrTableimport['uniqueTarget']." FROM ".$arrTableimport['targetTable']." WHERE ".$arrTableimport['uniqueTarget']." IN ('".implode('\',\'',$arrTableimport['existentKeysSource'])."')")
				->executeUncached();

			$arrKeys = $objKeys->fetchEach($arrTableimport['uniqueTarget']);

		}

 		if(!$arrKeys || count($arrKeys)<1)
		{
			return false;
		}

		return $arrKeys;
	}


	/**
	 * prepare inserts and updates for fields from source value
	 */
	public function performDataManipulations($arrTableimport, $strMode)
	{
		// get fields for manipulation
		switch($strMode)
		{
			case 'insert':
				$objFields = $this->Database->prepare("SELECT * FROM tl_tabimporter_fields WHERE (published=? AND allowInsert=? AND pid=?)")
					->executeUncached(1,1,$arrTableimport['id']);

				break;

			case 'update':
				$objFields = $this->Database->prepare("SELECT * FROM tl_tabimporter_fields WHERE (published=? AND allowUpdate=? AND pid=?)")
					->executeUncached(1,1,$arrTableimport['id']);

				break;
		}

		$arrFieldnames = $objFields->fetchEach('fieldname');
		$strDetails = '';

		// do data manipulations in parts because of execution time
		$intFirstline = ($this->Input->get('firstline') ? $this->Input->get('firstline') : 0);
		$_SESSION['tl_tabimporter']['currentLine'] = 0;
		unset($_SESSION['tl_tabimporter']['nextStepFirstline']);


		// get source data if needed at this point, like db
		if(!$arrTableimport['getDataOnStepbegin'] && !$_SESSION['tl_tabimporter']['arrAllData'])
		{
			$_SESSION['tl_tabimporter']['arrAllData'] = $this->TabimporterSource->getAllData($arrTableimport, $strMode, $arrFieldnames);
		}

		if($_SESSION['tl_tabimporter']['sqlSteps'][$strMode]==0 && $_SESSION['tl_tabimporter']['currentLine']==0)
		{
			$intBeginMaxtime = time()+microtime();
		}

		// walk thru data
		foreach($_SESSION['tl_tabimporter']['arrAllData'] as $arrData)
		{
			if($_SESSION['tl_tabimporter']['currentLine'] >= $intFirstline)
			{
				// check number of fields per row and skip row if not ok
				if($arrTableimport['needsExactRowmatch'] && count($arrData) != $arrTableimport['fieldCount'])
				{
					$strDetails .= sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['fieldcount_fail'],$_SESSION['tl_tabimporter']['currentLine']).'<br>';

					// error handling
					$_SESSION['tl_tabimporter']['countErrors']++;

					if($arrTableimport['abortOnError'])
					{
						return $this->abortDataManipulation($strMode, $strDetails);
					}
				}
				// perform insert or update of row
				else
				{
					switch($strMode)
					{
						case 'update':
							// only existent rows can be updated ;-)
							if(is_array($arrTableimport['existentKeysTarget']) && (in_array($arrData[$arrTableimport['uniqueSource']], $arrTableimport['existentKeysTarget']) || in_array($arrData['tabimport_unique'], $arrTableimport['existentKeysTarget'])))
							{
								// perform update of this row
								$arrCheck = $this->performSingleDataManipulation($arrTableimport, $arrData, $objFields, $arrFieldnames, 'Update');

								$strDetails .= '<br>'.$arrCheck['details'];
		
								if(!$arrCheck['result'] && $arrTableimport['abortOnError'])
								{
									return $this->abortDataManipulation($strMode, $strDetails);
								}
							}
							break;

						case 'insert':
							if(!in_array($arrData[$arrTableimport['uniqueSource']], (is_array($arrTableimport['existentKeysTarget']) ? $arrTableimport['existentKeysTarget'] : array())))
							{
								// perform insert of this row
								$arrCheck = $this->performSingleDataManipulation($arrTableimport, $arrData, $objFields, $arrFieldnames, 'Insert');

								$strDetails .= '<br>'.$arrCheck['details'];

								if(!$arrCheck['result'] && $arrTableimport['abortOnError'])
								{
									return $this->abortDataManipulation($strMode, $strDetails);
								}
							}
							break;

					}
				}
			}

			// increase line
			$_SESSION['tl_tabimporter']['currentLine']++;

			// determine maximum steps in php execution time
			if($_SESSION['tl_tabimporter']['sqlSteps'][$strMode]==0 && $_SESSION['tl_tabimporter']['currentLine']==100)
			{
				$intEndMaxtime = time()+microtime();
				
				// calculate max steps and give 50% safety
				$_SESSION['tl_tabimporter']['sqlSteps'][$strMode] = 50 * ceil($GLOBALS['tl_tabimporter']['sqlSteps']['maxtime']/($intEndMaxtime-$intBeginMaxtime));
			}

			// next step required
			if($_SESSION['tl_tabimporter']['currentLine'] == $intFirstline+$_SESSION['tl_tabimporter']['sqlSteps'][$strMode])
			{
				// if run at the backend
				if($this->Input->get('do')=='tabimporter')
				{
					$_SESSION['tl_tabimporter']['nextStepFirstline'] = $_SESSION['tl_tabimporter']['currentLine'];

					return array
					(
						'result' => true,
						'abort' => false
					);
				}
				// run by cron job
				else
				{
					$this->redirect($this->addToUrl('&firstline='.$_SESSION['tl_tabimporter']['currentLine'],$this->Environment->request));
				}

			}

		}

		// log warnings, errors and inserts
		if($_SESSION['tl_tabimporter']['countWarnings']>0)
		{
			$strDetails = $GLOBALS['TL_LANG']['tl_tabimporter']['warnings'].': '.$_SESSION['tl_tabimporter']['countWarnings'].'<br>'.$strDetails;
		}
		if($_SESSION['tl_tabimporter']['countErrors']>0)
		{
			$strDetails = $GLOBALS['TL_LANG']['tl_tabimporter']['errors'].': '.$_SESSION['tl_tabimporter']['countErrors'].'<br>'.$strDetails;
		}
		if($_SESSION['tl_tabimporter']['countOperations']>0)
		{
			$strDetails = $GLOBALS['TL_LANG']['tl_tabimporter'][$strMode].': '.$_SESSION['tl_tabimporter']['countOperations'].'<br>'.$strDetails;
		}
		
		if($_SESSION['tl_tabimporter']['countErrors']>0)
		{
			return array
			(
				'result' => false,
				'abort' => false,
				'details' => $strDetails
			);
		}

		return array
		(
			'result' => ($_SESSION['tl_tabimporter']['countWarnings']>0 ? 'warnings' : true),
			'abort' => false,
			'details' => ($strDetails ? $strDetails : $GLOBALS['TL_LANG']['tl_tabimporter']['no_hit'])
		);
	}


	/**
	 * perform inserts or updates for fields from source value
	 */
	public function performSingleDataManipulation($arrTableimport, $arrData, $objFields, $arrFieldnames, $strMode)
	{
		if($strMode=='Update')
		{
			if($arrData['tabimport_unique'])
			{
				$strKeyValue = $arrData['tabimport_unique'];
			}
			elseif($arrData[$arrTableimport['uniqueTarget']])
			{
				$strKeyValue = $arrData[$arrTableimport['uniqueTarget']];
			}
			else
			{
				$strKeyValue = $arrData[$arrTableimport['uniqueSource']];
			}
		}

		$arrWarnings = array();
		$arrSet = array();
		$objFields->reset();
		while($objFields->next())
		{
			if(in_array($objFields->fieldname,$arrFieldnames))
			{
				$strTypeField = 'type'.$strMode;
				
				if($strMode=='Update')
				{
					// get actual data
					$objActualData = $this->Database->prepare("SELECT ".$objFields->fieldname." as tabimporterValue FROM ".$arrTableimport['targetTable']."_tabimport WHERE ".$arrTableimport['uniqueTarget']."=?")
						->limit(1)
						->executeUncached($strKeyValue);
				}

				switch($objFields->$strTypeField)
				{
					case 'Insertfromfield':
					case 'Updatefromfield':
						$strModeField = 'mode'.$strMode;

						switch($objFields->$strModeField)
						{
							case 'Bool':
								$strTmp = 'field'.$strMode;
								if(in_array(strToLower($arrData[$objFields->$strTmp]),array('0','','n','no','-','-1',false,'false')))
								{
									$arrSet[$objFields->fieldname] = 0;
								}
								else
								{
									$arrSet[$objFields->fieldname] = 1;
								}
								break;
	
							case 'Expand':
								switch($strMode)
								{
									case 'Update':
										if($objFields->expandSideUpdate=='leftSide')
										{
											$arrSet[$objFields->fieldname] = $objActualData->tabimporterValue.$objFields->expandStringUpdate.$arrData[$objFields->fieldUpdate];
										}
										else
										{
											$arrSet[$objFields->fieldname] = $arrData[$objFields->fieldUpdate].$objFields->expandStringUpdate.$objActualData->tabimporterValue;
										}
										break;
									case 'Insert':
										if($objFields->expandSideInsert=='leftSide')
										{
											$arrSet[$objFields->fieldname] = $objFields->expandStringInsert.$arrData[$objFields->fieldInsert];
										}
										else
										{
											$arrSet[$objFields->fieldname] = $arrData[$objFields->fieldInsert].$objFields->expandStringInsert;
										}
										break;
								}
								break;
	
							case 'Fill':
								$strTmp = 'field'.$strMode;
								$strTmp2 = 'fieldLength'.$strMode;
								$strTmp3 = 'fillChar'.$strMode;
								$strTmp4 = 'expandSide'.$strMode;
								if($objFields->$strTmp4=='leftSide')
								{
									$arrSet[$objFields->fieldname] = str_pad($arrData[$objFields->$strTmp], ($objFields->$strTmp2+1), $objFields->$strTmp3, STR_PAD_LEFT);
								}
								else
								{
									$arrSet[$objFields->fieldname] = str_pad($arrData[$objFields->$strTmp], ($objFields->$strTmp2+1), $objFields->$strTmp3, STR_PAD_RIGHT);
								}
								break;
	
							case 'Datestring':
								$strTmp = 'field'.$strMode;
								$strTmp2 = 'dateFormat'.$strMode;
								if($objFields->$strTmp2)
								{
									if($arrData[$objFields->$strTmp]!='' || $arrData[$objFields->$strTmp]>0)
									{
										$tmpTstamp = new Date($arrData[$objFields->$strTmp],$objFields->$strTmp2);
										$arrSet[$objFields->fieldname] = $tmpTstamp->tstamp;
									}
									else
									{
										$arrSet[$objFields->fieldname] = '';
									}
								}
								break;
	
							case 'Crop':
								$strTmp = 'field'.$strMode;
								$strTmp2 = 'fieldLength'.$strMode;
								$strTmp3 = 'expandSide'.$strMode;
								if($objFields->$strTmp3=='leftSide')
								{
									$arrSet[$objFields->fieldname] = substr($arrData[$objFields->$strTmp], 0, $objFields->$strTmp2);
								}
								else
								{
									$arrSet[$objFields->fieldname] = substr($arrData[$objFields->$strTmp], -1*$objFields->$strTmp2);
								}
								break;
	
							case 'Tags':
								switch($strMode)
								{
									case 'Update':
										if($objFields->tagTypeSourceUpdate == 'delimited' && $objFields->sourceDelimiterUpdate)
										{
											$arrSourceTags = explode($objFields->sourceDelimiterUpdate, $arrData[$objFields->fieldUpdate]);
										}
										else
										{
											$arrSourceTags = unserialize($arrData[$objFields->fieldUpdate]);
										}
									
										if($objFields->tagMode != 'Replace')
										{
											if($objFields->tagTypeTargetUpdate == 'delimited' && $objFields->targetDelimiterUpdate)
											{
												$arrTargetTags = explode($objFields->targetDelimiterUpdate, $objActualData->tabimporterValue);
											}
											else
											{
												$arrTargetTags = unserialize($objActualData->tabimporterValue);
											}
										}
			
										switch($objFields->tagMode)
										{
											case 'Replace':
												$arrNewTags = $arrSourceTags;
												break;
			
											case 'Add':
												if(is_array($arrTargetTags) && is_array($arrSourceTags))
												{
													$arrNewTags = array_unique(array_merge($arrTargetTags, $arrSourceTags));
												}
												elseif(is_array($arrTargetTags))
												{
													$arrNewTags = $arrTargetTags;
												}
												elseif(is_array($arrSourceTags))
												{
													$arrNewTags = $arrSourceTags;
												}
												break;
			
											case 'Delete':
												$arrNewTags = array();
												if(is_array($arrTargetTags))
												{
													foreach($arrTargetTags as $tag)
													{
														if(is_array($arrSourceTags) && !in_array($tag, $arrSourceTags))
														{
															$arrNewTags[] = $tag;
														}
													}
												}
												break;
										}
			
										if($objFields->tagTypeTargetUpdate == 'delimited' && $objFields->targetDelimiterUpdate)
										{
											$arrSet[$objFields->fieldname] = is_array($arrNewTags) ? implode($objFields->targetDelimiterUpdate,$arrNewTags) : '';
										}
										else
										{
											$arrSet[$objFields->fieldname] = is_array($arrNewTags) ? serialize($arrNewTags) : '';
										}
										break;
	
									case 'Insert':
										if($objFields->tagTypeSourceInsert == 'delimited' && $objFields->sourceDelimiterInsert)
										{
											$arrNewTags = explode($objFields->sourceDelimiterInsert, $arrData[$objFields->fieldInsert]);
										}
										else
										{
											$arrNewTags = unserialize($arrData[$objFields->fieldInsert]);
										}
	
										if($objFields->tagTypeTargetInsert == 'delimited' && $objFields->targetDelimiterInsert)
										{
											$arrSet[$objFields->fieldname] = is_array($arrNewTags) ? implode($objFields->targetDelimiterInsert,$arrNewTags) : '';
										}
										else
										{
											$arrSet[$objFields->fieldname] = is_array($arrNewTags) ? serialize($arrNewTags) : '';
										}
										break;
	
								}
								break;
	
							default:
								$strTmp = 'field'.$strMode;
								$arrSet[$objFields->fieldname] = $arrData[$objFields->$strTmp];
								break;

						}
						break;

					// fix value
					case 'Updatefix':
						if($objFields->fixUpdate)
						{
							$arrSet[$objFields->fieldname] = $objFields->fixUpdate;
						}
						break;
					case 'Insertfix':
						if($objFields->fixInsert)
						{
							$arrSet[$objFields->fieldname] = $objFields->fixInsert;
						}
						break;

					// date value
					case 'Updatedate':
						if($objFields->dateValUpdate && $objFields->timeValUpdate)
						{
							$arrSet[$objFields->fieldname] = $objFields->dateValUpdate+$objFields->timeValUpdate;
						}
						break;
					case 'Insertdate':
						if($objFields->dateValInsert && $objFields->timeValInsert)
						{
							$arrSet[$objFields->fieldname] = $objFields->dateValInsert+$objFields->timeValInsert;
						}
						break;
					
					// timestamp
					case 'Updatetstamp':
						$arrSet[$objFields->fieldname] = time()+$objFields->tstampUpUpdate;
						break;
					case 'Inserttstamp':
						$arrSet[$objFields->fieldname] = time()+$objFields->tstampUpInsert;
						break;

					// count up
					case 'Insertcountup':
						if((!$_SESSION['tl_tabimporter']['countUp'][$objFields->fieldname] || $_SESSION['tl_tabimporter']['countUp'][$objFields->fieldname] == 0) && $objFields->initialValue == 'ownValue')
						{
							$arrSet[$objFields->fieldname] = $objFields->start;
						}
						elseif(!$_SESSION['tl_tabimporter']['countUp'][$objFields->fieldname] || $_SESSION['tl_tabimporter']['countUp'][$objFields->fieldname] == 0)
						{
							$objCount = $this->Database->prepare("SELECT ".$objFields->fieldname." as tabimport_value FROM ".$arrTableimport['targetTable']."_tabimport ORDER BY ".$objFields->fieldname." DESC")
								->limit(1)
								->executeUncached();

							if($objCount->error)
							{
								// warn if counting has errors
								$arrWarnings[] = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['countup_error'],$objFields->fieldname,$_SESSION['tl_tabimporter']['currentLine'],$arrTableimport['uniqueTarget'],$arrSet[$arrTableimport['uniqueTarget']]).'<br>';
							}

							$arrSet[$objFields->fieldname] = $objCount->tabimport_value + $objFields->step;
						}
						else
						{
							$arrSet[$objFields->fieldname] = ($_SESSION['tl_tabimporter']['countUp'][$objFields->fieldname] + $objFields->step);
						}
						$_SESSION['tl_tabimporter']['countUp'][$objFields->fieldname] = $arrSet[$objFields->fieldname];
						break;

					// from sql query
					case 'Updatesql':
						if($objFields->sqlUpdate)
						{
							$arrSql = $this->performSQL($this->parseSimpleTokens($objFields->sqlUpdate, $arrData));

							if($arrSql->error)
							{
								// warn if sql has errors
								$arrWarnings[] = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['sql_error'],$objFields->fieldname,$_SESSION['tl_tabimporter']['currentLine'],$arrTableimport['uniqueTarget'],$arrSet[$arrTableimport['uniqueTarget']]).'<br>';
							}

							$arrSet[$objFields->fieldname] = ($arrSql['result'] && $arrSql['value'] ? $arrSql['value'] : '');
						}
						break;
					case 'Insertsql':
						if($objFields->sqlInsert)
						{
							$arrSql = $this->performSQL($this->parseSimpleTokens($objFields->sqlInsert, $arrData));
							
							if($arrSql->error)
							{
								// warn if sql has errors
								$arrWarnings[] = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['sql_error'],$objFields->fieldname,$_SESSION['tl_tabimporter']['currentLine'],$arrTableimport['uniqueTarget'],$arrSet[$arrTableimport['uniqueTarget']]).'<br>';
							}

							$arrSet[$objFields->fieldname] = ($arrSql['result'] && $arrSql['value'] ? $arrSql['value'] : '');
						}
						break;

					// from hook
					case 'Updatehook':
						if(is_array($GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookUpdate]) && count($GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookUpdate]))
						{
							$this->import($GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookUpdate][0]);
							$arrSet[$objFields->fieldname] = $this->$GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookUpdate][0]->$GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookUpdate][1]($arrTableimport, $arrData);
						}
						break;
					case 'Inserthook':
						if(is_array($GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookInsert]) && count($GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookInsert]))
						{
							$this->import($GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookInsert][0]);
							$arrSet[$objFields->fieldname] = $this->$GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookInsert][0]->$GLOBALS['TL_HOOKS']['tabimporter'][$objFields->hookInsert][1]($arrTableimport, $arrData);
						}
						break;
				}

				// no null values
				if(is_null($arrSet[$objFields->fieldname]))
				{
					$arrSet[$objFields->fieldname] = '';
				}
			}
		}

		$objFields->reset();

		// update or insert
		switch($strMode)
		{
			case 'Update':
				$objDataUpdate = false;
				$checkFieldtypes = $this->checkFieldtypes($arrSet, $arrTableimport['fieldDef']);
		
				// update if no simulation
				if($checkFieldtypes===true)
				{
					if($_SESSION['tl_tabimporter']['jobSim'])
					{
						// simulated updates always work ...
						$objDataUpdate = true;
					}
					else
					{
						try
						{
							$objDataUpdate = $this->Database->prepare("UPDATE ".$arrTableimport['targetTable']."_tabimport %s WHERE ".$arrTableimport['uniqueTarget']."=?")
								->set($arrSet)
								->executeUncached($strKeyValue);
						}
						catch(Exception $e)
						{
							// fatal errors
							return array
							(
								'result' => false,
								'details' => $e->getMessage()
							);
						}
					}
				}
				else
				{
					$arrWarnings[] = implode('',$checkFieldtypes);
					$_SESSION['tl_tabimporter']['countWarnings'] += count($checkFieldtypes);
				}
		
				// errors
				if(!$objDataUpdate || $objDataUpdate->error)
				{
					$_SESSION['tl_tabimporter']['countErrors']++;
		
					return array
					(
						'result' => false,
						'details' => implode('',$arrWarnings).sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['update_error'],$arrTableimport['targetTable'],$arrTableimport['uniqueTarget'],$strKeyValue,$_SESSION['tl_tabimporter']['currentLine'])
					);
				}
				break;

			case 'Insert':
				// make sure that a key field exists, even empty
//				if(!$arrSet[$arrTableimport['uniqueTarget']])
//				{
//					$arrSet[$arrTableimport['uniqueTarget']] = '';
//				}
		
				$objDataInsert = false;
				$checkFieldtypes = $this->checkFieldtypes($arrSet, $arrTableimport['fieldDef']);
		
				// insert if no simulation
				if($checkFieldtypes===true)
				{
					if($_SESSION['tl_tabimporter']['jobSim'])
					{
						// simulated inserts always work ...
						$objDataInsert = true;
					}
					else
					{
						try
						{
							$objDataInsert = $this->Database->prepare("INSERT INTO ".$arrTableimport['targetTable']."_tabimport %s")
								->set($arrSet)
								->executeUncached();
						}
						catch(Exception $e)
						{
							// fatal errors
							return array
							(
								'result' => false,
								'details' => $e->getMessage()
							);
						}			
					}
				}
				else
				{
					$arrWarnings[] = implode('',$checkFieldtypes);
					$_SESSION['tl_tabimporter']['countWarnings'] += count($checkFieldtypes);
				}
	
				// errors
				if(!$objDataInsert || $objDataInsert->error)
				{
					$_SESSION['tl_tabimporter']['countErrors']++;
		
					return array
					(
						'result' => false,
						'details' => implode('',$arrWarnings).sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['sql_inserterror'],$arrTableimport['targetTable'],$arrTableimport['uniqueTarget'],$arrSet[$arrTableimport['uniqueTarget']],$_SESSION['tl_tabimporter']['currentLine']).'<br>'
					);
				}
				break;
		}

		// row inserted
		$_SESSION['tl_tabimporter']['countOperations']++;
		$_SESSION['tl_tabimporter']['countWarnings'] += count($arrWarnings);

		return array
		(
			'result' => true,
			'details' => implode('',$arrWarnings)
		);

	}


	/**
	 * abort data manipulation
	 */
	public function abortDataManipulation($strMode, $strDetails)
	{
		// log warnings, errors and inserts
		if($_SESSION['tl_tabimporter']['countWarnings']>0)
		{
			$strDetails = $GLOBALS['TL_LANG']['tl_tabimporter']['warnings'].': '.$_SESSION['tl_tabimporter']['countWarnings'].'<br>'.$strDetails;
		}
		if($_SESSION['tl_tabimporter']['countErrors']>0)
		{
			$strDetails = $GLOBALS['TL_LANG']['tl_tabimporter']['errors'].': '.$_SESSION['tl_tabimporter']['countErrors'].'<br>'.$strDetails;
		}
		if($_SESSION['tl_tabimporter']['countOperations']>0)
		{
			$strDetails = $GLOBALS['TL_LANG']['tl_tabimporter'][$strMode].': '.$_SESSION['tl_tabimporter']['countOperations'].'<br>'.$strDetails;
		}
		
		return array
		(
			'result' => false,
			'abort' => true,
			'warnings' => ($_SESSION['tl_tabimporter']['countWarnings']>0 ? true : false),
			'details' => $strDetails
		);
	}



	/**
	 * make sure that values could be stored in fieldtype, regardless of sense
	 */
	public function checkFieldtypes($arrSet, $arrFielddef)
	{
		$arrWarnings = array();

		foreach($arrSet as $k=>$v)
		{
			foreach($arrFielddef as $arrDef)
			{
				if($arrDef['name']==$k)
				{
					switch($arrDef['type'])
					{
						case 'int':
							if(!is_numeric($v))
							{
								if(!is_int($v*1))
								{
									$arrWarnings[] = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['fielderror_int'],$k).'<br>';
								}
							}
							elseif(!is_int($v*1))
							{
								$arrWarnings[] = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['fielderror_int'],$k).'<br>';
							}
							break;
						case 'char':
						case 'varchar':
							if (strlen($v)>$arrDef['length'])
							{
								$arrWarnings[] = sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['fielderror_char'],$k).'<br>';
							}
							break;
					}
				}
			}	
		}

		if(count($arrWarnings)>0)
		{
			return $arrWarnings;
		}
		
		return true;
	}


	/**
	 * perform sql query and return value from sql query if needed
	 */
	public function performSQL($strSql, $arrSet=array(), $strArgs=false)
	{
		try
		{
			$objSql = $this->Database->prepare($strSql)
				->set($arrSet)
				->executeUncached($strArgs);
		}
		catch(Exception $e)
		{
			// fatal errors
			return array
			(
				'result' => false,
				'details' => $e->getMessage()
			);
		}

		// errors
		if(!$objSql || $objSql->error)
		{
			return array
			(
				'result' => false,
				'details' => $GLOBALS['TL_LANG']['tl_tabimporter']['errors'].': '.$objSql->error
			);
		}

		// ok
		return array
		(
			'result' => true,
			'details' => $GLOBALS['TL_LANG']['tl_tabimporter']['datasets'].': '.$objSql->affectedRows.'<br>'.$GLOBALS['TL_LANG']['tl_tabimporter']['SQL'].':<br>'.$strSql,
			'value' => $objSql->tabimport_value
		);
	}


	/**
	 * perform hook functionality
	 */
	public function performHook($objSteps)
	{
		if(is_array($GLOBALS['TL_HOOKS']['tabimporter'][$objSteps->hook]) && count($GLOBALS['TL_HOOKS']['tabimporter'][$objSteps->hook]))
		{
			$this->import($GLOBALS['TL_HOOKS']['tabimporter'][$objSteps->hook][0]);
			$arrResult = $this->$GLOBALS['TL_HOOKS']['tabimporter'][$objSteps->hook][0]->$GLOBALS['TL_HOOKS']['tabimporter'][$objSteps->hook][1]($objSteps);
			if($arrResult)
			{
				// success
				return array
				(
					'result' => $arrResult['result'],
					'details' => $arrResult['details']
				);
			}
		}

		// errors
		return array
		(
			'result' => false,
			'details' => $arrResult['details']
		);
	}



	/**
	 * track import step and build status view
	 */
	protected function updateStatus($strCheck, $blnAbort, $strStep, $strOk, $strFail, $strDetails='')
	{
		// new step?
		if($strStep != $_SESSION['tl_tabimporter']['currentStepName'])
		{
			$_SESSION['tl_tabimporter']['jobLog'] .= '<div class="tl_tabimporter_step">'.$strStep.'</div>';
			$_SESSION['tl_tabimporter']['currentStepName'] = $strStep;
		}

		if($strCheck)
		{
			// import step succeeded
			$this->Database->prepare("INSERT INTO tl_tabimporter_runsteps %s")
				->set(array(
					'tstamp' => time(),
					'pid' => $_SESSION['tl_tabimporter']['runId'],
					'step' => $strStep,
					'title' => $strOk,
					'status' => ($strCheck===true ? 'ok' : 'warn'),
					'details' => $strDetails
					))
				->executeUncached();

			$_SESSION['tl_tabimporter']['jobLog'] .= '<div class="tl_tabimporter_ok">'.$strOk.'</div>';
		}
		else
		{
			// import step has errors
			if($blnAbort)
			{
				// error aborts import job
				$this->Database->prepare("INSERT INTO tl_tabimporter_runsteps %s")
					->set(array(
						'tstamp' => time(),
						'pid' => $_SESSION['tl_tabimporter']['runId'],
						'step' => $strStep,
						'title' => $strFail,
						'status' => 'abort',
						'details' => $strDetails
						))
					->executeUncached();

				$_SESSION['tl_tabimporter']['abortError'] = true;
				$_SESSION['tl_tabimporter']['jobLog'] .= '<div class="tl_tabimporter_abort">'.$strFail.'</div>';
			}
			else
			{
				// no abortion but error
				$this->Database->prepare("INSERT INTO tl_tabimporter_runsteps %s")
					->set(array(
						'tstamp' => time(),
						'pid' => $_SESSION['tl_tabimporter']['runId'],
						'step' => $strStep,
						'title' => $strFail,
						'status' => 'error',
						'details' => $strDetails
						))
					->executeUncached();

				$_SESSION['tl_tabimporter']['jobLog'] .= '<div class="tl_tabimporter_error">'.$strFail.'</div>';
			}
		}
	}

}

?>