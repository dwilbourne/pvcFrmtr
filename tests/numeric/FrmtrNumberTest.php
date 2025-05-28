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
use pvc\frmtr\err\InvalidRoundingModeException;
use pvc\frmtr\numeric\FrmtrFloat;
use pvc\frmtr\numeric\FrmtrNumber;

class FrmtrNumberTest extends TestCase
{
    protected MockObject $formatter;

    public function setUp(): void
    {
        $this->formatter = $this->getMockForAbstractClass(FrmtrNumber::class);
    }

    /**
     * testDefaultRoundingMode
     */
    #[CoversMethod(FrmtrFloat::class, '__construct')]
    #[CoversMethod(FrmtrFloat::class, 'getRoundingMode')]
    public function testDefaultRoundingMode(): void
    {
        $expectedResult = NumberFormatter::ROUND_HALFUP;
        self::assertEquals($expectedResult, $this->formatter->getRoundingMode());
    }

    /**
     * testSetRoundingModeThrowsExceptionWithBadArgument
     * @throws InvalidRoundingModeException
     */
    #[CoversMethod(FrmtrFloat::class, 'setRoundingMode')]
    public function testSetRoundingModeThrowsExceptionWithBadArgument(): void
    {
        self::expectException(InvalidRoundingModeException::class);
        $this->formatter->setRoundingMode(5276);
    }

    /**
     * testSetGetRoundingMode
     * @throws InvalidRoundingModeException
     */
    #[CoversMethod(FrmtrFloat::class, 'setRoundingMode')]
    #[CoversMethod(FrmtrFloat::class, 'getRoundingMode')]
    public function testSetGetRoundingMode(): void
    {
        $roundingMode = NumberFormatter::ROUND_FLOOR;
        $this->formatter->setRoundingMode($roundingMode);
        self::assertEquals($roundingMode, $this->formatter->getRoundingMode());
    }

    /**
     * testUseGroupingSeparatorDefault
     */
    #[CoversMethod(FrmtrNumber::class, 'useGroupingSeparator')]
    public function testUseGroupingSeparatorDefault(): void
    {
        self::assertEquals(1, $this->formatter->useGroupingSeparator());
    }

    /**
     * testSetGetUseGroupingSeparator
     */
    #[CoversMethod(FrmtrNumber::class, 'setUseGroupingSeparator')]
    #[CoversMethod(FrmtrNumber::class, 'useGroupingSeparator')]
    public function testSetGetUseGroupingSeparator(): void
    {
        $useSeparator = false;
        $this->formatter->setUseGroupingSeparator($useSeparator);
        self::assertEquals(0, $this->formatter->useGroupingSeparator());
    }
}
