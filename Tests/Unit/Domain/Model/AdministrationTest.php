<?php
namespace KURZ\KurzFlowplayer\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Alexander Fuchs <alexander.fuchs@kurz.de>
 */
class AdministrationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \KURZ\KurzFlowplayer\Domain\Model\Administration
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \KURZ\KurzFlowplayer\Domain\Model\Administration();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function dummyTestToNotLeaveThisFileEmpty()
    {
        self::markTestIncomplete();
    }
}
