<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace tests\formatter\msg;

use PHPUnit\Framework\TestCase;
use pvc\formatter\msg\FrmtrMsg;
use pvc\msg\Msg;

/**
 * Class MsgFormatterDefaultTest
 * @package tests\msg
 * @covers \pvc\msg\MsgFormatterDefault
 */

class FrmtrMsgTest extends TestCase
{
    protected FrmtrMsg $formatter;
    protected Msg $msg;

    public function setUp() : void
    {
        $msgVars = ['foo', 'bar', 'baz'];
        $msgText = "(%s) one variable (%s) is not the same as another (%s).";
        $this->msg = new Msg($msgVars, $msgText);

        $this->formatter = new FrmtrMsg();
    }

    public function testSetGetOutputMsgVarsValue() : void
    {
        self::assertFalse($this->formatter->getOutputMsgVarsValue());
        $this->formatter->outputMsgVars(true);
        self::assertTrue($this->formatter->getOutputMsgVarsValue());
    }

    public function testFormat() : void
    {
        $expectedValue = "one variable is not the same as another.";
        self::assertEquals($expectedValue, (string) $this->formatter->format($this->msg));
    }
}
