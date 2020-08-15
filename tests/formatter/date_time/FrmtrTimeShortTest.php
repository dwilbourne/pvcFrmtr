<?php
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace tests\formatter\date_time;

use Carbon\Carbon;
use pvc\formatter\date_time\FrmtrTimeShort;
use PHPUnit\Framework\TestCase;
use pvc\intl\Locale;
use pvc\intl\UtcOffset;

class FrmtrTimeShortTest extends TestCase
{

    /**
     * @function testFormat
     * @param string $locale
     * @param string $timeZone
     * @param string $expectedResult
     * @throws \pvc\intl\err\InvalidLocaleException
     * @throws \pvc\intl\err\UtcOffsetException
     * @dataProvider  dataProvider
     */
    public function testFormat(string $locale, string $timeZone, string $expectedResult) : void
    {
        $loc = new Locale($locale);
        $frmtr = new FrmtrTimeShort($loc);
        $time = Carbon::createFromTime(13, 32);
        self::assertEquals($expectedResult, $frmtr->format($time));
    }

    public function dataProvider() : array
    {
        return [
            'test US' => ['en_US', 'America/New_York', '1:32 pm'],
            'test FR' => ['fr_FR', 'Europe/Paris', '13:32'],
            // notice that the locale specifies a different separator for Canada
            'test CA' => ['en_CA', 'America/Toronto', '1:32 pm'],
        ];
    }

    public function testFormatChange() : void
    {
        $locale = new locale('en_US');
        $time = Carbon::createFromTime(13, 32);

        $frmtr = new FrmtrTimeShort($locale);
        $frmtr->setFormat('H:i:s');
        $expectedResult = '13:32:00';
        self::assertEquals($expectedResult, $frmtr->format($time));
    }
}
