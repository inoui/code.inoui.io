<?php

namespace inoui\extensions\helper;

use inoui\extensions\g11n\Date;

class Time extends \lithium\template\Helper {

    public function to($date = null, $pattern = '', array $options = array()) {
        if ($date == null) return '';
        $default = array();
        $options += $default;
    	$d = new Date($date, $options);
        return $d->format($pattern);
	}

}

?>