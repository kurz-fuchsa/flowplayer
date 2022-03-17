<?php
namespace KURZ\KurzFlowplayer\Controller;

use KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository;
use TYPO3\CMS\Extbase\Annotation\IgnoreValidation;
use TYPO3\CMS\Extbase\Annotation\Inject;

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
 * PlayerController
 */
class PlayerController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * playerRepository
     *
     * @var \KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository
     * @Inject
     */
    protected $playerRepository = null;

    /**
     * workspaceRepository
     *
     * @var \KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository
     * @Inject
     */
    protected $workspaceRepository = null;


    /**
     * AdministrationController constructor.
     * @param WorkspaceRepository $workspaceRepository
     */
    public function __construct(WorkspaceRepository $workspaceRepository)
    {
        $this->workspaceRepository = $workspaceRepository;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $players = $this->playerRepository->findAll();
        $this->view->assign('players', $players);
    }

    /**
     * action show
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Player $player
     * @return void
     */
    public function showAction(\KURZ\KurzFlowplayer\Domain\Model\Player $player)
    {
        $this->view->assign('player', $player);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $workspaces = $this->workspaceRepository->findAll();
        $this->view->assign('workspaces', $workspaces);

    }

    /**
     * action create
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Player $newPlayer
     * @return void
     */
    public function createAction(\KURZ\KurzFlowplayer\Domain\Model\Player $newPlayer)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->playerRepository->add($newPlayer);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Player $player
     * @IgnoreValidation $player
     * @return void
     */
    public function editAction(\KURZ\KurzFlowplayer\Domain\Model\Player $player)
    {
        $workspaces = $this->workspaceRepository->findAll();
        $this->view->assign('player', $player);
        $this->view->assign('workspaces', $workspaces);
    }

    /**
     * action update
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Player $player
     * @return void
     */
    public function updateAction(\KURZ\KurzFlowplayer\Domain\Model\Player $player)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->playerRepository->update($player);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Player $player
     * @return void
     */
    public function deleteAction(\KURZ\KurzFlowplayer\Domain\Model\Player $player)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->playerRepository->remove($player);
        $this->redirect('list');
    }
}
