<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\html;

use pvc\interfaces\frmtr\html\FrmtrHtmlInterface;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\html\tag\TagInterface;
use pvc\interfaces\html\tag\TagVoidInterface;
use pvc\interfaces\intl\LocaleInterface;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class FrmtrHtml
 * @template AttributeValueType
 * @implements FrmtrHtmlInterface<AttributeValueType>
 */
class FrmtrHtml implements FrmtrHtmlInterface
{
    protected FrmtrMsgInterface $msgFrmtr;

    public function __construct(FrmtrMsgInterface $msgFrmtr, LocaleInterface $locale)
    {
        $this->setMsgFrmtr($msgFrmtr);
        $this->setLocale($locale);
    }

    /**
     * setLocale
     * @param LocaleInterface $locale
     */
    public function setLocale(LocaleInterface $locale): void
    {
        $this->getMsgFrmtr()->setLocale($locale);
    }

    /**
     * getMsgFrmtr
     * @return FrmtrMsgInterface
     */
    public function getMsgFrmtr(): FrmtrMsgInterface
    {
        return $this->msgFrmtr;
    }

    /**
     * setMsgFrmtr
     * @param FrmtrMsgInterface $frmtrMsg
     */
    public function setMsgFrmtr(FrmtrMsgInterface $frmtrMsg): void
    {
        $this->msgFrmtr = $frmtrMsg;
    }

    /**
     * getLocale
     * @return LocaleInterface
     */
    public function getLocale(): LocaleInterface
    {
        return $this->getMsgFrmtr()->getLocale();
    }

    /**
     * format
     * @param TagVoidInterface<AttributeValueType> $value
     * @return string
     */
    public function format($value): string
    {
        $z = $value->generateOpeningTag();

        /**
         * if it is a tag (not a void tag) then go ahead and generate the inner html and the closing tag
         */
        if ($value instanceof TagInterface) {
            /** @var TagVoidInterface<AttributeValueType>|MsgInterface|string $item */
            foreach ($value->getInnerHtml() as $item) {
                $z .= $this->formatInnerHtmlRecurse($item);
            }
            $z .= $value->generateClosingTag();
            return $z;
        }

        return $z;
    }

    /**
     * formatInnerHtmlRecurse
     * @param TagVoidInterface<AttributeValueType>|MsgInterface|string $value
     * @return string
     */
    protected function formatInnerHtmlRecurse(TagVoidInterface|MsgInterface|string $value): string
    {
        if ($value instanceof TagVoidInterface) {
            return $this->format($value);
        } elseif ($value instanceof MsgInterface) {
            return htmlspecialchars($this->getMsgFrmtr()->format($value), ENT_HTML5 | ENT_COMPAT);
        } /**
         * is a literal string, not to be translated
         */
        else {
            return $value;
        }
    }
}
