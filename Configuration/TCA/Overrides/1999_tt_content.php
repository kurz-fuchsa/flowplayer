<?php

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
            ]
        ]
    ];

