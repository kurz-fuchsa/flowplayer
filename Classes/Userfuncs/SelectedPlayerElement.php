<?php
declare(strict_types = 1);
namespace KURZ\KurzFlowplayer\Userfuncs;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SelectedPlayerElement extends AbstractFormElement
{

    public function render()
    {
        $parameterArray = $this->data['parameterArray'];
        $databaseRow = $this->data['databaseRow'];
        /** @var $logger \TYPO3\CMS\Core\Log\Logger */
        $this->logger = GeneralUtility::makeInstance(LogManager::class)
            ->getLogger(__CLASS__);
        //$this->logger->info("databaseRow", array($databaseRow["uid_local"][0]["row"]));
        if($databaseRow["uid_local"][0]["row"]["extension"] == 'flowplayer') {
            $players = $this->getPlayers();
            $html = [];
            if (count($players) > 0) {
                $html[] = '<select name="' . $parameterArray['itemFormElName'] . '" class="form-control form-control-adapt">';
                $html[] = '<option value="0">--Please select the player--</option>';
                foreach ($players as $player) {
                    $parameterArray['itemFormElValue'] == $player['player_id'] ? $selected = 'selected="selected"' : $selected = '';
                    $html[] = '<option ' . $selected . ' value="' . htmlspecialchars($player['player_id']) . '">' . $player['player_name'] . '-' . htmlspecialchars($player['player_id']) . '</option>';
                }
                $html[] .= ' </select>';
                $resultArray['html'] = implode(LF, $html);

            }
       }
        return $resultArray;
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
