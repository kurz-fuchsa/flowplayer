<?php
namespace KURZ\KurzFlowplayer\Domain\Model;

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
 * Player
 */
class Player extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * playerId
     *
     * @var string
     */
    protected $playerId = '';

    /**
     * playerName
     *
     * @var string
     */
    protected $playerName = '';

    /**
     * workspace
     *
     * @var \KURZ\KurzFlowplayer\Domain\Model\Workspace
     */
    protected $workspace = null;

    /**
     * Returns the playerId
     *
     * @return string $playerId
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * Sets the playerId
     *
     * @param string $playerId
     * @return void
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;
    }

    /**
     * Returns the playerName
     *
     * @return string $playerName
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * Sets the playerName
     *
     * @param string $playerName
     * @return void
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;
    }

    /**
     * Returns the workspace
     *
     * @return \KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * Sets the workspace
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace
     * @return void
     */
    public function setWorkspace(\KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace)
    {
        $this->workspace = $workspace;
    }
}
