<?php
namespace Comnerds\JpfaqComments\Controller;

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
class QuestionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * questionRepository
     *
     * @var \Comnerds\JpfaqComments\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository;

    /**
     * categoryRepository
     *
     * @var \Comnerds\JpfaqComments\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * commentRepository
     *
     * @var \Comnerds\JpfaqComments\Domain\Repository\CommentRepository
     * @inject
     */
    protected $commentRepository;

    /**
     * frontendUserRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * newquestions
     *
     */
    protected $newquestions;

    /**
     * Overriden to be called before every action.
     *
     * @return void
     */
    protected function initializeAction()
    {
	$temp = $GLOBALS['TSFE']->fe_user->getKey('ses', 'jpfaq_newquestions');
	if (is_array($temp))
	{
	    $this->newquestions = $temp;
	}
	else
	{
	    $this->newquestions = array();
	}
	//		if ($this->arguments->hasArgument('image')) {
	//			$this->arguments->getArgument('image')->getPropertyMappingConfiguration()->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_TARGET_TYPE, 'array');
	//			$this->arguments->getArgument('image')->getPropertyMappingConfiguration()->setTypeConverterOption('TYPO3\\CMS\\Extbase\\Property\\TypeConverter\\PersistentObjectConverter', \TYPO3\CMS\Extbase\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED, TRUE);
	//		}
    }

    /**
     * Displays all Questions
     *
     * @return string The rendered list view
     */
    public function listAction() {
	// stylesheets includes in header
	$includes = '';
	foreach ($this->settings['includeCss'] as $cssFile)
	{
	    $path = '';
	    $mediatype = 'all';
	    if (isset($cssFile['path']))
	    {
		$path .= str_replace('EXT:', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $cssFile['path']);
		if (isset($cssFile['mediatype']))
		{
		    $mediaType = $cssFile['mediatype'];
		}
		$includes .= chr(13) . '<link rel="stylesheet" type="text/css" href="' . $path . '" media="' . $mediatype . '" />';
	    }
	}

	$GLOBALS["TSFE"]->additionalHeaderData[$this->request->getControllerExtensionKey()] = $includes;

	// check if extension t3query is loaded, if not load jQuery lib
	if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3jquery'))
	{
	    require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('t3jquery') . 'class.tx_t3jquery.php');
	}

	// If t3jquery is loaded and the custom library has been created
	if (T3JQUERY === true)
	{
	    \tx_t3jquery::addJqJS();
	}
	else
	{
	    $includeJquery = $this->settings['includeJquery'];
	    $pathIncludeJquery = '';
	    if (isset($includeJquery['path']))
	    {
		$pathIncludeJquery .= str_replace('EXT:', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $includeJquery['path']);
	    }
	    else
	    {
		$pathIncludeJquery = NULL;
	    }
	}

	// Load quicksearch js
	$includeQuicksearch = $this->settings['includeQuicksearch'];
	$pathIncludeQuicksearch = '';
	if (isset($includeQuicksearch['path']))
	{
	    $pathIncludeQuicksearch .= str_replace('EXT:', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $includeQuicksearch['path']);
	}
	else
	{
	    $pathIncludeQuicksearch = NULL;
	}

	// Load quicksearch js
	$includeColorbox = $this->settings['includeColorbox'];
	$pathIncludeColorbox = '';
	if (isset($includeColorbox['path']))
	{
	    $pathIncludeColorbox .= str_replace('EXT:', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()), $includeColorbox['path']);
	}
	else
	{
	    $pathIncludeColorbox = NULL;
	}

	// put js in footer
	if (isset($pathIncludeJquery))
	{
	    $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeJquery), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
	}
	if (isset($pathIncludeQuicksearch))
	{
	    $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeQuicksearch), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
	}
	if (isset($pathIncludeColorbox))
	{
	    $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeColorbox), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
	}

	// get selected category and page from flexform
	$selectedCategory = intval($this->settings['flexform']['selectCategory']);
	$flexformPid = intval($this->settings['flexform']['selectPid']);
	// get all questions belonging to this category
	$questions = $this->questionRepository->getAllQuestionsForCategory($selectedCategory, $flexformPid);
	$categoryName = $this->categoryRepository->getCategoryNameForCategoryUid($selectedCategory);
	$this->view->assign('questions', $questions);
	$this->view->assign('showSearchForm', $this->settings['flexform']['showSearch']);
	$this->view->assign('category', $categoryName);
	$this->view->assign('categoryUid', $selectedCategory);

	//set fold / unfold js
	$json = json_encode($this->newquestions);
	$js = <<<EOJ
