<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\date_time;

use IntlDateFormatter;

/**
 * Class FrmtrTimeShort
 */
class FrmtrTimeShort extends FrmtrDateTimeAbstract
{
    protected function createFormatter(): IntlDateFormatter
    {
        $dateType = IntlDateFormatter::NONE;
        $timeType = IntlDateFormatter::SHORT;

        return new IntlDateFormatter(
            (string)$this->getLocale(),
            $dateType,
            $timeType,
            $this->getTimeZone()->getName(),
            $this->getCalendarType()
        );
    }
}
