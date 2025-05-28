<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\numeric;

use NumberFormatter;
use Override;

/**
 * Class FrmtrCurrency
 */
class FrmtrCurrency extends FrmtrNumber
{
    #[Override]
    protected function createFormatter(): NumberFormatter
    {
        $formatter = new NumberFormatter((string)$this->getLocale(), NumberFormatter::CURRENCY);
        $formatter->setAttribute(NumberFormatter::ROUNDING_MODE, $this->getRoundingMode());
        return $formatter;
    }
}
