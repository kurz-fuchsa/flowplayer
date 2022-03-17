<?php

namespace KURZ\KurzFlowplayer\Controller;

use KURZ\KurzFlowplayer\Connection\ApiConnection;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Index\FileIndexRepository;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use KURZ\KurzFlowplayer\Constants\JsonParameters;
use TYPO3\CMS\Extbase\Annotation\Inject;
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
     * @var \TYPO3\CMS\Core\Resource\StorageRepository
     */
    private $storageRepository;


    /**
     * @var \KURZ\KurzFlowplayer\Connection\ApiConnection
     */
    protected $apiConnection;

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
     * @Inject
     */
    protected $workspaceRepository = null;

    /**
     * playerRepository
     *
     * @var \KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository
     * @Inject
     */
    protected $playerRepository = null;


    /**
     * AdministrationController constructor.
     * @param StorageRepository $storageRepository
     */
    public function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }


    /**
     * action overview
     *
     * @return void
     */
    public function overviewAction(){

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
        }else{
            $this->storageConfiguration = $this->storage->getConfiguration();
            if ($this->request->hasArgument('siteId')) {
                $siteId = $this->request->getArgument('siteId');
                $res = $this->workspaceRepository->findOneBySiteId($siteId);

                try {
                    $apiKey = $res->getApiKey();
                    $apiBaseURL = $this->storageConfiguration['apiBaseURL'];
                    ///Endpoint for listing a Video
                    $path = "videos";
                    $targetUrl = trim($apiBaseURL, '/') ."/". trim($path, '/');
                    $additionalOptions = [
                        'headers' => [
                            'x-flowplayer-api-key' => $apiKey
                        ],
                    ];

                    /** @var ApiConnection */
                    $this->apiConnection = GeneralUtility::makeInstance(ApiConnection::class);
                    $res = $this->apiConnection->handle($targetUrl , "GET", $additionalOptions);

                    if ($res['total_count'] > 0) {
                        $this->view->assign('videos', $res);
                    } else {
                        $this->addFlashMessage(
                            'Please check your proxy configuration options for this TYPO3 instanz.',
                            '',
                            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
                            TRUE
                        );
                    }
                } catch (Exception $exception) {
                    debug($exception->getMessage());
                }

            }

        }
        $players = $this->playerRepository->findAll();

        $this->view->assign('workspaces', $workspaces);
        $this->view->assign('siteId', $siteId);
        $this->view->assign('players', $players);

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
                $this->view->assign('workspace', $res);
                try {
                    $apiKey = $res->getApiKey();
                } catch (Exception $exception) {
                    //$exception->getMessage();
                }

            }

            $apiBaseURL = $this->storageConfiguration['apiBaseURL'];
            ///Endpoint for listing a Video
            $path = "videos";
            $targetUrl = trim($apiBaseURL, '/') ."/". trim($path, '/');
            $additionalOptions = [
                'headers' => [
                    'x-flowplayer-api-key' => $apiKey
                ],
            ];

            /** @var ApiConnection */
            $this->apiConnection = GeneralUtility::makeInstance(ApiConnection::class);
            $res = $this->apiConnection->handle($targetUrl , "GET", $additionalOptions);

            if ($res['total_count'] > 0) {
                $videosTemp = [];
                foreach ($res['assets'] as $video) {

                    if ($video[JsonParameters::ID]) {

                        if ($this->request->hasArgument('method') && $this->request->hasArgument('asset')) {

                            $method = $this->request->getArgument('method');
                            $assetid = $this->request->getArgument('asset');

                            switch ($method) {
                                case 'update':
                                    if ($video[JsonParameters::ID] === $assetid) {
                                        $this->replaceFile($video);
                                    }
                                    break;
                                case 'import':
                                    if ($video[JsonParameters::ID] === $assetid) {
                                        $this->createNewFile($video);
                                    }
                                    break;
                            }
                        }
                        $video['isInFalExist'] = $this->isFileExist($video);
                        $videosTemp['assets'][] = $video;
                    }
                }

                $this->view->assign('videos', $videosTemp);


            } else {
                $this->addFlashMessage(
                    'Please check your proxy configuration options for this TYPO3 instanz.',
                    '',
                    \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
                    TRUE
                );
            }

            $this->view->assign('workspaces', $workspaces);
            $this->view->assign('siteId', $siteId);


        }

    }

    /**
     *
     */
    public function importAction()
    {


    }

    /**
     *
     */
    public function updateAction()
    {


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

        $ordnername = $this->storage->sanitizeFileName($video[JsonParameters::WORKSPACE]['name']);
        try {
            /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
            $folder = $this->storage->getFolder("/" . $ordnername . "/");
        } catch (FolderDoesNotExistException $exception) {
            /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
            $folder = $this->storage->createFolder("/" . $ordnername . "/");
        }
        $name = $this->storage->sanitizeFileName($video['name']);
        $file = $folder->createFile($video[JsonParameters::ID] . '.flowplayer');
        $properties = $file->getProperties();
        $properties['type'] = File::FILETYPE_VIDEO;
        $properties['name'] = $name . '.flowplayer';
        $file->updateProperties($properties);
        $file->setContents($video[JsonParameters::WORKSPACE]['id']);
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

        $fileMetadata = array(
            'title' => $video[JsonParameters::NAME],
            'description' => $video[JsonParameters::DESCRIPTION],
            'keywords' => $video[JsonParameters::TAGS],
            //'categories' => $video->{JsonParameters::CATEGORY}->name,
            'duration' => $video[JsonParameters::DURATION]
            //'width' =>,
            //'height' =>

        );

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
        $metadata = $objectManager->get('TYPO3\CMS\Core\Resource\Index\MetaDataRepository');
        // Update metadata of FAL record
        if (!empty($fileMetadata)) {
            $metadata->update($fileObject->getUid(), $fileMetadata);
/*            $fileObject->_updateMetaDataProperties($fileMetadata);
            $metaDataRepository = MetaDataRepository::getInstance();
            $metaDataRepository->update($fileObject->getUid(), $fileMetadata);*/
        }
    }

    /**
     * Runs the metadata extraction for a given file.
     *
     * @param array $fileProperties
     * @param File $fileObject
     * @return void
     * @see Indexer::runMetaDataExtraction
     */
    protected function updateFileProperties(File $fileObject, $fileProperties = array())
    {
        $fileObject->updateProperties($fileProperties);
        $fileIndexRepository = FileIndexRepository::getInstance();
        $fileIndexRepository->update($fileObject);
    }

    /**
     * @param $video
     * @return bool
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    protected function isFileExist($video)
    {

        $ordnername = $this->storage->sanitizeFileName($video[JsonParameters::WORKSPACE]['name']);
        try {
            /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
            $folder = $this->storage->getFolder("/" . $ordnername);
            if ($folder->hasFile($video[JsonParameters::ID] . '.flowplayer')) {
                return true;
            }
        } catch (FileDoesNotExistException | FolderDoesNotExistException $e) {
            debug($e->getMessage());
        }
        return false;

    }

    /**
     * @param $video
     * @return bool
     * @throws \TYPO3\CMS\Core\Resource\Exception\ExistingTargetFileNameException
     * @throws \TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException
     */
    private function replaceFile($video)
    {
        $ordnername = $this->storage->sanitizeFileName($video[JsonParameters::WORKSPACE]['name']);


        try {
            /** @var \TYPO3\CMS\Core\Resource\Folder $folder */
            $folder = $this->storage->getFolder("/" . $ordnername . "/");
            $file = $this->storage->getFile($folder->getIdentifier() . $video[JsonParameters::ID] . '.flowplayer');
            //$folder->getStorage()->replaceFile($file, $folder->getIdentifier() . $video->{JsonParameters::ID} . '.flowplayer');
            return true;
        } catch (FileDoesNotExistException | FolderDoesNotExistException $e) {
            debug($e->getMessage());
        }
        return false;
    }


}
