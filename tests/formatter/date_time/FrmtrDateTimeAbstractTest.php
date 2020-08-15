<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use Carbon\Carbon;
use Mockery;
use pvc\formatter\date_time\FrmtrDateTimeAbstract;
use PHPUnit\Framework\TestCase;
use pvc\intl\Locale;
use pvc\intl\TimeZone;

class FrmtrDateTimeAbstractTest extends TestCase
{
    /** @phpstan-ignore-next-line */
    protected $frmtr;

    public function setUp(): void
    {
        $this->frmtr = Mockery::mock(FrmtrDateTimeAbstract::class)->makePartial();
    }

    public function testSetGetFormat() : void
    {
        $format = "foo";
        $this->frmtr->setFormat($format);
        self::assertEquals($format, $this->frmtr->getFormat());
    }

    public function testSetGetLocale() : void
    {
        $locale = new locale('de_DE');
        $this->frmtr->setLocale($locale);
        self::assertEquals($locale, $this->frmtr->getLocale());
    }

    public function testConstruct() : void
    {
        $locale = Mockery::mock(Locale::class);
        $this->frmtr->__construct($locale);
        self::assertEquals($locale, $this->frmtr->getLocale());
    }

    public function testConstructDefaults() : void
    {
        $this->frmtr->__construct();
        self::assertInstanceOf(Locale::class, $this->frmtr->getLocale());
    }

    public function testFormatValueImplicitly() : void
    {
        $carbon = new Carbon('2015-08-13');
        $this->frmtr->shouldReceive('getPatternFromLocale')->withNoArgs()->andReturn('d/m/Y');
        $expectedResult = '13/08/2015';
        self::assertEquals($expectedResult, $this->frmtr->format($carbon));
    }

}
