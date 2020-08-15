<?php declare(strict_types = 1);
/**
 * @package: pvc
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @version: 1.0
 */

namespace pvc\formatter\date_time;

use Carbon\Carbon;
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
        $locale = $locale ?: new Locale();
        $this->setLocale($locale);
    }

    /**
     * @function getFormat
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format ?? $this->getPatternFromLocale();
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
     * @param Locale $locale
     */
    public function setLocale(Locale $locale): void
    {
        $this->locale = $locale;
    }

    public function format(Carbon $dt) : string
    {
        return $dt->format($this->getFormat());
    }

    /**
     * @function getPatternFromLocale
     * @return string
     */
    abstract public function getPatternFromLocale(): string;
}
