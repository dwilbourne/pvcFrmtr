<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 * @noinspection PhpCSValidationInspection
 */
declare(strict_types=1);

namespace pvc\frmtr\err;

use pvc\err\XDataAbstract;

/**
 * Class _FrmtrXData
 */
class _FrmtrXData extends XDataAbstract
{

    public function getLocalXCodes(): array
    {
        return [
            UnsetLocaleException::class => 1001,
            InvalidMinMaxFractionalDigitException::class => 1002,
            InvalidRoundingModeException::class => 1003,
            InvalidIntlCalendarTypeException::class => 1004,
        ];
    }

    public function getXMessageTemplates(): array
    {
        return [
            UnsetLocaleException::class => 'Error trying to access uninitialized property \'locale\'',
            InvalidMinMaxFractionalDigitException::class => 'min / max fractional digits must be greater than or equal to zero',
            InvalidRoundingModeException::class => 'rounding mode must be set to one of the number formatter rounding constants e.g. NumberFormatter::ROUND_HALFUP',
            InvalidIntlCalendarTypeException::class => 'Invalid calendar type, use one of the IntlDateFormatter constants.',
        ];
    }
}