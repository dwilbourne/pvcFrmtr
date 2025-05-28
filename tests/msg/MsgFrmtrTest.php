<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\msg;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use pvc\frmtr\err\MsgContentNotSetException;
use pvc\frmtr\err\NonExistentMessageException;
use pvc\frmtr\msg\MsgFrmtr;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;


class MsgFrmtrTest extends TestCase
{
    /**
     * @var LocaleInterface
     */
    protected MockObject $locale;

    /**
     * @var DomainCatalogInterface|MockObject
     */
    protected MockObject $catalog;

    protected MsgFrmtr $frmtr;

    public function setUp(): void
    {
        $this->locale = $this->createMock(LocaleInterface::class);
        $this->catalog = $this->createMock(DomainCatalogInterface::class);
        $this->frmtr = new MsgFrmtr();
        $this->frmtr->setDomainCatalog($this->catalog);
        $this->frmtr->setLocale($this->locale);
    }

    /**
     * testSetGetDomainCatalog
     */
    #[CoversMethod(MsgFrmtr::class, 'setDomainCatalog')]
    #[CoversMethod(MsgFrmtr::class, 'getDomainCatalog')]

    public function testSetGetDomainCatalog(): void
    {
        $newCatalog = $this->createMock(DomainCatalogInterface::class);
        $this->frmtr->setDomainCatalog($newCatalog);
        self::assertEquals($newCatalog, $this->frmtr->getDomainCatalog());
    }

    /**
     * testSetGetLocale
     */
    #[CoversMethod(MsgFrmtr::class, 'setLocale')]
    #[CoversMethod(MsgFrmtr::class, 'getLocale')]

    public function testSetGetLocale(): void
    {
        $newLocale = $this->createMock(LocaleInterface::class);
        $this->frmtr->setLocale($newLocale);
        self::assertEquals($newLocale, $this->frmtr->getLocale());
    }

    /**
     * testFormat
     */
    #[CoversMethod(MsgFrmtr::class, 'format')]
    public function testFormat(): void
    {
        $this->locale->method('__toString')->willReturn('fr_FR');
        $domain = 'domain';
        $msgId = 'msgId';
        $msgText = 'some string';
        $parameters = [1 => 'fiver'];

        $msg = $this->createMock(MsgInterface::class);
        $msg->method('contentIsSet')->willReturn(true);
        $msg->method('getMsgId')->willReturn($msgId);
        $msg->method('getDomain')->willReturn($domain);

        $this->catalog->method('getMessage')->with($msgId)->willReturn($msgText);
        $this->catalog->method('getLocale')->willReturn((string)$this->locale);

        $expectedResult = $msgText;

        $msg->method('getParameters')->willReturn($parameters);
        $actualResult = $this->frmtr->format($msg);

        self::assertEquals($expectedResult, $actualResult);
    }

    /**
     * testMsgThrowsExceptionIfMsgIdNotSet
     * @throws MsgContentNotSetException
     * @throws NonExistentMessageException
     */
    #[CoversMethod(MsgFrmtr::class, 'format')]
    public function testFormatMsgThrowsExceptionIfMsgContentNotSet(): void
    {
        $msg = $this->createMock(MsgInterface::class);
        $msg->method('contentIsSet')->willReturn(false);
        self::expectException(MsgContentNotSetException::class);
        $this->frmtr->format($msg);
    }

    /**
     * testMsgTthrowsExceptionIfMessageIsNotInCatalog
     * @throws MsgContentNotSetException
     * @throws NonExistentMessageException
     */
    #[CoversMethod(MsgFrmtr::class, 'format')]
    public function testMsgThrowsExceptionIfMessageIsNotInCatalog(): void
    {
        $msgId = 'msgId';
        $domain = 'domain';
        $msg = $this->createMock(MsgInterface::class);
        $msg->method('contentIsSet')->willReturn(true);
        $msg->method('getMsgId')->willReturn($msgId);
        $msg->method('getDomain')->willReturn($domain);

        $this->catalog->method('getMessage')->with($msgId)->willReturn(null);
        self::expectException(NonExistentMessageException::class);
        $this->frmtr->format($msg);
    }
}
