<?php
defined('TYPO3_MODE') or die();


  if( \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('news')){
    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['fal_media']['config']['overrideChildTca']['types'][4] = [
        'showitem' => '
        --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
        --palette--;;videoOverlayPalette,
        --palette--;;filePalette'
    ];

    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['fal_media']['config']['overrideChildTca']['types'][0] = [
        'showitem' => '
            --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;newsPalette,
            --palette--;;videoOverlayPalette,
            --palette--;;filePalette'
    ];

}
