<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\numeric;

use NumberFormatter;
use Override;

/**
 * Class FrmtrInteger
 */
class FrmtrInteger extends FrmtrNumber
{
    /**
     * @function createDefaultFormatter
     * @return NumberFormatter
     */
    #[Override]
    protected function createFormatter(): NumberFormatter
    {
        $formatter = parent::createFormatter();
        $formatter->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        return $formatter;
    }
}
