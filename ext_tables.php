<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'KURZ.KurzFlowplayer',
                'tools', // Make module a submodule of 'tools'
                'm2', // Submodule key
                '', // Position
                [
                    'Administration' => 'index', 'importVideos',
                    'Workspace' => 'list, new, create, edit, update, delete'

                ],
                [
                    'access' => 'user,group',
                    'icon' => 'EXT:kurz_flowplayer/Resources/Public/Icons/logo-blue.png',
                    'labels' => 'LLL:EXT:kurz_flowplayer/Resources/Private/Language/locallang_m2.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('kurz_flowplayer', 'Configuration/TypoScript', 'FAL flowplayer Driver');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_kurzflowplayer_domain_model_administration', 'EXT:kurz_flowplayer/Resources/Private/Language/locallang_csh_tx_kurzflowplayer_domain_model_administration.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_kurzflowplayer_domain_model_administration');

    }
);
