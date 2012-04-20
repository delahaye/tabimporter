<?php

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
 * Initialize the system
 */
define('TL_MODE', 'FE');
require('system/initialize.php');


/**
 * Class TabimporterCron
 *
 * Cron job controller for Tabimporter.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class TabimporterCron extends Frontend
{

	/**
	 * Initialize the object (do not remove)
	 */
	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Run the controller
	 */
	public function run()
	{
		$this->loadLanguageFile('tl_tabimporter');
		$this->import('Tabimporter');

		// only run with token
		if(!$this->Input->get('token'))
		{
			die(sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['errorMessageNotFound'],''));
		}
		
		// get job data
		$objJob = $this->Database->prepare("SELECT id FROM tl_tabimporter_jobs WHERE token=?")
			->limit(1)
			->execute($this->Input->get('token'));

		if(!$objJob || !$objJob->numRows || $objJob->error)
		{
			die(sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['errorMessageNotFound'].$objJob->error,$this->Input->get('token')));
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
				$this->Tabimporter->runInit($objJob->id);

				// next step if no abortion
				if(!$_SESSION['tl_tabimporter']['abortError'])
				{
					// perform first step
					if(count($_SESSION['tl_tabimporter']['jobSteps'])>0)
					{
						$this->redirect(sprintf('tabimporter.php?token=%s&step=steps&stepid=%s',$this->Input->get('token'),$_SESSION['tl_tabimporter']['jobSteps'][0]));
					}
					// no steps defined
					else
					{
						$this->redirect(sprintf('tabimporter.php?token=%s&step=final',$this->Input->get('token')));
					}
				}

				break;

			case 'steps':
				// run step
				$this->Tabimporter->runStep($this->Input->get('stepid'));

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
							$this->redirect(sprintf('tabimporter.php?token=%s&step=steps&stepid=%s',$this->Input->get('token'),$arrNext[$arrNextKey[0]]));
						}
						// no next step defined
						else
						{
							$this->redirect(sprintf('tabimporter.php?token=%s&step=final',$this->Input->get('token')));
						}
					}
				}

				break;

			case 'final':
				// run finalisation step
				$this->Tabimporter->runFinal();

				break;

		}

		// Add log entry
		if(!$this->Input->get('sim'))
		{
			if($_SESSION['tl_tabimporter']['abortError'])
			{
				$this->log('Importjob "' . specialchars($arrJob['title']) . '" manually failed.', 'Tabimporter runJob()', TL_ERROR);
			}
			else
			{
				$this->log('Importjob "' . specialchars($arrJob['title']) . '" manually succeeded.', 'Tabimporter runJob()', TL_GENERAL);
			}
		}
		
		// print out log
		exit(sprintf($GLOBALS['TL_LANG']['tl_tabimporter']['jobtitle'],$objJob->id).': '.strip_tags(str_replace('</div>',' | ',$_SESSION['tl_tabimporter']['jobLog'])));
		unset($_SESSION['tl_tabimporter']);
	}
}


/**
 * Instantiate controller
 */
$objTabimporterCron = new TabimporterCron();
$objTabimporterCron->run();

?>