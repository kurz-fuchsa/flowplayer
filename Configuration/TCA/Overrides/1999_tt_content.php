<?php




/*###playsinline autoplay muted loop width height
$GLOBALS['TCA']['sys_file_reference']['palettes']['videoOverlayPalette'] = array_replace_recursive(
    $GLOBALS['TCA']['sys_file_reference']['palettes']['videoOverlayPalette'],
    [
        'showitem' => ' title,description,--linebreak--,autoplay, videoloop, muted, --linebreak--, height,  width'
    ]
);*/

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToPalette('sys_file_reference', 'videoOverlayPalette', 'title, description,--linebreak--,autoplay, videoloop, muted, --linebreak--, height,  width');

$GLOBALS['TCA']['tt_content']['types']['media']['columnsOverrides']['assets']['config'] =
    [
        'filter' => [
            0 => [
                'parameters' => [
                    'allowedFileExtensions' => 'gif,jpg,jpeg,bmp,png,pdf,svg,ai,mp3,wav,mp4,ogg,flac,opus,webm, flowplayer'
                ]
            ]
        ],
        'foreign_selector_fieldTcaOverride' => [
            'config' => [
                'appearance' => [
                    'elementBrowserAllowed' => 'youtube, vimeo, flowplayer, mp4'
                ]
            ]
        ],
        'overrideChildTca' => [
            'columns' => [
                'uid_local' => [
                    'config' => [
                        'appearance' => [
                            'elementBrowserAllowed' => 'gif,jpg,jpeg,bmp,png,pdf,svg,ai,mp3,wav,mp4,ogg,flac,opus,webm,youtube,vimeo,flowplayer'
                        ]
                    ]
                ]
            ],
            'types' =>[
                \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                    'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.videoOverlayPalette;videoOverlayPalette,
                                    --palette--;;filePalette'
                ]
            ]

        ]
    ];




