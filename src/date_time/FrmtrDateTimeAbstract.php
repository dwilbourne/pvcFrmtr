<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\date_time;

use IntlCalendar;
use IntlDateFormatter;
use pvc\frmtr\Frmtr;
use pvc\interfaces\intl\TimeZoneInterface;

/**
 * Class FrmtrDateTimeAbstract
 * @extends Frmtr<float|int>
 */
abstract class FrmtrDateTimeAbstract extends Frmtr
{
    /**
     * @var IntlCalendar
     */
    protected IntlCalendar $calendar;

    protected TimeZoneInterface $timeZone;

    /**
     * @return IntlCalendar|null
     *  null defaults to the Gregorian calendar
     */
    public function getCalendar(): ?IntlCalendar
    {
        return $this->calendar ?? null;
    }

    /**
     * @param IntlCalendar $calendar
     */
    public function setCalendar(IntlCalendar $calendar): void
    {
        $this->calendar = $calendar;
    }

    /**
     * @return TimeZoneInterface|null
     * null defaults to the timezone returned by date_default_timezone_get
     */
    public function getTimeZone(): ?TimeZoneInterface
    {
        return $this->timeZone ?? null;
    }

    /**
     * @param TimeZoneInterface $timeZone
     */
    public function setTimeZone(TimeZoneInterface $timeZone): void
    {
        $this->timeZone = $timeZone;
    }

    /**
     * createFormatter
     * @return IntlDateFormatter
     */
    abstract protected function createFormatter(): IntlDateFormatter;

    /**
     * format
     *
     * The IntlDateFormatter class can take a wide variety of arguments.  However, this class attempts to strip away as
     * much complexity as possible.  I believe dates/times should be stored as timestamps.  DateTime (and
     * DateTimeImmutable) objects suffer from the fact that the timezone used in creating the DateTime object is
     * essentially not used for any other purpose than creating a timestamp from the DateTime object.  For example
     * DateTime::diff does not respect the timezone of the DateTime object.  The array produced by localtime() is
     * just a more detailed representation the int/float produced by time().
     *
     * Because this class extends Frmtr, the argument is named 'value', but it would be better to name it 'timestamp'
     *
     * @param float|int $value
     * @return string
     */
    public function format($value): string
    {
        return ($this->createFormatter()->format($value) ?: '');
    }
}
