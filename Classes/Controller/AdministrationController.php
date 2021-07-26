<?php

namespace KURZ\KurzFlowplayer\Controller;

use KURZ\KurzFlowplayer\Lib\HTTP\HttpRequest;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Index\FileIndexRepository;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use KURZ\KurzFlowplayer\Constants\JsonParameters;

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

/**
 * AdministrationController
 */
class AdministrationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * administrationRepository
     *
     * @var \KURZ\KurzFlowplayer\Domain\Repository\AdministrationRepository
     * @inject
     */
    protected $administrationRepository = null;

    /**
     * @var \TYPO3\CMS\Core\Resource\StorageRepository
     */
    private $storageRepository;


    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory|null
     */
    protected $resourceFactory;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceStorage[]
     */
    protected $fileStorages;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceStorage
     */
    protected $storage;

    /**
     * The configuration belonging to this storage (decoded from the configuration field).
     *
     * @var array
     */
    protected $storageConfiguration;

    /**
     * workspaceRepository
     *
     * @var \KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository
     * @inject
     */
    protected $workspaceRepository = null;

    /**
     * AdministrationController constructor.
     * @param StorageRepository $storageRepository
     */
    public function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }


    /**
     * action index
     *
     * @return void
     */
    public function indexAction()
    {
        $siteId = '';
        $fileStorages = $this->storageRepository->findByStorageType('FlowplayerFalDriver');
        $this->storage = $fileStorages[0];
        $workspaces = $this->workspaceRepository->findAll();

        if (count($fileStorages) < 1) {
            $this->addFlashMessage(
                'Please adding Flowplayer File Storage in TYPO3 Backend.',
                'Flowplayer storage FAL driver not defined',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
                TRUE
            );
        } else {

            $this->storageConfiguration = $this->storage->getConfiguration();
            if ($this->request->hasArgument('siteId')) {
                $siteId = $this->request->getArgument('siteId');
                $res = $this->workspaceRepository->findOneBySiteId($siteId);

                try{
                    $apiKey = $res->getApiKey();
                }catch ( Exception $exception ){
                    $exception->getMessage();
                }

            }

            $apiBaseURL = $this->storageConfiguration['apiBaseURL'];
            ///Endpoint for listing a Video
            $videosUrl = $apiBaseURL . "videos";
            $httpHeader = [
                'Content-Type: application/json',
                'x-flowplayer-api-key:' . $apiKey
            ];

            $request = new HttpRequest($videosUrl, $httpHeader);

            if($r = $request->executeRESTCall("GET", null)){

                $videos = json_decode($r);
                $basePath = GeneralUtility::getFileAbsFileName(
                    $this->storageConfiguration['basePath']
                );
                if ($videos->total_count > 0) {
                    foreach ($videos->assets as $video) {
                        if ($video->{JsonParameters::ID}) {
                            $this->createNewFile($video);
                        }
                    }
                    $this->view->assign('videos', $videos);

                }
            }else{
                $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['kurz_flowplayer']);
                $this->addFlashMessage(
                    'Please check your proxy settings in configuration options for this extension.',
                    'Proxy Setting is ' . $this->extConf['useProxy'],
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
                    TRUE
                );
            }


            $this->view->assign('workspaces', $workspaces);
            $this->view->assign('siteId',  $siteId );
        }

    }


    /**
     * Create new OnlineMedia item container file
     * @param $video
     * @return void
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFolderException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderWritePermissionsException
     */
    protected function createNewFile($video)
    {


        $ordnername = $this->storage->sanitizeFileName($video->{JsonParameters::WORKSPACE}->name);
        try {
            /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
            $folder = $this->storage->getFolder("/" . $ordnername . "/");
        } catch (FolderDoesNotExistException $exception) {
            /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
            $folder = $this->storage->createFolder("/" . $ordnername . "/");
        }

        $file = $folder->createFile($video->{JsonParameters::ID} . '.flowplayer');
        $properties = $file->getProperties();
        $properties['type'] = File::FILETYPE_VIDEO;
        $file->updateProperties($properties);
        $file->setContents($video->{JsonParameters::WORKSPACE}->id);
        $this->updateFileProperties($file, $properties);
        $this->runMetaDataExtraction($file, $video);

    }


    /**
     * Runs the metadata extraction for a given file.
     *
     * @param object $video
     * @param File $fileObject
     * @return void
     * @see Indexer::runMetaDataExtraction
     */
    protected function runMetaDataExtraction(File $fileObject, $video)
    {

        $newMetaData = array(
            'title' => $video->{JsonParameters::NAME},
            'description' => $video->{JsonParameters::DESCRIPTION},
            'keywords' => $video->{JsonParameters::TAGS},
            //'categories' => $video->{JsonParameters::CATEGORY}->name,
            'duration' => $video->{JsonParameters::DURATION}
            //'width' =>,
            //'height' =>

        );

        $fileObject->_updateMetaDataProperties($newMetaData);
        $metaDataRepository = MetaDataRepository::getInstance();
        $metaDataRepository->update($fileObject->getUid(), $newMetaData);
    }

    /**
     * Runs the metadata extraction for a given file.
     *
     * @param array $fileProperties
     * @param File $fileObject
     * @return void
     * @see Indexer::runMetaDataExtraction
     */
    protected function updateFileProperties(\TYPO3\CMS\Core\Resource\File $fileObject, $fileProperties = array())
    {
        $fileObject->updateProperties($fileProperties);
        $fileIndexRepository = FileIndexRepository::getInstance();
        $fileIndexRepository->update($fileObject);
    }



}