if (typeof jpfaqCategories == 'undefined') {
	jpfaqCategories = new Array();
}		
jpfaqCategories.push($selectedCategory);
if (typeof jpfaqNewQuestions == 'undefined') {
    jpfaqNewQuestions = JSON.parse('$json');
}
EOJ;

	//load dynamic js in footer
	$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode($this->request->getControllerExtensionKey() . ' ' . $categoryName, $js, $compress = TRUE, $forceOnTop = FALSE);

	$jspath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/jpfaqcomments.js';
	$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($jspath), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');

    }

    /**
     * Creates a comment for this question.
     *
     * @param integer $qid The uid of the question
     * @param string $comment The submitted body of the question
     */
    public function createCommentAction($qid, $comment)
    {
	$question = $this->questionRepository->findByUid($qid);
	if ($question)
	{
	    $uid = @$GLOBALS['TSFE']->fe_user->user['uid'];
	    if ($uid)
	    {
		$user = $this->frontendUserRepository->findByUid($uid);
		if ($user)
		{
		    $flexformPid = intval($this->settings['flexform']['selectPid']);
		    $c = $this->objectManager->get('Comnerds\\JpfaqComments\\Domain\\Model\\Comment');
		    $c->setQuestion($question);
		    $c->setComment($comment);
		    $c->setUser($user);
		    $c->setCommentdate(time());
		    $c->setPid($flexformPid);
		    $c->setHidden(true);
		    // check if image was uploaded
		    $filename = 'tx_jpfaqcomments_' . strtolower($this->request->getPluginName());
		    $fileObject = null;
		    if (@$_FILES[$filename]['error']['image'] == 0)
		    {
			$name = $_FILES[$filename]['name']['image'];
			$tmp_name = $_FILES[$filename]['tmp_name']['image'];
			$storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
			$storage = $storageRepository->findByUid(1);
			$fileObject = $storage->addFile($tmp_name, $storage->getRootLevelFolder(), $name);
			$c->setImage($fileObject->getUid());
		    }
		    $this->commentRepository->add($c);
		    // TODO: Clear cache for all pages related to this question
		    $this->cacheService->clearPageCache($GLOBALS['TSFE']->id);
		    $this->sendMail($c, $fileObject);
		}
	    }
	}
	$this->redirect(NULL);
    }

    /**
     * Shows the new questions notification
     */
    public function notificationAction()
    {
	$this->view->assign('count', count($this->newquestions));
    }

    /**
     * Injects the count of new questions into the menu.
     */
    public function showCountAction()
    {
	$cats = $GLOBALS['TSFE']->fe_user->getKey('ses', 'jpfaq_newpercats');
	if (!is_array($cats))
	{
	    $cats = array();
//	    error_log("fetch new per cats");
	    if (count($this->newquestions) > 0)
	    {
		$pid = 127; // temp, ..., intval($this->settings['flexform']['selectPid']);
		$pages = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows('uid,title', 'pages', "pid = $pid AND hidden = 0 AND deleted = 0");
		$uids = array();
		$titles = array();
		foreach($pages as $page)
		{
		    $uids[] = $page["uid"];
		    $titles[$page["uid"]] = $page["title"];
		}
		$uidstring = "(" . implode(",", $uids) . ")";
		$titlecats = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows("pid,pi_flexform", 'tt_content', "pid in $uidstring AND hidden = 0 AND deleted = 0 AND list_type = 'jpfaqcomments_jpfaqcomments'");
		$cats = array();
		foreach($titlecats as $titlecat)
		{
		    $str = $titlecat['pi_flexform'];
		    $pos = strpos($str, "selectCategory");
		    $str = substr($str, $pos);
		    $pos = strpos($str, "value");
		    $str = substr($str, $pos);
		    $pos = strpos($str, ">");
		    $str = substr($str, $pos+1);
		    $pos = strpos($str, "<");
		    $str = substr($str, 0, $pos);
		    $cat = intval($str);

		    $count = 0;
		    foreach($this->newquestions as $qid)
		    {
			$qcats = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows("uid_foreign", "tx_jpfaqcomments_question_category_mm", "uid_local = $qid");
			foreach($qcats as $qcat)
			{
			    if ($qcat['uid_foreign'] == $cat)
			    {
				$count++;
			    }
			}
		    }
		    if ($count > 0)
		    {
			$cats[$titles[$titlecat["pid"]]] = $count;
		    }
		}
		if (count($cats) > 0)
		{
		    $GLOBALS['TSFE']->fe_user->setKey('ses', 'jpfaq_newpercats', $cats);
		}
	    }
	}
	$newtotal = $GLOBALS['TSFE']->fe_user->getKey('ses', 'jpfaq_newtotal');
	if (!is_array($newtotal))
	{
	    $newtotal = array();
//	    error_log("fetch new total");
	    if (count($this->newquestions) > 0)
	    {
		$pid = 127; // temp, ..., intval($this->settings['flexform']['selectPid']);
		$page = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('title', 'pages', "uid = $pid AND hidden = 0 AND deleted = 0");
		if ($page !== NULL)
		{
		    $newtotal = $page;
		    $newtotal['count'] = count($this->newquestions);
		    $GLOBALS['TSFE']->fe_user->setKey('ses', 'jpfaq_newtotal', $newtotal);
		}
	    }
	}

	$GLOBALS['TSFE']->fe_user->storeSessionData();
	$json = json_encode($cats);
	$json2 = json_encode($newtotal);
	$js = <<<EOJ
if (typeof jpfaqNewPerCats == 'undefined') {
    jpfaqNewPerCats = JSON.parse('$json');
}
if (typeof jpfaqTotal == 'undefined') {
    jpfaqTotal = JSON.parse('$json2');
}
EOJ;

	//load dynamic js in footer
	$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode($this->request->getControllerExtensionKey() . 'newcount', $js, $compress = TRUE, $forceOnTop = FALSE);

	$jspath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Js/newcount.js';
	$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($jspath), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');

	return $this->view->render();
    }

    /**
     * Sends an email that a new comment was created to the configured recipient.
     *
     * @param \Comnerds\JpfaqComments\Domain\Model\Comment $comment
     */
    private function sendMail($comment, $fileObject = NULL)
    {
	if (!isset($this->settings['newCommentRecipient']) || !isset($this->settings['newCommentSender']) || !isset($this->settings['newCommentSubject']))
	{
	    return;
	}

	// render email template
	$emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
	$emailView->setFormat('html');
	$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

	$templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
	$templateFullPath = $templateRootPath . 'Email/NewComment.html';
	$emailView->setTemplatePathAndFilename($templateFullPath);
	$emailView->assign('comment', $comment);
	if ($fileObject != NULL)
	{
	    $appendix = $this->request->getBaseURI() . $fileObject->getPublicUrl();
	    $emailView->assign('appendix', $appendix);
	}

	$recipient = $this->settings['newCommentRecipient'];
	//		$sender = $this->settings['newCommentSender'];
	$sender = $comment->getUser()->getEmail();
	//		$subject = $this->settings['newCommentSubject'];
	$subject = "Nachfrage zu FAQ ID " . $comment->getQuestion()->getUid() . " - " . 
	    $this->configurationManager->getContentObject()->crop($comment->getQuestion()->getQuestion(), '32|...|true');
	$mail = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
	$mail->setFrom(array($sender => ''))
	    ->setTo(array($recipient => ''))
	    //			 ->setSubject(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('tx_jpfaqcomments.newComment_subject', $this->request->getControllerExtensionKey()))
	    ->setSubject($subject)
	    ->setBody($emailView->render(), 'text/html')
	    ->send();

    }

}
?>
