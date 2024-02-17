<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\frmtr\range;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\range\FrmtrRange;
use pvc\interfaces\frmtr\FrmtrInterface;
use pvc\interfaces\struct\range\RangeInterface;

class FrmtrRangeTest extends TestCase
{
    protected FrmtrRange $formatter;

    protected FrmtrInterface|MockObject $rangeElementFormatter;

    public function setUp(): void
    {
        $this->rangeElementFormatter = $this->createMock(FrmtrInterface::class);
        $this->formatter = new FrmtrRange($this->rangeElementFormatter);
    }

    /**
     * testConstruct
     * @covers \pvc\frmtr\range\FrmtrRange::__construct
     */
    public function testConstruct(): void
    {
        self::assertInstanceOf(FrmtrRange::class, $this->formatter);
    }

    /**
     * testSetGetRangeElementFormatter
     * @covers \pvc\frmtr\range\FrmtrRange::getRangeElementFrmtr
     * @covers \pvc\frmtr\range\FrmtrRange::setRangeElementFrmtr
     */
    public function testSetGetRangeElementFormatter(): void
    {
        $newElementFormatter = $this->createMock(FrmtrInterface::class);
        $this->formatter->setRangeElementFrmtr($newElementFormatter);
        self::assertEquals($newElementFormatter, $this->formatter->getRangeElementFrmtr());
    }

    /**
     * testFormatWithDifferentMinMax
     * @covers \pvc\frmtr\range\FrmtrRange::format
     */
    public function testFormatWithDifferentMinMax(): void
    {
        $min = 3;
        $max = 5;
        $mockRange = $this->createMock(RangeInterface::class);
        $mockRange->expects($this->once())->method('getRange')->willReturn([$min, $max]);
        $callBack = function (int $x) {
            return (string)$x;
        };
        $this->rangeElementFormatter->expects($this->exactly(2))->method('format')->willReturnCallback($callBack);
        $expectedResult = '3-5';
        self::assertEquals($expectedResult, $this->formatter->format($mockRange));
    }

    /**
     * testFormatWithIdenticalMinMax
     * @covers \pvc\frmtr\range\FrmtrRange::format
     */
    public function testFormatWithIdenticalMinMax(): void
    {
        $min = 3;
        $max = 3;
        $mockRange = $this->createMock(RangeInterface::class);
        $mockRange->expects($this->once())->method('getRange')->willReturn([$min, $max]);
        $callBack = function (int $x) {
            return (string)$x;
        };
        $this->rangeElementFormatter->expects($this->once())->method('format')->willReturnCallback($callBack);
        $expectedResult = '3';
        self::assertEquals($expectedResult, $this->formatter->format($mockRange));
    }
}
