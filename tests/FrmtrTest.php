<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\frmtr;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\err\UnsetLocaleException;
use pvc\frmtr\Frmtr;
use pvc\interfaces\intl\LocaleInterface;

class FrmtrTest extends TestCase
{
    /**
     * @template DataType
     */
    protected MockObject $frmtr;

    public function setUp(): void
    {
        $this->frmtr = $this->getMockForAbstractClass(Frmtr::class);
    }

    /**
     * testGetLocaleWhenNotSetThrowsError
     */
    #[CoversMethod(Frmtr::class, 'getLocale')]
    public function testGetLocaleWhenNotSetThrowsError(): void
    {
        self::expectException(UnsetLocaleException::class);
        $locale = $this->frmtr->getLocale();
        unset($locale);
    }

    /**
     * testSetGetLocale
     * @throws UnsetLocaleException
     */
    #[CoversMethod(Frmtr::class, 'setLocale')]
    #[CoversMethod(Frmtr::class, 'getLocale')]
    public function testSetGetLocale(): void
    {
        $mockLocale = $this->createMock(LocaleInterface::class);
        $this->frmtr->setLocale($mockLocale);
        self::assertEquals($mockLocale, $this->frmtr->getLocale());
    }
}
