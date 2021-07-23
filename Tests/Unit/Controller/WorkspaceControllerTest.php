<?php
namespace KURZ\KurzFlowplayer\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Alexander Fuchs <alexander.fuchs@kurz.de>
 */
class WorkspaceControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \KURZ\KurzFlowplayer\Controller\WorkspaceController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\KURZ\KurzFlowplayer\Controller\WorkspaceController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllWorkspacesFromRepositoryAndAssignsThemToView()
    {

        $allWorkspaces = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $workspaceRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $workspaceRepository->expects(self::once())->method('findAll')->will(self::returnValue($allWorkspaces));
        $this->inject($this->subject, 'workspaceRepository', $workspaceRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('workspaces', $allWorkspaces);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenWorkspaceToView()
    {
        $workspace = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('workspace', $workspace);

        $this->subject->showAction($workspace);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenWorkspaceToWorkspaceRepository()
    {
        $workspace = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();

        $workspaceRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $workspaceRepository->expects(self::once())->method('add')->with($workspace);
        $this->inject($this->subject, 'workspaceRepository', $workspaceRepository);

        $this->subject->createAction($workspace);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenWorkspaceToView()
    {
        $workspace = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('workspace', $workspace);

        $this->subject->editAction($workspace);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenWorkspaceInWorkspaceRepository()
    {
        $workspace = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();

        $workspaceRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $workspaceRepository->expects(self::once())->method('update')->with($workspace);
        $this->inject($this->subject, 'workspaceRepository', $workspaceRepository);

        $this->subject->updateAction($workspace);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenWorkspaceFromWorkspaceRepository()
    {
        $workspace = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();

        $workspaceRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\WorkspaceRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $workspaceRepository->expects(self::once())->method('remove')->with($workspace);
        $this->inject($this->subject, 'workspaceRepository', $workspaceRepository);

        $this->subject->deleteAction($workspace);
    }
}
