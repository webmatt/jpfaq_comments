<?php
namespace Comnerds\JpfaqComments\Domain\Model;

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
class Comment extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * comment
	 *
	 * @var \string
	 */
	protected $comment;

	/**
	 * commentdate
	 *
	 * @var \DateTime
	 */
	protected $commentdate;

	/**
	 * question
	 *
	 * @var \Comnerds\JpfaqComments\Domain\Model\Question
	 */
	protected $question;

	/**
	 * user
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
	 */
	protected $user;

	/**
	 * image
	 *
	 * @var int
	 */
	protected $image;

	/**
	 * Returns the comment
	 *
	 * @return \string $comment
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * Sets the comment
	 *
	 * @param \string $comment
	 * @return void
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	/**
	 * Returns the commentdate
	 *
	 * @return \DateTime $commentdate
	 */
	public function getCommentdate() {
		return $this->commentdate;
	}

	/**
	 * Sets the commentdate
	 *
	 * @param \DateTime $commentdate
	 * @return void
	 */
	public function setCommentdate($commentdate) {
		$this->commentdate = $commentdate;
	}

	/**
	 * Returns the question
	 *
	 * @return \Comnerds\JpfaqComments\Domain\Model\Question $question
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * Sets the question
	 *
	 * @param \Comnerds\JpfaqComments\Domain\Model\Question $question
	 * @return void
	 */
	public function setQuestion(\Comnerds\JpfaqComments\Domain\Model\Question $question) {
		$this->question = $question;
	}

	/**
	 * Returns the user
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Sets the user
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user
	 * @return void
	 */
	public function setUser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $user) {
		$this->user = $user;
	}

	/**
	 * Returns the image
	 *
	 * @return int $image
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param int $image
	 *
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

}
?>
