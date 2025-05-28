<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\numeric;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\numeric\FrmtrInteger;
use pvc\frmtr\numeric\FrmtrNumber;
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
     */
    #[CoversMethod(FrmtrNumber::class, 'createFormatter')]
    #[CoversMethod(FrmtrNumber::class, 'format')]
    #[CoversMethod(FrmtrInteger::class, 'createFormatter')]
    #[CoversMethod(FrmtrInteger::class, 'format')]
    #[DataProvider('numberProvider')]
    public function testFormat(int $value, string $expectedValue) : void
    {
        self::assertEquals($expectedValue, $this->frmtr->format($value));
    }

    /**
     * numberProvider
     * @return array<int, string>
     */
    public static function numberProvider(): array
    {
        return [
            'basic test' => [5, '5'],
            'includes grouping separator' => [1234, '1,234'],
            'negative number' => [-12345, '-12,345']
        ];
    }
}
