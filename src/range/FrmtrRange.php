<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr\range;

use pvc\interfaces\frmtr\FrmtrInterface;
use pvc\interfaces\struct\range\RangeInterface;

/**
 * Class FrmtrRange
 */
class FrmtrRange
{
    /**
     * @var FrmtrInterface<int|float>
     */
    protected FrmtrInterface $rangeElementFrmtr;

    /**
     * @param FrmtrInterface<int|float> $rangeElementFrmtr
     */
    public function __construct(FrmtrInterface $rangeElementFrmtr)
    {
        $this->setRangeElementFrmtr($rangeElementFrmtr);
    }

    /**
     * @return FrmtrInterface<int|float>
     */
    public function getRangeElementFrmtr(): FrmtrInterface
    {
        return $this->rangeElementFrmtr;
    }

    /**
     * @param FrmtrInterface<int|float> $rangeElementFrmtr
     */
    public function setRangeElementFrmtr(FrmtrInterface $rangeElementFrmtr): void
    {
        $this->rangeElementFrmtr = $rangeElementFrmtr;
    }

    /**
     * format
     * @param RangeInterface<int|float> $range
     * @return string
     */
    public function format(RangeInterface $range): string
    {
        $rangeArray = $range->getRange();

        $result = $this->rangeElementFrmtr->format($rangeArray[0]);

        if ($rangeArray[0] != $rangeArray[1]) {
            $result .= '-' . $this->rangeElementFrmtr->format($rangeArray[1]);
        }

        return $result;
    }
}
