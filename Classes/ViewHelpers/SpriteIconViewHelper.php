<?php

namespace KURZ\KurzFlowplayer\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;

class SpriteIconViewHelper extends AbstractBackendViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('iconName', 'string', 'iconName', true);
    }

    /**
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Prints sprite icon html for $iconName key.
     *
     * @return string
     */
    public function render()
    {
        $options = array();
        $uid = 0;
        $iconName = $this->arguments['iconName'];
        if (!isset($options['title']) && $uid > 0) {
            $options['title'] = 'id=' . $uid;
        }
            /** @var \TYPO3\CMS\Core\Imaging\IconFactory $iconFactory */
            $iconFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconFactory::class);
            $html = $iconFactory->getIcon($iconName, \TYPO3\CMS\Core\Imaging\Icon::SIZE_SMALL)->render();
            if (!empty($options)) {
                $attributes = '';
                foreach ($options as $key => $value) {
                    $attributes .= htmlspecialchars($key) . '="' . htmlspecialchars($value) . '" ';
                }
                $html = str_replace('<img src=', '<img ' . $attributes . 'src=', $html);
            }


        return $html;
    }
}
