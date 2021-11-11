<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\formatter\range_collection;

use Mockery;
use pvc\formatter\FrmtrInterface;
use pvc\formatter\range_collection\FrmtrRangeElement;
use PHPUnit\Framework\TestCase;

class FrmtrRangeElementTest extends TestCase
{
    protected FrmtrRangeElement $frmtr;
    protected $mockFrmtr;

    public function setUp() : void
    {
        $this->mockFrmtr = Mockery::mock(FrmtrInterface::class);
        $this->frmtr = new FrmtrRangeElement($this->mockFrmtr);
    }

    public function testSetGetMockFrmtr() : void
    {
        self::assertSame($this->mockFrmtr, $this->frmtr->getRangeAtomFrmtr());
        $newMock = Mockery::mock(FrmtrInterface::class);
        $this->frmtr->setRangeAtomFrmtr($newMock);
        self::assertSame($newMock, $this->frmtr->getRangeAtomFrmtr());
    }

    public function testSetGetSeparator() : void
    {
        self::assertEquals('-', $this->frmtr->getSeparator());
        $newSeparator = '*';
        $this->frmtr->setSeparator($newSeparator);
        self::assertEquals($newSeparator, $this->frmtr->getSeparator());
    }

    public function testFormat() : void
    {
        $rangeElement = new RangeInteger(1, 5);
        $this->mockFrmtr->shouldReceive('format');
    }
}
