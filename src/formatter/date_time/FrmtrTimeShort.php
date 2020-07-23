<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use pvc\intl\DateTimePattern;

/**
 * Class FrmtrTimeShort
 */
class FrmtrTimeShort extends FrmtrTimeAbstract
{

    /**
     * @function getPatternFromLocale
     * @return string
     */
    public function getPatternFromLocale(): string
    {
        return DateTimePattern::getPatternTimeShort($this->getLocale());
    }
}
