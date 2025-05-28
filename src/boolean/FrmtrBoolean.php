<?php

/**
 * @author Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\boolean;

use pvc\frmtr\Frmtr;
use pvc\interfaces\frmtr\bool\FrmtrBooleanInterface;
use pvc\interfaces\frmtr\msg\FrmtrMsgInterface;
use pvc\interfaces\msg\MsgInterface;

/**
 * Class FrmtrBoolean
 * @extends Frmtr<bool>
 * Formats a boolean value into any one of several valid Formats.
 */
class FrmtrBoolean extends Frmtr implements FrmtrBooleanInterface
{
    /**
     * @var string
     *
     * The 'format' string is the msgId in the messages data store.  For example, there are msgIds such as
     * 'yes_no' and 'true_false'.  This preserves the language-neutral character of this class.
     */
    protected string $format;

    /**
     * FrmtrBoolean constructor.
     * @param string $format
     */
    public function __construct(
        /**
         * @var MsgInterface
         * outputting a word for true or false (yes / no, etc) should be done in a language neutral way, so we use the Msg
         * library.
         */
        protected MsgInterface $msg,
        protected FrmtrMsgInterface $msgFrmtr,
        string $format = 'yes'
    )
    {
        $this->setFormat($format);
    }

    /**
     * @function setFormat
     * @param string $format
     * there is no error checking the format (msgId) at this point.  When it comes time to output the message, the
     * message library will throw an exception if the msgId cannot be found in the messages store.
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @function getFormat
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @function formatValue
     * @param bool $value
     * @return string
     */
    public function format($value): string
    {
        $domain = 'formatter';
        $msgId = $this->getFormat();
        $parameters = ['true_false' => ($value ? 'true' : 'false')];
        $this->msg->setContent($domain, $msgId, $parameters);
        return $this->msgFrmtr->format($this->msg);
    }
}
