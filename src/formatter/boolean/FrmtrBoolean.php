<?php declare(strict_types = 1);

namespace pvc\formatter\boolean;

use pvc\formatter\boolean\err\AddBooleanFormatException;
use pvc\formatter\boolean\err\SetBooleanFormatException;

/**
 * Formats a boolean value into any one of several validFormats.
 *
 * Class FrmtrBoolean
 */
class FrmtrBoolean
{

    /**
     * @var string
     */
    protected string $format;

    /**
     * @var string[]
     */
    protected array $validFormats;

    /**
     * FrmtrBoolean constructor.
     * @param string $format
     * @throws SetBooleanFormatException
     */
    public function __construct(string $format = 'yes')
    {
        $this->validFormats = $this->createValidFormats();
        $this->setFormat($format);
    }

    /**
     * @function setFormat
     * @param string $format
     * @throws SetBooleanFormatException
     */
    public function setFormat(string $format): void
    {
        if (!$this->validateBooleanFormat($format)) {
            throw new SetBooleanFormatException($format);
        }
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
     * @function createValidFormats
     * @return array|string[]
     */
    protected function createValidFormats(): array
    {
        return [
            'yes' => 'no',
            'true' => 'false',
            '1' => '0'
        ];
    }

    /**
     * @function getValidFormats
     * @return string[]
     */
    public function getValidFormats(): array
    {
        return $this->validFormats;
    }

    /**
     * @function addValidFormat
     * @param string $trueString
     * @param string $falseString
     * @throws AddBooleanFormatException
     */
    public function addValidFormat(string $trueString, string $falseString): void
    {
        if ($trueString == $falseString) {
            throw new AddBooleanFormatException($trueString);
        }
        if (!isset($this->validFormats[$trueString])) {
            $this->validFormats[$trueString] = $falseString;
        }
    }

    /**
     * @function validateBooleanFormat
     * @param string $x
     * @return bool
     */
    public function validateBooleanFormat(string $x): bool
    {
        return in_array($x, array_keys($this->getValidFormats()));
    }

    /**
     * @function getTrueString
     * @return string
     */
    public function getTrueString(): string
    {
        return $this->format;
    }

    /**
     * @function getFalseString
     * @return string
     */
    public function getFalseString(): string
    {
        return $this->validFormats[$this->format];
    }

    /**
     * @function formatValue
     * @param bool $x
     * @return string
     */
    public function format(bool $x): string
    {
        return $x ? $this->getTrueString() : $this->getFalseString();
    }
}
