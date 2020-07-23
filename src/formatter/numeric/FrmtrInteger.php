<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\numeric;

use Locale;
use NumberFormatter;

/**
 * Class FrmtrInteger
 */
class FrmtrInteger extends FrmtrNumberFormatter
{

    /**
     * FrmtrInteger constructor.
     */
    public function __construct()
    {
        $this->setFormatter($this->createDefaultFormatter());
    }

    /**
     * @function createDefaultFormatter
     * @return NumberFormatter
     */
    protected function createDefaultFormatter(): NumberFormatter
    {
        $locale = Locale::getDefault();
        $frmtr = new NumberFormatter($locale, NumberFormatter::DECIMAL);
        $frmtr->setAttribute(NumberFormatter::GROUPING_USED, 1);
        $frmtr->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
        return $frmtr;
    }

    /**
     * @function formatValue
     * @param int $x
     * @return string
     */
    public function format(int $x): string
    {
        return $this->frmtr->format($x);
    }
}
