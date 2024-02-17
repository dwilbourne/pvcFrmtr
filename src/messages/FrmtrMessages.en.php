<?php

/**
 * @author: Doug Wilbourne (dougwilbourne@gmail.com)
 */

declare (strict_types=1);

namespace pvc\frmtr\messages;

return [
    'true_false' => '{true_false, select,
        true {true}
        false {false}
        other {true} 
    }',

    'yes_no' => '{true_false, select, 
        true {yes}
        false {no}
        other {yes}
    }',
];
