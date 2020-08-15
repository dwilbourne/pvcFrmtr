<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use pvc\intl\DateTimePattern;

/**
 * Class FrmtrDateTime
 */
class FrmtrDateShortTimeShort extends FrmtrDateTimeAbstract
{
    public function getPatternFromLocale(): string
    {
        return DateTimePattern::getPatternDateShortTimeShort($this->getLocale());
    }
}
