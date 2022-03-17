<?php

namespace KURZ\KurzFlowplayer\ViewHelpers;

use KURZ\KurzFlowplayer\Connection\ApiConnection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FlowplayerImagesViewHelper extends AbstractViewHelper
{
    public function initializeArguments()
    {
        $this->registerArgument('identifier', 'string', 'file identifier', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {

        $identifier = explode("/", trim( $arguments['identifier'], "/"));
        $workspace = $identifier[0];
        $videoId = explode(".", $identifier[1]);
        $videoId = $videoId[0];

        $fields = '*';
        $where = "name LIKE '$workspace'";
        //$backendUtility = GeneralUtility::makeInstance(BackendUtility::class);
        $result = self::executeSelectQuery($fields, 'tx_kurzflowplayer_domain_model_workspace', $where,'name', null);

        if($result){
            $siteId = $result[0]['site_id'];
            $apiKey = $result[0]['api_key'];

            $apiBaseURL = 'https://api.flowplayer.com/platform/v3/';
            ///Endpoint for listing a Video
            $path = "videos/$videoId";
            $targetUrl = trim($apiBaseURL, '/') ."/". trim($path, '/');
            $additionalOptions = [
                'headers' => [
                    'x-flowplayer-api-key' => $apiKey
                ],
            ];

            /** @var ApiConnection */
            $apiConnection = GeneralUtility::makeInstance(ApiConnection::class);
            $res = $apiConnection->handle($targetUrl , "GET", $additionalOptions);

        }
        return (empty($res) === false) ? $res : false;
        //return $arguments['id'];
    }


    /**
     * @param string $fields
     * @param string $condition
     * @param string $order
     * @param integer $limit
     * @return array
     */
    protected static function executeSelectQuery($fields, $table, $condition, $order, $limit)
    {
        $queryBuilder = (new ConnectionPool())->getConnectionForTable($table)->createQueryBuilder();

        $queryBuilder->select($fields)->from($table)->where($condition);

        if ($order) {
            $orderings = explode(' ', $order);
            $queryBuilder->orderBy($orderings[0], $orderings[1]);
        }
        if ($limit) {
            $queryBuilder->setMaxResults((integer) $limit);
        }
        return $queryBuilder->execute()->fetchAll();
    }



}
