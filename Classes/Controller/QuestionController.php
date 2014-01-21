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
	 * Overriden to be called before every action.
	 *
	 * @return void
	 */
	protected function initializeAction()
	{
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

		$GLOBALS["TSFE"]->additionalHeaderData[$this->extKey] = $includes;

		// check if extension t3query is loaded, if not load jQuery lib
		if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('t3jquery'))
		{
			require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('t3jquery') . 'class.tx_t3jquery.php');
		}

		// If t3jquery is loaded and the custom library has been created
		if (T3JQUERY === true)
		{
			tx_t3jquery::addJqJS();
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

		// put js in footer
		if (isset($pathIncludeJquery))
		{
			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeJquery), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
		}
		if (isset($pathIncludeQuicksearch))
		{
			$GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($GLOBALS['TSFE']->tmpl->getFileName($pathIncludeQuicksearch), $type = 'text/javascript', $compress = TRUE, $forceOnTop = FALSE, $allWrap = '');
		}
	}

	/**
	 * Displays all Questions
	 *
	 * @return string The rendered list view
	 */
	public function listAction() {
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
		$js = <<<HEREDOC
		$(document).ready(function(){
			jQuery('.jpfaqHide$selectedCategory').hide();
			jQuery('ul.listCategory$selectedCategory .toggleTrigger').next().hide();
			jQuery('ul.listCategory$selectedCategory .toggleTrigger').click(function(){
				jQuery(this).next().toggleClass("active").slideToggle('fast');
				jQuery(this).toggleClass("questionUnfolded");
				if (jQuery(".tx-jpfaq-pi1 ul.listCategory$selectedCategory li").children(':first-child').length == jQuery(".tx-jpfaq-pi1 ul.listCategory$selectedCategory li").children(':first-child.questionUnfolded').length) {
					jQuery('.jpfaqShow$selectedCategory').hide();
					jQuery('.jpfaqHide$selectedCategory').show();
				} else {
					jQuery('.jpfaqHide$selectedCategory').hide();
					jQuery('.jpfaqShow$selectedCategory').show();
				}
			});
			jQuery('.jpfaqShow$selectedCategory').click(function(){
				jQuery('.toggleTriggerContainer$selectedCategory').removeClass("active");
				jQuery('.toggleTriggerContainer$selectedCategory').addClass("active").slideDown('fast');
				jQuery('ul.listCategory$selectedCategory .toggleTrigger').removeClass("questionUnfolded");
				jQuery('ul.listCategory$selectedCategory .toggleTrigger').addClass("questionUnfolded");
				jQuery('.jpfaqShow$selectedCategory').hide();
				jQuery('.jpfaqHide$selectedCategory').show();
			});
			jQuery('.jpfaqHide$selectedCategory').click(function(){
				jQuery('.toggleTriggerContainer$selectedCategory').removeClass("active").slideUp('fast');
				jQuery('ul.listCategory$selectedCategory .toggleTrigger').removeClass("questionUnfolded");
				jQuery('.jpfaqHide$selectedCategory').hide();
				jQuery('.jpfaqShow$selectedCategory').show();
			});
		});
HEREDOC;

		//load dynamic js in footer
		$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode($this->extKey . ' ' . $categoryName, $js, $compress = TRUE, $forceOnTop = FALSE);

	}

}
?>
