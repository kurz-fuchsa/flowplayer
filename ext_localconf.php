<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

/** @var \TYPO3\CMS\Core\Resource\Driver\DriverRegistry $driverRegistry */
$driverRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\Driver\\DriverRegistry');
$driverRegistry->registerDriverClass(
    'KURZ\\KurzFlowplayer\\Driver\\FlowplayerDriver',
    \KURZ\KurzFlowplayer\Driver\FlowplayerDriver::DRIVER_TYPE,
    'Flowplayer FAL Driver',
    'FILE:EXT:kurz_flowplayer/Configuration/FlexForms/FlowplayerDriver.xml'
);

// Register flowplayer frontend viewhelper
$GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['onlineMediaHelpers']['flowplayer'] = KURZ\KurzFlowplayer\ViewHelpers\FlowplayerVideoHelper::class;

$rendererRegistry = \TYPO3\CMS\Core\Resource\Rendering\RendererRegistry::getInstance();
$rendererRegistry->registerRendererClass(
    KURZ\KurzFlowplayer\Rendering\FlowplayerVideoRenderer::class
);

// Register an custom mime-type for flowplayer videos
$GLOBALS['TYPO3_CONF_VARS']['SYS']['FileInfo']['fileExtensionToMimeType']['flowplayer'] = 'application/octet-stream';

// Register flowplayer custom file extension as allowed media file
$GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'] .= ',flowplayer';

// Register a node in ext_localconf.php
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry']["1647533258"] = [
    'nodeName' => 'fieldSelectedPlayer',
    'priority' => 40,
    'class' =>  \KURZ\KurzFlowplayer\Userfuncs\SelectedPlayerElement::class,
];




