<?php


namespace KURZ\KurzFlowplayer\ViewHelpers;

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


use KURZ\KurzFlowplayer\Constants\JsonParameters;
use KURZ\KurzFlowplayer\Lib\HTTP\HttpRequest;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\AbstractOEmbedHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class FlowplayerVideoHelper
 * @package KURZ\KurzFlowplayer\ViewHelpers
 */
class FlowplayerVideoHelper extends AbstractOEmbedHelper
{


    /**
     * Get public url
     * Return NULL if you want to use core default behaviour
     *
     * @param File $file
     * @param bool $relativeToCurrentScript
     * @return string|null
     */
    public function getPublicUrl(File $file, $relativeToCurrentScript = false)
    {
        $videoId = $this->getFileName($file);
        $response = $this->requestingAPI($file, $videoId);

        $encodings = $response->{JsonParameters::ENCODINGS};
        //return sprintf('https://cdn.flowplayer.com/%s', rawurlencode($videoId));
        return $encodings[0]->{JsonParameters::ENCODING_VIDEO_FILE_URL};
    }


    /**
     * @param \TYPO3\CMS\Core\Resource\File $file
     * @return string
     */
    public function getPreviewImage(File $file)
    {

        $videoId = $this->getFileName($file);
        $response = $this->requestingAPI($file, $videoId);
        $temporaryFileName = $this->getTempFolderPath() . 'flowplayer_' . md5($videoId) . '.jpg';

        $previewImage = GeneralUtility::getUrl(
            $response->images[0]->url
        );

        if ($images = $response->{JsonParameters::IMAGES}) {
                    foreach ($images as $image) {
                        if ($image->type == JsonParameters::IMAGE_TYPE_THUMBNAIL) {
                            $imageUrl = $image->url;
                        }
                    }
        $request = new HttpRequest($imageUrl, $httpHeader = []);
        $previewImage = $request->executeRESTCall("GET", null);
        ///$previewImage = GeneralUtility::getUrl($response->images[0]->url);

        }
        if ($previewImage !== false) {
            file_put_contents($temporaryFileName, $previewImage);
            GeneralUtility::fixPermissions($temporaryFileName);
        }

        return $temporaryFileName;
    }




    /**
     * @param $siteId
     * @return mixed
     */
    public function getApiKey($siteId)
    {

        $field = "site_id";
        $table = "tx_kurzflowplayer_domain_model_workspace";
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $query = $queryBuilder
            ->select('api_key')
            ->from($table);
        $queryBuilder->where(
            $queryBuilder->expr()->eq($field,
                $queryBuilder->createNamedParameter($siteId))
        );
        ///$queryBuilder->andWhere('sys_language_uid = ' . $GLOBALS['TSFE']->sys_language_uid);
        $result = $query->execute();
        $res = [];
        while ($row = $result->fetch(0)) {
            $res[] = $row['api_key'];
        }
        return $res[0];
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


    /**
     * @param \TYPO3\CMS\Core\Resource\File $file
     * @param string $videoId
     * @param string $apiKey
     * @return mixed
     */
    protected function requestingAPI($file, $videoId)
    {

        $siteId = $file->getContents();
        $apiKey = $this->getApiKey($siteId);

        $storageConfiguration = $file->getStorage()->getConfiguration();
        //$apiKey = $storageConfiguration['apiKey'];
        $apiBaseURL = $storageConfiguration['apiBaseURL'];
        ///Endpoint for listing a Video
        $videosUrl = $apiBaseURL . "videos/" . $videoId;
        $httpHeader = [
            'Content-Type: application/json',
            'x-flowplayer-api-key:' . $apiKey
        ];

        $request = new HttpRequest($videosUrl, $httpHeader);
        $r = $request->executeRESTCall("GET", null);
        return json_decode($r);

    }


    protected function getOEmbedUrl($mediaId, $format = 'json')
    {
        // TODO: Implement getOEmbedUrl() method.
    }

    public function transformUrlToFile($url, Folder $targetFolder)
    {
        // TODO: Implement transformUrlToFile() method.
    }
}
