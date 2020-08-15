<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use pvc\intl\DateTimePattern;

/**
 * Class FrmtrDateShort
 */
class FrmtrDateShort extends FrmtrDateTimeAbstract
{
    public function getPatternFromLocale(): string
    {
        return DateTimePattern::getPatternDateShort($this->getLocale());
    }
}
