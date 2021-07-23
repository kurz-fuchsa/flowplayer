<?php
namespace KURZ\KurzFlowplayer\Tests\Unit\Domain\Model;

/**
 * Test case.
 *
 * @author Alexander Fuchs <alexander.fuchs@kurz.de>
 */
class WorkspaceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \KURZ\KurzFlowplayer\Domain\Model\Workspace
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \KURZ\KurzFlowplayer\Domain\Model\Workspace();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getSiteIDReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getSiteID()
        );
    }

    /**
     * @test
     */
    public function setSiteIDForStringSetsSiteID()
    {
        $this->subject->setSiteID('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'siteID',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getApiKeyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getApiKey()
        );
    }

    /**
     * @test
     */
    public function setApiKeyForStringSetsApiKey()
    {
        $this->subject->setApiKey('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'apiKey',
            $this->subject
        );
    }
}
