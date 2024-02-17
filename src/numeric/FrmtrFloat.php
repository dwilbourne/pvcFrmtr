<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\numeric;

use NumberFormatter;
use pvc\frmtr\err\InvalidMinMaxFractionalDigitException;
use pvc\interfaces\struct\range\RangeInterface;

/**
 * Class FrmtrFloat
 */
class FrmtrFloat extends FrmtrNumber
{
    /**
     * @var RangeInterface<int>
     */
    protected RangeInterface $fractionalDigits;

    /**
     * @param RangeInterface<int> $range
     */
    public function __construct(RangeInterface $range)
    {
        $this->fractionalDigits = $range;
        /**
         * these are the default values for Decimal NumberFormatter when you create it
         */
        $this->fractionalDigits->setRange(0, 3);
    }

    /**
     * getFractionalDigits
     * @return RangeInterface<int>
     */
    public function getFractionalDigits(): RangeInterface
    {
        return $this->fractionalDigits;
    }

    /**
     * setMinFractionalDigits
     * @param non-negative-int $minDigits
     * @param non-negative-int $maxDigits
     * @throws InvalidMinMaxFractionalDigitException
     */

    public function setFractionalDigits(int $minDigits, int $maxDigits): void
    {
        /**
         * the theoretical limit is something really large like 2^32, so we are not going to error check it on the
         * large side
         */
        if (($minDigits < 0) || ($maxDigits < 0)) {
            throw new InvalidMinMaxFractionalDigitException();
        }
        $this->fractionalDigits->setRange($minDigits, $maxDigits);
    }

    /**
     * @function createFormatter
     * @return NumberFormatter
     */
    protected function createFormatter(): NumberFormatter
    {
        $fractionalDigits = $this->fractionalDigits->getRange();

        $formatter = parent::createFormatter();
        $formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $fractionalDigits[0]);
        $formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $fractionalDigits[1]);
        return $formatter;
    }
}
