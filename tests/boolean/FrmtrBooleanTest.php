<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\boolean;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\boolean\FrmtrBoolean;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\MsgInterface;

class FrmtrBooleanTest extends TestCase
{
    protected MockObject $msg;

    protected MockObject $msgFormatter;

    protected FrmtrBoolean $boolFormatter;

    public function setUp() : void
    {
        $this->msg = $this->createMock(MsgInterface::class);
        $this->msgFormatter = $this->createMock(FrmtrMsgInterface::class);
        $this->boolFormatter = new FrmtrBoolean($this->msg, $this->msgFormatter);
    }

    /**
     * testConstruct
     */
    #[CoversMethod(FrmtrBoolean::class, '__construct')]
    public function testConstruct(): void
    {
        self::assertInstanceOf(FrmtrBoolean::class, $this->boolFormatter);
    }

    /**
     * testSetGetFormat
     */
    #[CoversMethod(FrmtrBoolean::class, 'setFormat')]
    #[CoversMethod(FrmtrBoolean::class, 'getFormat')]

    public function testSetGetFormat() : void
    {
        $format = '1';
        $this->boolFormatter->setFormat($format);
        self::assertEquals($format, $this->boolFormatter->getFormat());
    }

    /**
     * testFormat
     */
    #[CoversMethod(FrmtrBoolean::class, 'format')]
    public function testFormat() : void
    {
        $format = 'yes';
        $value = true;

        $parameters = ['true_false' => ($value ? 'true' : 'false')];
        $this->boolFormatter->setFormat($format);

        $this->msg->expects($this->once())->method('setContent')->with('formatter', $format, $parameters);
        $this->msgFormatter->expects($this->once())->method('format')->with($this->msg);
        $this->boolFormatter->format($value);
    }
}
