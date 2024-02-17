<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvc\frmtr;

use pvc\frmtr\err\UnsetLocaleException;
use pvc\interfaces\frmtr\FrmtrInterface;
use pvc\interfaces\intl\LocaleInterface;

/**
 * Class Frmtr
 *
 * The underlying icu formatters that this class uses all have a method called 'setPattern', which allows you to
 * customize the exact formatting of the value(s) so that it deviates from the 'standard pattern' which is indicated
 * by the locale.  This set of classes is meant to do nothing more than provide quick and easy formatting according
 * to the locale defaults, resulting in a narrow interface which should fit the vast majority of use cases.  If you
 * need the flexibiity of customizing a pattern, then just use the appropriate underlying icu formatter (e.g.
 * NumberFormatter, IntlDateFormatter and MessageFormatter).
 *
 * @template DataType
 * @implements FrmtrInterface<DataType>
 */
abstract class Frmtr implements FrmtrInterface
{
    protected LocaleInterface $locale;

    /**
     * getLocale
     * @return LocaleInterface
     */
    public function getLocale(): LocaleInterface
    {
        if (!isset($this->locale)) {
            throw new UnsetLocaleException();
        }
        return $this->locale;
    }

    /**
     * setLocale
     * @param LocaleInterface $locale
     */
    public function setLocale(LocaleInterface $locale): void
    {
        $this->locale = $locale;
    }

    /**
     * format
     * @param DataType $value
     * @return string
     */
    abstract public function format($value): string;
}
