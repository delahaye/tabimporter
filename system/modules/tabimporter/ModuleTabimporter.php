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
 * Class ModuleTabimporter
 *
 * Execute an import job.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class ModuleTabimporter extends BackendModule
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'be_tabimporter';

	/**
	 * Generate module
	 * @throws Exception
	 */
	protected function compile()
	{
		$this->loadLanguageFile('tl_tabimporter');
		$this->import('BackendUser', 'User');
		$this->import('Tabimporter');

		$this->Template = new BackendTemplate($this->strTemplate);

		$this->Template->href = $this->getReferer(true);
		$this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['backBT']);
		$this->Template->action = ampersand($this->Environment->request);
		$this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];

		// run import job
		$this->Template->content = $this->Tabimporter->runJob();

		// parse template
		return $this->Template->parse();
	}


	/**
	 * track import step and build status view
	 */
	protected function updateStatus($strCheck, $blnAbort, $strStep, $strOk, $strFail, $strDetails='')
	{
		// new step?
		if($strStep != $this->currentStep)
		{
			$this->Template->content .= '<div class="tl_tabimporter_step">'.$strStep.'</div>';
			$this->currentStep = $strStep;
		}

		if($strCheck)
		{
			// import step succeeded
			$this->Database->prepare("INSERT INTO tl_tabimporter_runsteps %s")
				->set(array(
					'tstamp' => time(),
					'pid' => $this->runId,
					'step' => $strStep,
					'title' => $strOk,
					'status' => ($strCheck===true ? 'ok' : 'warn'),
					'details' => $strDetails
					))
				->execute();

			$this->Template->content .= '<div class="tl_tabimporter_ok">'.$strOk.'</div>';
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
						'pid' => $this->runId,
						'step' => $strStep,
						'title' => $strFail,
						'status' => 'abort',
						'details' => $strDetails
						))
					->execute();

				$this->Template->abortError = true;
				$this->Template->content .= '<div class="tl_tabimporter_abort">'.$strFail.'</div>';
			}
			else
			{
				// no abortion but error
				$this->Database->prepare("INSERT INTO tl_tabimporter_runsteps %s")
					->set(array(
						'tstamp' => time(),
						'pid' => $this->runId,
						'step' => $strStep,
						'title' => $strFail,
						'status' => 'error',
						'details' => $strDetails
						))
					->execute();

				$this->Template->content .= '<div class="tl_tabimporter_error">'.$strFail.'</div>';
			}
		}
	}

}

?>