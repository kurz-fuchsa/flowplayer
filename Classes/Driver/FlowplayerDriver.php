<?php

namespace KURZ\KurzFlowplayer\Driver;

/***
 *
 * This file is part of the "FAL flowplayer Driver" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Alexander Fuchs <alexander.fuchs@kurz.de>
 *
 ***/

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Resource\Driver\LocalDriver;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FlowplayerDriver
 * @package KURZ\KurzFlowplayer\Driver
 */
class FlowplayerDriver extends LocalDriver
{

    /**
     *
     */
    const DRIVER_TYPE = 'FlowplayerFalDriver';
    /**
     * @var mixed
     */
    public $extConf;

    /**
     * The base URL that points to this driver's storage. As long is this is not set, it is assumed that this folder
     * is not publicly available
     *
     * @var string
     */

    protected $baseUrl;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration = [])
    {
        $this->extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('kurz_flowplayer');
        parent::__construct($configuration);

        // The capabilities default of this driver. See CAPABILITY_* constants for possible values
        $this->capabilities =
            ResourceStorage::CAPABILITY_BROWSABLE
            | ResourceStorage::CAPABILITY_PUBLIC
            | ResourceStorage::CAPABILITY_WRITABLE;
    }




}
