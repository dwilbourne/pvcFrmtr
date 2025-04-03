<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\frmtr\date_time;

use DateTimeImmutable;
use DateTimeZone;
use Exception;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\interfaces\intl\LocaleInterface;

/**
 * Class FrmtrDateTimeTest
 */
abstract class FrmtrDateTimeTest extends TestCase
{
    /**
     * ICU library now appears to be using narrow non breaking space in certain parts of its formatting output.
     */
    protected string $NNBSP = "\u{202F}";

    protected LocaleInterface $locale;

    protected DateTimeZone $timeZone;

    protected string $dateString;

    public function setUp(): void
    {
        $this->locale = $this->createMock(LocaleInterface::class);
        $this->timeZone = new DateTimeZone('America/New_York');
        $this->dateString = '2002-05-20T14:44';
    }

    /**
     * testFormat
     * @param string $localeString
     * @param string $timeZoneString
     * @param string $expectedResult
     * @param string $comment
     * @throws Exception
     *
     * @dataProvider dataProvider
     *
     * @covers       \pvc\frmtr\date_time\FrmtrDateShort::createFormatter
     * @covers       \pvc\frmtr\date_time\FrmtrDateShort::format
     *
     * @covers       \pvc\frmtr\date_time\FrmtrDateShortTimeShort::createFormatter
     * @covers       \pvc\frmtr\date_time\FrmtrDateShortTimeShort::format
     *
     * @covers       \pvc\frmtr\date_time\FrmtrTimeShort::createFormatter
     * @covers       \pvc\frmtr\date_time\FrmtrTimeShort::format
     */
    public function testFormat(
        string $localeString,
        string $timeZoneString,
        string $expectedResult,
        string $comment
    ): void {
        $this->locale->method('__toString')->willReturn($localeString);

        $tz = new DateTimeZone($timeZoneString);
        $dt = new DateTimeImmutable($this->dateString, $tz);
        $timestamp = $dt->getTimestamp();

        $frmtr = $this->makeFormatter();
        $frmtr->setLocale($this->locale);
        $frmtr->setTimeZone($tz);

        self::assertEquals($expectedResult, $frmtr->format($timestamp), $comment);
    }

    abstract public function makeFormatter(): FrmtrDateTimeAbstract;
}
