<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Comnerds.' . $_EXTKEY,
	'Jpfaqcomments',
	array(
		'Question' => 'list, createComment',
		
	),
	// non-cacheable actions
	array(
		'Question' => 'createComment',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Comnerds.' . $_EXTKEY,
	'Jpfaqcomments2',
	array(
		'Question' => 'list, createComment',
		
	),
	// non-cacheable actions
	array(
		'Question' => 'createComment',
	)
);

?>
