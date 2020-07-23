<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\msg;

use pvc\msg\Msg;
use pvc\sanitizer\SanitizerText;

class FrmtrMsgText
{
    /**
     * @function formatValue
     * @param Msg $msg
     * @return string
     */
    public function format(Msg $msg): string
    {
        $sanitizer = new SanitizerText();
        $txt = vsprintf($msg->getMsgText(), $msg->getMsgVars());
        return $sanitizer->sanitize($txt);
    }
}
