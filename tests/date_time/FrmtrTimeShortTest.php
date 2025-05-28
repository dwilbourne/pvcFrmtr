<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\date_time;

use pvc\frmtr\date_time\FrmtrDateTimeAbstract;
use pvc\frmtr\date_time\FrmtrTimeShort;

class FrmtrTimeShortTest extends FrmtrDateTimeTest
{

    public static function dataProvider(): array
    {
        return [
            ['en_US', 'America/New_York', '2:44'.self::NNBSP.'PM', 'test US'],
            ['fr_FR', 'Europe/Paris', '14:44', 'test FR'],
            /**
             * notice that the locale specifies a different separator for Canada
             */
            ['en_CA', 'America/Toronto', '2:44'.self::NNBSP.'p.m.', 'test CA'],
        ];
    }

    public function makeFormatter(): FrmtrDateTimeAbstract
    {
        return new FrmtrTimeShort();
    }
}
