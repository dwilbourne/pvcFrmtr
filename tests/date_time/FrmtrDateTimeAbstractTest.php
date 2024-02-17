<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\date_time;

use IntlCalendar;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\interfaces\intl\TimeZoneInterface;

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
        self::assertNull($this->formatter->getTimeZone());
    }

    /**
     * testSetGetTimeZone
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::setTimeZone
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getTimeZone
     */
    public function testSetGetTimeZone(): void
    {
        $tz = $this->createMock(TimeZoneInterface::class);
        $this->formatter->setTimeZone($tz);
        self::assertEquals($tz, $this->formatter->getTimeZone());
    }

    /**
     * testDefaultCalendar
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getCalendar
     */
    public function testDefaultCalendar(): void
    {
        self::assertNull($this->formatter->getCalendar());
    }

    /**
     * testSetGetCalendar
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::setCalendar
     * @covers \pvc\frmtr\date_time\FrmtrDateTimeAbstract::getCalendar
     */
    public function testSetGetCalendar(): void
    {
        $calendar = $this->createMock(IntlCalendar::class);
        $this->formatter->setCalendar($calendar);
        self::assertEquals($calendar, $this->formatter->getCalendar());
    }
}
