<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvcTests\frmtr\err;

use pvc\err\XDataTestMaster;
use pvc\frmtr\err\_FrmtrXData;

/**
 * Class _FrmtrXDataTest
 */
class _FrmtrXDataTest extends XDataTestMaster
{
    /**
     * @function testPvcRegexExceptionLibrary
     * @covers \pvc\frmtr\err\_FrmtrXData::getXMessageTemplates
     * @covers \pvc\frmtr\err\_FrmtrXData::getLocalXCodes
     * @covers \pvc\frmtr\err\UnsetLocaleException
     * @covers \pvc\frmtr\err\InvalidMinMaxFractionalDigitException
     * @covers \pvc\frmtr\err\InvalidRoundingModeException
     */
    public function testPvcRegexExceptionLibrary(): void
    {
        $xData = new _FrmtrXData();
        self::assertTrue($this->verifylibrary($xData));
    }
}
