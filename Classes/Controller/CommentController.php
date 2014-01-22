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
class CommentController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * commentRepository
	 *
	 * @var \Comnerds\JpfaqComments\Domain\Repository\CommentRepository
	 * @inject
	 */
	protected $commentRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$comments = $this->commentRepository->findAll();
		$this->view->assign('comments', $comments);
	}

	/**
	 * action new
	 *
	 * @param \Comnerds\JpfaqComments\Domain\Model\Comment $newComment
	 * @dontvalidate $newComment
	 * @return void
	 */
	public function newAction(\Comnerds\JpfaqComments\Domain\Model\Comment $newComment = NULL) {
		$this->view->assign('newComment', $newComment);
	}

	/**
	 * action create
	 *
	 * @param \Comnerds\JpfaqComments\Domain\Model\Comment $newComment
	 * @return void
	 */
	public function createAction(\Comnerds\JpfaqComments\Domain\Model\Comment $newComment) {
		$this->commentRepository->add($newComment);
		$this->flashMessageContainer->add('Your new Comment was created.');
		$this->redirect('list');
	}

}
?>