<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\text;

use pvc\frmtr\Frmtr;

/**
 * Class FrmtrText
 * @extends Frmtr<string>
 */
class FrmtrText extends Frmtr
{
    /**
     * format
     * @param string $value
     * @return string
     */
    public function format($value): string
    {
        return (string)$value;
    }
}
