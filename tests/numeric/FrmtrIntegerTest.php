<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\numeric;

use PHPUnit\Framework\TestCase;
use pvc\frmtr\numeric\FrmtrInteger;
use pvc\interfaces\intl\LocaleInterface;

class FrmtrIntegerTest extends TestCase
{
    protected FrmtrInteger $frmtr;

    public function setUp(): void
    {
        $this->frmtr = new FrmtrInteger();

        $locale = $this->createMock(LocaleInterface::class);
        $locale->method('__toString')->willReturn('en');
        $this->frmtr->setLocale($locale);
    }


    /**
     * @function testFormat
     * @param int $value
     * @param string $expectedValue
     * @dataProvider numberProvider
     * @covers       \pvc\frmtr\numeric\FrmtrNumber::createFormatter
     * @covers       \pvc\frmtr\numeric\FrmtrNumber::format
     * @covers       \pvc\frmtr\numeric\FrmtrInteger::createFormatter
     * @covers       \pvc\frmtr\numeric\FrmtrInteger::format
     */
    public function testFormat(int $value, string $expectedValue) : void
    {
        self::assertEquals($expectedValue, $this->frmtr->format($value));
    }

    /**
     * numberProvider
     * @return array<int, string>
     */
    public function numberProvider() : array
    {
        return [
            'basic test' => [5, '5'],
            'includes grouping separator' => [1234, '1,234'],
            'negative number' => [-12345, '-12,345']
        ];
    }
}
