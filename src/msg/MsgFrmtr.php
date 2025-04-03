<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\msg;

use MessageFormatter;
use pvc\frmtr\err\MsgContentNotSetException;
use pvc\frmtr\err\NonExistentMessageException;
use pvc\frmtr\err\UnsetLocaleException;
use pvc\frmtr\Frmtr;
use pvc\interfaces\msg\DomainCatalogInterface;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class MsgFrmtr
 *
 * This formatter behaves a bit differently than the others.  Other formatters depend on a locale, this object
 * depends on a domain catalog (which is appropriate for a locale)
 *
 * @extends Frmtr<MsgInterface>
 */
class MsgFrmtr extends Frmtr
{
    /**
     * @var DomainCatalogInterface
     */
    protected DomainCatalogInterface $domainCatalog;


    /**
     * getDomainCatalog
     * @return DomainCatalogInterface
     */
    public function getDomainCatalog(): DomainCatalogInterface
    {
        return $this->domainCatalog;
    }

    /**
     * setDomainCatalog
     * @param DomainCatalogInterface $domainCatalog
     */
    public function setDomainCatalog(DomainCatalogInterface $domainCatalog): void
    {
        $this->domainCatalog = $domainCatalog;
    }

    /**
     * format
     *
     * @param MsgInterface $value
     * @return string
     * @throws MsgContentNotSetException
     * @throws NonExistentMessageException
     * @throws UnsetLocaleException
     */
    public function format($value): string
    {
        /**
         * ensure the message content is set (e.g. msgId, domain and locale)
         */
        if (!$value->contentIsSet()) {
            throw new MsgContentNotSetException();
        }

        /**
         * Calling the load method will only load a new message set if the messages have not already been loaded. The
         * load method also throws an error if it was unable to load the catalog for the requested domain and locale,
         * so we know that the domain and the locale of the msg match the domain and locale of the catalog
         */
        $this->getDomainCatalog()->load($value->getDomain(), (string)$this->getLocale());


        $msgId = $value->getMsgId();
        if (!$pattern = $this->getDomainCatalog()->getMessage($msgId)) {
            throw new NonExistentMessageException($msgId);
        }
        $frmtr = MessageFormatter::create((string)$this->getLocale(), $pattern);

        /**
         * if MessageFormatter fails for some reason, return an empty string
         */
        return ($frmtr->format($value->getParameters()) ?: '');
    }
}
