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


use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperInterface;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\OnlineMediaHelperRegistry;
use TYPO3\CMS\Core\Resource\Rendering\FileRendererInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
    public function render(FileInterface $file, $width, $height, array $options = [], $usedPathsRelativeToCurrentScript = false)
    {

        $videoId = $this->getFileName($file);
        $siteId = $file->getContents();
        $this->extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('kurz_flowplayer');
        $propertiesOfFileReference = $file->getProperties();
        $parameters = '&';

        $attributes = [];
        if ($propertiesOfFileReference['autoplay']) {
            $attributes[] = ' allow="autoplay" ';
            $parameters .='autoplay=true&';
        }
        if ($propertiesOfFileReference['muted']) {
            $attributes[] = 'muted';
            $parameters .='mute=true&';
        }
        if ($propertiesOfFileReference['videoloop']) {
            $attributes[] = 'videoloop';
            $parameters .='loop=true&';
        }
        if ($propertiesOfFileReference['autopause']) {
            $attributes[] = 'autopause';
        }
        if ($propertiesOfFileReference['width']) {
            $attributes[] = 'width="' . (int)$propertiesOfFileReference['width'] . '"';
        }
        if ($propertiesOfFileReference['height']) {
            $attributes[] = 'height="' . (int)$propertiesOfFileReference['height'] . '"';
        }
       // if ($propertiesOfFileReference['title']) {
            $attributes[] = 'title="' . $options['title'] . '"';
       // }

        if ($propertiesOfFileReference['player']) {
            $player = '//embed.flowplayer.com/api/video/embed.jsp?id='.$videoId.'&pi='.  $propertiesOfFileReference['player'];
        }else{
            $player =  '//ljsp.lwcdn.com/api/video/embed.jsp?id='. $videoId;
        }

        $attributes[] = ' byline="0" portrait="0" frameborder="0" ';
            ///return '<div data-player-id="5c149835-639d-42b4-abb8-ab70a6372e2d"><script src="//cdn.flowplayer.com/players/'.$siteId.'/native/flowplayer.async.js">{"src": "'. $videoId.'"}</script></div>';

        $iframe =  sprintf('<div %s><iframe %s src="%s" %s></iframe></div>',
            'class="flowplayer-embed-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width:100%;"',
            'style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" webkitAllowFullScreen mozallowfullscreen allowfullscreen ',
            $player,
            empty($attributes) ? '' : ' ' . implode(' ', $attributes)
        );

        return $iframe;
        $js = '<div class="flowplayer-embed-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width:100%;">
<iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" webkitAllowFullScreen mozallowfullscreen allowfullscreen 
src="//ljsp.lwcdn.com/api/video/embed.jsp?id='. $videoId.'&pi=a29c6a42-b142-42fa-b7be-4e280e8020a5" 
title="0" byline="0" portrait="0" width="640" height="360" frameborder="0" allow="autoplay"></iframe>
</div>';
        return $js;
    }

    /**
     * @param \TYPO3\CMS\Core\Resource\File $file
     * @return string
     */
    public function getFileName($file)
    {
        $filename = explode("/", $file->getProperty('identifier'));
        $filename = explode(".",  $filename[count($filename)-1]);
        return $filename[0];
    }

}
