<?php
/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version 1.0
 */

namespace pvc\formatter\range_collection;

use pvc\formatter\FrmtrInterface;
use pvc\struct\range_collection\range_element\RangeElementInterface;

/**
 * Class FrmtrRangeElement
 * @package pvc\formatter\range_collection
 */
class FrmtrRangeElement
{
    protected FrmtrInterface $rangeAtomFrmtr;
    protected string $separator = '-';

    /**
     * @return FrmtrInterface
     */
    public function getRangeAtomFrmtr(): FrmtrInterface
    {
        return $this->rangeAtomFrmtr;
    }

    /**
     * @param FrmtrInterface $rangeAtomFrmtr
     */
    public function setRangeAtomFrmtr(FrmtrInterface $rangeAtomFrmtr): void
    {
        $this->rangeAtomFrmtr = $rangeAtomFrmtr;
    }

    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     */
    public function setSeparator(string $separator): void
    {
        $this->separator = $separator;
    }

    public function __construct(FrmtrInterface $rangeAtomFrmtr)
    {
        $this->setRangeAtomFrmtr($rangeAtomFrmtr);
    }


    public function format(RangeElementInterface $rangeElement) : string
    {
        $z = '';
        $z .= $this->rangeAtomFrmtr->format($rangeElement->getMin());
        $z .= $this->getSeparator();
        $z .= $this->rangeAtomFrmtr->format($rangeElement->getMax());
        return $z;
    }
}
