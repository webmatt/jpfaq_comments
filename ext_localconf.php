<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Comnerds.' . $_EXTKEY,
	'Jpfaqcomments',
	array(
		'Question' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Category' => '',
		'Question' => '',
		'Comment' => '',
		
	)
);

?>