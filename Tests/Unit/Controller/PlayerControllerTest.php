<?php
namespace KURZ\KurzFlowplayer\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Alexander Fuchs <alexander.fuchs@kurz.de>
 */
class PlayerControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \KURZ\KurzFlowplayer\Controller\PlayerController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\KURZ\KurzFlowplayer\Controller\PlayerController::class)
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
    public function listActionFetchesAllPlayersFromRepositoryAndAssignsThemToView()
    {

        $allPlayers = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $playerRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $playerRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPlayers));
        $this->inject($this->subject, 'playerRepository', $playerRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('players', $allPlayers);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPlayerToView()
    {
        $player = new \KURZ\KurzFlowplayer\Domain\Model\Player();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('player', $player);

        $this->subject->showAction($player);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenPlayerToPlayerRepository()
    {
        $player = new \KURZ\KurzFlowplayer\Domain\Model\Player();

        $playerRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $playerRepository->expects(self::once())->method('add')->with($player);
        $this->inject($this->subject, 'playerRepository', $playerRepository);

        $this->subject->createAction($player);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenPlayerToView()
    {
        $player = new \KURZ\KurzFlowplayer\Domain\Model\Player();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('player', $player);

        $this->subject->editAction($player);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenPlayerInPlayerRepository()
    {
        $player = new \KURZ\KurzFlowplayer\Domain\Model\Player();

        $playerRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $playerRepository->expects(self::once())->method('update')->with($player);
        $this->inject($this->subject, 'playerRepository', $playerRepository);

        $this->subject->updateAction($player);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenPlayerFromPlayerRepository()
    {
        $player = new \KURZ\KurzFlowplayer\Domain\Model\Player();

        $playerRepository = $this->getMockBuilder(\KURZ\KurzFlowplayer\Domain\Repository\PlayerRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $playerRepository->expects(self::once())->method('remove')->with($player);
        $this->inject($this->subject, 'playerRepository', $playerRepository);

        $this->subject->deleteAction($player);
    }
}
