<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\numeric;

use NumberFormatter;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\err\InvalidMinMaxFractionalDigitException;
use pvc\frmtr\numeric\FrmtrFloat;
use pvc\frmtr\numeric\FrmtrNumber;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\struct\range\RangeInterface;

class FrmtrFloatTest extends TestCase
{
    /**
     * @var RangeInterface<int>|MockObject
     */
    protected MockObject $range;

    protected FrmtrFloat $formatter;

    public function setUp(): void
    {
        $this->range = $this->createMock(RangeInterface::class);
        $this->formatter = new FrmtrFloat($this->range);

        $mockLocale = $this->createMock(LocaleInterface::class);
        $mockLocale->method('__toString')->willReturn('en_US');
        $this->formatter->setLocale($mockLocale);
    }

    /**
     * testConstructAndDefaults
     */
    #[CoversMethod(FrmtrFloat::class, '__construct')]
    public function testConstructAndDefaults(): void
    {
        $this->range->expects($this->once())->method('setRange')->with(0, 3);
        new FrmtrFloat($this->range);
    }

    /**
     * testSetFractionalDigitsThrowsExceptionWithNegativeMinArgument
     * @throws InvalidMinMaxFractionalDigitException
     */
    #[CoversMethod(FrmtrFloat::class, 'setFractionalDigits')]
    public function testSetFractionalDigitsThrowsExceptionWithNegativeMinArgument(): void
    {
        self::expectException(InvalidMinMaxFractionalDigitException::class);
        $this->formatter->setFractionalDigits(-2, 5);
    }

    /**
     * testSetFractionalDigitsThrowsExceptionWithNegativeMaxArgument
     * @throws InvalidMinMaxFractionalDigitException
     */
    #[CoversMethod(FrmtrFloat::class, 'setFractionalDigits')]
    public function testSetFractionalDigitsThrowsExceptionWithNegativeMaxArgument(): void
    {
        self::expectException(InvalidMinMaxFractionalDigitException::class);
        $this->formatter->setFractionalDigits(2, -5);
    }

    /**
     * testSetGetFractionalDigits
     * @throws InvalidMinMaxFractionalDigitException
     */
    #[CoversMethod(FrmtrFloat::class, 'setFractionalDigits')]
    #[CoversMethod(FrmtrFloat::class, 'getFractionalDigits')]
    public function testSetGetFractionalDigits(): void
    {
        $min = 2;
        $max = 5;
        $this->range->expects($this->once())->method('setRange')->with($min, $max);
        $this->formatter->setFractionalDigits($min, $max);
        self::assertEquals($this->range, $this->formatter->getFractionalDigits());
    }

    /**
     * @function testFormat
     */
    #[CoversMethod(FrmtrNumber::class, 'createFormatter')]
    #[CoversMethod(FrmtrNumber::class, 'format')]
    #[CoversMethod(FrmtrFloat::class, 'createFormatter')]
    #[CoversMethod(FrmtrFloat::class, 'format')]
    public function testFormat(): void
    {
        $this->range->method('getRange')->willReturn([3, 5]);
        /**
         * test min digits
         */
        self::assertEquals('5.000', $this->formatter->format(5));

        /**
         * test max digits and rounding
         */
        self::assertEquals('5.00007', $this->formatter->format(5.000065));

        /**
         * test rounding
         */
        $this->formatter->setRoundingMode(NumberFormatter::ROUND_FLOOR);
        self::assertEquals('5.00006', $this->formatter->format(5.000065));

        /**
         * confirm grouping
         */
        self::assertEquals('5,432.1064', $this->formatter->format(5432.1064));
    }
}
