<?php


namespace KURZ\KurzFlowplayer\Rendering;

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


use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperInterface;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperRegistry;
use TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface;
use KURZ\KurzFlowplayer\ViewHelpers\FlowplayerVideoHelper;

/**
 * Class FlowplayerVideoRenderer
 * @package KURZ\KurzFlowplayer\Rendering
 */
class FlowplayerVideoRenderer implements FileRendererInterface
{

    /**
     * @var OnlineMediaHelperInterface
     */
    protected $onlineMediaHelper;


    /**
     * @return integer
     */
    public function getPriority()
    {
        return 1;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @return boolean
     */
    public function canRender(FileInterface $file)
    {
        return ($file->getMimeType() === 'application/octet-stream' || $file->getExtension() === 'flowplayer') && $this->getOnlineMediaHelper($file) !== false;
    }


    /**
     * Get online media helper
     *
     * @param FileInterface $file
     * @return bool|OnlineMediaHelperInterface
     */
    protected function getOnlineMediaHelper(FileInterface $file)
    {
        if ($this->onlineMediaHelper === null) {
            $orgFile = $file;
            if ($orgFile instanceof FileReference) {
                $orgFile = $orgFile->getOriginalFile();
            }
            if ($orgFile instanceof File) {
                $this->onlineMediaHelper = OnlineMediaHelperRegistry::getInstance()->getOnlineMediaHelper($orgFile);
            } else {
                $this->onlineMediaHelper = false;
            }
        }

        return $this->onlineMediaHelper;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\FileInterface $file
     * @param int|string $width
     * @param int|string $height
     * @param array $options
     * @param bool $usedPathsRelativeToCurrentScript
     * @return string
     */
    public function render(\TYPO3\CMS\Core\Resource\FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false)
    {
        $filename = explode(".", $file->getProperty('name'));
        $videoId = $filename[0];
        $siteId = $file->getContents();

        ///return '<div data-player-id="5c149835-639d-42b4-abb8-ab70a6372e2d"><script src="//cdn.flowplayer.com/players/'.$siteId.'/native/flowplayer.async.js">{"src": "'. $videoId.'"}</script></div>';
        $js = '<div class="flowplayer-embed-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width:100%;">
<iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" webkitAllowFullScreen mozallowfullscreen allowfullscreen 
src="//ljsp.lwcdn.com/api/video/embed.jsp?id='. $videoId.'&pi=a29c6a42-b142-42fa-b7be-4e280e8020a5" 
title="0" byline="0" portrait="0" width="640" height="360" frameborder="0" allow="autoplay"></iframe>
</div>';
        return $js;
    }

}
