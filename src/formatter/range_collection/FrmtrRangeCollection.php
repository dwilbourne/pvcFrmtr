<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\formatter\range_collection;

use pvc\formatter\FrmtrInterface;
use pvc\struct\range_collection\RangeCollectionInterface;

/**
 * Class FrmtrRangeCollection
 * @package pvc\formatter\range_collection
 */
class FrmtrRangeCollection
{
    protected FrmtrInterface $rangeElementFrmtr;

    /**
     * @return FrmtrInterface
     */
    public function getRangeElementFrmtr(): ? FrmtrInterface
    {
        return $this->rangeElementFrmtr ?? null;
    }

    /**
     * @param FrmtrInterface $rangeElementFrmtr
     */
    public function setRangeElementFrmtr(FrmtrInterface $rangeElementFrmtr): void
    {
        $this->rangeElementFrmtr = $rangeElementFrmtr;
    }

    protected function formatRangeElement($rangeElement) : string
    {
        if ($frmtr = $this->getRangeElementFrmtr()) {
            return $frmtr->format($rangeElement);
        }
        return (string) $rangeElement;
    }

    public function format(RangeCollectionInterface $rangeCollection): string
    {
        $resultArray = [];
        foreach ($rangeCollection->getRangeElements() as $rangeElement) {
            $resultArray[] = $this->formatRangeElement($rangeElement);
        }
        // convert the result array to a string
        return implode(',', $resultArray);
    }
}
