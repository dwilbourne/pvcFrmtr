<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\numeric;

use NumberFormatter;
use pvc\frmtr\err\InvalidRoundingModeException;
use pvc\frmtr\Frmtr;

/**
 * Class FrmtrNumber
 * @extends Frmtr<float|int>
 */
abstract class FrmtrNumber extends Frmtr
{
    /**
     * @var array<int>
     */
    protected array $validRoundingModes = [
        NumberFormatter::ROUND_CEILING,
        NumberFormatter::ROUND_FLOOR,
        NumberFormatter::ROUND_DOWN,
        NumberFormatter::ROUND_UP,
        NumberFormatter::ROUND_HALFEVEN,
        NumberFormatter::ROUND_HALFDOWN,
        NumberFormatter::ROUND_HALFUP,
    ];

    /**
     * @var int
     * I think HALFUP is more common in most people's minds instead of the actual default of ROUND_HALFEVEN
     */
    protected int $roundingMode = NumberFormatter::ROUND_HALFUP;

    protected bool $useGroupingSeparator = true;

    /**
     * @param bool $useGroupingSeparator
     */
    public function setUseGroupingSeparator(bool $useGroupingSeparator): void
    {
        $this->useGroupingSeparator = $useGroupingSeparator;
    }

    /**
     * @function format
     * @param float|int $value
     * @return string
     */
    public function format($value): string
    {
        /**
         * in theory, NumberFormatter can return false.  Convert to empty string if it fails....
         */
        return ($this->createFormatter()->format($value) ?: '');
    }

    /**
     * createFormatter
     * default type of formatter is Decimal, which covers both integers and floats.  The currency formatter
     * creates a different type.
     * @return NumberFormatter
     */
    protected function createFormatter(): NumberFormatter
    {
        $formatter = new NumberFormatter((string)$this->getLocale(), NumberFormatter::DECIMAL);
        $formatter->setAttribute(
            NumberFormatter::GROUPING_USED,
            ($this->useGroupingSeparator() !== 0 ? 1 : 0)
        );
        $formatter->setAttribute(NumberFormatter::ROUNDING_MODE, $this->getRoundingMode());
        return $formatter;
    }

    /**
     * @return int
     * return an int because that is the data type required for the GROUPING_USED attribute of NumberFormatter
     */
    public function useGroupingSeparator(): int
    {
        return ($this->useGroupingSeparator ? 1 : 0);
    }

    /**
     * getRoundingMode
     * @return int
     */
    public function getRoundingMode(): int
    {
        return $this->roundingMode;
    }

    /**
     * setRoundingMode
     * @param int $roundingMode
     * @throws InvalidRoundingModeException
     */
    public function setRoundingMode(int $roundingMode): void
    {
        if (!in_array($roundingMode, $this->validRoundingModes)) {
            throw new InvalidRoundingModeException();
        }
        $this->roundingMode = $roundingMode;
    }
}
