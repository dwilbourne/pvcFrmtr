<?php declare(strict_types = 1);

namespace pvc\formatter\numeric;

use NumberFormatter;

abstract class FrmtrNumberFormatter
{
    protected NumberFormatter $frmtr;

    /**
     * @function setFormatter
     * @param NumberFormatter $frmtr
     */
    public function setFormatter(NumberFormatter $frmtr) : void
    {
        $this->frmtr = $frmtr;
    }

    /**
     * @function getFormatter
     * @return NumberFormatter
     */
    public function getFormatter(): NumberFormatter
    {
        return $this->frmtr;
    }

    /**
     * @function createDefaultFormatter
     * @return NumberFormatter
     */
    abstract protected function createDefaultFormatter(): NumberFormatter;
}
