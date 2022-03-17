<?php

namespace KURZ\KurzFlowplayer\Connection;

use Psr\Http\Message\RequestFactoryInterface;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 */
class ApiConnection
{

    /**
     * @var
     */
    private $authToken;
    /**
     * @var
     */
    const HTTP_CODE_OK = 200;
    /**
     * @var
     */
    private $result;
    /**
     * @var string
     */
    const CONTENT_TYPE_JSON = "application/json";

    /**
     * @var array
     */
    private $httpHeader = [];


    /** @var RequestFactoryInterface */
    private $requestFactory;

    // Initiate the Request Factory, which allows to run multiple requests (prefer dependency injection)
    public function __construct()
    {
        $this->requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
    }

    /**
     * @return array|bool Associative array on success, false otherwise
     */
    public function handle(string $url, string $method = 'GET', array $additionalOptions = [])
    {

        if (!array_key_exists('headers', $additionalOptions)) $additionalOptions['headers'] = [];
        if (!array_key_exists('Content-Type', $additionalOptions['headers'])) $additionalOptions['headers']['Content-Type'] = self::CONTENT_TYPE_JSON;

        if (!empty($this->authToken)) $additionalOptions['headers']['Authorization'] = 'Basic ' . $this->authToken;

        // Return a PSR-7 compliant response object
        $response = $this->requestFactory->request($url, $method, $additionalOptions);


        // Get the content as a string on a successful request
        if ($response->getStatusCode() == self::HTTP_CODE_OK) {
            return json_decode($response->getBody(), true);
        }

        return false;
    }

    public function handleImage(string $url, string $method = 'GET',  $pfad)
    {

        // Return a PSR-7 compliant response object
        $response = $this->requestFactory->request($url, $method, ['save_to' => $pfad]);
        // Get the content as a string on a successful request
        if ($response->getStatusCode() === self::HTTP_CODE_OK) {
            if (strpos($response->getHeaderLine('Content-Type'), 'text/html') === 0) {
                $content = $response->getBody()->getContents();
            }
        }
    }


}
