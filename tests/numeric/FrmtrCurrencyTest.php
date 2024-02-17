<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvcTests\frmtr\numeric;

use PHPUnit\Framework\TestCase;
use pvc\frmtr\numeric\FrmtrCurrency;
use pvc\interfaces\intl\LocaleInterface;

class FrmtrCurrencyTest extends TestCase
{
    protected FrmtrCurrency $frmtr;

    public function setUp() : void
    {
        $this->frmtr = new FrmtrCurrency();
        $locale = $this->createMock(LocaleInterface::class);
        $locale->method('__toString')->willReturn('en_US');
        $this->frmtr->setLocale($locale);
    }

    /**
     * @function testFormat
     * @param float $value
     * @param string $expectedValue
     * @param string $comment
     * @dataProvider numberProvider
     * @covers       \pvc\frmtr\numeric\FrmtrNumber::createFormatter
     * @covers       \pvc\frmtr\numeric\FrmtrNumber::format
     * @covers       \pvc\frmtr\numeric\FrmtrCurrency::createFormatter
     * @covers       \pvc\frmtr\numeric\FrmtrCurrency::format
     */
    public function testFormat(float $value, string $expectedValue, string $comment): void
    {
        self::assertEquals($expectedValue, $this->frmtr->format($value));
    }

    /**
     * @function numberProvider
     * @return array
     *
     * This test data is specific to the locale for the United States
     */
    public function numberProvider()
    {
        return [
            [5, '$5.00', 'basic test with integer'],
            [5.00, '$5.00', 'basic test with float'],
            [1234.4567, '$1,234.46', 'includes grouping separator and rounds'],
            [-12345.994321, '-$12,345.99', 'negative number and rounds'],
        ];
    }
}
