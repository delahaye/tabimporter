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
 * Class TabimporterSource_db
 *
 * Provides methods used for table imports.
 * @copyright  Christian de la Haye 2012
 * @author     Christian de la Haye 
 * @package    tabimporter 
 */
class TabimporterSource_db extends Backend
{

	/**
	 * read complete csv data
	 */
	public function getAllData($arrTableimport, $strMode, $arrFieldnames)
	{
		switch($strMode)
		{
			case 'update':
					$objData = $this->Database->prepare("SELECT *, ".$arrTableimport['uniqueSource']." as tabimport_unique FROM ".$arrTableimport['sourceTable'])
						->executeUncached();
				break;

			case 'insert':
				$objData = $this->Database->prepare("SELECT * FROM ".$arrTableimport['sourceTable'])
					->executeUncached();

				break;
		}

		return $objData->fetchAllAssoc();
	}


	/**
	 * get keys of the source
	 */
	public function getExistentKeysSource($arrTableimport)
	{
		$objKeys = $this->Database->executeUncached("SELECT ".$arrTableimport['uniqueSource']." FROM ".$arrTableimport['sourceTable']);
		$arrKeys = $objKeys->fetchEach($arrTableimport['uniqueSource']);

 		if(!$arrKeys || count($arrKeys)<1)
		{
			return false;
		}

		return $arrKeys;
	}

}

?>