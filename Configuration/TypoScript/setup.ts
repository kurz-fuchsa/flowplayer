
# Module configuration
module.tx_kurzflowplayer_tools_kurzflowplayerm2 {
    persistence {
        storagePid = {$module.tx_kurzflowplayer_m2.persistence.storagePid}
    }
    view {
        templateRootPaths.0 = EXT:{extension.extensionKey}/Resources/Private/Backend/Templates/
        templateRootPaths.1 = {$module.tx_kurzflowplayer_m2.view.templateRootPath}
        partialRootPaths.0 = EXT:kurz_flowplayer/Resources/Private/Backend/Partials/
        partialRootPaths.1 = {$module.tx_kurzflowplayer_m2.view.partialRootPath}
        layoutRootPaths.0 = EXT:kurz_flowplayer/Resources/Private/Backend/Layouts/
        layoutRootPaths.1 = {$module.tx_kurzflowplayer_m2.view.layoutRootPath}
    }
}
