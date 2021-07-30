<?php

if( !defined( 'TYPO3_MODE' ) )
{
    die( 'Access denied.' );
}


// Feld definieren
$tempColumns = [
    'videoloop' => [
        'label' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang.xlf:sys_file_reference.videoloop',
        'exclude' => 1,
        'config' => [
            'type' => 'check',
            'default' => 0,
            'size' => 10
        ]
    ],
    'autopause' => [
        'label' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang.xlf:sys_file_reference.autopause',
        'exclude' => 1,
        'config' => [
            'type' => 'check',
            'default' => 0,
            'size' => 10
        ]
    ],
    'muted' => [
        'label' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang.xlf:sys_file_reference.muted',
        'exclude' => 1,
        'config' => [
            'type' => 'check',
            'default' => 0,
            'size' => 10
        ]
    ],

    'height' => [
        'label' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang.xlf:sys_file_reference.height',
        'exclude' => 1,
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'size' => 10
        ]
    ],

    'width' => [
        'label' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang.xlf:sys_file_reference.width',
        'exclude' => 1,
        'config' => [
            'type' => 'input',
            'eval' => 'trim',
            'size' => 10
        ]
    ],

    'player' => [
        'exclude' => true,
        'label' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang.xlf:tx_kurzflowplayer_domain_model_player',
        'config' => [
            'type' => 'user',
            'userFunc' => KURZ\KurzFlowplayer\Userfuncs\Tca::class . '->fieldSelectedPlayer',
        ],
    ],


];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'sys_file_reference', $tempColumns
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette(
    'sys_file_reference',
    'videoOverlayPalette',
    '--linebreak--,player, autopause, autoplay, videoloop, muted, --linebreak--, height,  width',
    'after:description'
);
