<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvcTests\frmtr\numeric;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\numeric\FrmtrCurrency;
use pvc\frmtr\numeric\FrmtrNumber;
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
     */
    #[CoversMethod(FrmtrNumber::class, 'createFormatter')]
    #[CoversMethod(FrmtrNumber::class, 'format')]
    #[CoversMethod(FrmtrCurrency::class, 'createFormatter')]
    #[CoversMethod(FrmtrCurrency::class, 'format')]
    #[DataProvider('numberProvider')]
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
    public static function numberProvider(): array
    {
        return [
            [5, '$5.00', 'basic test with integer'],
            [5.00, '$5.00', 'basic test with float'],
            [1234.4567, '$1,234.46', 'includes grouping separator and rounds'],
            [-12345.994321, '-$12,345.99', 'negative number and rounds'],
        ];
    }
}
