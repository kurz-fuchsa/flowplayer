<?php
namespace KURZ\KurzFlowplayer\Controller;

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
 * WorkspaceController
 */
class WorkspaceController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * workspaceRepository
     *
     * @var \KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository
     * @inject
     */
    protected $workspaceRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $workspaces = $this->workspaceRepository->findAll();
        $this->view->assign('workspaces', $workspaces);
    }

    /**
     * action show
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace
     * @return void
     */
    public function showAction(\KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace)
    {
        $this->view->assign('workspace', $workspace);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Workspace $newWorkspace
     * @return void
     */
    public function createAction(\KURZ\KurzFlowplayer\Domain\Model\Workspace $newWorkspace)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->workspaceRepository->add($newWorkspace);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace
     * @ignorevalidation $workspace
     * @return void
     */
    public function editAction(\KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace)
    {
        $this->view->assign('workspace', $workspace);
    }

    /**
     * action update
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace
     * @return void
     */
    public function updateAction(\KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->workspaceRepository->update($workspace);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace
     * @return void
     */
    public function deleteAction(\KURZ\KurzFlowplayer\Domain\Model\Workspace $workspace)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->workspaceRepository->remove($workspace);
        $this->redirect('list');
    }
}
