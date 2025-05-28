<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\frmtr\date_time;

use DateTimeImmutable;
use DateTimeZone;
use Exception;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\date_time\FrmtrDateShort;
use pvc\frmtr\date_time\FrmtrDateShortTimeShort;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\frmtr\date_time\FrmtrTimeShort;
use pvc\interfaces\intl\LocaleInterface;

/**
 * Class FrmtrDateTimeTest
 */

abstract class FrmtrDateTimeTest extends TestCase
{
    /**
     * ICU library now appears to be using narrow non-breaking space in certain parts of its formatting output.
     */
    protected const NNBSP = "\u{202F}";

    protected MockObject $locale;

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
     */

    #[CoversMethod(FrmtrDateShort::class, 'createFormatter')]
    #[CoversMethod(FrmtrDateShort::class, 'format')]
    #[CoversMethod(FrmtrDateShortTimeShort::class, 'createFormatter')]
    #[CoversMethod(FrmtrDateShortTimeShort::class, 'format')]
    #[CoversMethod(FrmtrTimeShort::class, 'createFormatter')]
    #[CoversMethod(FrmtrTimeShort::class, 'format')]
    #[DataProvider('dataProvider')]
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
