<?php


namespace KURZ\KurzFlowplayer\DataProcessing;


use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class FileFilterProcessor implements DataProcessorInterface
{
    /**
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
        $confVars = $GLOBALS['TYPO3_CONF_VARS'];
        $predefinedLists = [
            'image' => isset($confVars['GFX']['imagefile_ext']) ? $confVars['GFX']['imagefile_ext'] : 'gif,jpg,jpeg,tif,tiff,bmp,pcx,tga,png,pdf,ai,svg',
            'media' => isset($confVars['SYS']['mediafile_ext']) ? $confVars['SYS']['mediafile_ext'] : 'gif,jpg,jpeg,bmp,png,pdf,svg,ai,mp3,wav,mp4,ogg,flac,opus,webm,youtube,vimeo',
            'text' => isset($confVars['SYS']['textfile_ext']) ? $confVars['SYS']['textfile_ext'] : 'txt,ts,typoscript,html,htm,css,tmpl,js,sql,xml,csv,xlf,yaml,yml',
        ];
        $predefinedList = $cObj->stdWrapValue('predefinedList', $processorConfiguration, 'image');
        $allowedFileExtensions = array_key_exists($predefinedList, $predefinedLists) ? $predefinedLists[$predefinedList] : '';
        $allowedFileExtensions = GeneralUtility::trimExplode(',', $cObj->stdWrapValue('allowedFileExtensions', $processorConfiguration, $allowedFileExtensions));
        if (empty($allowedFileExtensions)) {
            return $processedData;
        }

        $variableName = $cObj->stdWrapValue('variableName', $processorConfiguration, 'files');
        if (!isset($processedData[$variableName]) || empty($processedData[$variableName])) {
            return $processedData;
        }

        foreach ($processedData[$variableName] as $key => $value) {
            if (is_object($value)
                && in_array(get_class($value), [FileReference::class, File::class], true)
                && !in_array($value->getExtension(), $allowedFileExtensions, true)
            ) {
                unset($processedData[$variableName][$key]);
            }
        }

        return $processedData;
    }
}
