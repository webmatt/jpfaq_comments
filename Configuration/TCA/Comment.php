<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_jpfaqcomments_domain_model_comment'] = array(
	'ctrl' => $TCA['tx_jpfaqcomments_domain_model_comment']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'comment,question,user',
	),
	'types' => array(
		'1' => array('showitem' => 'comment,question,user'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_jpfaqcomments_domain_model_comment',
				'foreign_table_where' => 'AND tx_jpfaqcomments_domain_model_comment.pid=###CURRENT_PID### AND tx_jpfaqcomments_domain_model_comment.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'comment' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:jpfaq_comments/Resources/Private/Language/locallang_db.xlf:tx_jpfaqcomments_domain_model_comment.comment',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'commentdate' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:jpfaq_comments/Resources/Private/Language/locallang_db.xlf:tx_jpfaqcomments_domain_model_comment.date',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'question' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:jpfaq_comments/Resources/Private/Language/locallang_db.xlf:tx_jpfaqcomments_domain_model_comment.question',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_jpfaqcomments_domain_model_question',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'user' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:jpfaq_comments/Resources/Private/Language/locallang_db.xlf:tx_jpfaqcomments_domain_model_comment.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:jpfaq_comments/Resources/Private/Language/locallang_db.xlf:tx_jpfaqcomments_domain_model_comment.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', 
				array(
					'maxitems' => 1,
					'appearance' => array(
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference',
					),
				), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
		),

	),
);

?>
