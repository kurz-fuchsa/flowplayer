<?php
namespace KURZ\KurzFlowplayer\Userfuncs;


use KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;


class Tca
{



    public function fieldSelectedPlayer($PA, $fObj)
    {

         if($PA["row"]["uid_local"][0]["row"]["extension"] == 'flowplayer'){
             $players = $this->getPlayers();
             if(count( $players) > 0){
                 $formField  = '<select name="' . $PA['itemFormElName'] . '" class="form-control form-control-adapt">';
                 $formField .= '<option value="0">--Please select the player--</option>';
                 foreach ($players as $player){
                     $PA['itemFormElValue'] == $player['player_id'] ? $selected= 'selected="selected"' : $selected = '';
                     $formField .= '<option ' . $selected . ' value="' . htmlspecialchars($player['player_id']) . '">' . $player['player_name'] . '-'.htmlspecialchars($player['player_id']). '</option>';
                 }
                 $formField  .= ' </select>';
                 return $formField;
             }

         }

    }

    /**
     * @return mixed
     */
    public function getPlayers()
    {

        $table = "tx_kurzflowplayer_domain_model_player";
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $query = $queryBuilder
            ->select('*')
            ->from($table);
        $result = $query->execute();
        $res = [];
        while ($row = $result->fetch(0)) {
            $res[] = $row;
        }
        return $res;
    }
}
