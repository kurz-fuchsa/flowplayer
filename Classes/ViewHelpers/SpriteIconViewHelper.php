<?php

namespace KURZ\KurzFlowplayer\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class SpriteIconViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper
{

    /**
     * @var bool
     */
    protected $escapeOutput = false;


    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('iconName', 'string', 'iconName', true);
        $this->registerArgument('options', 'array', 'Options', false, null );
        $this->registerArgument('uid', 'int', 'uid', false, 0);
    }


    /**
     * Prints sprite icon html for $iconName key.
     *
     * @return string
     */
    public function render()
    {
        $iconName = $this->arguments['iconName'];
        $options = $this->arguments['options'] ?? array();
        $uid = $this->arguments['uid'] ?? 0;

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
