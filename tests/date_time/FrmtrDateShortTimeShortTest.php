<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

namespace pvcTests\frmtr\date_time;

use pvc\frmtr\date_time\FrmtrDateShortTimeShort;
use pvc\frmtr\date_time\FrmtrDateTimeAbstract;

class FrmtrDateShortTimeShortTest extends FrmtrDateTimeTest
{
    /**
     * dataProvider
     * @return array<string, string, string, string>
     */
    public function dataProvider(): array
    {
        return [
            ['en_US', 'America/New_York', '5/20/02, 2:44' . $this->NNBSP . 'PM', 'test US'],
            ['fr_FR', 'Europe/Paris', '20/05/2002 14:44', 'test FR'],
            /**
             * notice that the locale specifies a different separator for Canada
             */
            ['en_CA', 'America/Toronto', '2002-05-20, 2:44' . $this->NNBSP . 'p.m.', 'test CA'],
        ];
    }

    public function makeFormatter(): FrmtrDateTimeAbstract
    {
        return new FrmtrDateShortTimeShort();
    }
}
