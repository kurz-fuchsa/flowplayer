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




