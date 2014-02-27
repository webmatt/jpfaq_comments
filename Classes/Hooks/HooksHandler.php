<?php
namespace Comnerds\JpfaqComments\Hooks;

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
class HooksHandler {

	/**
	 * Login Confirmed hook
	 * @param array $params
	 * @param object $obj
	 */
	public function loginConfirmed($params, &$obj)
	{
		if (is_array($GLOBALS['TSFE']->fe_user->user))
		{
			$user = $GLOBALS['TSFE']->fe_user->user;
			if ($user['jpfaq_lastlogin'] != 0)
			{
				$lastlogin = $user['jpfaq_lastlogin'];
				$where = "hidden=0 AND deleted=0 AND tstamp>$lastlogin";
				$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', 'tx_jpfaqcomments_domain_model_question', $where);
				$questions = array();
				foreach($rows as $row)
				{
					$questions[] = $row['uid'];
				}
				$GLOBALS['TSFE']->fe_user->setKey('ses', 'jpfaq_newquestions', $questions);
				$GLOBALS['TSFE']->fe_user->storeSessionData();
			}
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users',
				'uid=' . intval($user['uid']), array('jpfaq_lastlogin' => $user['lastlogin']));
		}
	}

	public function checkDataSubmission()
	{
		if (\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('logintype') == 'login')
		{
			if (is_array($GLOBALS['TSFE']->fe_user->user))
			{
				$user = $GLOBALS['TSFE']->fe_user->user;
				if ($user['jpfaq_lastlogin'] != 0)
				{
					$lastlogin = $user['jpfaq_lastlogin'];
					$where = "hidden=0 AND deleted=0 AND tstamp>$lastlogin";
					$rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid', 'tx_jpfaqcomments_domain_model_question', $where);
					$questions = array();
					foreach($rows as $row)
					{
						$questions[] = $row['uid'];
					}
					$GLOBALS['TSFE']->fe_user->setKey('ses', 'jpfaq_newquestions', $questions);
				}
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users',
					'uid=' . intval($user['uid']), array('jpfaq_lastlogin' => $user['lastlogin']));
			}
		}
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'jpfaq_newpercats', null);
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'jpfaq_newtotal', null);
		$GLOBALS['TSFE']->fe_user->storeSessionData();
	}

}
?>
