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
use pvc\frmtr\date_time\FrmtrDateShort;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\intl\TimeZoneInterface;

/**
 * Class FrmtrDateTimeTest
 */
abstract class FrmtrDateTimeTest extends TestCase
{
    protected LocaleInterface $locale;

    protected TimeZoneInterface $timeZone;

    protected string $dateString;

    public function setUp(): void
    {
        $this->locale = $this->createMock(LocaleInterface::class);
        $this->timeZone = $this->createMock(TimeZoneInterface::class);
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
        $this->timeZone->method('__toString')->willReturn($timeZoneString);

        $tz = new DateTimeZone($timeZoneString);
        $dt = new DateTimeImmutable($this->dateString, $tz);
        $timestamp = $dt->getTimestamp();

        $frmtr = $this->makeFormatter();
        $frmtr->setLocale($this->locale);
        $frmtr->setTimeZone($this->timeZone);

        self::assertEquals($expectedResult, $frmtr->format($timestamp), $comment);
    }

    abstract public function makeFormatter(): FrmtrDateTimeAbstract;
}
