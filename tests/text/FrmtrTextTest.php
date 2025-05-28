<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\frmtr\text;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\text\FrmtrText;


class FrmtrTextTest extends TestCase
{
    protected FrmtrText $formatter;

    public function setUp(): void
    {
        $this->formatter = new FrmtrText();
    }

    /**
     * testFormat
     */
    #[CoversMethod(FrmtrText::class, 'format')]
    public function testFormat(): void
    {
        $testValue = 'some string';
        self::assertEquals($testValue, $this->formatter->format($testValue));
    }
}
