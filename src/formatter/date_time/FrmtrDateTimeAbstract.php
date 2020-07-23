<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use pvc\intl\Locale;

/**
 * Class FrmtrDateTimeAbstract
 */
abstract class FrmtrDateTimeAbstract
{

    /**
     * @var string
     */
    protected string $format;

    /**
     * @var Locale
     */
    protected Locale $locale;


    /**
     * FrmtrDateTimeAbstract constructor.
     * @param Locale|null $locale
     */
    public function __construct(Locale $locale = null)
    {
        $this->setLocale($locale);
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
     * @function setFormat
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * @function getLocale
     * @return Locale
     */
    public function getLocale(): Locale
    {
        return $this->locale;
    }

    /**
     * @function setLocale
     * @param Locale|null $locale
     */
    public function setLocale(Locale $locale = null): void
    {
        if (is_null($locale)) {
            $locale = new locale();
        }
        $this->locale = $locale;
    }

    /**
     * @function getPatternFromLocale
     * @return string
     */
    abstract public function getPatternFromLocale(): string;
}
