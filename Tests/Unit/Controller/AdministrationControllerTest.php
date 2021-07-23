<?php
namespace KURZ\KurzFlowplayer\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Alexander Fuchs <alexander.fuchs@kurz.de>
 */
class AdministrationControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \KURZ\KurzFlowplayer\Controller\AdministrationController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\KURZ\KurzFlowplayer\Controller\AdministrationController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

}
