<?php

namespace inoui_ecomm\extensions\g11n;

use lithium\core\Environment;
use NumberFormatter;

class Currency {
    
    protected static $_taux = '1';

	public static function format($val, $fn='total', $taux = null) {
		$val = Currency::$fn($val, $taux);
        $locale     = Environment::get('locale');
        $fmt = numfmt_create($locale, NumberFormatter::CURRENCY );
        return numfmt_format_currency($fmt, $val, "EUR");
	}

	public static function ht($val, $taux = null) {
		if ($taux == null) $taux = Currency::$_taux;
        $valht = $val / (1 + $taux / 100);
		return $valht;
	}

	public static function vat($val, $taux = null) {
		if ($taux == null) $taux = Currency::$_taux;
        $valht = $val / (1 + $taux / 100);
        $vat = $val-$valht;
		return $vat;
	}

	public static function total($val) {
        return $val;
	}

}
?>
