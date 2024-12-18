<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */
declare (strict_types=1);

namespace pvcTests\frmtr\frmtr;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\html\FrmtrHtml;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\html\tag\TagInterface;
use pvc\interfaces\html\tag\TagVoidInterface;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\msg\MsgInterface;

class FrmtrHtmlTest extends TestCase
{
    protected FrmtrMsgInterface|MockObject $frmtrMsg;

    protected LocaleInterface|MockObject $locale;

    protected FrmtrHtml $frmtrHtml;

    public function setUp(): void
    {
        $this->frmtrMsg = $this->createMock(FrmtrMsgInterface::class);
        $this->locale = $this->createMock(LocaleInterface::class);
        $this->frmtrHtml = new FrmtrHtml($this->frmtrMsg, $this->locale);
        $this->frmtrHtml->setLocale($this->locale);
    }

    /**
     * testConstruct
     * @covers \pvc\frmtr\html\FrmtrHtml::__construct
     */
    public function testConstruct(): void
    {
        self::assertInstanceOf(FrmtrHtml::class, $this->frmtrHtml);
    }

    /**
     * testSetGetFrmtrMsg
     * @covers \pvc\frmtr\html\FrmtrHtml::setMsgFrmtr
     * @covers \pvc\frmtr\html\FrmtrHtml::getMsgFrmtr
     */
    public function testSetGetFrmtrMsg(): void
    {
        self::assertEquals($this->frmtrMsg, $this->frmtrHtml->getMsgFrmtr());
    }

    /**
     * testSetGetLocale
     * @covers \pvc\frmtr\html\FrmtrHtml::getLocale
     * @covers \pvc\frmtr\html\FrmtrHtml::setLocale
     */
    public function testSetGetLocale(): void
    {
        $this->frmtrMsg->expects($this->once())->method('getLocale')->willReturn($this->locale);
        self::assertEquals($this->locale, $this->frmtrHtml->getLocale());
    }

    /**
     * testFormatTagVoid
     * @covers \pvc\frmtr\html\FrmtrHtml::format
     */
    public function testFormatTagVoid(): void
    {
        $expectedResult = '<col>';
        $tag = $this->createMock(TagVoidInterface::class);
        $tag->expects($this->once())->method('generateOpeningTag')->willReturn($expectedResult);
        self::assertEquals($expectedResult, $this->frmtrHtml->format($tag));
    }

    /**
     * testFormatWithNestedTagsAndMsgs
     * @covers \pvc\frmtr\html\FrmtrHtml::format
     * @covers \pvc\frmtr\html\FrmtrHtml::formatInnerHtmlRecurse
     */
    public function testFormatWithNestedTagsMsgsAndStrings(): void
    {
        $tagOpeningString = '<div>';
        $tagClosingString = '</div>';

        $innerTagOpeningString = '<p>';
        $innerTagClosingString = '</p>';

        $innerMsgText = 'text string';

        $innerMsg = $this->createMock(MsgInterface::class);
        $this->frmtrMsg->expects($this->once())->method('format')->with($innerMsg)->willReturn($innerMsgText);

        $literalText = 'this string is njot to be translated';

        $innerTag = $this->createMock(TagInterface::class);
        $innerTag->expects($this->once())->method('getChildren')->willReturn([$innerMsg, $literalText]);
        $innerTag->expects($this->once())->method('generateOpeningTag')->willReturn($innerTagOpeningString);
        $innerTag->expects($this->once())->method('generateClosingTag')->willReturn($innerTagClosingString);

        $tag = $this->createMock(TagInterface::class);
        $tag->expects($this->once())->method('getChildren')->willReturn([$innerTag]);
        $tag->expects($this->once())->method('generateOpeningTag')->willReturn($tagOpeningString);
        $tag->expects($this->once())->method('generateClosingTag')->willReturn($tagClosingString);

        $expectedResult = $tagOpeningString . $innerTagOpeningString;
        $expectedResult .= $innerMsgText . $literalText;
        $expectedResult .= $innerTagClosingString . $tagClosingString;

        self::assertEquals($expectedResult, $this->frmtrHtml->format($tag));
    }
}
