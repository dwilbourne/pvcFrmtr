<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\date_time;

use DateTimeZone;
use IntlDateFormatter;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\frmtr\err\InvalidIntlCalendarTypeException;

#[CoversMethod(FrmtrDateTimeAbstract::class, 'getTimeZone')]
#[CoversMethod(FrmtrDateTimeAbstract::class, 'setTimeZone')]
#[CoversMethod(FrmtrDateTimeAbstract::class, 'getCalendarType')]
#[CoversMethod(FrmtrDateTimeAbstract::class, 'setCalendarType')]
class FrmtrDateTimeAbstractTest extends TestCase
{
    protected MockObject $formatter;

    public function setUp(): void
    {
        $this->formatter = $this->getMockForAbstractClass(FrmtrDateTimeAbstract::class);
    }

    /**
     * testDefaultTimezone
     */
    public function testDefaultTimezone(): void
    {
        self::assertInstanceOf(DateTimeZone::class, $this->formatter->getTimeZone());
    }

    /**
     * testSetGetTimeZone
     */
    public function testSetGetTimeZone(): void
    {
        $tz = new DateTimeZone('America/New_York');
        $this->formatter->setTimeZone($tz);
        self::assertEquals($tz, $this->formatter->getTimeZone());
    }

    /**
     * testDefaultCalendar
     */
    public function testDefaultCalendar(): void
    {
        self::assertIsInt($this->formatter->getCalendarType());
    }

    /**
     * testSetCalendarThrowsExceptionWithBadCalendarType
     * @throws InvalidIntlCalendarTypeException
     */
    public function testSetCalendarThrowsExceptionWithBadCalendarType(): void
    {
        self::expectException(InvalidIntlCalendarTypeException::class);
        $this->formatter->setCalendarType(9);
    }

    /**
     * testSetGetCalendar
     */
    public function testSetGetCalendar(): void
    {
        $calendarType = IntlDateFormatter::TRADITIONAL;
        $this->formatter->setCalendarType($calendarType);
        self::assertEquals($calendarType, $this->formatter->getCalendarType());
    }
}
