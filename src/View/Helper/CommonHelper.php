<?php

namespace App\View\Helper;

use Cake\View\Helper;

class CommonHelper extends Helper {
    
    public function getDate($time_int) {
        return date('d/m/Y', $time_int);
    }
}

?>