<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\date_time;

use IntlDateFormatter;

/**
 * Class FrmtrDateShort
 */
class FrmtrDateShort extends FrmtrDateTimeAbstract
{
    protected function createFormatter(): IntlDateFormatter
    {
        $dateType = IntlDateFormatter::SHORT;
        $timeType = IntlDateFormatter::NONE;

        return new IntlDateFormatter(
            (string)$this->getLocale(),
            $dateType,
            $timeType,
            $this->getTimeZone()->getName(),
            $this->getCalendarType()
        );
    }
}
