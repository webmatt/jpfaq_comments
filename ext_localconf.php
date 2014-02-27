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

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Comnerds.' . $_EXTKEY,
	'notification',
	array(
		'Question' => 'notification',
		
	),
	// non-cacheable actions
	array(
		'Question' => 'notification',
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Comnerds.' . $_EXTKEY,
	'showcount',
	array(
		'Question' => 'showCount',
		
	),
	// non-cacheable actions
	array(
		'Question' => 'showCount',
	)
);

//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'][] = 'EXT:jpfaq_comments/Classes/Hooks/HooksHandler.php:Comnerds\JpfaqComments\Hooks\HooksHandler->loginConfirmed';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkDataSubmission'][] = 'EXT:jpfaq_comments/Classes/Hooks/HooksHandler.php:Comnerds\JpfaqComments\Hooks\HooksHandler';

?>
