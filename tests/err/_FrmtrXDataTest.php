<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\frmtr\err;

use PHPUnit\Framework\Attributes\CoversMethod;
use pvc\err\XDataTestMaster;
use pvc\frmtr\err\_FrmtrXData;
use pvc\frmtr\err\InvalidMinMaxFractionalDigitException;
use pvc\frmtr\err\InvalidRoundingModeException;
use pvc\frmtr\err\MsgContentNotSetException;
use pvc\frmtr\err\NonExistentMessageException;
use pvc\frmtr\err\UnsetLocaleException;

/**
 * Class _FrmtrXDataTest
 */
class _FrmtrXDataTest extends XDataTestMaster
{
    /**
     * @function testPvcRegexExceptionLibrary
     */
    #[CoversMethod(_FrmtrXData::class, 'getXMessageTemplates')]
    #[CoversMethod(_FrmtrXData::class, 'getLocalXCodes')]
    #[CoversMethod(UnsetLocaleException::class, '__construct')]
    #[CoversMethod(InvalidMinMaxFractionalDigitException::class, '__construct')]
    #[CoversMethod(InvalidRoundingModeException::class, '__construct')]
    #[CoversMethod(NonExistentMessageException::class, '__construct')]
    #[CoversMethod(MsgContentNotSetException::class, '__construct')]
    public function testPvcRegexExceptionLibrary(): void
    {
        $xData = new _FrmtrXData();
        self::assertTrue($this->verifylibrary($xData));
    }
}
