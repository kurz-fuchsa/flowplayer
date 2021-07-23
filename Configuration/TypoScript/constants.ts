
module.tx_kurzflowplayer_m2 {
    view {
        # cat=module.tx_kurzflowplayer_m2/file; type=string; label=Path to template root (BE)
        templateRootPath = EXT:kurz_flowplayer/Resources/Private/Backend/Templates/
        # cat=module.tx_kurzflowplayer_m2/file; type=string; label=Path to template partials (BE)
        partialRootPath = EXT:kurz_flowplayer/Resources/Private/Backend/Partials/
        # cat=module.tx_kurzflowplayer_m2/file; type=string; label=Path to template layouts (BE)
        layoutRootPath = EXT:kurz_flowplayer/Resources/Private/Backend/Layouts/
    }
    persistence {
        # cat=module.tx_kurzflowplayer_m2//a; type=string; label=Default storage PID
        storagePid =
    }
}
