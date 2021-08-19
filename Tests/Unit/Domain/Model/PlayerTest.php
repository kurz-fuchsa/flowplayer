<?php
namespace KURZ\KurzFlowplayer\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Alexander Fuchs <alexander.fuchs@kurz.de>
 */
class PlayerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \KURZ\KurzFlowplayer\Domain\Model\Player
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \KURZ\KurzFlowplayer\Domain\Model\Player();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getPlayerIdReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPlayerId()
        );
    }

    /**
     * @test
     */
    public function setPlayerIdForStringSetsPlayerId()
    {
        $this->subject->setPlayerId('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'playerId',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPlayerNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPlayerName()
        );
    }

    /**
     * @test
     */
    public function setPlayerNameForStringSetsPlayerName()
    {
        $this->subject->setPlayerName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'playerName',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getWorkspaceReturnsInitialValueForWorkspace()
    {
        self::assertEquals(
            null,
            $this->subject->getWorkspace()
        );
    }

    /**
     * @test
     */
    public function setWorkspaceForWorkspaceSetsWorkspace()
    {
        $workspaceFixture = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();
        $this->subject->setWorkspace($workspaceFixture);

        self::assertAttributeEquals(
            $workspaceFixture,
            'workspace',
            $this->subject
        );
    }
}
