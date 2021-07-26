<?php
namespace KURZ\KurzFlowplayer\Lib\HTTP;

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
 * HttpRequest
 * The extension php_curl must be enabled in php.ini
 */
class HttpRequest {

    /**
     * @var string
     */
    private $url;
    /**
     * @var
     */
    private $ch;
    /**
     * @var
     */
    private $httpCode;
    /**
     * @var
     */
    private $result;
    /**
     * @var string
     */
    private $CONTENT_TYPE_JSON = "application/json";
    /**
     * @var string
     */
    private $CONTENT_TYPE_OCTET_STREAM = "application/octet-stream";
    /**
     * @var string
     */
    private $USER_AGENT = "PHP CIP.lib";
    /**
     * @var array
     */
    private $httpHeader = [];

    /**
     *
     */
    const PROXY_URL = "proxy.lkis.local";
    /**
     *
     */
    const PROXY_PORT = "8080";

    /**
     * Create a new instance
     * @param string $url The base URL to the CIP server
     * @param array $httpHeader
     */
    public function __construct($url, $httpHeader) {
        $this->url = $url;
        $this->httpHeader = $httpHeader;
    }


    /**
     * @param $methode
     * @param $adresse
     * @param bool $daten
     * @return bool|string
     */
    public function executeRESTCall($methode ,  $daten = false)
    {

        ///The extension configuration stored in $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'] since v 9.0 has been deprecated
        $this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['kurz_flowplayer']);

        $curl = curl_init();
        if ($this->extConf['useProxy']) {
            curl_setopt($curl, CURLOPT_PROXY, $this->extConf['proxyUrl']);
            curl_setopt($curl, CURLOPT_PROXYPORT, $this->extConf['proxyPort']);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 50);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $methode);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->httpHeader);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $daten);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $r =curl_exec($curl);
            curl_close($curl);
        return $r;
    }

    /**
     * Gets the HTTP code from the last operation
     * @return int The HTTP code
     */
    public function getHttpCode() {
        return $this->httpCode;
    }

}
?>
