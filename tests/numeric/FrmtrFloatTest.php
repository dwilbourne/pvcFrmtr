<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\numeric;

use NumberFormatter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\err\InvalidMinMaxFractionalDigitException;
use pvc\frmtr\numeric\FrmtrFloat;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\struct\range\RangeInterface;

class FrmtrFloatTest extends TestCase
{
    /**
     * @var RangeInterface<int>|MockObject
     */
    protected RangeInterface|MockObject $range;

    /**
     * @var FrmtrFloat
     */
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
     * testFractionalDigitsDefaults
     * @covers \pvc\frmtr\numeric\FrmtrFloat::__construct
     */
    public function testFractionalDigitsDefaults(): void
    {
        $this->range->expects($this->once())->method('setRange')->with(0, 3);
        $formatter = new FrmtrFloat($this->range);
        unset($formatter);
    }

    /**
     * testSetFractionalDigitsThrowsExceptionWithNegativeMinArgument
     * @throws InvalidMinMaxFractionalDigitException
     * @covers \pvc\frmtr\numeric\FrmtrFloat::setFractionalDigits
     */
    public function testSetFractionalDigitsThrowsExceptionWithNegativeMinArgument(): void
    {
        self::expectException(InvalidMinMaxFractionalDigitException::class);
        $this->formatter->setFractionalDigits(-2, 5);
    }

    /**
     * testSetFractionalDigitsThrowsExceptionWithNegativeMaxArgument
     * @throws InvalidMinMaxFractionalDigitException
     * @covers \pvc\frmtr\numeric\FrmtrFloat::setFractionalDigits
     */
    public function testSetFractionalDigitsThrowsExceptionWithNegativeMaxArgument(): void
    {
        self::expectException(InvalidMinMaxFractionalDigitException::class);
        $this->formatter->setFractionalDigits(2, -5);
    }

    /**
     * testSetGetFractionalDigits
     * @throws InvalidMinMaxFractionalDigitException
     * @covers \pvc\frmtr\numeric\FrmtrFloat::setFractionalDigits
     * @covers \pvc\frmtr\numeric\FrmtrFloat::getFractionalDigits
     */
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
     * @covers \pvc\frmtr\numeric\FrmtrNumber::createFormatter
     * @covers \pvc\frmtr\numeric\FrmtrNumber::format
     * @covers \pvc\frmtr\numeric\FrmtrFloat::createFormatter
     * @covers \pvc\frmtr\numeric\FrmtrFloat::format
     */
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
