<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare(strict_types=1);

namespace pvcTests\frmtr\date_time;

use pvc\frmtr\date_time\FrmtrDateShort;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;

class FrmtrDateShortTest extends FrmtrDateTimeTest
{
    /**
     * dataProvider
     * @return array<string, string, string, string>
     */
    public static function dataProvider(): array
    {
        return [
            ['en_US', 'America/New_York', '5/20/02', 'test US'],
            ['fr_FR', 'Europe/Paris', '20/05/2002', 'test FR'],
            /**
             * notice that the locale specifies a different separator for Canada
             */
            ['en_CA', 'America/Toronto', '2002-05-20', 'test CA'],
        ];
    }

    public function makeFormatter(): FrmtrDateTimeAbstract
    {
        return new FrmtrDateShort();
    }
}
