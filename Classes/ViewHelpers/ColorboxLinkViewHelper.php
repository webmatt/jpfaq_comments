<?php
namespace Comnerds\JpfaqComments\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Matthias Toews <m.toews@comnerds.com>, comnerds.com
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package jpfaq_comments
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ColorboxLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 * @return string the rendered output for the user
	 */
	public function render($image)
	{
		$out = '<span class="fullname">';
		// Construct a custom representation of the user
		// dependent if getFirstname() and/or getLastName() are set
		// and later company
		if ($user->getFirstName() || $user->getLastName())
		{
			if (!$user->getFirstName())
			{
				$out .= $user->getLastName();
			}
			else if (!$user->getLastName())
			{
				$out .= $user->getFirstName();
			}
			else
			{
				$out .= $user->getFirstName() . ' ' . $user->getLastName();
			}

		}
		else
		{
			// If neither are set fall back to just username
			$out .= $user->getUsername();
		}
		$out .= '</span>';
		if ($user->getCompany())
		{
			$out .= ' (' . $user->getCompany() . ')';
		}
		return $out;
	}

}
?>

