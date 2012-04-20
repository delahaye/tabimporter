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
 * Class TabimporterExamples
 *
 * Example for using hooks in the Tabimporter
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class TabimporterExamples extends Backend
{

	/**
	 * Perform anything here
	 * @param object
	 * @return array
	 */
	public function exampleStep($objSteps)
	{
		// add hook functionality here

		return array
		(
			'result' => true, // true or false
			'details' => 'Everything is fine.' // status for logging
		);
	}

	/**
	 * Perform anything here and return a value for the field
	 * @param array
	 * @param array
	 * @return string
	 */
	public function exampleField($arrTableimport, $arrData)
	{
		// add hook functionality here
		$return = '1';
	
		return $return;
	}

}

?>