
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

######################
#### CTYPE: MEDIA ####
######################

tt_content.media >
tt_content.media =< lib.contentElement
tt_content.media {

    ################
    ### TEMPLATE ###
    ################
    templateName = Media

    ##########################
    ### DATA PREPROCESSING ###
    ##########################
    dataProcessing {
        10 = TYPO3\CMS\Frontend\DataProcessing\FilesProcessor
        10 {
            references.fieldName = assets
            folders.field = file_folder
            sorting.field = filelink_sorting
        }
        20 = KURZ\KurzFlowplayer\DataProcessing\FileFilterProcessor
        20 {
            allowedFileExtensions = youtube, vimeo, flowplayer, mp4
        }
    }

}

