<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\date_time;

use DateTimeZone;
use IntlDateFormatter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\frmtr\err\InvalidIntlCalendarTypeException;

class FrmtrDateTimeAbstractTest extends TestCase
{
    protected FrmtrDateTimeAbstract|MockObject $formatter;

    public function setUp(): void
    {
        $this->formatter = $this->getMockForAbstractClass(FrmtrDateTimeAbstract::class);
    }

    /**
     * testDefaultTimezone
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getTimeZone
     */
    public function testDefaultTimezone(): void
    {
        self::assertInstanceOf(DateTimeZone::class, $this->formatter->getTimeZone());
    }

    /**
     * testSetGetTimeZone
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::setTimeZone
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getTimeZone
     */
    public function testSetGetTimeZone(): void
    {
        $tz = new DateTimeZone('America/New_York');
        $this->formatter->setTimeZone($tz);
        self::assertEquals($tz, $this->formatter->getTimeZone());
    }

    /**
     * testDefaultCalendar
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getCalendarType
     */
    public function testDefaultCalendar(): void
    {
        self::assertIsInt($this->formatter->getCalendarType());
    }

    /**
     * testSetCalendarThrowsExceptionWithBadCalendarType
     * @throws InvalidIntlCalendarTypeException
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::setCalendarType
     */
    public function testSetCalendarThrowsExceptionWithBadCalendarType(): void
    {
        self::expectException(InvalidIntlCalendarTypeException::class);
        $this->formatter->setCalendar(9);
    }

    /**
     * testSetGetCalendar
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::setCalendarType
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getCalendarType
     */
    public function testSetGetCalendar(): void
    {
        $calendarType = IntlDateFormatter::TRADITIONAL;
        $this->formatter->setCalendar($calendarType);
        self::assertEquals($calendarType, $this->formatter->getCalendarType());
    }
}
