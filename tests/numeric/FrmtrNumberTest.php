<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\numeric;

use NumberFormatter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\err\InvalidRoundingModeException;
use pvc\frmtr\numeric\FrmtrNumber;

class FrmtrNumberTest extends TestCase
{
    /**
     * @var FrmtrNumber|MockObject
     */
    protected FrmtrNumber $formatter;

    public function setUp(): void
    {
        $this->formatter = $this->getMockForAbstractClass(FrmtrNumber::class);
    }

    /**
     * testDefaultRoundingMode
     * @covers \pvc\frmtr\numeric\FrmtrFloat::__construct
     */
    public function testDefaultRoundingMode(): void
    {
        $expectedResult = NumberFormatter::ROUND_HALFUP;
        self::assertEquals($expectedResult, $this->formatter->getRoundingMode());
    }

    /**
     * testSetRoundingModeThrowsExceptionWithBadArgument
     * @throws InvalidRoundingModeException
     * @covers \pvc\frmtr\numeric\FrmtrFloat::setRoundingMode
     */
    public function testSetRoundingModeThrowsExceptionWithBadArgument(): void
    {
        self::expectException(InvalidRoundingModeException::class);
        $this->formatter->setRoundingMode(5276);
    }

    /**
     * testSetGetRoundingMode
     * @throws InvalidRoundingModeException
     * @covers \pvc\frmtr\numeric\FrmtrFloat::setRoundingMode
     * @covers \pvc\frmtr\numeric\FrmtrFloat::getRoundingMode
     */
    public function testSetGetRoundingMode(): void
    {
        $roundingMode = NumberFormatter::ROUND_FLOOR;
        $this->formatter->setRoundingMode($roundingMode);
        self::assertEquals($roundingMode, $this->formatter->getRoundingMode());
    }

    /**
     * testUseGroupingSeparatorDefault
     * @coversNothing
     */
    public function testUseGroupingSeparatorDefault(): void
    {
        self::assertEquals(1, $this->formatter->useGroupingSeparator());
    }

    /**
     * testSetGetUseGroupingSeparator
     * @covers \pvc\frmtr\numeric\FrmtrNumber::setUseGroupingSeparator
     * @covers \pvc\frmtr\numeric\FrmtrNumber::useGroupingSeparator
     */
    public function testSetGetUseGroupingSeparator(): void
    {
        $useSeparator = false;
        $this->formatter->setUseGroupingSeparator($useSeparator);
        self::assertEquals(0, $this->formatter->useGroupingSeparator());
    }
}
