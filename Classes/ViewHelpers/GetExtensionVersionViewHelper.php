<?php

namespace KURZ\KurzFlowplayer\ViewHelpers;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetExtensionVersionViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        $this->registerArgument('extensionKey', 'string', 'extension key', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return ExtensionManagementUtility::getExtensionVersion($arguments['extensionKey']);
    }
}
